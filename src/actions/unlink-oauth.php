<?php
$authorization->mustBeSignedIn();

$location = "/settings?tab=authentication";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["provider"])) break;
    if(!is_string($_POST["provider"])) break;
    if(!isset(Configuration::OAUTH_AUTHENTICATION_METHODS[$_POST["provider"]])) break;
    $name = ucfirst($_POST["provider"]);
    
    $filter = ["accountId" => constant("ACCOUNT_ID"), "provider" => $_POST["provider"]];
    $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($filter);
    if(!$oauthAuthenticationMethod) break;
    
    $filter = ["accountId" => constant("ACCOUNT_ID")];
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($filter);
    $oauthAuthenticationMethods = $oauthAuthenticationMethodManager->read($filter, [], true);
    
    if(!$emailAuthenticationMethod && count($oauthAuthenticationMethods) < 2) {
        $variables = [
            "name" => $name
        ];
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_only_authentication_method", $variables)
        ];
        break;
    }
    
    $oauthAuthenticationMethodManager->delete($oauthAuthenticationMethod);
    
    $variables = [
        "name" => $name
    ];
    $alert = [
        "type" => "success",
        "message" => $localization->getText("alert_authentication_method_deleted", $variables)
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;