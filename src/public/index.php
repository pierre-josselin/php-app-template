<?php
$root = "/var/www/test.pierrejosselin.com";

session_start();

require_once("/var/www/vendor/autoload.php");

spl_autoload_register(function($class) {
    global $root;
    $path = "{$root}/models/{$class}.php";
    if(!is_file($path)) return;
    require_once($path);
});

if(!isset($_SESSION["alerts"])) {
    $_SESSION["alerts"] = [];
}

$routes = [
    "/" => "{$root}/controllers/home.php",
    "/sign-up" => "{$root}/controllers/sign-up.php"
];

define("PATH", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

if(!array_key_exists(constant("PATH"), $routes)) {
    http_response_code(404);
} elseif(!is_file($routes[constant("PATH")])) {
    http_response_code(500);
} else {
    require($routes[constant("PATH")]);
}