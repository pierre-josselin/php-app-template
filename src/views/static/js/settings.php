<?php
header("Content-Type: application/json");
?>
var settings = {
    unlinkOAuth: function(provider) {
        var url = "/actions/unlink-oauth";
        var data = {"provider": provider};
        utils.request(url, "post", data);
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