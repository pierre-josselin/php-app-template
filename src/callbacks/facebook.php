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
    if(!isset(Configuration::OAUTH_AUTHENTICATION_METHODS["facebook"])) break;
    if($_SERVER["REQUEST_METHOD"] !== "GET") break;
    
    try {
        $accessToken = $facebookRedirectLoginHelper->getAccessToken();
        if(!$accessToken) break;
    } catch(Exception $exception) {
        break;
    }
    
    try {
        $response = $facebook->get("/me?fields=id,email,name,first_name,last_name", $accessToken);
        $graphUser = $response->getGraphUser();
        if(!$graphUser->getId()) break;
    } catch(Exception $exception) {
        break;
    }
    
    if(constant("ACCOUNT_ID")) {
        $query = ["accountId" => constant("ACCOUNT_ID"), "provider" => "facebook"];
        $oauthAuthenticationMethod = $manager->read("oauthAuthenticationMethods", $query);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "info",
                "message" => $localization->getText("alert_facebook_already_associated")
            ];
            break;
        }
        
        $query = ["id" => $graphUser->getId(), "provider" => "facebook"];
        $oauthAuthenticationMethod = $manager->read("oauthAuthenticationMethods", $query);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "danger",
                "message" => $localization->getText("alert_facebook_unavailable")
            ];
            break;
        }
        
        $oauthAuthenticationMethod = [
            "_id" => Utils::generateId(),
            "accountId" => constant("ACCOUNT_ID"),
            "id" => $graphUser->getId(),
            "provider" => "facebook"
        ];
        if($graphUser->getName()) {
            $oauthAuthenticationMethod["name"] = $graphUser->getName();
        }
        $manager->create("oauthAuthenticationMethods", $oauthAuthenticationMethod);
        
        $alert = [
            "type" => "success",
            "message" => $localization->getText("alert_facebook_associated")
        ];
        break;
    } else {
        $query = ["id" => $graphUser->getId(), "provider" => "facebook"];
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
        if($graphUser->getEmail()) {
            $account["email"] = $graphUser->getEmail();
        }
        if($graphUser->getFirstName()) {
            $account["firstName"] = $graphUser->getFirstName();
        }
        if($graphUser->getLastName()) {
            $account["lastName"] = $graphUser->getLastName();
        }
        $manager->create("accounts", $account);
        
        $oauthAuthenticationMethod = [
            "_id" => Utils::generateId(),
            "accountId" => $account["_id"],
            "id" => $graphUser->getId(),
            "provider" => "facebook"
        ];
        if($graphUser->getName()) {
            $oauthAuthenticationMethod["name"] = $graphUser->getName();
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