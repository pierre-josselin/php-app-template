<?php
Authorization::mustBeSignedIn();

$query = ["_id" => $_SESSION["id"]];
$account = $manager->read("accounts", $query);

$query = ["accountId" => $_SESSION["id"]];
$emailAuthenticationMethod = $manager->read("emailAuthenticationMethods", $query);

$oauthAuthenticationMethods = [];
$result = $manager->read("oauthAuthenticationMethods", $query, [], true);
foreach($result as $key => $value) {
    $oauthAuthenticationMethods[$value["provider"]] = $value;
}

$tab = "account";
if(isset($_GET["tab"])) {
    $tab = $_GET["tab"];
}

require(Configuration::ROOT . "/views/pages/settings.php");