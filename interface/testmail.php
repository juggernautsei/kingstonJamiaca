<?php
//set_time_limit(1000);
$ignoreAuth = true;
require_once("globals.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use OpenEMR\Common\Crypto\CryptoGen;

$email = 'sherwin@affordablecustomehr.com';
$user = $GLOBALS['SMTP_USER'];
$cryptoGen = new CryptoGen();
$password = $cryptoGen->decryptStandard($GLOBALS['SMTP_PASS']);
$port =   $GLOBALS['SMTP_PORT'];
$secure =  $GLOBALS['SMTP_SECURE'];
$host = $GLOBALS['SMTP_HOST'];
$refId = "0092";
$body = "
                <table cellpadding='0' cellspacing='2'>
                <tr>
                <td align='center'><font size='4'><strong>Test mail</strong></font></td>
                </tr>
                <tr>
                <td align='center'><p>hello aiyash this is an test mail</p>
                </td>
                </tr>
                <tr>
                <td>Email</td><td>$email</td>
                </tr>
                </table>";

$mail = new PHPMailer(true);
try {
    $mail->SMTPDebug = true;
    $mail->isSMTP();
    $mail->IsHTML(true);
    $mail->Host = $host;
    $mail->SMTPAuth = true;
    $mail->Username = $user;
    $mail->Password = $password;
    $mail->SMTPSecure = $secure;
    $mail->Port = $port;

    $mail->setFrom($GLOBALS['patient_reminder_sender_email'], 'Email Testing');

//    $mail->addReplyTo('billing@mindfultransitions.com', 'Billing Coordinator');
//    $mail->addBCC('john.jalbert@mindfultransitions.com', 'John Jalbert');
    $mail->addAddress($email, 'Client');
    //$mail->addEmbeddedImage('/images/receipt-logo.png', 'receipt-logo', 'receipt-logo.png');
    $mail->Subject = 'Email Testing - Does it work '. $refId;
    $mail->Body = $body;
    $mail->send();
    echo '<br><br>Message Sent. Please check email for results';
}
catch (Exception $e)
{
    echo "Message could not be sent";
    echo "<pre>";
    echo "Mailer error: " . $mail->ErrorInfo;

}
?>
