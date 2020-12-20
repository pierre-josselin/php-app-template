<?php
class Configuration {
    const DEBUG = true;
    const BRAND = "App Template";
    const STYLE = "flatly";
    const LOCALE = "fr";
    const TIMEZONE = "Europe/Paris";
    const NAVIGATION = [
        "/" => "title_home",
    ];
    const ROUTES = [
        "/" => "/controllers/home.php",
        "/actions/delete-account" => "/actions/delete-account.php",
        "/actions/development" => "/actions/development.php",
        "/actions/sign-in" => "/actions/sign-in.php",
        "/actions/sign-out" => "/actions/sign-out.php",
        "/actions/sign-up" => "/actions/sign-up.php",
        "/actions/unlink-oauth" => "/actions/unlink-oauth.php",
        "/actions/update-email" => "/actions/update-email.php",
        "/actions/update-password" => "/actions/update-password.php",
        "/actions/update-personal-informations" => "/actions/update-personal-informations.php",
        "/callbacks/facebook" => "/callbacks/facebook.php",
        "/callbacks/keyrock" => "/callbacks/keyrock.php",
        "/development" => "/controllers/development.php",
        "/file" => "/controllers/file.php",
        "/privacy-policy" => "/controllers/privacy-policy.php",
        "/settings" => "/controllers/settings.php",
        "/sign-in" => "/controllers/sign-in.php",
        "/sign-up" => "/controllers/sign-up.php",
        "/css/global.css" => "/views/static/css/global.php",
        "/js/global.js" => "/views/static/js/global.php",
        "/js/settings.js" => "/views/static/js/settings.php",
        "/js/utils.js" => "/views/static/js/utils.php"
    ];
    const OAUTH_AUTHENTICATION_METHODS = [
        "facebook" => [
            "appId" => "403923844314676",
            "appSecret" => "001b310c4aaa5aff06c1ec5dd9acfe71",
            "redirectUri" => "https://test.pierrejosselin.com/callbacks/facebook",
            "graphVersion" => "v8.0"
        ],
        "keyrock" => [
            "url" => "http://34.91.232.139:3000",
            "appId" => "5850525f-86e0-4da5-87ec-5ddedfd8ce7b",
            "redirectUri" => "https://test.pierrejosselin.com/callbacks/keyrock"
        ]
    ];
}