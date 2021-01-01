<?php
class Session {
    use Hydration;
    
    protected $id;
    protected $accountId;
    protected $ip;
    protected $creationTime;
    protected $updateTime;
    protected $expirationTime;
    
    public function __construct(array $data = null) {
        if(!is_null($data)) {
            $this->hydrate($data);
        }
    }
    
    public function initialize() {
        $this->setId(Utils::generateId(512));
        $this->setIp(Utils::getIp());
        $this->setCreationTime(time());
        $this->setUpdateTime(time());
        $this->setExpirationTime(strtotime(Configuration::SESSION_LIFESPAN));
    }
    
    public function toArray() {
        return [
            "_id" => $this->getId(),
            "accountId" => $this->getAccountId(),
            "ip" => $this->getIp(),
            "creationTime" => $this->getCreationTime(),
            "updateTime" => $this->getUpdateTime(),
            "expirationTime" => $this->getExpirationTime()
        ];
    }
    
    public function getId() { return $this->id; }
    public function getAccountId() { return $this->accountId; }
    public function getIp() { return $this->ip; }
    public function getCreationTime() { return $this->creationTime; }
    public function getUpdateTime() { return $this->updateTime; }
    public function getExpirationTime() { return $this->expirationTime; }
    
    public function setId(string $id = null) { $this->id = $id; }
    public function setAccountId(string $accountId = null) { $this->accountId = $accountId; }
    public function setIp(string $ip = null) { $this->ip = $ip; }
    public function setCreationTime(int $creationTime = null) { $this->creationTime = $creationTime; }
    public function setUpdateTime(int $updateTime = null) { $this->updateTime = $updateTime; }
    public function setExpirationTime(int $expirationTime = null) { $this->expirationTime = $expirationTime; }
}