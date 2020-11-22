<?php
Authorization::mustBeSignedIn();

$location = "/settings";
$alert = [
    "type" => "danger",
    "message" => "Une erreur s'est produite."
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["email"])) break;
    if(!is_string($_POST["email"])) break;
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) break;
    
    $query = ["accountId" => $_SESSION["id"]];
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($query);
    if(!$emailAuthenticationMethod) break;
    
    if($emailAuthenticationMethod["email"] === $_POST["email"]) {
        $alert = [
            "type" => "info",
            "message" => "L'adresse e-mail est identique."
        ];
        break;
    }
    
    $query = ["email" => $_POST["email"]];
    $result = $emailAuthenticationMethodManager->read($query);
    if($result) {
        $alert = [
            "type" => "danger",
            "message" => "L'adresse e-mail est déjà utilisée."
        ];
        break;
    }
    
    $emailAuthenticationMethod["email"] = $_POST["email"];
    $emailAuthenticationMethodManager->update($emailAuthenticationMethod);
    
    $alert = [
        "type" => "success",
        "message" => "L'adresse e-mail a bien été mise à jour."
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;