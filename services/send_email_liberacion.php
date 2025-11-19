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
$procesoEstudiante = $student['process_name'];




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
$asunto = "Conclusión de proceso – Sistema de Liberación de Adeudos Institucionales";
$usuario = "m.valencia";
$contrasena = "25v4l3ncia.Mig";
$servidorCorreo = "ccc.inaoep.mx";

// Fecha
$currentTime = date("Y-m-d H:i:s");

// Armar mensaje al estudiante
$mensajeCorreo  = "Estimado(a) $nombreEstudiante,\n\n";
$mensajeCorreo .= "Te informamos que tu trámite dentro del Sistema de Liberación de Adeudos Académicos ha concluido exitosamente.\n\n";
$mensajeCorreo .= "Nombre del proceso: $procesoEstudiante\n\n";
$mensajeCorreo .= "Por favor, continúa con los trámites correspondientes en la Dirección de Formación Académica, según las indicaciones establecidas para tu proceso.\n\n";
$mensajeCorreo .= "Quedamos a tu disposición para cualquier duda o aclaración.\n\n";
$mensajeCorreo .= "Fecha de aviso: $currentTime\n\n";
$mensajeCorreo .= "Saludos cordiales,\n";
$mensajeCorreo .= "Dirección de Formación Académica\n";
$mensajeCorreo .= "Instituto Nacional de Astrofísica, Óptica y Electrónica (INAOE)";


// Enviar correo al estudiante
if (enviarCorreoLiberacion($correoEstudiante, $asunto, $mensajeCorreo, $usuario, $contrasena, $servidorCorreo)) {
    echo json_encode(['status' => 'success', 'message' => "Correo enviado a $correoEstudiante"]);
} else {
    echo json_encode(['status' => 'error', 'message' => "Error al enviar correo a $correoEstudiante"]);
}

?>
