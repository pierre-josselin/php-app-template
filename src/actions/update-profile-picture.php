<?php
$authorization->mustBeSignedIn();

$location = "/settings?tab=profile-picture";
$alert = [
    "type" => "danger",
    "message" => $localization->getText("alert_error")
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_FILES["profile-picture"])) break;
    if($_FILES["profile-picture"]["error"]) break;
    if(!$_FILES["profile-picture"]["tmp_name"]) break;
    
    $path = $_FILES["profile-picture"]["tmp_name"];
    $type = mime_content_type($path);
    if(!in_array($type, ["image/jpeg", "image/png", "image/gif"])) break;
    
    $content = Utils::resizeImage($path, $type, "image/jpeg", 300);
    if(!$content) break;
    
    $file = new File();
    $file->initialize();
    $file->setType("image/jpeg");
    $file->setContent($content);
    $fileManager->create($file);
    
    $filter = ["_id" => constant("ACCOUNT_ID")];
    $account = $accountManager->read($filter);
    $account->setPicture($file->getId());
    $accountManager->update($account);
    
    $alert = [
        "type" => "success",
        "message" => $localization->getText("alert_profile_picture_updated")
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;