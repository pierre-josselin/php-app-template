<?php
Authorization::mustBeSignedIn();

$location = "/development";
$alert = [
    "type" => "danger",
    "message" => "Une erreur s'est produite."
];

while(true) {
    if($_SERVER["REQUEST_METHOD"] !== "POST") break;
    if(!isset($_FILES["file"])) break;
    if(!$_FILES["file"]["tmp_name"]) break;
    if($_FILES["file"]["error"]) break;
    
    $path = $_FILES["file"]["tmp_name"];
    $type = mime_content_type($path);
    if(!in_array($type, ["image/jpeg", "image/png", "image/gif"])) break;
    
    $file = [
        "_id" => Utils::generateId(),
        "accountId" => $_SESSION["id"],
        "name" => $_FILES["file"]["name"],
        "type" => $type,
        "size" => filesize($path),
        "content" => file_get_contents($path),
        "uploadTime" => time()
    ];
    $fileManager->create($file);
    
    $alert = [
        "type" => "success",
        "message" => "Le fichier a bien été téléchargé."
    ];
    break;
}

if($alert) {
    $_SESSION["alerts"][] = $alert;
}
header("Location: {$location}");
exit;