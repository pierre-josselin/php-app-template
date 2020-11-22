var settings = {
    unlinkOauth: function(provider) {
        utils.request("/actions/unlink-oauth", "post", {"provider": provider});
    },
    deleteAccount: function() {
        bootbox.prompt({
            locale: "fr",
            title: "La suppression est définitive.<br>Entrez <b>supprimer mon compte</b> pour continuer.",
            callback: function(result) {
                if(result != "supprimer mon compte") return;
                var url = "/actions/delete-account";
                utils.request(url, "post");
            }
        });
    }
}