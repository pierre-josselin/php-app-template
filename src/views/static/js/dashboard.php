<?php
header("Content-Type: application/json");
?>
$("#accounts").DataTable({
    responsive: true,
    scrollX: true,
    ordering: false,
    language: {
        url: "/libraries/datatables/plug-ins/i18n/<?= $localization->getLocale() ?>.json"
    }
});