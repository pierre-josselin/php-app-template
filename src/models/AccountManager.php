<?php
class AccountManager {
    public function create(array $account) {
        global $database;
        $collection = $database->accounts;
        $collection->insertOne($account);
    }
    
    public function read(array $query) {
        global $database;
        $collection = $database->accounts;
        return $collection->findOne($query);
    }
    
    public function update(MongoDB\Model\BSONDocument $account) {
        global $database;
        $collection = $database->accounts;
        return $collection->updateOne(
            ["_id" => $account["_id"]],
            ["\$set" => $account]
        );
    }
}