<?php
header("Content-Type: application/json");
?>
if(window.location.hash && window.location.hash == "#_=_") {
    history.replaceState(null, null, " ");
}