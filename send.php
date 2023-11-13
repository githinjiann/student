<?php

//declare variables

$fullName = $_POST["fullname"];
$email = $_POST["email"];
$course = $_POST["course"];
$courseCode = $_POST["coursecode"];
$password = $_POST["password"];

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require'./PHPMailer/src/Exemption.php';
require'./PHPMailer/src/PHPMailer.php';
require'./PHPMailer/src/SMTP.php';




//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
                         //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'annndutaw2020@gmail.com';                     //SMTP username
    $mail->Password   = 'iqpx finz mfqb cpzp';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('$email', 'fullname');
    $mail->addAddress('annndutaw2020@gmail.com');     //Add a recipient
   

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Welcome to Egerton university';
    $mail->Body    = 'your coursecode';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}