<?php
class EmailAuthenticationMethodManager {
    protected $collection;
    
    public function __construct(MongoDB\Database $database) {
        $this->collection = $database->emailAuthenticationMethods;
    }
    
    public function create(EmailAuthenticationMethod $emailAuthenticationMethod) {
        return $this->collection->insertOne($emailAuthenticationMethod->toArray());
    }
    
    public function read(array $filter, array $options = [], bool $multiple = false) {
        if($multiple) {
            $cursor = $this->collection->find($filter, $options);
            if(!$cursor) return false;
            $output = [];
            foreach($cursor as $document) {
                $array = Utils::objectToArray($document);
                $output[] = new EmailAuthenticationMethod($array);
            }
            return $output;
        } else {
            $document = $this->collection->findOne($filter, $options);
            if(!$document) return false;
            $array = Utils::objectToArray($document);
            return new EmailAuthenticationMethod($array);
        }
    }
    
    public function update(EmailAuthenticationMethod $emailAuthenticationMethod) {
        $filter = ["_id" => $emailAuthenticationMethod->getId()];
        $update = ['$set' => $emailAuthenticationMethod->toArray()];
        return $this->collection->updateOne($filter, $update);
    }
    
    public function delete(EmailAuthenticationMethod $emailAuthenticationMethod) {
        $filter = ["_id" => $emailAuthenticationMethod->getId()];
        return $this->collection->deleteOne($filter);
    }
}