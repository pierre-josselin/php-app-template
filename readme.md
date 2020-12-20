# PHP App Template

A PHP MVC application template including an account system.

## Installation

1. Create an instance of Debian 9 (stretch)
2. Initialize a [web server](https://github.com/pierre-josselin/web-server) and configure a virtual host
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
5. Copy all source files to web server directory

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
}
```

## Features

- MVC structure
- Bootswatch styles
- Email and password authentication method
- Facebook authentication method
- Keyrock authentication method
- File storage (upload and download)
- Personal informations (name, gender, address...)
- Authentication methods management
- Email and password update
- Account deletion
- Privacy policy page

## Server

- PHP
- Apache
- MongoDB

## Libraries

- jQuery 3.5.1
- Bootstrap 4.5.3
- Bootswatch 4.5.3
- Bootbox 5.4.0
- FontAwesome 5.15.1

## Release history

- [1.0.0](https://github.com/pierre-josselin/php-app-template/releases/tag/1.0.0) - 22/11/2020

## Model

![](https://i.imgur.com/uaySlrg.png)

## Screenshots

![](https://i.imgur.com/O4GXGFT.png)

![](https://i.imgur.com/HrPCWne.png)

![](https://i.imgur.com/sJpfPrL.png)