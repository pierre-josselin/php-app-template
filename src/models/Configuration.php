<?php
class Configuration {
    const DEBUG = true;
    const BRAND = "App Template";
    const STYLE = "flatly";
    const TIMEZONE = "Europe/Paris";
    const NAVIGATION = [
        "/" => "Accueil",
    ];
    const ROUTES = [
        "/" => "/controllers/home.php",
        "/sign-up" => "/controllers/sign-up.php",
        "/sign-in" => "/controllers/sign-in.php",
        "/actions/sign-up" => "/actions/sign-up.php",
        "/actions/sign-in" => "/actions/sign-in.php",
        "/actions/sign-out" => "/actions/sign-out.php",
        "/callbacks/facebook" => "/callbacks/facebook.php",
    ];
    const AUTHENTICATION_METHODS = [
        "facebook" => [
            "appId" => "403923844314676",
            "appSecret" => "001b310c4aaa5aff06c1ec5dd9acfe71",
            "redirectUri" => "https://test.pierrejosselin.com/callbacks/facebook",
            "graphVersion" => "v8.0"
        ]
    ];
}