<?php
class Manager {
    public function create(string $collection, array $data) {
        global $database;
        $database->$collection->insertOne($data);
    }
    
    public function read(string $collection, array $query, array $options = [], bool $multiple = false) {
        global $database;
        if($multiple) {
            $result = $database->$collection->find($query, $options)->toArray();
        } else {
            $result = $database->$collection->findOne($query, $options);
        }
        return Utils::objectToArray($result);
    }
    
    public function update(string $collection, array $data) {
        global $database;
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