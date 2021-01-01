<?php
if(constant("SESSION_ID")) {
    $filter = ["_id" => constant("SESSION_ID")];
    $session = $sessionManager->read($filter);
    if($session) {
        $sessionManager->delete($session);
    }
}

setcookie("session", "", time() - 3600, "/");
header("Location: /sign-in");
exit;