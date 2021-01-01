<?php
$authorization->mustBeSignedIn();

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
    
    $filter = ["accountId" => constant("ACCOUNT_ID")];
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($filter);
    if(!$emailAuthenticationMethod) break;
    
    if($emailAuthenticationMethod->getEmail() === $_POST["email"]) {
        $alert = [
            "type" => "info",
            "message" => $localization->getText("alert_same_email")
        ];
        break;
    }
    
    $filter = ["email" => $_POST["email"]];
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($filter);
    if($emailAuthenticationMethod) {
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_email_unavailable")
        ];
        break;
    }
    
    $filter = ["accountId" => constant("ACCOUNT_ID")];
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($filter);
    $emailAuthenticationMethod->setEmail($_POST["email"]);
    $emailAuthenticationMethodManager->update($emailAuthenticationMethod);
    
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