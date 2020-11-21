<?php
Authorization::mustNotBeSignedIn();

$location = "/sign-in";
$alert = [
    "type" => "danger",
    "message" => "Une erreur s'est produite."
];

while(true) {
    if(!isset($oauthAuthenticationMethods["facebook"])) break;
    if($_SERVER["REQUEST_METHOD"] !== "GET") break;
    
    try {
        $accessToken = $facebookRedirectLoginHelper->getAccessToken();
        if(!$accessToken) break;
    } catch(Exception $exception) {
        break;
    }
    
    try {
        $response = $facebook->get("/me?fields=id,email,first_name,last_name", $accessToken);
        $graphUser = $response->getGraphUser();
        if(!$graphUser->getId()) break;
    } catch(Exception $exception) {
        break;
    }
    
    $query = ["oauthId" => $graphUser->getId(), "oauthProvider" => "facebook"];
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
    if($graphUser->getEmail()) {
        $account["email"] = $graphUser->getEmail();
    }
    if($graphUser->getFirstName()) {
        $account["firstName"] = $graphUser->getFirstName();
    }
    if($graphUser->getLastName()) {
        $account["lastName"] = $graphUser->getLastName();
    }
    $accountManager->create($account);
    
    $oauthAuthenticationMethod = [
        "_id" => Utils::generateId(),
        "accountId" => $account["_id"],
        "oauthId" => $graphUser->getId(),
        "oauthProvider" => "facebook"
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