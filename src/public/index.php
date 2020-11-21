<?php
session_start();
$root = "/var/www/test.pierrejosselin.com";

spl_autoload_register(function($class) {
    global $root;
    $path = "{$root}/models/{$class}.php";
    if(!is_file($path)) return;
    require_once($path);
});

error_reporting(E_ALL);
ini_set("display_errors", Configuration::DEBUG);
date_default_timezone_set(Configuration::TIMEZONE);
require_once("/var/www/vendor/autoload.php");

if(isset(Configuration::AUTHENTICATION_METHODS["facebook"])) {
    $facebook = new Facebook\Facebook([
        "app_id" => Configuration::AUTHENTICATION_METHODS["facebook"]["appId"],
        "app_secret" => Configuration::AUTHENTICATION_METHODS["facebook"]["appSecret"],
        "default_graph_version" => Configuration::AUTHENTICATION_METHODS["facebook"]["graphVersion"]
    ]);
    $facebookRedirectLoginHelper = $facebook->getRedirectLoginHelper();
    $facebookLoginUrl = $facebookRedirectLoginHelper->getLoginUrl(
        Configuration::AUTHENTICATION_METHODS["facebook"]["redirectUri"],
        ["email"]
    );
}

$database = (new MongoDB\Client())->database;

if(!isset($_SESSION["alerts"])) {
    $_SESSION["alerts"] = [];
}

$accountManager = new AccountManager();
$emailAuthenticationMethodManager = new EmailAuthenticationMethodManager();
$oauthAuthenticationMethodManager = new OAuthAuthenticationMethodManager();

define("PATH", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

if(!array_key_exists(constant("PATH"), Configuration::ROUTES)) {
    http_response_code(404);
} elseif(!is_file($root . Configuration::ROUTES[constant("PATH")])) {
    http_response_code(500);
} else {
    require($root . Configuration::ROUTES[constant("PATH")]);
}