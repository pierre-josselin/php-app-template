<?php
class SessionManager {
    protected $collection;
    
    public function __construct(MongoDB\Database $database) {
        $this->collection = $database->sessions;
    }
    
    public function create(Session $session) {
        return $this->collection->insertOne($session->toArray());
    }
    
    public function read(array $filter, array $options = [], bool $multiple = false) {
        if($multiple) {
            $cursor = $this->collection->find($filter, $options);
            if(!$cursor) return false;
            $output = [];
            foreach($cursor as $document) {
                $array = Utils::objectToArray($document);
                $output[] = new Session($array);
            }
            return $output;
        } else {
            $document = $this->collection->findOne($filter, $options);
            if(!$document) return false;
            $array = Utils::objectToArray($document);
            return new Session($array);
        }
    }
    
    public function update(Session $session) {
        $filter = ["_id" => $session->getId()];
        $update = ['$set' => $session->toArray()];
        return $this->collection->updateOne($filter, $update);
    }
    
    public function delete(Session $session) {
        $filter = ["_id" => $session->getId()];
        return $this->collection->deleteOne($filter);
    }
}