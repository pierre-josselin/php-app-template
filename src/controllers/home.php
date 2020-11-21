<?php
Authorization::mustBeSignedIn();
require("{$root}/views/home.php");