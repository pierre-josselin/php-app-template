<?php
session_start();
$root = "/var/www/test.pierrejosselin.com";

spl_autoload_register(function($class) {
    global $root;
    $path = "{$root}/models/{$class}.php";
    if(!is_file($path)) return;
    require_once($path);
});

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", Configuration::DEBUG);
date_default_timezone_set(Configuration::TIMEZONE);
require_once("/var/www/vendor/autoload.php");

$oauthAuthenticationMethods = Configuration::OAUTH_AUTHENTICATION_METHODS;

if(isset($oauthAuthenticationMethods["facebook"])) {
    $facebook = new Facebook\Facebook([
        "app_id" => $oauthAuthenticationMethods["facebook"]["appId"],
        "app_secret" => $oauthAuthenticationMethods["facebook"]["appSecret"],
        "default_graph_version" => $oauthAuthenticationMethods["facebook"]["graphVersion"]
    ]);
    $facebookRedirectLoginHelper = $facebook->getRedirectLoginHelper();
    $oauthAuthenticationMethods["facebook"]["signInUrl"] = $facebookRedirectLoginHelper->getLoginUrl(
        $oauthAuthenticationMethods["facebook"]["redirectUri"],
        ["email"]
    );
}

if(isset($oauthAuthenticationMethods["keyrock"])) {
    $oauthAuthenticationMethods["keyrock"]["signInUrl"] = $oauthAuthenticationMethods["keyrock"]["url"];
    $oauthAuthenticationMethods["keyrock"]["signInUrl"] .= "/oauth2/authorize?response_type=token";
    $oauthAuthenticationMethods["keyrock"]["signInUrl"] .= "&client_id=" . $oauthAuthenticationMethods["keyrock"]["appId"];
    $oauthAuthenticationMethods["keyrock"]["signInUrl"] .= "&redirect_uri=" . $oauthAuthenticationMethods["keyrock"]["redirectUri"];
    $oauthAuthenticationMethods["keyrock"]["signInUrl"] .= "&state=false";
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