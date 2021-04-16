<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

$mail = new PHPMailer(true);

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  $phone = $_POST['phone'];
  $subject = $_POST['subject'];

  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lisbethportillo5574@gmail.com'; // Dirección de Gmail que desea utilizar como servidor SMTP
    $mail->Password = 'LisAlex:)'; // Contraseña de la dirección de Gmail
    //$mail->SMTPSecure = 'tls';
    //$mail->SMTPSecure = 'ssl';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('lisbethportillo5574@gmail.com'); // Dirección de Gmail que usó como servidor SMTP
    $mail->addAddress('lisbethportillo5574@gmail.com'); // Dirección de correo electrónico donde desea recibir correos electrónicos (puede usar cualquiera de sus direcciones de gmail, incluida la dirección de gmail que usó como servidor SMTP)

    $mail->isHTML(true);
    $mail->Subject = "Mensaje recibido sobre $subject";
    $mail->Body = "<h3>Nombre : $name <br>Email: $email <br>Mensaje : $message</h3><br>Contacto : $phone</h3>";

    $mail->send();
    echo '1';

  } catch (Exception $e) {
    echo "asdfa $e";
  }
}
?>

