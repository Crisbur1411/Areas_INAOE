<?php
date_default_timezone_set("America/Mexico_City");

// Cargar modelo de emails
require_once __DIR__ . '/../m/email/model_email.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Función para enviar correo a un destinatario
function enviarCorreo($correoDestino, $asunto, $mensaje, $usuario, $contrasena, $servidorCorreo) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = $servidorCorreo;
        $mail->SMTPAuth = true;
        $mail->Username = $usuario;
        $mail->Password = $contrasena;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('m.valencia@inaoep.mx', 'Miguel');
        $mail->addAddress($correoDestino);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Parámetros del correo
$asunto = "Prueba de correo electrónico 2";
$mensaje = "Este es un mensaje de prueba.";
$usuario = "m.valencia";
$contrasena = "25v4l3ncia.Mig";
$servidorCorreo = "ccc.inaoep.mx";

// Obtener correos desde el modelo
$emailModel = new EmailModel();
$correos = $emailModel->listEmails();

foreach ($correos as $correoDestino) {
    if (enviarCorreo($correoDestino, $asunto, $mensaje, $usuario, $contrasena, $servidorCorreo)) {
        echo "Correo enviado exitosamente a $correoDestino.<br>";
    } else {
        echo "Error al enviar el correo a $correoDestino.<br>";
    }
}
?>
