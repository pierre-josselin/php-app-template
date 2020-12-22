<?php
Authorization::mustBeSignedIn();
$genders = ["male" => "Homme", "female" => "Femme"];
$query = ["_id" => $_SESSION["id"]];
$account = $manager->read("accounts", $query);
$query = ["accountId" => $_SESSION["id"]];
$emailAuthenticationMethod = $manager->read("emailAuthenticationMethods", $query);
$result = $manager->read("oauthAuthenticationMethods", $query, true);
$oauthAuthenticationMethods = [];
foreach($result as $key => $value) {
    $oauthAuthenticationMethods[$value["provider"]] = $value;
}
require(Configuration::ROOT . "/views/pages/settings.php");