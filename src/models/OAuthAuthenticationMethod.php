<?php
class OAuthAuthenticationMethod {
    use Hydration;
    
    protected $id;
    protected $accountId;
    protected $name;
    protected $userId;
    protected $provider;
    
    public function __construct(array $data = null) {
        if(!is_null($data)) {
            $this->hydrate($data);
        }
    }
    
    public function initialize() {
        $this->setId(Utils::generateId());
    }
    
    public function toArray() {
        return [
            "_id" => $this->getId(),
            "accountId" => $this->getAccountId(),
            "name" => $this->getName(),
            "userId" => $this->getUserId(),
            "provider" => $this->getProvider()
        ];
    }
    
    public function getId() { return $this->id; }
    public function getAccountId() { return $this->accountId; }
    public function getName() { return $this->name; }
    public function getUserId() { return $this->userId; }
    public function getProvider() { return $this->provider; }
    
    public function setId(string $id = null) { $this->id = $id; }
    public function setAccountId(string $accountId = null) { $this->accountId = $accountId; }
    public function setName(string $name = null) { $this->name = $name; }
    public function setUserId(string $userId) { $this->userId = $userId; }
    public function setProvider(string $provider) { $this->provider = $provider; }
}