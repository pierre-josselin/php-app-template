<?php
while(true) {
    if(!isset($_GET["id"])) break;
    if(!is_string($_GET["id"])) break;
    if($_GET["id"] === "") break;
    
    $filter = ["_id" => $_GET["id"]];
    $file = $fileManager->read($filter);
    if(!$file) break;
    
    $name = $file->getId();
    if($file->getName()) {
        $name = rawurlencode($file->getName());
    }
    $contentDisposition = (isset($_GET["attachment"]) ? "attachment" : "inline");
    header("Content-Type: " . $file->getType());
    header("Content-Disposition: {$contentDisposition}; filename=\"{$name}\"");
    
    exit($file->getContent());
}

http_response_code(404);
exit;