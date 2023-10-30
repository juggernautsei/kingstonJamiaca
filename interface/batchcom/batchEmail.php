<?php
set_time_limit(150);
/**
 * Batch Email processor, included from batchcom
 *
 * @package OpenEMR
 * @link    http://www.open-emr.org
 * @author  cfapress
 * @author  Jason 'Toolbox' Oettinger <jason@oettinger.email>
 * @copyright Copyright (c) 2008 cfapress
 * @copyright Copyright (c) 2017 Jason 'Toolbox' Oettinger <jason@oettinger.email>
 * @license https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

// create file header.
// menu for fields could be added in the future
require_once("../globals.php");

use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Core\Header;
use PHPMailer\PHPMailer\PHPMailer;
use OpenEMR\Common\Crypto\CryptoGen;

if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token_form"])) {
    CsrfUtils::csrfNotVerified();
}

?>
<html>
<head>
    <title><?php echo xlt('Email Notification Report'); ?></title>
    <?php Header::setupHeader(); ?>
</head>
<body class="body_top container">
<header class="row">
    <?php require_once("batch_navigation.php");?>
    <h1 class="col-md-12">
        <a href="batchcom.php"><?php echo xlt('Batch Communication Tool')?></a>
        <small><?php echo xlt('Email Notification Report'); ?></small>
    </h1>
</header>
<main class="row mx-4">
    <ul class="col-md-12">
        <?php
        $email_sender = empty($_POST['email_sender']) ? $GLOBALS['SMTP_USER'] : $_POST['email_sender'];
        $cryptoGen = new CryptoGen();
        $password = $cryptoGen->decryptStandard($GLOBALS['SMTP_PASS']);
        $m_error_count = 0;
        while ($row = sqlFetchArray($res)) {
            
            // prepare text for ***NAME*** tag
            $pt_name = $row['title'] . ' ' . $row['fname'] . ' ' . $row['lname'];
            $pt_email = $row['email'];
            $email_subject = $_POST['email_subject'];

            $email_body = $_POST['email_body'];
            $email_subject = preg_replace('/\*{3}NAME\*{3}/', $pt_name, $email_subject);
            $email_body = preg_replace('/\*{3}NAME\*{3}/', $pt_name, $email_body);
            
            $email_body = preg_replace('/\*{3}DATE\*{3}/', $row['pc_eventDate'], $email_body);
            $email_body = preg_replace('/\*{3}STARTTIME\*{3}/', $row['pc_startTime'], $email_body);
            if($pt_email){
                $mail =  new PHPMailer();

                $mail->IsSMTP();
                $mail->SMTPDebug = 1;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure =$GLOBALS['SMTP_SECURE']; 
                $mail->Host = $GLOBALS['SMTP_HOST']; 
                $mail->Port = $GLOBALS['SMTP_PORT']; 
                $mail->IsHTML(true);
                $mail->Username = $GLOBALS['SMTP_USER'];
                $mail->Password = $password;
                $mail->setFrom($email_sender);
                $mail->addAddress($pt_email, $pt_name);
                $mail->addReplyTo($email_sender);
                $mail->isHTML(true);
                $mail->Subject = $email_subject;
                $mail->Body    =  $email_body;
                if(!$mail->send()){
                    echo "Mailer Error: " . $mail->ErrorInfo . "<br>";
                    $m_error = true;
                    $m_error_count++;

                } else {
                    echo "<li>" . xlt('Email sent to') . ": " . text($pt_name) . " , " . text($pt_email) . "</li>";
                }
            }
        }
        ?>
    </ul>
    <?php
    if ($m_error) {
        echo '<div class="alert alert-danger">' . xlt('Could not send email due to a server problem.') . ' ' . text($m_error_count) . ' ' . xlt('emails not sent') . '</div>';
    }

    ?>
</main>
</body>
</html>
