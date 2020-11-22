<?php
if(isset($_SESSION["id"])) {
    Authorization::mustBeSignedIn();
    $location = "/settings";
} else {
    Authorization::mustNotBeSignedIn();
    $location = "/sign-in";
}
$alert = [
    "type" => "danger",
    "message" => "Une erreur s'est produite."
];

while(true) {
    if(!isset($oauthAuthenticationMethods["keyrock"])) break;
    if($_SERVER["REQUEST_METHOD"] !== "GET") break;
    if(!isset($_GET["token"])) break;
    if(!is_string($_GET["token"])) break;
    if(!$_GET["token"]) break;
    
    $url = $oauthAuthenticationMethods["keyrock"]["url"];
    $url .= "/user?access_token={$_GET["token"]}";
    $data = json_decode(Utils::request($url), true);
    
    if(!isset($data["id"])) break;
    if(!$data["id"]) break;
    
    if(isset($_SESSION["id"])) {
        $query = ["accountId" => $_SESSION["id"], "provider" => "keyrock"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($query);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "info",
                "message" => "Keyrock est déjà associé à ce compte."
            ];
            break;
        }
        
        $query = ["id" => $data["id"], "provider" => "keyrock"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($query);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "danger",
                "message" => "Ce compte Keyrock est déjà associé à un autre compte."
            ];
            break;
        }
        
        $oauthAuthenticationMethod = [
            "_id" => Utils::generateId(),
            "accountId" => $_SESSION["id"],
            "id" => $data["id"],
            "provider" => "keyrock"
        ];
        if($data["email"]) {
            $oauthAuthenticationMethod["name"] = $data["email"];
        }
        $oauthAuthenticationMethodManager->create($oauthAuthenticationMethod);
        
        $alert = [
            "type" => "success",
            "message" => "Keyrock a bien été associé à ce compte."
        ];
        break;
    } else {
        $query = ["id" => $data["id"], "provider" => "keyrock"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($query);
        
        if($oauthAuthenticationMethod) {
            $query = ["_id" => $oauthAuthenticationMethod["accountId"]];
            $account = $accountManager->read($query);
            if(!$account) break;
            
            if(!$account["enabled"]) {
                $alert = [
                    "type" => "danger",
                    "message" => "Ce compte est désactivé."
                ];
                break;
            }
            
            $_SESSION["id"] = $account["_id"];
            $location = "/";
            $alert = false;
            break;
        }
        
        $account = [
            "_id" => Utils::generateId(),
            "enabled" => true,
            "registrationTime" => time()
        ];
        if($data["email"]) {
            $account["email"] = $data["email"];
        }
        $accountManager->create($account);
        
        $oauthAuthenticationMethod = [
            "_id" => Utils::generateId(),
            "accountId" => $account["_id"],
            "id" => $data["id"],
            "provider" => "keyrock"
        ];
        if($data["email"]) {
            $oauthAuthenticationMethod["name"] = $data["email"];
        }
        $oauthAuthenticationMethodManager->create($oauthAuthenticationMethod);
        
        $_SESSION["id"] = $account["_id"];
        $location = "/";
        $alert = [
            "type" => "success",
            "message" => "Le compte a bien été créé."
        ];
        break;
    }
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;