<?php


namespace MyProject\Services;

$rdir = str_replace("\\", "/", __DIR__);                    //Root Dir
require $rdir.'/PHPMailer-master/PHPMailer-master/src/Exception.php';
require $rdir.'/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require $rdir.'/PHPMailer-master/PHPMailer-master/src/SMTP.php';

use MyProject\Models\Users\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/** Класс для отправки email-ов пользователям */
class EmailSender
{

    public static function send(
        User $receiver,
        string $subject,
        string $templateName,
        array $templateVars = []
    ): void
    {
        extract($templateVars);

        ob_start();
        require __DIR__ . '/../../../templates/mail/' . $templateName;

        $body = ob_get_contents();

        ob_end_clean();



        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->Host = 'smtp.yandex.ru';
            $mail->SMTPAuth = true;
            $mail->Username = 'sveshnickova.vera';
            $mail->Password = 'mkwwddgmynnjjpzh';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('sveshnickova.vera@yandex.by', 'Name');
            $mail->addAddress($receiver->getEmail());
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = 'Альтернативный текст письма?';


            $mail->send();
//            echo 'Письмо успешно отправлено.';
        } catch (Exception $e) {
            echo "Письмо не может быть отправлено. PHPMailer: {$mail->ErrorInfo}";
        }

    }
}