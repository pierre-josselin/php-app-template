<?php
Authorization::mustBeSignedIn();

$location = "/settings";
$alert = [
    "type" => "danger",
    "message" => "Une erreur s'est produite."
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["firstName"])) break;
    if(!isset($_POST["lastName"])) break;
    if(!isset($_POST["gender"])) break;
    if(!isset($_POST["email"])) break;
    if(!isset($_POST["phone"])) break;
    if(!isset($_POST["birthDate"])) break;
    if(!is_string($_POST["firstName"])) break;
    if(!is_string($_POST["lastName"])) break;
    if(!is_string($_POST["gender"])) break;
    if(!is_string($_POST["email"])) break;
    if(!is_string($_POST["phone"])) break;
    if(!is_string($_POST["birthDate"])) break;
    
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
    if($_POST["phone"] !== "") {
        # To do
    }
    if($_POST["birthDate"] !== "") {
        # To do
    }
    
    $query = ["_id" => $_SESSION["id"]];
    $account = $accountManager->read($query);
    $account["firstName"] = $_POST["firstName"];
    $account["lastName"] = $_POST["lastName"];
    $account["gender"] = $_POST["gender"];
    $account["email"] = $_POST["email"];
    $account["phone"] = $_POST["phone"];
    $account["birthDate"] = $_POST["birthDate"];
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