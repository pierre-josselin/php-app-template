<?php
Authorization::mustNotBeSignedIn();
require(Configuration::ROOT . "/views/pages/sign-up.php");