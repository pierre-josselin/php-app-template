<?php
header("Content-Type: application/json");
?>
if(window.location.hash) {
    if(window.location.hash == "#_=_") {
        history.replaceState(null, null, " ");
    }
}
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})