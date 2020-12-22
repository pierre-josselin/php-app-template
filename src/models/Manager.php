<?php
class Manager {
    public function create($collection, array $array) {
        global $database;
        $database->$collection->insertOne($array);
    }
    
    public function read($collection, array $query, bool $multiple = false) {
        global $database;
        if($multiple) {
            return $database->$collection->find($query)->toArray();
        } else {
            return $database->$collection->findOne($query);
        }
    }
    
    public function update($collection, MongoDB\Model\BSONDocument $array) {
        global $database;
        $database->$collection->updateOne(
            ["_id" => $array["_id"]],
            ["\$set" => $array]
        );
    }
    
    public function delete($collection, array $query, bool $multiple = false) {
        global $database;
        if($multiple) {
            $database->$collection->deleteMany($query);
        } else {
            $database->$collection->deleteOne($query);
        }
    }
}