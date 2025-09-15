<?php

$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$email = $_POST['email'];
$message = $_POST['message'];

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'mindbuildersict@gmail.com';                     //SMTP username
    $mail->Password   = 'bjiykkdxzretobpg';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($email, $firstName . ' ' . $lastName);
    $mail->addAddress('mindbuildersict@gmail.com');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Contact Form: ' . $firstName . ' ' . $lastName;
    
    // Create HTML body with proper formatting
    $htmlBody = "
    <h2>Contact Form Submission</h2>
    <p><strong>Name:</strong> {$firstName} {$lastName}</p>
    <p><strong>Email:</strong> {$email}</p>
    <p><strong>Message:</strong></p>
    <p>{$message}</p>
    ";
    
    $mail->Body = $htmlBody;
    $mail->AltBody = "Contact Form Submission\n\nName: {$firstName} {$lastName}\nEmail: {$email}\n\nMessage:\n{$message}";

    $mail->send();
    header("Location: thanks.html");
    exit();
} catch (Exception $e) {
    error_log("Mailer Error: {$mail->ErrorInfo}");
    header("Location: index.html?error=1#section_5");
    exit();
}