<?php
class FileManager {
    public function create(array $file) {
        global $database;
        file_put_contents(Configuration::ROOT . "/files/{$file["_id"]}", $file["content"]);
        unset($file["content"]);
        $collection = $database->files;
        $collection->insertOne($file);
    }
    
    public function read(array $query) {
        global $database;
        $collection = $database->files;
        $file = $collection->findOne($query);
        $file["content"] = file_get_contents(Configuration::ROOT . "/files/{$file["_id"]}");
        return $file;
    }
    
    public function delete(array $query) {
        global $database;
        $collection = $database->files;
        $collection->deleteOne($query);
        unlink(Configuration::ROOT . "/files/{$query["_id"]}");
    }
}