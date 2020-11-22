<?php
Authorization::mustBeSignedIn();

$location = "/settings";
$alert = [
    "type" => "danger",
    "message" => "Une erreur s'est produite."
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_POST["provider"])) break;
    if(!is_string($_POST["provider"])) break;
    if(!isset($oauthAuthenticationMethods[$_POST["provider"]])) break;
    $name = ucfirst($_POST["provider"]);
    
    $query = ["accountId" => $_SESSION["id"], "provider" => $_POST["provider"]];
    $oauthAuthenticationMethod = $oauthAuthenticationMethodManager->read($query);
    if(!$oauthAuthenticationMethod) break;
    
    $query = ["accountId" => $_SESSION["id"]];
    $emailAuthenticationMethod = $emailAuthenticationMethodManager->read($query);
    $result = $oauthAuthenticationMethodManager->read($query, true);
    
    if(!$emailAuthenticationMethod && count($result) < 2) {
        $alert = [
            "type" => "danger",
            "message" => "Impossible de retirer {$name} car c'est la seule méthode d'authentification associée au compte."
        ];
        break;
    }
    
    $query = ["accountId" => $_SESSION["id"], "provider" => $_POST["provider"]];
    $oauthAuthenticationMethodManager->delete($query);
    
    $alert = [
        "type" => "success",
        "message" => "{$name} a bien été retiré de ce compte."
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;