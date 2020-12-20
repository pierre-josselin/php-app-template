<?php
Authorization::mustBeSignedIn();

$location = "/settings";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["provider"])) break;
    if(!is_string($_POST["provider"])) break;
    if(!isset($oauthAuthenticationMethods[$_POST["provider"]])) break;
    $name = ucfirst($_POST["provider"]);
    
    $query = ["accountId" => $_SESSION["id"], "provider" => $_POST["provider"]];
    $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($query);
    if(!$oauthAuthenticationMethod) break;
    
    $query = ["accountId" => $_SESSION["id"]];
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($query);
    $result = $oauthAuthenticationMethodManager->read($query, true);
    
    if(!$emailAuthenticationMethod && count($result) < 2) {
        $variables = [
            "name" => $name
        ];
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_only_authentication_method", $variables)
        ];
        break;
    }
    
    $query = ["accountId" => $_SESSION["id"], "provider" => $_POST["provider"]];
    $oauthAuthenticationMethodManager->delete($query);
    
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