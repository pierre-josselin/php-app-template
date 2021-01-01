<?php
$authorization->mustBeSignedIn();

$location = "/settings?tab=sessions";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["id"])) break;
    if(!is_string($_POST["id"])) break;
    if(!$_POST["id"]) break;
    
    $filter = ["_id" => $_POST["id"], "accountId" => constant("ACCOUNT_ID")];
    $session = $sessionManager->read($filter);
    if(!$session) break;
    $sessionManager->delete($session);
    
    $alert = [
        "type" => "success",
        "message" => $localization->getText("alert_session_deleted")
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;