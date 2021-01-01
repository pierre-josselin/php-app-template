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
    },
    deleteSession: function(id) {
        var url = "/actions/delete-session";
        var data = {"id": id};
        utils.request(url, "post", data);
    },
    deleteAllSessions: function() {
        var url = "/actions/delete-all-sessions";
        utils.request(url, "post");
    },
    openDefaultTab: function() {
        if(window.location.hash === "#account") {
            $('.nav-pills a[href="#settings-account-tab"]').tab("show");
        } else if(window.location.hash === "#profile-picture") {
            $('.nav-pills a[href="#settings-profile-picture-tab"]').tab("show");
        } else if(window.location.hash === "#authentication") {
            $('.nav-pills a[href="#settings-authentication-tab"]').tab("show");
        } else if(window.location.hash === "#sessions") {
            $('.nav-pills a[href="#settings-sessions-tab"]').tab("show");
        } else {
            $('.nav-pills a[href="#settings-account-tab"]').tab("show");
        }
    }
}