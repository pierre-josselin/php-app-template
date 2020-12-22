<?php
require_once("../models/Configuration.php");

session_set_cookie_params(Configuration::SESSION_LIFESPAN, "/");
session_start();

spl_autoload_register(function($class) {
    $path = Configuration::ROOT . "/models/{$class}.php";
    if(!is_file($path)) return;
    require_once($path);
});

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", Configuration::DEBUG);
date_default_timezone_set(Configuration::TIMEZONE);
require_once(Configuration::ROOT . "/vendor/autoload.php");

if(!is_dir(Configuration::ROOT . "/files")) {
    mkdir(Configuration::ROOT . "/files");
}

$localization = new Localization(Configuration::LOCALE);
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

$databaseName = Configuration::DATABASE_NAME;
$database = (new MongoDB\Client())->$databaseName;

if(!isset($_SESSION["alerts"])) {
    $_SESSION["alerts"] = [];
}

$manager = new Manager();
$fileManager = new FileManager();

if(isset($_SESSION["id"])) {
    $query = ["_id" => $_SESSION["id"]];
    $account = $manager->read("accounts", $query);
    define("ACCOUNT", $account);
    unset($account);
}

define("PATH", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

if(!array_key_exists(constant("PATH"), Configuration::ROUTES)) {
    http_response_code(404);
} elseif(!is_file(Configuration::ROOT . Configuration::ROUTES[constant("PATH")])) {
    http_response_code(500);
} else {
    require(Configuration::ROOT . Configuration::ROUTES[constant("PATH")]);
}

exit;