<?php
class Authorization {
    public static function mustBeSignedIn() {
        global $accountManager;
        if(!isset($_SESSION["id"])) {
            header("Location: /sign-in");
            exit;
        }
        $query = ["_id" => $_SESSION["id"]];
        $account = $accountManager->read($query);
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