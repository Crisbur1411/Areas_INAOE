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

// Obtener nota del estudiante
$studentNotes = $emailModel->getNotes($id_student);
if (empty($studentNotes)) {
    echo json_encode(['status' => 'error', 'message' => 'No se encontraron notas para el estudiante']);
    exit;
}

$notesStudent = $studentNotes[0];
$nombreArea = $notesStudent['area_name'];
$descriptionNote = $notesStudent['note_description'];

// ------------------------------------------------------
// EXTRAER RESPONSABLE Y MOTIVO DESDE $descriptionNote
// ------------------------------------------------------
$nombreResponsable = '';
$motivo = '';

// Ejemplo esperado: "Nota por el usuario: ADRIANA TECUAPETLA MOYOTL por el motivo: Nos debe una chela!"
if (preg_match('/Nota por el usuario:\s*(.*?)\s*por el motivo:\s*(.*)/i', $descriptionNote, $matches)) {
    $nombreResponsable = trim($matches[1]);
    $motivo = trim($matches[2]);
} else {
    // Si el formato no coincide, se asigna toda la nota como motivo
    $motivo = trim($descriptionNote);
}

// ------------------------------------------------------
// Cargar PHPMailer
// ------------------------------------------------------
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Función para enviar correo
function enviarCorreoNotes($correoDestino, $asunto, $mensaje, $usuario, $contrasena, $servidorCorreo) {
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
$asunto = "Aviso de registro en el Sistema de No Adeudo Académico";
$usuario = "m.valencia";
$contrasena = "25v4l3ncia.Mig";
$servidorCorreo = "ccc.inaoep.mx";

// Fecha
$currentTime = date("Y-m-d H:i:s");

// Mensaje de correo con formato institucional
$mensajeCorreo  = "Estimado(a) Estudiante,\n\n";
$mensajeCorreo .= "Te informamos que el área de $nombreArea ha registrado una nota en el Sistema de No Adeudo Académico.\n\n";
$mensajeCorreo .= "Detalle del registro:\n";
$mensajeCorreo .= "Área: $nombreArea\n\n";
$mensajeCorreo .= "Nota registrada por: $nombreResponsable\n\n";
$mensajeCorreo .= "Motivo: $motivo\n\n";
$mensajeCorreo .= "Fecha de aviso: $currentTime\n\n";
$mensajeCorreo .= "Para cualquier aclaración o duda, puedes acudir con la persona responsable de tu área o con la Dirección de Formación Académica.\n\n";
$mensajeCorreo .= "Atentamente,\n";
$mensajeCorreo .= "Sistema de No Adeudo Académico\n";
$mensajeCorreo .= "Dirección de Formación Académica – INAOE";

// Enviar correo al estudiante
if (enviarCorreoNotes($correoEstudiante, $asunto, $mensajeCorreo, $usuario, $contrasena, $servidorCorreo)) {
    echo json_encode(['status' => 'success', 'message' => "Correo enviado a $correoEstudiante"]);
} else {
    echo json_encode(['status' => 'error', 'message' => "Error al enviar correo a $correoEstudiante"]);
}

?>
