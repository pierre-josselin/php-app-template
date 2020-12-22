<?php
Authorization::mustNotBeSignedIn();

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
    
    $query = ["email" => $_POST["email"]];
    $emailAuthenticationMethod = $manager->read("emailAuthenticationMethods", $query);
    if($emailAuthenticationMethod) {
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_email_unavailable")
        ];
        break;
    }
    
    $account = [
        "_id" => Utils::generateId(),
        "type" => "user",
        "email" => $_POST["email"],
        "enabled" => true,
        "registrationTime" => time()
    ];
    $manager->create("accounts", $account);
    
    $emailAuthenticationMethod = [
        "_id" => Utils::generateId(),
        "accountId" => $account["_id"],
        "email" => $_POST["email"],
        "passwordHash" => password_hash($_POST["password"], PASSWORD_DEFAULT)
    ];
    $manager->create("emailAuthenticationMethods", $emailAuthenticationMethod);
    
    $_SESSION["id"] = $account["_id"];
    $location = "/";
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