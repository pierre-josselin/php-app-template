<?php
class Authorization {
    public static function mustBeSignedIn() {
        global $accountManager;
        if(!isset($_SESSION["id"])) {
            header("Location: /sign-in");
            exit;
        }
        $account = $accountManager->read(["_id" => $_SESSION["id"]]);
        if(!$account) {
            header("Location: /actions/sign-out");
            exit;
        }
        if(!$account["enabled"]) {
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
}