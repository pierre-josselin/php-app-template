<?php
Authorization::mustBeSignedIn();
Authorization::mustBeAdmin();

$options = ["sort" => ["registrationTime" => -1]];
$accounts = $manager->read("accounts", [], $options, true);

require(Configuration::ROOT . "/views/pages/dashboard.php");