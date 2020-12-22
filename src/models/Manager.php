<?php
class Manager {
    public function create(string $collection, array $data) {
        global $database;
        $database->$collection->insertOne($data);
    }
    
    public function read(string $collection, array $query, bool $multiple = false) {
        global $database;
        if($multiple) {
            $result = $database->$collection->find($query)->toArray();
        } else {
            $result = $database->$collection->findOne($query);
        }
        return Utils::objectToArray($result);
    }
    
    public function update(string $collection, array $data) {
        global $database;
        if(!isset($data["_id"])) {
            return false;
        }
        $database->$collection->updateOne(
            ["_id" => $data["_id"]],
            ['$set' => $data]
        );
    }
    
    public function delete(string $collection, array $query, bool $multiple = false) {
        global $database;
        if($multiple) {
            $database->$collection->deleteMany($query);
        } else {
            $database->$collection->deleteOne($query);
        }
    }
}