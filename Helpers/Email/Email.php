<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {

    public $mail;
    private $jsonFile;

    function __construct($directory)
    {
        $this->mail = new PHPMailer(true);
        $this->jsonFile = new JsonFile($directory);
    }

    public function sendEmail($to,$subject,$content) {

        try {

        $configuration = $this->jsonFile->getJSON();

       

        $this->mail->SMTPDebug = 2;
        $this->mail->isSMTP();
        $this->mail->Host = $configuration->host;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $configuration->username;
        $this->mail->Password = $configuration->password;
        $this->mail->SMTPSecure = "tls";
        $this->mail->Port = $configuration->port;
        $this->mail->setFrom($configuration->username,$configuration->from);

        

        $this->mail->addAddress($to);


        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $this->mail->Body = $content;

        

        $this->mail->send();

        } catch(Exception $e) {

            echo "A ocurrido un error al enviar su mensaje. Error: {$this->mail->ErrorInfo}";
            exit();
        }

        
    }
}

?>