<?php
Authorization::mustNotBeSignedIn();

$location = "/sign-in";
$alert = [
    "type" => "danger",
    "message" => "Une erreur s'est produite."
];

while(true) {
    if(!isset(Configuration::AUTHENTICATION_METHODS["keyrock"])) break;
    if($_SERVER["REQUEST_METHOD"] !== "GET") break;
    if(!isset($_GET["token"])) break;
    if(!is_string($_GET["token"])) break;
    if(!$_GET["token"]) break;
    
    $url = Configuration::AUTHENTICATION_METHODS["keyrock"]["url"];
    $url .= "/user?access_token={$_GET["token"]}";
    $data = json_decode(Utils::request($url), true);
    
    if(!isset($data["id"])) break;
    if(!$data["id"]) break;
    
    $query = ["oauthId" => $data["id"], "oauthProvider" => "keyrock"];
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
    if(isset($data["email"]) && $data["email"]) {
        $account["email"] = $data["email"];
    }
    $accountManager->create($account);
    
    $oauthAuthenticationMethod = [
        "_id" => Utils::generateId(),
        "accountId" => $account["_id"],
        "oauthId" => $data["id"],
        "oauthProvider" => "keyrock"
    ];
    $oauthAuthenticationMethodManager->create($oauthAuthenticationMethod);
    
    $_SESSION["id"] = $account["_id"];
    $location = "/";
    $alert = [
        "type" => "success",
        "message" => "Le compte a bien été créé."
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;