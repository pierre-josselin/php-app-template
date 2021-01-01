<?php
class Authorization {
    public static function mustBeSignedIn() {
        global $accountManager;
        global $localization;
        if(!constant("ACCOUNT_ID")) {
            $_SESSION["alerts"][] = [
                "type" => "warning",
                "message" => $localization->getText("alert_must_be_signed_in_to_continue")
            ];
            $_SESSION["redirection"] = $_SERVER["REQUEST_URI"];
            header("Location: /sign-in");
            exit;
        }
        $filter = ["_id" => constant("ACCOUNT_ID")];
        $account = $accountManager->read($filter);
        if(!$account) {
            header("Location: /actions/sign-out");
            exit;
        }
        if(!$account->getEnabled()) {
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
        global $accountManager;
        global $localization;
        $filter = ["_id" => constant("ACCOUNT_ID")];
        $account = $accountManager->read($filter);
        if($account->getType() !== "admin") {
            $_SESSION["alerts"][] = [
                "type" => "danger",
                "message" => $localization->getText("alert_access_denied")
            ];
            header("Location: /");
            exit;
        }
    }
}