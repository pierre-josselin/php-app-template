<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailManager {
    public function send(array $email) {
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
            $mail->addAddress($email["to"]);
            $mail->isHTML($email["isHTML"];
            $mail->CharSet = "UTF-8";
            $mail->Subject = $email["subject"];
            $mail->Body = $email["body"];
            $mail->send();
            return true;
        } catch(Exception $exception) {
            return false;
        }
    }
}