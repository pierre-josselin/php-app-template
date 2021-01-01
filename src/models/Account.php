<?php
class Account {
    use Hydration;
    
    protected $id;
    protected $type;
    protected $firstName;
    protected $lastName;
    protected $gender;
    protected $email;
    protected $phone;
    protected $birthDate;
    protected $address;
    protected $picture;
    protected $enabled;
    protected $registrationTime;
    
    public function __construct(array $data = null) {
        if(!is_null($data)) {
            $this->hydrate($data);
        }
    }
    
    public function initialize() {
        $this->setId(Utils::generateId());
        $this->setType("user");
        $this->setEnabled(true);
        $this->setRegistrationTime(time());
    }
    
    public function toArray() {
        return [
            "_id" => $this->getId(),
            "type" => $this->getType(),
            "firstName" => $this->getFirstName(),
            "lastName" => $this->getLastName(),
            "gender" => $this->getGender(),
            "email" => $this->getEmail(),
            "phone" => $this->getPhone(),
            "birthDate" => $this->getBirthDate(),
            "address" => $this->getAddress(),
            "picture" => $this->getPicture(),
            "enabled" => $this->getEnabled(),
            "registrationTime" => $this->getRegistrationTime()
        ];
    }
    
    public function getId() { return $this->id; }
    public function getType() { return $this->type; }
    public function getFirstName() { return $this->firstName; }
    public function getLastName() { return $this->lastName; }
    public function getGender() { return $this->gender; }
    public function getEmail() { return $this->email; }
    public function getPhone() { return $this->phone; }
    public function getBirthDate() { return $this->birthDate; }
    public function getAddress() { return $this->address; }
    public function getPicture() { return $this->picture; }
    public function getEnabled() { return $this->enabled; }
    public function getRegistrationTime() { return $this->registrationTime; }
    
    public function setId(string $id = null) { $this->id = $id; }
    public function setType(string $type = null) { $this->type = $type; }
    public function setFirstName(string $firstName = null) { $this->firstName = $firstName; }
    public function setLastName(string $lastName = null) { $this->lastName = $lastName; }
    public function setGender(string $gender = null) { $this->gender = $gender; }
    public function setEmail(string $email = null) { $this->email = $email; }
    public function setPhone(string $phone = null) { $this->phone = $phone; }
    public function setBirthDate(string $birthDate = null) { $this->birthDate = $birthDate; }
    public function setAddress(array $address = null) { $this->address = $address; }
    public function setPicture(string $picture = null) { $this->picture = $picture; }
    public function setEnabled(bool $enabled = null) { $this->enabled = $enabled; }
    public function setRegistrationTime(int $registrationTime = null) { $this->registrationTime = $registrationTime; }
}