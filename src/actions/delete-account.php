<?php
$authorization->mustBeSignedIn();

$location = "/settings?tab=account";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    
    $filter = ["accountId" => constant("ACCOUNT_ID")];
    $oauthAuthenticationMethods = $oauthAuthenticationMethodManager->read($filter, [], true);
    foreach($oauthAuthenticationMethods as $oauthAuthenticationMethod) {
        $oauthAuthenticationMethodManager->delete($oauthAuthenticationMethod);
    }
    $emailAuthenticationMethods = $emailAuthenticationMethodManager->read($filter, [], true);
    foreach($emailAuthenticationMethods as $emailAuthenticationMethod) {
        $emailAuthenticationMethodManager->delete($emailAuthenticationMethod);
    }
    
    $filter = ["_id" => constant("ACCOUNT_ID")];
    $account = $accountManager->read($filter);
    $accountManager->delete($account);
    
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