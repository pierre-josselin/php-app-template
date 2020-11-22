<?php
Authorization::mustBeSignedIn();
$query = ["_id" => $_SESSION["id"]];
$account = $accountManager->read($query);
$genders = ["male" => "Homme", "female" => "Femme"];
require("{$root}/views/settings.php");