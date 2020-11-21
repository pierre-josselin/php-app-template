<?php
class OAuthAuthenticationMethodManager {
    public function create(array $oauthAuthenticationMethod) {
        global $database;
        $collection = $database->oauthAuthenticationMethods;
        $collection->insertOne($oauthAuthenticationMethod);
    }
    
    public function read(array $query) {
        global $database;
        $collection = $database->oauthAuthenticationMethods;
        return $collection->findOne($query);
    }
}