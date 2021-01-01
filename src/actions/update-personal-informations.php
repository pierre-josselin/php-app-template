<?php
$authorization->mustBeSignedIn();

$location = "/settings?tab=account";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["first-name"])) break;
    if(!isset($_POST["last-name"])) break;
    if(!isset($_POST["gender"])) break;
    if(!isset($_POST["email"])) break;
    if(!isset($_POST["phone"])) break;
    if(!isset($_POST["birth-date"])) break;
    if(!isset($_POST["street"])) break;
    if(!isset($_POST["postal-code"])) break;
    if(!isset($_POST["city"])) break;
    if(!isset($_POST["country"])) break;
    if(!is_string($_POST["first-name"])) break;
    if(!is_string($_POST["last-name"])) break;
    if(!is_string($_POST["gender"])) break;
    if(!is_string($_POST["email"])) break;
    if(!is_string($_POST["phone"])) break;
    if(!is_string($_POST["birth-date"])) break;
    if(!is_string($_POST["street"])) break;
    if(!is_string($_POST["postal-code"])) break;
    if(!is_string($_POST["city"])) break;
    if(!is_string($_POST["country"])) break;
    
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
    
    $filter = ["_id" => constant("ACCOUNT_ID")];
    $account = $accountManager->read($filter);
    $account->setFirstName($_POST["first-name"]);
    $account->setLastName($_POST["last-name"]);
    $account->setGender($_POST["gender"]);
    $account->setEmail($_POST["email"]);
    $account->setPhone($_POST["phone"]);
    $account->setBirthDate($_POST["birth-date"]);
    $account->setAddress([
        "street" => $_POST["street"],
        "postalCode" => $_POST["postal-code"],
        "city" => $_POST["city"],
        "country" => $_POST["country"]
    ]);
    $accountManager->update($account);
    
    $alert = [
        "type" => "success",
        "message" => $localization->getText("alert_personal_informations_updated")
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;