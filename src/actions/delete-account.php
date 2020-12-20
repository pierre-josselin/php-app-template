<?php
Authorization::mustBeSignedIn();

$location = "/settings";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    
    $query = ["accountId" => $_SESSION["id"]];
    $oauthAuthenticationMethodManager->delete($query, true);
    $emailAuthenticationMethodManager->delete($query, true);
    $query = ["_id" => $_SESSION["id"]];
    $accountManager->delete($query);
    
    $location = "/actions/sign-out";
    $alert = [
        "type" => "success",
        "message" => $localization->getText("alert_account_deleted")
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;