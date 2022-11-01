<?php

include('../libraries/phpmailer651/src/PHPMailer.php');
include('../libraries/phpmailer651/src/SMTP.php');
include('../libraries/phpmailer651/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function sendemail($nombre, $correo, $asunto, $mensaje)
{



    //Create an instance; passing `true` enables exceptions

    $mail = new PHPMailer(true);

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'andres.lborja@hotmail.com';                     //SMTP username
    $mail->Password   = 'gosdytl8';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    function generarCodigo($longitud)
    {
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern) - 1;

        for ($i = 0; $i < $longitud; $i++) $key .= $pattern[mt_rand(0, $max)];
        return $key;
    }

    //Ejemplo de uso
    $mail->setFrom('andres.lborja@hotmail.com', 'Jellyfish hardware');
    $mail->addAddress($correo);     //Add a recipient
    $_SESSION['codigo'] = generarCodigo(5);
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = utf8_decode($asunto);
    $mail->Body    = '<p> hola ' . $nombre . ', Le informamos que ' . $mensaje .', este es su codigo jellyfish,no lo comparta con nadie: <h3>' . $_SESSION['codigo'] . '</h3>';


    //generador de cogigos

    //Content


    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}
