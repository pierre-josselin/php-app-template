<?php
class OAuthAuthenticationMethodManager {
    public function create(array $oauthAuthenticationMethod) {
        global $database;
        $collection = $database->oauthAuthenticationMethods;
        $collection->insertOne($oauthAuthenticationMethod);
    }
    
    public function read(array $query, bool $multiple = false) {
        global $database;
        $collection = $database->oauthAuthenticationMethods;
        if($multiple) {
            return $collection->find($query)->toArray();
        } else {
            return $collection->findOne($query);
        }
    }
    
    public function delete(array $query, bool $multiple = false) {
        global $database;
        $collection = $database->oauthAuthenticationMethods;
        if($multiple) {
            $collection->deleteMany($query);
        } else {
            $collection->deleteOne($query);
        }
    }
}