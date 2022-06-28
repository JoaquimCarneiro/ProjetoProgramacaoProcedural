<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

function envia_email(   $remetente, $nome_remetente,
                        $destinatario, $nome_destinatario,
                        $assunto, $conteudo_html, $conteudo_txt){

    date_default_timezone_set('Etc/UTC');
    //inicia class
    $mail = new PHPMailer();
    //configurações
    $mail->isSMTP();
    //SMTP::DEBUG_OFF
    //SMTP::DEBUG_SERVER
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->Host = SMTP_HOST;
    $mail->Port = SMTP_PORT;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASS;

    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    //remetente
    $mail->setFrom($remetente, $nome_remetente);
    //$mail->addReplyTo('geral@kaosdesign.com.pt', 'First Last');
    //destinatário
    $mail->addAddress($destinatario, $nome_destinatario);
    //falta bcc

    //configuração de mensagem
    $mail->Subject = $assunto;
    $mail->msgHTML($conteudo_html, __DIR__);
    $mail->AltBody = $conteudo_txt;

    //envia mensagem... candidato a modificação
    if (!$mail->send()) {
        $msg =  'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $msg = 'Message sent!';
    }
    return $msg;
}

/* Cria mensagens para o email de registo */
function conteudo_email_registo():array{
    $email_registo = [];

    $email_registo['html'] = "
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Email de confirmação de registo</title>
    </head>
    <body>
        <div style='width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;'>
            <a href='".SITE_ROOT."'>
                <img style='margin-right: 10px;' src='imgs/logo.png' height='80' width='80' alt='Logo'>
                <h1 style='display: inline-block; font-size: 80px; color: darkorange;'>".SITE_TITLE."</h1>
            </a>
            <h1>This is a test of PHPMailer.</h1>
            <p>local onde irá estar o link de confirmação</p>
        </div>
    </body>
</html>
    ";

    $email_registo['txt'] = "Email de confirmação de registo\n futuro link de confirmação de registo";

    return $email_registo;
}