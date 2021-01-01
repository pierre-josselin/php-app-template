<?php
$authorization->mustBeSignedIn();
$authorization->mustBeAdmin();

$options = ["sort" => ["registrationTime" => -1]];
$accounts = $accountManager->read([], $options, true);

require(Configuration::ROOT . "/views/pages/dashboard.php");