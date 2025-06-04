<?php
date_default_timezone_set("America/Mexico_City");

// Cargar modelo de emails
require_once __DIR__ . '/../m/email/model_email.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Validar parámetros
$id_student = isset($_GET['id_student']) ? $_GET['id_student'] : null;
$proceso = isset($_GET['proceso']) ? $_GET['proceso'] : 'Proceso de Liberación'; // por si quieres enviarlo por GET

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

// Solo debería haber un registro, así que tomamos el primero
$student = $studentData[0];
$nombreEstudiante = $student['full_name'];
$correoEstudiante = $student['email'];

// Obtener lista de destinatarios
$correosDestinatarios = $emailModel->listEmails();
if (empty($correosDestinatarios)) {
    echo json_encode(['status' => 'error', 'message' => 'No se encontraron destinatarios']);
    exit;
}

// Cargar PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Función para enviar correo
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
$asunto = "Aviso de registro de estudiante en Sistema de No Adeudo";
$usuario = "m.valencia";
$contrasena = "25v4l3ncia.Mig";
$servidorCorreo = "ccc.inaoep.mx";

// Fecha actual formateada
$fecha = new DateTime();
$formatter = new IntlDateFormatter(
    'es_MX', // idioma y país
    IntlDateFormatter::LONG, // formato largo de fecha
    IntlDateFormatter::MEDIUM, // formato medio de hora
    'America/Mexico_City',
    IntlDateFormatter::GREGORIAN,
    "d 'de' MMMM 'de' yyyy, HH:mm:ss"
);

$currentTime = date("Y-m-d H:i:s");



// Enlace al sistema
$enlaceSistema = "http://adria.inaoep.mx:11038/liberacion_maina_funcional/";

// Armar el cuerpo del correo
$mensajeCorreo = "Estimado/a Responsable de Área,\n\n";
$mensajeCorreo .= "Le informamos que se ha registrado un nuevo estudiante en el Sistema de Liberación de No Adeudo de Bienes y Servicios del INAOE.\n\n";
$mensajeCorreo .= "El estudiante: $nombreEstudiante\n\n";
$mensajeCorreo .= "Correo del estudiante: $correoEstudiante\n\n";
$mensajeCorreo .= "Realizará el proceso: $proceso\n\n";
$mensajeCorreo .= "Fecha de aviso: $currentTime\n\n";
$mensajeCorreo .= "Enlace de acceso al sistema: $enlaceSistema\n\n";
$mensajeCorreo .= "Le solicitamos ingresar al sistema para consultar la información y realizar el trámite correspondiente.\n\n";
$mensajeCorreo .= "Atentamente,\nSistema de No Adeudo Institucional\nDirección de Formación Académica – INAOE";

// Enviar a cada destinatario
$responses = [];
foreach ($correosDestinatarios as $correoDestino) {
    if (enviarCorreo($correoDestino, $asunto, $mensajeCorreo, $usuario, $contrasena, $servidorCorreo)) {
        $responses[] = "Correo enviado a $correoDestino";
    } else {
        $responses[] = "Error al enviar correo a $correoDestino";
    }
}

// Respuesta final
echo json_encode(['status' => 'success', 'data' => $responses]);

?>
