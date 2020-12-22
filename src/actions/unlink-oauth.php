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
    $oauthAuthenticationMethod = $manager->read("oauthAuthenticationMethods", $query);
    if(!$oauthAuthenticationMethod) break;
    
    $query = ["accountId" => $_SESSION["id"]];
    $emailAuthenticationMethod = $manager->read("emailAuthenticationMethods", $query);
    $result = $manager->read("oauthAuthenticationMethods", $query, true);
    
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
    $manager->delete("oauthAuthenticationMethods", $query);
    
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