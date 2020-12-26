<?php
if(constant("ACCOUNT_ID")) {
    Authorization::mustBeSignedIn();
    $location = "/settings?tab=authentication";
} else {
    Authorization::mustNotBeSignedIn();
    $location = "/sign-in";
}
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if(!isset(Configuration::OAUTH_AUTHENTICATION_METHODS["keyrock"])) break;
    if($_SERVER["REQUEST_METHOD"] !== "GET") break;
    if(!isset($_GET["token"])) break;
    if(!is_string($_GET["token"])) break;
    if(!$_GET["token"]) break;
    
    $url = Configuration::OAUTH_AUTHENTICATION_METHODS["keyrock"]["url"];
    $url .= "/user?access_token={$_GET["token"]}";
    $data = json_decode(Utils::request($url), true);
    
    if(!isset($data["id"])) break;
    if(!$data["id"]) break;
    
    if(constant("ACCOUNT_ID")) {
        $query = ["accountId" => constant("ACCOUNT_ID"), "provider" => "keyrock"];
        $oauthAuthenticationMethod = $manager->read("oauthAuthenticationMethods", $query);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "info",
                "message" => $localization->getText("alert_keyrock_already_associated")
            ];
            break;
        }
        
        $query = ["id" => $data["id"], "provider" => "keyrock"];
        $oauthAuthenticationMethod = $manager->read("oauthAuthenticationMethods", $query);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "danger",
                "message" => $localization->getText("alert_keyrock_unavailable")
            ];
            break;
        }
        
        $oauthAuthenticationMethod = [
            "_id" => Utils::generateId(),
            "accountId" => constant("ACCOUNT_ID"),
            "id" => $data["id"],
            "provider" => "keyrock"
        ];
        if($data["email"]) {
            $oauthAuthenticationMethod["name"] = $data["email"];
        }
        $manager->create("oauthAuthenticationMethods", $oauthAuthenticationMethod);
        
        $alert = [
            "type" => "success",
            "message" => $localization->getText("alert_keyrock_associated")
        ];
        break;
    } else {
        $query = ["id" => $data["id"], "provider" => "keyrock"];
        $oauthAuthenticationMethod = $manager->read("oauthAuthenticationMethods", $query);
        
        if($oauthAuthenticationMethod) {
            $query = ["_id" => $oauthAuthenticationMethod["accountId"]];
            $account = $manager->read("accounts", $query);
            if(!$account) break;
            
            if(!$account["enabled"]) {
                $alert = [
                    "type" => "danger",
                    "message" => $localization->getText("alert_disabled_account")
                ];
                break;
            }
            
            $session = [
                "_id" => Utils::generateId(512),
                "accountId" => $account["_id"],
                "ip" => Utils::getIp(),
                "creationTime" => time(),
                "updateTime" => time(),
                "expirationTime" => strtotime(Configuration::SESSION_LIFESPAN)
            ];
            $manager->create("sessions", $session);
            setcookie("session", $session["_id"], $session["expirationTime"], "/");
            $location = "/";
            $alert = false;
            break;
        }
        
        $account = [
            "_id" => Utils::generateId(),
            "type" => "user",
            "enabled" => true,
            "registrationTime" => time()
        ];
        if($data["email"]) {
            $account["email"] = $data["email"];
        }
        $manager->create("accounts", $account);
        
        $oauthAuthenticationMethod = [
            "_id" => Utils::generateId(),
            "accountId" => $account["_id"],
            "id" => $data["id"],
            "provider" => "keyrock"
        ];
        if($data["email"]) {
            $oauthAuthenticationMethod["name"] = $data["email"];
        }
        $manager->create("oauthAuthenticationMethods", $oauthAuthenticationMethod);
        
        $session = [
            "_id" => Utils::generateId(512),
            "accountId" => $account["_id"],
            "ip" => Utils::getIp(),
            "creationTime" => time(),
            "updateTime" => time(),
            "expirationTime" => strtotime(Configuration::SESSION_LIFESPAN)
        ];
        $manager->create("sessions", $session);
        setcookie("session", $session["_id"], $session["expirationTime"], "/");
        $location = "/";
        $alert = [
            "type" => "success",
            "message" => $localization->getText("alert_account_created")
        ];
        break;
    }
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;