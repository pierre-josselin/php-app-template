<?php
if(isset($_SESSION["id"])) {
    unset($_SESSION["id"]);
}
header("Location: /sign-in");
exit;