<?php

$rdir = str_replace("\\", "/", __DIR__);                    //Root Dir
require $rdir.'/PHPMailer-master/PHPMailer-master/src/Exception.php';
require $rdir.'/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require $rdir.'/PHPMailer-master/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.yandex.ru';
    $mail->SMTPAuth = true;
    $mail->Username = 'sveshnickova.vera';
    $mail->Password = 'mkwwddgmynnjjpzh';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('sveshnickova.vera@yandex.by', 'Name');
    $mail->addAddress('sveshnickova.vera@yandex.by');
    //$mail->addAddress('chernyak.vera8@gmail.com', 'Name');
    $mail->Subject = 'Subject/Тема письма';
    $mail->Body = 'Текст письма';
    $mail->AltBody = 'Альтернативный текст письма?';

    $mail->send();
    echo 'Письмо успешно отправлено.';
} catch (Exception $e) {
    echo "Письмо не может быть отправлено. PHPMailer: {$mail->ErrorInfo}";
}


//mail('rozenbaymanatolij@gmail.com', 'Тема письма',
//    'Текст письма', 'From: rozenbaymanatolij@gmail.com');

$b = 2;