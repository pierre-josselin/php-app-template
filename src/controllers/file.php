<?php
while(true) {
    if(!isset($_GET["id"])) break;
    if(!is_string($_GET["id"])) break;
    if($_GET["id"] === "") break;
    
    $query = ["_id" => $_GET["id"]];
    $file = $fileManager->read($query);
    if(!$file) break;
    
    $name = $file["_id"];
    if($file["name"]) {
        $name = rawurlencode($file["name"]);
    }
    $contentDisposition = (isset($_GET["download"]) ? "attachment" : "inline");
    header("Content-Type: {$file["type"]}");
    header("Content-Disposition: {$contentDisposition}; filename=\"{$name}\"");
    
    exit($file["content"]);
}

http_response_code(404);
exit;