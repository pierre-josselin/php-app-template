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
}