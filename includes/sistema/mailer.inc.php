<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

function envia_email($msg_html){
    date_default_timezone_set('Etc/UTC');
    //inicia class
    $mail = new PHPMailer();
    //configurações
    $mail->isSMTP();
    //SMTP::DEBUG_OFF
    //SMTP::DEBUG_SERVER
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->Host = SMTP_HOST;
    $mail->Port = 25;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASS;

    //remetente
    $mail->setFrom('geral@kaosdesign.com.pt', 'First Last');
    $mail->addReplyTo('geral@kaosdesign.com.pt', 'First Last');
    //destinatário
    $mail->addAddress('quimkaos@gmail.com', 'John Doe');
    //falta bcc

    //configuração de mensagem
    $mail->Subject = 'PHPMailer SMTP test';
    $mail->msgHTML($msg_html, __DIR__);
    $mail->AltBody = 'This is a plain-text message body';

    //envia mensagem
    if (!$mail->send()) {
        $msg =  'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $msg = 'Message sent!';
    }
    return $msg;
}

envia_email("<h1>texto</h1>");
