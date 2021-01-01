<?php
$authorization->mustBeSignedIn();

$filter = ["_id" => constant("ACCOUNT_ID")];
$account = $accountManager->read($filter);

$filter = ["accountId" => constant("ACCOUNT_ID")];
$emailAuthenticationMethod = $emailAuthenticationMethodManager->read($filter);

$oauthAuthenticationMethods = [];
$array = $oauthAuthenticationMethodManager->read($filter, [], true);
foreach($array as $oauthAuthenticationMethod) {
    $oauthAuthenticationMethods[$oauthAuthenticationMethod->getProvider()] = $oauthAuthenticationMethod;
}

$filter = ["accountId" => constant("ACCOUNT_ID")];
$options = ["sort" => ["updateTime" => -1]];
$sessions = $sessionManager->read($filter, $options, true);

$sessionsMetadata = [];
foreach($sessions as $session) {
    $sessionsMetadata[$session->getId()] = [];
    $sessionsMetadata[$session->getId()]["badge"] = false;
    if($session->getId() === constant("SESSION_ID")) {
        $sessionsMetadata[$session->getId()]["badge"] = [
            "type" => "success",
            "name" => $localization->getText("current_session")
        ];
    } elseif($session->getExpirationTime() < time()) {
        $sessionsMetadata[$session->getId()]["badge"] = [
            "type" => "danger",
            "name" => $localization->getText("expired_session")
        ];
    } elseif($session->getUpdateTime() > strtotime("-1 minute")) {
        $sessionsMetadata[$session->getId()]["badge"] = [
            "type" => "primary",
            "name" => $localization->getText("in_use_session")
        ];
    } elseif($session->getUpdateTime() < strtotime("-7 days")) {
        $sessionsMetadata[$session->getId()]["badge"] = [
            "type" => "secondary",
            "name" => $localization->getText("unused_session")
        ];
    }
    $sessionsMetadata[$session->getId()]["ipLocation"] = false;
    if(count($sessions) <= 5) {
        $sessionsMetadata[$session->getId()]["ipLocation"] = Utils::getIpLocation($session->getIp());
    }
}

$tab = "account";
if(isset($_GET["tab"])) {
    $tab = $_GET["tab"];
}

require(Configuration::ROOT . "/views/pages/settings.php");