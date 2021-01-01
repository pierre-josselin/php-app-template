<?php
class Email {
    protected $to;
    protected $subject;
    protected $body;
    protected $isHTML;
    
    public function getTo() { return $this->to; }
    public function getSubject() { return $this->subject; }
    public function getBody() { return $this->body; }
    public function getIsHTML() { return $this->isHTML; }
    
    public function setTo(string $to) { $this->to = $to; }
    public function setSubject(string $subject) { $this->subject = $subject; }
    public function setBody(string $body) { $this->body = $body; }
    public function setIsHTML(bool $isHTML) { $this->isHTML = $isHTML; }
}