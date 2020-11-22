<?php
Authorization::mustBeSignedIn();

$location = "/settings";
$alert = [
    "type" => "danger",
    "message" => "Une erreur s'est produite."
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
        "message" => "Le compte a bien été supprimé."
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;