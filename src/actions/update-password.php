<?php
Authorization::mustBeSignedIn();

$location = "/settings?tab=authentication";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["password"], $_POST["new-password"])) break;
    if(!is_string($_POST["password"])) break;
    if(!is_string($_POST["new-password"])) break;
    if(mb_strlen($_POST["new-password"]) < 6) break;
    if(mb_strlen($_POST["new-password"]) > 128) break;
    
    $query = ["accountId" => $_SESSION["id"]];
    $emailAuthenticationMethod = $manager->read("emailAuthenticationMethods", $query);
    if(!$emailAuthenticationMethod) break;
    
    if(!password_verify($_POST["password"], $emailAuthenticationMethod["passwordHash"])) {
        $alert = [
            "type" => "danger",
            "message" => $localization->getText("alert_incorrect_password")
        ];
        break;
    }
    
    $emailAuthenticationMethod["passwordHash"] = password_hash($_POST["new-password"], PASSWORD_DEFAULT);
    $manager->update("emailAuthenticationMethods", $emailAuthenticationMethod);
    
    $alert = [
        "type" => "success",
        "message" => $localization->getText("alert_password_updated")
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;