<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailManager {
    protected $configuration;
    
    public function __construct(array $configuration) {
        $this->configuration = $configuration;
    }
    
    public function send(Email $email) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $this->configuration["host"];
            $mail->Port = $this->configuration["port"];
            $mail->SMTPAuth = true;
            $mail->Username = $this->configuration["username"];
            $mail->Password = $this->configuration["password"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->setFrom($this->configuration["from"], $this->configuration["fromName"]);
            $mail->addAddress($email->getTo());
            $mail->isHTML($email->getIsHTML());
            $mail->CharSet = "UTF-8";
            $mail->Subject = $email->getSubject();
            $mail->Body = $email->getBody();
            $mail->send();
            return true;
        } catch(Exception $exception) {
            return false;
        }
    }
}