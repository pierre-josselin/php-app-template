<?php
class EmailAuthenticationMethodManager {
    public function create(array $emailAuthenticationMethod) {
        global $database;
        $collection = $database->emailAuthenticationMethods;
        $collection->insertOne($emailAuthenticationMethod);
    }
    
    public function read(array $query) {
        global $database;
        $collection = $database->emailAuthenticationMethods;
        return $collection->findOne($query);
    }
    
    public function update(MongoDB\Model\BSONDocument $emailAuthenticationMethod) {
        global $database;
        $collection = $database->emailAuthenticationMethods;
        $collection->updateOne(
            ["_id" => $emailAuthenticationMethod["_id"]],
            ["\$set" => $emailAuthenticationMethod]
        );
    }
    
    public function delete(array $query, bool $multiple = false) {
        global $database;
        $collection = $database->emailAuthenticationMethods;
        if($multiple) {
            $collection->deleteMany($query);
        } else {
            $collection->deleteOne($query);
        }
    }
}