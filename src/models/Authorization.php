<?php
class Authorization {
    public static function mustBeSignedIn() {
        global $manager;
        global $localization;
        if(!constant("ACCOUNT_ID")) {
            header("Location: /sign-in");
            exit;
        }
        $query = ["_id" => constant("ACCOUNT_ID")];
        $account = $manager->read("accounts", $query);
        if(!$account) {
            header("Location: /actions/sign-out");
            exit;
        }
        if(!$account["enabled"]) {
            $_SESSION["alerts"][] = [
                "type" => "danger",
                "message" => $localization->getText("alert_account_disabled")
            ];
            header("Location: /actions/sign-out");
            exit;
        }
    }
    
    public static function mustNotBeSignedIn() {
        if(constant("ACCOUNT_ID")) {
            header("Location: /");
            exit;
        }
    }
    
    public static function mustBeAdmin() {
        global $manager;
        global $localization;
        $query = ["_id" => constant("ACCOUNT_ID")];
        $account = $manager->read("accounts", $query);
        if($account["type"] !== "admin") {
            $_SESSION["alerts"][] = [
                "type" => "danger",
                "message" => $localization->getText("alert_access_denied")
            ];
            header("Location: /");
            exit;
        }
    }
}