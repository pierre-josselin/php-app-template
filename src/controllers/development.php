<?php
Authorization::mustBeSignedIn();
require(Configuration::ROOT . "/views/pages/development.php");