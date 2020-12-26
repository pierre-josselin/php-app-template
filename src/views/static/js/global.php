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

$(".custom-file input").change(function(e) {
    var files = [];
    for(var i = 0; i < $(this)[0].files.length; i ++) {
        files.push($(this)[0].files[i].name);
    }
    $(this).next(".custom-file-label").html(files.join(", "));
});