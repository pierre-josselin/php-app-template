<?php
if(constant("SESSION_ID")) {
    $query = ["_id" => constant("SESSION_ID")];
    $manager->delete("sessions", $query);
}
setcookie("session", "", time() - 3600, "/");
header("Location: /sign-in");
exit;