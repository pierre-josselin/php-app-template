<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailManager {
    public function send(Email $email) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = Configuration::SMTP["host"];
            $mail->Port = Configuration::SMTP["port"];
            $mail->SMTPAuth = true;
            $mail->Username = Configuration::SMTP["username"];
            $mail->Password = Configuration::SMTP["password"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->setFrom(Configuration::SMTP["from"], Configuration::SMTP["fromName"]);
            $mail->addAddress($email->getTo());
            $mail->isHTML($email->getHTML());
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