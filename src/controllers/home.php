<?php
$authorization->mustBeSignedIn();
require(Configuration::ROOT . "/views/pages/home.php");