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

/* Cria mensagens para o email */
function conteudo_email($titulo, $mensagem_html, $mensagem_txt):array{
    $email_registo = [];

    $email_registo['html'] = "<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>$titulo</title>
        <style>
            html, body{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 11px;
                height: 100%;
                margin: 0;
            }
            .wraper{
                min-height: 100%;
                display: grid;
                grid-template-rows: 60px auto 60px;
                margin: 0 auto;
            }
            .logo{
                background-color: #333;
                padding: 10px;
            }
            .logo a{
                display: flex;
                color: #fff;
                text-decoration: none;
            }

            .logo img{
                display:block;
                height: 40px;
                
            }
            .logo h1{
                font-size: 40px;
                margin: 0 10px;
                color: darkorange;
            }
            .conteudo{
                padding: 10px;
                background-color: #ddd;
            }
            .footer{
                background-color: #333;
            }
        </style>
    </head>
    <body>
        <div class='wraper'>
            <div class='logo'>
                <a href=''>
                    <img src='imgs/logo.png' alt='Logo'>
                    <h1>LoginSys</h1>
                </a>
            </div>
            <div class='conteudo'>
                <h1>$titulo</h1>
                $mensagem_html
            </div>
            <div class='footer'></div>
        </div>
    </body>
</html>
";

    $email_registo['txt'] = $titulo."\n".$mensagem_txt;

    return $email_registo;
}