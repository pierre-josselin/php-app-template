<?php
$authorization->mustBeSignedIn();

$location = "/settings#sessions";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    
    $filter = ["accountId" => constant("ACCOUNT_ID")];
    $sessions = $sessionManager->read($filter, [], true);
    foreach($sessions as $session) {
        $sessionManager->delete($session);
    }
    
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