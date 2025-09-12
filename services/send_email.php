<?php
date_default_timezone_set("America/Mexico_City");

// Cargar modelo de emails
require_once __DIR__ . '/../model/email/model_email.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$id_student = $_GET['id_student'] ?? null;
$fk_process_catalog = $_GET['fk_process_catalog'] ?? null;
$proceso = $_GET['proceso'] ?? 'Proceso de Liberación';

if (!$id_student || !$fk_process_catalog) {
    echo json_encode(['status' => 'error', 'message' => 'Faltan parámetros']);
    exit;
}

$emailModel = new EmailModel();

// Datos estudiante
$studentData = $emailModel->getDataStudent($id_student);
if (empty($studentData)) {
    echo json_encode(['status' => 'error', 'message' => 'No se encontraron datos del estudiante']);
    exit;
}
$student = $studentData[0];
$nombreEstudiante = $student['full_name'];
$correoEstudiante = $student['email'];

// Traer pasos del proceso con responsables
$stages = $emailModel->getProcessEmails($fk_process_catalog);

// Configuración correo
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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

$asunto = "Aviso de registro de estudiante en Sistema de No Adeudo";
$usuario = "m.valencia";
$contrasena = "25v4l3ncia.Mig";
$servidorCorreo = "ccc.inaoep.mx";

$currentTime = date("Y-m-d H:i:s");
$enlaceSistema = "http://adria.inaoep.mx:11038/liberacion_maina_funcional/";

$responses = [];

// 🔹 Obtener el flujo actual del estudiante
$currentFlow = $emailModel->getCurrentFlow($id_student, $fk_process_catalog);

// 🔹 Verificar que todos los responsables del flujo actual hayan liberado
if (!$emailModel->isCurrentFlowCompleted($id_student, $fk_process_catalog, $currentFlow)) {
    echo json_encode([
        'status' => 'info',
        'data' => ["Aún no se han liberado todos los encargados del flujo actual, no se envía correo."]
    ]);
    exit;
}

// 🔹 Buscar el siguiente flujo
$nextFlow = null;
foreach ($stages as $stage) {
    $flow = $stage["execution_flow"];
    if ($flow > $currentFlow) {
        if ($nextFlow === null) $nextFlow = $flow; // solo el siguiente flujo inmediato
        if ($flow === $nextFlow) {
            $responsable = $stage["full_name"];
            $correoDestino = $stage["email"];

            $mensajeCorreo = "Estimado/a $responsable,\n\n";
            $mensajeCorreo .= "Se ha registrado el estudiante $nombreEstudiante en el proceso $proceso.\n\n";
            $mensajeCorreo .= "Correo del estudiante: $correoEstudiante\n";
            $mensajeCorreo .= "Fecha de aviso: $currentTime\n\n";
            $mensajeCorreo .= "Acceda al sistema: $enlaceSistema\n\n";
            $mensajeCorreo .= "Atentamente,\nSistema de No Adeudo Institucional";

            if (enviarCorreo($correoDestino, $asunto, $mensajeCorreo, $usuario, $contrasena, $servidorCorreo)) {
                $responses[] = "Correo enviado a $correoDestino (flujo $flow)";
            } else {
                $responses[] = "Error al enviar a $correoDestino (flujo $flow)";
            }
        }
    }
}

if (empty($responses)) {
    $responses[] = "No hay siguientes flujos pendientes para este estudiante";
}

echo json_encode(['status' => 'success', 'data' => $responses]);

?>
