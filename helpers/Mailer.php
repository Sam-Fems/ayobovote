<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/mail.php';

function sendVoterIDEmail($email, $fullname, $voterId)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP CONFIG
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USER;
        $mail->Password   = MAIL_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // EMAIL DETAILS
        $mail->setFrom(MAIL_USER, 'Voting System');
        $mail->addAddress($email, $fullname);

        $mail->isHTML(true);
        $mail->Subject = 'Your Voter ID';
        $mail->Body = "
            <h3>Hello $fullname,</h3>
            <p>Your registration was successful.</p>
            <p><strong>Your Voter ID:</strong> <b>$voterId</b></p>
            <p>Please keep this ID safe. You will use it to log in.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
        return false;
    }
}
