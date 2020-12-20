<?php
header("Content-Type: application/json");
?>
var settings = {
    unlinkOauth: function(provider) {
        utils.request("/actions/unlink-oauth", "post", {"provider": provider});
    },
    deleteAccount: function() {
        bootbox.confirm({
            locale: <?= json_encode($localization->getLocale()) ?>,
            message: <?= json_encode($localization->getText("dialog_account_deletion")) ?>,
            callback: function(result) {
                if(!result) return;
                var url = "/actions/delete-account";
                utils.request(url, "post");
            }
        });
    }
}