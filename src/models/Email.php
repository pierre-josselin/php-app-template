<?php
class Email {
    private $to;
    private $subject;
    private $body;
    private $html;
    
    public function setTo(string $to) {
        $this->to = $to;
    }
    public function setSubject(string $subject) {
        $this->subject = $subject;
    }
    public function setBody(string $body) {
        $this->body = $body;
    }
    public function setHTML(bool $html) {
        $this->html = $html;
    }
    
    public function getTo() {
        return $this->to;
    }
    public function getSubject() {
        return $this->subject;
    }
    public function getBody() {
        return $this->body;
    }
    public function getHTML() {
        return $this->html;
    }
}