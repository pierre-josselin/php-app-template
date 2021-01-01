<?php
class EmailAuthenticationMethod {
    use Hydration;
    
    protected $id;
    protected $accountId;
    protected $email;
    protected $passwordHash;
    
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
            "email" => $this->getEmail(),
            "passwordHash" => $this->getPasswordHash()
        ];
    }
    
    public function getId() { return $this->id; }
    public function getAccountId() { return $this->accountId; }
    public function getEmail() { return $this->email; }
    public function getPasswordHash() { return $this->passwordHash; }
    
    public function setId(string $id = null) { $this->id = $id; }
    public function setAccountId(string $accountId = null) { $this->accountId = $accountId; }
    public function setEmail(string $email = null) { $this->email = $email; }
    public function setPasswordHash(string $passwordHash = null) { $this->passwordHash = $passwordHash; }
}