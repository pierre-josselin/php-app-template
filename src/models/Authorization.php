<?php
class Authorization {
    public static function mustBeSignedIn() {
        global $manager;
        global $localization;
        if(!$_SESSION["id"]) {
            header("Location: /sign-in");
            exit;
        }
        $query = ["_id" => $_SESSION["id"]];
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
        if(isset($_SESSION["id"])) {
            header("Location: /");
            exit;
        }
    }
    
    public static function mustBeAdmin() {
        global $manager;
        global $localization;
        $query = ["_id" => $_SESSION["id"]];
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