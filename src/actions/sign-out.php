<?php
$alerts = null;
if(isset($_SESSION["alerts"])) {
    $alerts = $_SESSION["alerts"];
}
session_destroy();
if(!is_null($alerts)) {
    session_start();
    $_SESSION["alerts"] = $alerts;
}
header("Location: /sign-in");
exit;