<?php
# PHP App Template 1.2.0

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

if(isset(Configuration::OAUTH_AUTHENTICATION_METHODS["facebook"])) {
    $facebook = new Facebook\Facebook([
        "app_id" => Configuration::OAUTH_AUTHENTICATION_METHODS["facebook"]["appId"],
        "app_secret" => Configuration::OAUTH_AUTHENTICATION_METHODS["facebook"]["appSecret"],
        "default_graph_version" => Configuration::OAUTH_AUTHENTICATION_METHODS["facebook"]["graphVersion"]
    ]);
    $facebookRedirectLoginHelper = $facebook->getRedirectLoginHelper();
    $url = $facebookRedirectLoginHelper->getLoginUrl(
        Configuration::OAUTH_AUTHENTICATION_METHODS["facebook"]["redirectUri"],
        ["email"]
    );
    define("FACEBOOK_SIGN_IN_URL", $url);
}

if(isset(Configuration::OAUTH_AUTHENTICATION_METHODS["keyrock"])) {
    $url = Configuration::OAUTH_AUTHENTICATION_METHODS["keyrock"]["url"];
    $url .= "/oauth2/authorize?response_type=token";
    $url .= "&client_id=" . Configuration::OAUTH_AUTHENTICATION_METHODS["keyrock"]["appId"];
    $url .= "&redirect_uri=" . Configuration::OAUTH_AUTHENTICATION_METHODS["keyrock"]["redirectUri"];
    $url .= "&state=false";
    define("KEYROCK_SIGN_IN_URL", $url);
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