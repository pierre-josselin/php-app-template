<?php
$authorization->mustNotBeSignedIn();

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
    
    $filter = ["email" => $_POST["email"]];
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($filter);
    if(!$emailAuthenticationMethod) {
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_unknown_email")
        ];
        break;
    }
    
    if(!password_verify($_POST["password"], $emailAuthenticationMethod->getPasswordHash())) {
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_incorrect_password")
        ];
        break;
    }
    
    $filter = ["_id" => $emailAuthenticationMethod->getAccountId()];
    $account = $accountManager->read($filter);
    if(!$account) break;
    
    if(!$account->getEnabled()) {
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_disabled_account")
        ];
        break;
    }
    
    $session = new Session();
    $session->initialize();
    $session->setAccountId($account->getId());
    $sessionManager->create($session);
    setcookie("session", $session->getId(), $session->getExpirationTime(), "/");
    
    $location = "/";
    $alert = false;
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;