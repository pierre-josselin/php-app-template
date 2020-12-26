<?php
Authorization::mustBeSignedIn();

$location = "/settings?tab=authentication";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["email"])) break;
    if(!is_string($_POST["email"])) break;
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) break;
    
    $query = ["accountId" => $_SESSION["id"]];
    $emailAuthenticationMethod = $manager->read("emailAuthenticationMethods", $query);
    if(!$emailAuthenticationMethod) break;
    
    if($emailAuthenticationMethod["email"] === $_POST["email"]) {
        $alert = [
            "type" => "info",
            "message" => $localization->getText("alert_same_email")
        ];
        break;
    }
    
    $query = ["email" => $_POST["email"]];
    $result = $manager->read("emailAuthenticationMethods", $query);
    if($result) {
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_email_unavailable")
        ];
        break;
    }
    
    $emailAuthenticationMethod["email"] = $_POST["email"];
    $manager->update("emailAuthenticationMethods", $emailAuthenticationMethod);
    
    $alert = [
        "type" => "success",
        "message" => $localization->getText("alert_email_updated")
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;