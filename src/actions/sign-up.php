<?php
$authorization->mustNotBeSignedIn();

$location = "/sign-up";
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
    if(mb_strlen($_POST["password"]) < 6) break;
    if(mb_strlen($_POST["password"]) > 128) break;
    
    $filter = ["email" => $_POST["email"]];
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($filter);
    if($emailAuthenticationMethod) {
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_email_unavailable")
        ];
        break;
    }
    
    $account = new Account();
    $account->initialize();
    $account->setEmail($_POST["email"]);
    $accountManager->create($account);
    
    $emailAuthenticationMethod = new EmailAuthenticationMethod();
    $emailAuthenticationMethod->initialize();
    $emailAuthenticationMethod->setAccountId($account->getId());
    $emailAuthenticationMethod->setEmail($_POST["email"]);
    $emailAuthenticationMethod->setPasswordHash(password_hash($_POST["password"], PASSWORD_DEFAULT));
    $emailAuthenticationMethodManager->create($emailAuthenticationMethod);
    
    $session = new Session();
    $session->initialize();
    $session->setAccountId($account->getId());
    $sessionManager->create($session);
    setcookie("session", $session->getId(), $session->getExpirationTime(), "/");
    
    $location = "/";
    if(isset($_SESSION["redirection"])) {
        $location = $_SESSION["redirection"];
    }
    $alert = [
        "type" => "success",
        "message" => $localization->getText("alert_account_created")
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;