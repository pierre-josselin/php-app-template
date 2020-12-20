<?php
Authorization::mustBeSignedIn();
require("{$root}/views/pages/home.php");