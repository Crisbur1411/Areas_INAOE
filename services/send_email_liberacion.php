<?php
date_default_timezone_set("America/Mexico_City");

// Cargar modelo de emails
require_once __DIR__ . '/../model/email/model_email.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Validar parámetros
$id_student = isset($_GET['id_student']) ? $_GET['id_student'] : null;

if (!$id_student) {
    echo json_encode(['status' => 'error', 'message' => 'No se recibió id_student']);
    exit;
}

// Instanciar modelo
$emailModel = new EmailModel();

// Obtener datos del estudiante
$studentData = $emailModel->getDataStudent($id_student);
if (empty($studentData)) {
    echo json_encode(['status' => 'error', 'message' => 'No se encontraron datos del estudiante']);
    exit;
}

$student = $studentData[0];
$nombreEstudiante = $student['full_name'];
$correoEstudiante = $student['email'];




// Cargar PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Función para enviar correo
function enviarCorreoLiberacion($correoDestino, $asunto, $mensaje, $usuario, $contrasena, $servidorCorreo) {
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
        $mail->setFrom('m.valencia@inaoep.mx', 'Sistema de Liberación de Adeudos Institucionales');
        $mail->addAddress($correoDestino);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Parámetros de conexión al servidor de correo
$asunto = "Aviso conclución en el trámite de liberación de No Adeudo";
$usuario = "m.valencia";
$contrasena = "25v4l3ncia.Mig";
$servidorCorreo = "ccc.inaoep.mx";

// Fecha
$currentTime = date("Y-m-d H:i:s");

// Armar mensaje al estudiante
$mensajeCorreo = "Estimado/a $nombreEstudiante,\n\n";
$mensajeCorreo .= "Te informamos que tu trámite de liberación ha concluido, por lo cual puedes acudir a la oficina de la Dirección de Formación Académica para solicitar tu constancia de liberación.\n\n";
$mensajeCorreo .= "Fecha de aviso: $currentTime\n\n";
$mensajeCorreo .= "Atentamente,\nSistema de No Adeudo Institucional\nDirección de Formación Académica – INAOE";

// Enviar correo al estudiante
if (enviarCorreoLiberacion($correoEstudiante, $asunto, $mensajeCorreo, $usuario, $contrasena, $servidorCorreo)) {
    echo json_encode(['status' => 'success', 'message' => "Correo enviado a $correoEstudiante"]);
} else {
    echo json_encode(['status' => 'error', 'message' => "Error al enviar correo a $correoEstudiante"]);
}

?>
