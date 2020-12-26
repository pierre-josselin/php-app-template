<?php
Authorization::mustBeSignedIn();

$location = "/settings?tab=account";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    
    $query = ["accountId" => $_SESSION["id"]];
    $manager->delete("oauthAuthenticationMethods", $query, true);
    $manager->delete("emailAuthenticationMethods", $query, true);
    
    $query = ["_id" => $_SESSION["id"]];
    $manager->delete("accounts", $query);
    
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