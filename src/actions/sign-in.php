<?php
Authorization::mustNotBeSignedIn();

$location = "/sign-in";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["email"], $_POST["password"])) break;
    if(!is_string($_POST["email"])) break;
    if(!is_string($_POST["password"])) break;
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) break;
    
    $query = ["email" => $_POST["email"]];
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($query);
    if(!$emailAuthenticationMethod) {
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_unknown_email")
        ];
        break;
    }
    
    if(!password_verify($_POST["password"], $emailAuthenticationMethod["passwordHash"])) {
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_incorrect_password")
        ];
        break;
    }
    
    $account = $accountManager->read(["_id" => $emailAuthenticationMethod["accountId"]]);
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

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;