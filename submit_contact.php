<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';
require 'PHPMailer/PHPMailer/src/Exception.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp$gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'adenike.iyiola@bowen.edu.ng';
$mail->Password = '0862810583';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('iyiolaajay@gmail.com', 'Iyiola Ajibola');
$mail->addAddress('iyiolaanjolaoluwa@gmail.com');
$mail->Subject = 'Test Email';
$mail->Body = 'Hello this is a test';

if($mail->send()){
    echo 'Message sent!';
}
else{
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>