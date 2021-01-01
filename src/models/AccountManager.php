<?php
class AccountManager {
    protected $collection;
    
    public function __construct(MongoDB\Database $database) {
        $this->collection = $database->accounts;
    }
    
    public function create(Account $account) {
        return $this->collection->insertOne($account->toArray());
    }
    
    public function read(array $filter, array $options = [], bool $multiple = false) {
        if($multiple) {
            $cursor = $this->collection->find($filter, $options);
            if(!$cursor) return false;
            $output = [];
            foreach($cursor as $document) {
                $array = Utils::objectToArray($document);
                $output[] = new Account($array);
            }
            return $output;
        } else {
            $document = $this->collection->findOne($filter, $options);
            if(!$document) return false;
            $array = Utils::objectToArray($document);
            return new Account($array);
        }
    }
    
    public function update(Account $account) {
        $filter = ["_id" => $account->getId()];
        $update = ['$set' => $account->toArray()];
        return $this->collection->updateOne($filter, $update);
    }
    
    public function delete(Account $account) {
        $filter = ["_id" => $account->getId()];
        return $this->collection->deleteOne($filter);
    }
}