<?php
# PHP App Template 1.2.0

require_once("../models/Configuration.php");

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

$accountManager = new AccountManager($database);
$emailAuthenticationMethodManager = new EmailAuthenticationMethodManager($database);
$oauthAuthenticationMethodManager = new OAuthAuthenticationMethodManager($database);
$sessionManager = new SessionManager($database);
$fileManager = new FileManager($database);
$authorization = new Authorization();

if(Configuration::SMTP) {
    $emailManager = new EmailManager(Configuration::SMTP);
}

$success = false;
while(true) {
    if(!isset($_COOKIE["session"])) break;
    if(!is_string($_COOKIE["session"])) break;
    if(!$_COOKIE["session"]) break;
    
    $filter = ["_id" => $_COOKIE["session"]];
    $session = $sessionManager->read($filter);
    
    if(!$session) {
        setcookie("session", "", time() - 3600, "/");
        break;
    }
    
    if($session->getExpirationTime() < time()) {
        $sessionManager->delete($session);
        break;
    }
    
    $session->setIp(Utils::getIp());
    $session->setUpdateTime(time());
    $sessionManager->update($session);
    
    define("SESSION_ID", $session->getId());
    define("ACCOUNT_ID", $session->getAccountId());
    $success = true;
    break;
}

if(!$success) {
    define("SESSION_ID", false);
    define("ACCOUNT_ID", false);
}

if(constant("ACCOUNT_ID")) {
    $filter = ["_id" => constant("ACCOUNT_ID")];
    $account = $accountManager->read($filter);
    if($account) {
        if($account->getFirstName() && $account->getLastName()) {
            define("ACCOUNT_NAME", $account->getFirstName() . " " . $account->getLastName());
        } elseif($account->getFirstName()) {
            define("ACCOUNT_NAME", $account->getFirstName());
        } elseif($account->getLastName()) {
            define("ACCOUNT_NAME", $account->getLastName());
        } elseif($account->getEmail()) {
            define("ACCOUNT_NAME", $account->getEmail());
        } else {
            define("ACCOUNT_NAME", false);
        }
        define("ACCOUNT_TYPE", $account->getType());
        define("ACCOUNT_PICTURE", $account->getPicture());
    }
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