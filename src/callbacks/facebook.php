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
    "message" => $localization->getText("alert_error")
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
        $response = $facebook->get("/me?fields=id,email,name,first_name,last_name", $accessToken);
        $graphUser = $response->getGraphUser();
        if(!$graphUser->getId()) break;
    } catch(Exception $exception) {
        break;
    }
    
    if(isset($_SESSION["id"])) {
        $query = ["accountId" => $_SESSION["id"], "provider" => "facebook"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($query);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "info",
                "message" => $localization->getText("alert_facebook_already_associated")
            ];
            break;
        }
        
        $query = ["id" => $graphUser->getId(), "provider" => "facebook"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($query);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "danger",
                "message" => $localization->getText("alert_facebook_unavailable")
            ];
            break;
        }
        
        $oauthAuthenticationMethod = [
            "_id" => Utils::generateId(),
            "accountId" => $_SESSION["id"],
            "id" => $graphUser->getId(),
            "provider" => "facebook"
        ];
        if($graphUser->getName()) {
            $oauthAuthenticationMethod["name"] = $graphUser->getName();
        }
        $oauthAuthenticationMethodManager->create($oauthAuthenticationMethod);
        
        $alert = [
            "type" => "success",
            "message" => $localization->getText("alert_facebook_associated")
        ];
        break;
    } else {
        $query = ["id" => $graphUser->getId(), "provider" => "facebook"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($query);
        
        if($oauthAuthenticationMethod) {
            $query = ["_id" => $oauthAuthenticationMethod["accountId"]];
            $account = $accountManager->read($query);
            if(!$account) break;
            
            if(!$account["enabled"]) {
                $alert = [
                    "type" => "danger",
                    "message" => $localization->getText("alert_disabled_account")
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
        $accountManager->create($account);
        
        $oauthAuthenticationMethod = [
            "_id" => Utils::generateId(),
            "accountId" => $account["_id"],
            "id" => $graphUser->getId(),
            "provider" => "facebook"
        ];
        if($graphUser->getName()) {
            $oauthAuthenticationMethod["name"] = $graphUser->getName();
        }
        $oauthAuthenticationMethodManager->create($oauthAuthenticationMethod);
        
        $_SESSION["id"] = $account["_id"];
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