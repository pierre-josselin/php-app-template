<?php
Authorization::mustNotBeSignedIn();

$location = "/sign-up";
$alert = [
    "type" => "danger",
    "message" => "Une erreur s'est produite."
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
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($query);
    if($emailAuthenticationMethod) {
        $alert = [
            "type" => "danger",
            "message" => "L'adresse e-mail est déjà utilisée."
        ];
        break;
    }
    
    $account = [
        "_id" => Utils::generateId(),
        "email" => $_POST["email"],
        "enabled" => true,
        "registrationTime" => time()
    ];
    $accountManager->create($account);
    
    $emailAuthenticationMethod = [
        "_id" => Utils::generateId(),
        "accountId" => $account["_id"],
        "email" => $_POST["email"],
        "passwordHash" => password_hash($_POST["password"], PASSWORD_DEFAULT)
    ];
    $emailAuthenticationMethodManager->create($emailAuthenticationMethod);
    
    $_SESSION["id"] = $account["_id"];
    $location = "/";
    $alert = [
        "type" => "success",
        "message" => "Le compte a bien été créé."
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;