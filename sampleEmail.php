<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender = 'support@saudagarkaya.com';
$senderName = 'Support';

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
//$recipient = "dzakirharista@gmail.com";
$recipient = "lala@getnada.com";
// Replace smtp_username with your Amazon SES SMTP user name.
$usernameSmtp = 'AKIAQBXG7F42UTEVWIJW';

// Replace smtp_password with your Amazon SES SMTP password.
$passwordSmtp = 'BIcZplisnAwqjmJ0n2tmU9+0E6n0FPZcAshEhYeoZ2c5';

// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
//$configurationSet = 'ConfigSet';

// If you're using Amazon SES in a region other than US West (Oregon),
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
// endpoint in the appropriate region.
$host = 'email-smtp.ap-southeast-2.amazonaws.com';
$port = 587;

// The subject line of the email
$subject = "TEST ENMAIL";

// The plain-text body of the email
// $bodyText =  "Email Test\r\nThis email was sent through the
//     Amazon SES SMTP interface using the PHPMailer class.";

// The HTML-formatted body of the email
$bodyHtml = "TEST EMAIL";

$mail = new PHPMailer(true);

try {
    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
    $mail->addCustomHeader('X-SES-CONFIGURATION-SET');

    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.

    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    // $mail->AltBody    = $bodyText;
    $mail->Send();
    echo "Email sent!" , PHP_EOL;
} catch (phpmailerException $e) {
    echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
} catch (Exception $e) {
    echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
}

?>
