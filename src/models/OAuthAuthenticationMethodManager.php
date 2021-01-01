<?php
class OAuthAuthenticationMethodManager {
    protected $collection;
    
    public function __construct(MongoDB\Database $database) {
        $this->collection = $database->oauthAuthenticationMethods;
    }
    
    public function create(OAuthAuthenticationMethod $oauthAuthenticationMethod) {
        return $this->collection->insertOne($oauthAuthenticationMethod->toArray());
    }
    
    public function read(array $filter, array $options = [], bool $multiple = false) {
        if($multiple) {
            $cursor = $this->collection->find($filter, $options);
            if(!$cursor) return false;
            $output = [];
            foreach($cursor as $document) {
                $array = Utils::objectToArray($document);
                $output[] = new OAuthAuthenticationMethod($array);
            }
            return $output;
        } else {
            $document = $this->collection->findOne($filter, $options);
            if(!$document) return false;
            $array = Utils::objectToArray($document);
            return new OAuthAuthenticationMethod($array);
        }
    }
    
    public function update(OAuthAuthenticationMethod $oauthAuthenticationMethod) {
        $filter = ["_id" => $oauthAuthenticationMethod->getId()];
        $update = ['$set' => $oauthAuthenticationMethod->toArray()];
        return $this->collection->updateOne($filter, $update);
    }
    
    public function delete(OAuthAuthenticationMethod $oauthAuthenticationMethod) {
        $filter = ["_id" => $oauthAuthenticationMethod->getId()];
        return $this->collection->deleteOne($filter);
    }
}