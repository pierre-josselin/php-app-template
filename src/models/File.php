<?php
class File {
    use Hydration;
    
    protected $id;
    protected $accountId;
    protected $name;
    protected $type;
    protected $content;
    protected $uploadTime;
    
    public function __construct(array $data = null) {
        if(!is_null($data)) {
            $this->hydrate($data);
        }
    }
    
    public function initialize() {
        $this->setId(Utils::generateId());
        $this->setAccountId(constant("ACCOUNT_ID"));
        $this->setUploadTime(time());
    }
    
    public function toArray() {
        return [
            "_id" => $this->getId(),
            "accountId" => $this->getAccountId(),
            "name" => $this->getName(),
            "type" => $this->getType(),
            "uploadTime" => $this->getUploadTime()
        ];
    }
    
    public function getId() { return $this->id; }
    public function getAccountId() { return $this->accountId; }
    public function getName() { return $this->name; }
    public function getType() { return $this->type; }
    public function getContent() { return $this->content; }
    public function getUploadTime() { return $this->uploadTime; }
    
    public function setId(string $id = null) { $this->id = $id; }
    public function setAccountId(string $accountId = null) { $this->accountId = $accountId; }
    public function setName(string $name = null) { $this->name = $name; }
    public function setType(string $type = null) { $this->type = $type; }
    public function setContent($content = null) { $this->content = $content; }
    public function setUploadTime(int $uploadTime = null) { $this->uploadTime = $uploadTime; }
}