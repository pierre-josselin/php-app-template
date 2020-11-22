<?php
Authorization::mustBeSignedIn();

$location = "/settings";
$alert = [
    "type" => "danger",
    "message" => "Une erreur s'est produite."
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["first-name"])) break;
    if(!isset($_POST["last-name"])) break;
    if(!isset($_POST["gender"])) break;
    if(!isset($_POST["email"])) break;
    if(!isset($_POST["phone"])) break;
    if(!isset($_POST["birth-date"])) break;
    if(!is_string($_POST["first-name"])) break;
    if(!is_string($_POST["last-name"])) break;
    if(!is_string($_POST["gender"])) break;
    if(!is_string($_POST["email"])) break;
    if(!is_string($_POST["phone"])) break;
    if(!is_string($_POST["birth-date"])) break;
    
    if($_POST["gender"] !== "") {
        if(!in_array($_POST["gender"], ["male", "female"])) {
            break;
        }
    }
    if($_POST["email"] !== "") {
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            break;
        }
    }
    if($_POST["birth-date"] !== "") {
        if(!Utils::checkDateFormat($_POST["birth-date"])) {
            break;
        }
    }
    
    $query = ["_id" => $_SESSION["id"]];
    $account = $accountManager->read($query);
    $account["firstName"] = $_POST["first-name"];
    $account["lastName"] = $_POST["last-name"];
    $account["gender"] = $_POST["gender"];
    $account["email"] = $_POST["email"];
    $account["phone"] = $_POST["phone"];
    $account["birthDate"] = $_POST["birth-date"];
    $accountManager->update($account);
    
    $alert = [
        "type" => "success",
        "message" => "Les informations personnelles ont bien été enregistrées."
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;