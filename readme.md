# PHP App Template

A PHP MVC application template including an account system.<br>
Apache web server and MongoDB database.

## Installation

1. Create an instance of Debian 9 (stretch)
2. Initialize an Apache [web server](https://github.com/pierre-josselin/web-server) and configure a virtual host
3. Install MongoDB
```sh
wget -qO - https://www.mongodb.org/static/pgp/server-4.4.asc | sudo apt-key add -
echo "deb http://repo.mongodb.org/apt/debian stretch/mongodb-org/4.4 main" | sudo tee /etc/apt/sources.list.d/mongodb-org-4.4.list
sudo apt update
sudo apt install -y mongodb-org
sudo service mongod start
```
4. Install PHP App Template
```sh
chmod +x install.sh
sudo ./install.sh
```
5. Copy all source files to the web server directory

https://docs.mongodb.com/manual/tutorial/install-mongodb-on-debian/<br>
https://docs.mongodb.com/drivers/php

## Configuration
Create **Configuration.php** in **models** :

```php
<?php
class Configuration {
    const DEBUG = true;
    const BRAND = "App Template";
    const STYLE = "flatly";
    const LOCALE = "en";
    const TIMEZONE = "Europe/Paris";
    const ROOT = "/var/www/example.com";
    const DATABASE_NAME = "test";
    const SESSION_LIFESPAN = "+1 year";
    const NAVIGATION = [
        "/" => "title_home",
    ];
    const ROUTES = [
        "/" => "/controllers/home.php",
        "/actions/delete-account" => "/actions/delete-account.php",
        "/actions/sign-in" => "/actions/sign-in.php",
        "/actions/sign-out" => "/actions/sign-out.php",
        "/actions/sign-up" => "/actions/sign-up.php",
        "/actions/unlink-oauth" => "/actions/unlink-oauth.php",
        "/actions/update-email" => "/actions/update-email.php",
        "/actions/update-password" => "/actions/update-password.php",
        "/actions/update-personal-informations" => "/actions/update-personal-informations.php",
        "/actions/update-profile-picture" => "/actions/update-profile-picture.php",
        "/callbacks/facebook" => "/callbacks/facebook.php",
        "/callbacks/keyrock" => "/callbacks/keyrock.php",
        "/dashboard" => "/controllers/dashboard.php",
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
            "appId" => "",
            "appSecret" => "",
            "redirectUri" => "https://example.com/callbacks/facebook",
            "graphVersion" => "v8.0"
        ],
        "keyrock" => [
            "url" => "",
            "appId" => "",
            "redirectUri" => "https://example.com/callbacks/keyrock"
        ]
    ];
    const SMTP = [
        "host" => "",
        "port" => 0,
        "username" => "",
        "password" => "",
        "from" => "",
        "fromName" => ""
    ];
    const IP_INFO_TOKEN = "";
}
```

## Features

- Account system
- Sessions (with [ipinfo](https://ipinfo.io/) lookup)
- Email/password authentication method
- OAuth authentication methods
- Personal informations (name, gender, address...)
- File storage system
- Bootswatch styles
- Admin dashboard
- Localization

## Supported OAuth authentication methods

- Facebook
- Keyrock

## Supported languages

- English
- French

## Included libraries

- Bootstrap 4.5.3
- Bootswatch 4.5.3
- FontAwesome 5.15.1
- jQuery 3.5.1
- Bootbox 5.4.0

## Release history

- [1.1.0](https://github.com/pierre-josselin/php-app-template/releases/tag/1.1.0) - 2020-12-23
- [1.0.0](https://github.com/pierre-josselin/php-app-template/releases/tag/1.0.0) - 2020-11-22

## Screenshots

![](https://i.imgur.com/O4GXGFT.png)

![](https://i.imgur.com/HrPCWne.png)

![](https://i.imgur.com/sJpfPrL.png)