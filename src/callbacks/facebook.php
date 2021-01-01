<?php
if(constant("ACCOUNT_ID")) {
    $authorization->mustBeSignedIn();
    $location = "/settings#authentication";
} else {
    $authorization->mustNotBeSignedIn();
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
        $filter = ["accountId" => constant("ACCOUNT_ID"), "provider" => "facebook"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($filter);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "info",
                "message" => $localization->getText("alert_facebook_already_associated")
            ];
            break;
        }
        
        $filter = ["userId" => $graphUser->getId(), "provider" => "facebook"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($filter);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "danger",
                "message" => $localization->getText("alert_facebook_unavailable")
            ];
            break;
        }
        
        $oauthAuthenticationMethod = new OAuthAuthenticationMethod();
        $oauthAuthenticationMethod->initialize();
        $oauthAuthenticationMethod->setAccountId(constant("ACCOUNT_ID"));
        $oauthAuthenticationMethod->setUserId($graphUser->getId());
        $oauthAuthenticationMethod->setProvider("facebook");
        if($graphUser->getName()) {
            $oauthAuthenticationMethod->setName($graphUser->getName());
        }
        $oauthAuthenticationMethodManager->create($oauthAuthenticationMethod);
        
        $alert = [
            "type" => "success",
            "message" => $localization->getText("alert_facebook_associated")
        ];
        break;
    } else {
        $filter = ["userId" => $graphUser->getId(), "provider" => "facebook"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($filter);
        
        if($oauthAuthenticationMethod) {
            $filter = ["_id" => $oauthAuthenticationMethod->getAccountId()];
            $account = $accountManager->read($filter);
            if(!$account) break;
            
            if(!$account->getEnabled()) {
                $alert = [
                    "type" => "danger",
                    "message" => $localization->getText("alert_disabled_account")
                ];
                break;
            }
            
            $session = new Session();
            $session->initialize();
            $session->setAccountId($account->getId());
            $sessionManager->create($session);
            setcookie("session", $session->getId(), $session->getExpirationTime(), "/");
            
            $location = "/";
            if(isset($_SESSION["redirection"])) {
                $location = $_SESSION["redirection"];
            }
            $alert = false;
            break;
        }
        
        $account = new Account();
        $account->initialize();
        if($graphUser->getEmail()) {
            $account->setEmail($graphUser->getEmail());
        }
        if($graphUser->getFirstName()) {
            $account->setFirstName($graphUser->getFirstName());
        }
        if($graphUser->getLastName()) {
            $account->setLastName($graphUser->getLastName());
        }
        $accountManager->create($account);
        
        $oauthAuthenticationMethod = new OAuthAuthenticationMethod();
        $oauthAuthenticationMethod->initialize();
        $oauthAuthenticationMethod->setAccountId($account->getId());
        $oauthAuthenticationMethod->setUserId($graphUser->getId());
        $oauthAuthenticationMethod->setProvider("facebook");
        if($graphUser->getName()) {
            $oauthAuthenticationMethod->setName($graphUser->getName());
        }
        $oauthAuthenticationMethodManager->create($oauthAuthenticationMethod);
        
        $session = new Session();
        $session->initialize();
        $session->setAccountId($account->getId());
        $sessionManager->create($session);
        setcookie("session", $session->getId(), $session->getExpirationTime(), "/");
        
        $location = "/";
        if(isset($_SESSION["redirection"])) {
            $location = $_SESSION["redirection"];
        }
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