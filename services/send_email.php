<?php
date_default_timezone_set("America/Mexico_City");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Cargar PHPMailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';
require 'phpmailer/SMTP.php';

// Configuración
$config = require 'config.php';

// Cargar modelo de emails
require_once __DIR__ . '/../m/email/model_email.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Obtener correos desde modelo
$emailModel = new EmailModel();
$emails = $emailModel->listEmails();

if (empty($emails)) {
    echo json_encode(['status' => 'error', 'message' => 'No hay correos disponibles']);
    exit;
}

// Crear correo
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = $config['smtp_host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $config['smtp_username'];
    $mail->Password   = $config['smtp_password'];
    $mail->SMTPSecure = $config['smtp_secure'];
    $mail->Port       = $config['smtp_port'];
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom($config['from_email'], $config['from_name']);

    // Agregar cada correo destinatario
    foreach ($emails as $email) {
        $mail->addAddress($email);
    }

    $mail->isHTML(true);
    $mail->Subject = 'Aviso de nuevo estudiante registrado';

    $currentTime = date("Y-m-d H:i:s");

    $mail->Body = "
        <div style='font-family: Arial, sans-serif; text-align: center;'>
            <h3 style='color: #333;'>Aviso de Registro</h3>
            <p>Se ha registrado un nuevo estudiante en el sistema.</p>
            <small>Fecha de aviso: $currentTime</small>
        </div>
    ";

    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'Correo enviado correctamente a todos los destinatarios']);
    
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error al enviar correo: ' . $mail->ErrorInfo]);
}
?>
