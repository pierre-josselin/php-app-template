<?php
class FileManager {
    protected $collection;
    
    public function __construct(MongoDB\Database $database) {
        $this->collection = $database->files;
    }
    
    public function create(File $file) {
        $result = file_put_contents(Configuration::ROOT . "/files/" . $file->getId(), $file->getContent());
        if($result === false) return false;
        return $this->collection->insertOne($file->toArray());
    }
    
    public function read(array $filter, array $options = [], bool $multiple = false) {
        if($multiple) {
            $cursor = $this->collection->find($filter, $options);
            if(!$cursor) return false;
            $output = [];
            foreach($cursor as $document) {
                $array = Utils::objectToArray($document);
                $file = new File($array);
                $content = file_get_contents(Configuration::ROOT . "/files/" . $file->getId());
                if($content === false) return false;
                $file->setContent($content);
                $output[] = $file;
            }
            return $output;
        } else {
            $document = $this->collection->findOne($filter, $options);
            if(!$document) return false;
            $array = Utils::objectToArray($document);
            $file = new File($array);
            $content = file_get_contents(Configuration::ROOT . "/files/" . $file->getId());
            if($content === false) return false;
            $file->setContent($content);
            return $file;
        }
    }
    
    public function update(File $file) {
        $filter = ["_id" => $file->getId()];
        $update = ['$set' => $file->toArray()];
        return $this->collection->updateOne($filter, $update);
    }
    
    public function delete(File $file) {
        $result = unlink(Configuration::ROOT . "/files/" . $file->getId());
        if(!$result) return false;
        $filter = ["_id" => $file->getId()];
        return $this->collection->deleteOne($filter);
    }
}