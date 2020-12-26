<?php
Authorization::mustBeSignedIn();

$location = "/settings?tab=sessions";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    
    $query = ["accountId" => constant("ACCOUNT_ID")];
    $manager->delete("sessions", $query, true);
    
    $alert = [
        "type" => "success",
        "message" => $localization->getText("alert_all_sessions_deleted")
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;