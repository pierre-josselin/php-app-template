<?php
Authorization::mustBeSignedIn();

$query = ["_id" => constant("ACCOUNT_ID")];
$account = $manager->read("accounts", $query);

$query = ["accountId" => constant("ACCOUNT_ID")];
$emailAuthenticationMethod = $manager->read("emailAuthenticationMethods", $query);

$oauthAuthenticationMethods = [];
$result = $manager->read("oauthAuthenticationMethods", $query, [], true);
foreach($result as $key => $value) {
    $oauthAuthenticationMethods[$value["provider"]] = $value;
}

$query = ["accountId" => constant("ACCOUNT_ID")];
$options = ["sort" => ["updateTime" => -1]];
$sessions = $manager->read("sessions", $query, $options, true);

foreach($sessions as $index => $session) {
    $sessions[$index]["badge"] = false;
    if($session["_id"] === constant("SESSION_ID")) {
        $sessions[$index]["badge"] = [
            "type" => "success",
            "name" => $localization->getText("current_session")
        ];
    } elseif($session["expirationTime"] < time()) {
        $sessions[$index]["badge"] = [
            "type" => "danger",
            "name" => $localization->getText("expired_session")
        ];
    } elseif($session["updateTime"] > strtotime("-1 minute")) {
        $sessions[$index]["badge"] = [
            "type" => "primary",
            "name" => $localization->getText("in_use_session")
        ];
    } elseif($session["updateTime"] < strtotime("-7 days")) {
        $sessions[$index]["badge"] = [
            "type" => "secondary",
            "name" => $localization->getText("unused_session")
        ];
    }
}

foreach($sessions as $index => $session) {
    $sessions[$index]["ipLocation"] = false;
    if(count($sessions) <= 5) {
        $sessions[$index]["ipLocation"] = Utils::getIpLocation($session["ip"]);
    }
}

$tab = "account";
if(isset($_GET["tab"])) {
    $tab = $_GET["tab"];
}

require(Configuration::ROOT . "/views/pages/settings.php");