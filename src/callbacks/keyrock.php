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
    if(!isset(Configuration::OAUTH_AUTHENTICATION_METHODS["keyrock"])) break;
    if($_SERVER["REQUEST_METHOD"] !== "GET") break;
    if(!isset($_GET["token"])) break;
    if(!is_string($_GET["token"])) break;
    if(!$_GET["token"]) break;
    
    $url = Configuration::OAUTH_AUTHENTICATION_METHODS["keyrock"]["url"];
    $url .= "/user?access_token={$_GET["token"]}";
    $data = Utils::decodeJSON(Utils::request($url), true);
    
    if(!isset($data["id"])) break;
    if(!$data["id"]) break;
    
    if(constant("ACCOUNT_ID")) {
        $filter = ["accountId" => constant("ACCOUNT_ID"), "provider" => "keyrock"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($filter);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "info",
                "message" => $localization->getText("alert_keyrock_already_associated")
            ];
            break;
        }
        
        $filter = ["userId" => $data["id"], "provider" => "keyrock"];
        $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($filter);
        
        if($oauthAuthenticationMethod) {
            $alert = [
                "type" => "danger",
                "message" => $localization->getText("alert_keyrock_unavailable")
            ];
            break;
        }
        
        $oauthAuthenticationMethod = new OAuthAuthenticationMethod();
        $oauthAuthenticationMethod->initialize();
        $oauthAuthenticationMethod->setAccountId(constant("ACCOUNT_ID"));
        $oauthAuthenticationMethod->setUserId($data["id"]);
        $oauthAuthenticationMethod->setProvider("keyrock");
        if($data["email"]) {
            $oauthAuthenticationMethod->setName($data["email"]);
        }
        $oauthAuthenticationMethodManager->create($oauthAuthenticationMethod);
        
        $alert = [
            "type" => "success",
            "message" => $localization->getText("alert_keyrock_associated")
        ];
        break;
    } else {
        $filter = ["userId" => $data["id"], "provider" => "keyrock"];
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
        if($data["email"]) {
            $account->setEmail($data["email"]);
        }
        $accountManager->create($account);
        
        $oauthAuthenticationMethod = new OAuthAuthenticationMethod();
        $oauthAuthenticationMethod->initialize();
        $oauthAuthenticationMethod->setAccountId($account->getId());
        $oauthAuthenticationMethod->setUserId($data["id"]);
        $oauthAuthenticationMethod->setProvider("keyrock");
        if($data["email"]) {
            $oauthAuthenticationMethod->setName($data["email"]);
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