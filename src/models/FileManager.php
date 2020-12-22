<?php
class FileManager {
    public function create(array $file) {
        global $database;
        file_put_contents(Configuration::ROOT . "/files/{$file["_id"]}", $file["content"]);
        unset($file["content"]);
        $database->files->insertOne($file);
    }
    
    public function read(array $query) {
        global $database;
        $file = $database->files->findOne($query);
        $file["content"] = file_get_contents(Configuration::ROOT . "/files/{$file["_id"]}");
        return $file;
    }
    
    public function delete(array $query) {
        global $database;
        $database->files->deleteOne($query);
        unlink(Configuration::ROOT . "/files/{$query["_id"]}");
    }
}