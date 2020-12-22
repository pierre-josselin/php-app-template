<?php
Authorization::mustBeSignedIn();
require(Configuration::ROOT . "/views/pages/home.php");