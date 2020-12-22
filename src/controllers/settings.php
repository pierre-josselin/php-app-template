<?php
Authorization::mustBeSignedIn();
$genders = ["male" => "Homme", "female" => "Femme"];
$query = ["_id" => $_SESSION["id"]];
$settingsAccount = $manager->read("accounts", $query);
$query = ["accountId" => $_SESSION["id"]];
$settingsEmailAuthenticationMethod = $manager->read("emailAuthenticationMethods", $query);
$result = $manager->read("oauthAuthenticationMethods", $query, true);
$settingsOAuthAuthenticationMethods = [];
foreach($result as $key => $value) {
    $settingsOAuthAuthenticationMethods[$value["provider"]] = $value;
}
require(Configuration::ROOT . "/views/pages/settings.php");