<?php
Authorization::mustBeSignedIn();
$genders = ["male" => "Homme", "female" => "Femme"];
$query = ["_id" => $_SESSION["id"]];
$settingsAccount = $accountManager->read($query);
$query = ["accountId" => $_SESSION["id"]];
$settingsEmailAuthenticationMethod = $emailAuthenticationMethodManager->read($query);
$result = $oauthAuthenticationMethodManager->read($query, true);
$settingsOAuthAuthenticationMethods = [];
foreach($result as $key => $value) {
    $settingsOAuthAuthenticationMethods[$value["provider"]] = $value;
}
require("{$root}/views/settings.php");