<?php
class Configuration {
    const BRAND = "App Template";
    const STYLE = "flatly";
    const NAVIGATION = [
        "/" => "Accueil"
    ];
    const ROUTES = [
        "/" => "/controllers/home.php",
        "/sign-up" => "/controllers/sign-up.php",
        "/sign-in" => "/controllers/sign-in.php",
        "/actions/sign-up" => "/actions/sign-up.php",
        "/actions/sign-in" => "/actions/sign-in.php",
        "/actions/sign-out" => "/actions/sign-out.php",
    ];
}