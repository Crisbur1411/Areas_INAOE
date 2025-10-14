<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./model/db_connection.php')){
    require_once './model/db_connection.php';
}else if(file_exists('../../model/db_connection.php')){
    require_once  '../../model/db_connection.php';
}else if(file_exists('../../../model/db_connection.php')){
    require_once  '../../../model/db_connection.php';
}

class liberacionArea{

// LISTAR ESTUDIANTES EN PROGRESO
public function listStudentInProgress(){
    $con = new DBconnection(); 
    $con->openDB();
    session_start();
    $fk_area_real = $_SESSION["id_area"]; // id de la tabla areas
    $id_user = $_SESSION["id_user"];      // id del usuario actual

    // Obtener id_user_area
    $userAreaQuery = $con->query("
        SELECT id_user_area 
        FROM user_area 
        WHERE fk_user = $id_user 
          AND fk_area = $fk_area_real
    ");
    if(!$userAreaQuery || pg_num_rows($userAreaQuery) == 0){
        $con->closeDB();
        return [];
    }
    $userAreaRow = pg_fetch_assoc($userAreaQuery);
    $id_user_area = $userAreaRow['id_user_area'];

    $dataR = $con->query("
        SELECT 
            s.id_student, 
            CONCAT(s.name, ' ', s.surname, ' ', s.second_surname) AS full_name,
            s.control_number,                                    
            s.status,
            s.fk_process_catalog,
            pc.description AS process_name,
            SUM(CASE WHEN n.fk_area = $fk_area_real THEN 1 ELSE 0 END) AS note_count
        FROM students s
        JOIN process_catalog pc 
            ON pc.id_process_catalog = s.fk_process_catalog
        JOIN process_stages ps
            ON ps.fk_process_catalog = pc.id_process_catalog
            AND ps.status = 1
            AND ps.status_process_stages = 1
        JOIN users u
            ON u.id_user = ps.fk_process_manager
        JOIN user_area ua
            ON ua.fk_user = u.id_user
            AND ua.id_user_area = $id_user_area
        LEFT JOIN notes n 
            ON n.fk_student = s.id_student
        WHERE s.status = 2
        AND NOT EXISTS (
            SELECT 1 
            FROM trace_student_areas tsa
            WHERE tsa.fk_student = s.id_student 
              AND tsa.fk_area = $id_user_area
        )
        GROUP BY 
            s.id_student, 
            CONCAT(s.name, ' ', s.surname, ' ', s.second_surname),
            s.control_number,
            s.status,
            s.fk_process_catalog,
            pc.description
        ORDER BY s.id_student;
    ");

    $data = [];
    while($row = pg_fetch_array($dataR)){
        $data[] = [
            "id_student"=>$row["id_student"],
            "full_name"=>$row["full_name"],
            "control_number"=>$row["control_number"],
            "note_count"=>$row["note_count"],
            "status" => $row["status"],
            "fk_process_catalog" => $row["fk_process_catalog"],
            "process_name" => $row["process_name"]
        ];
    }

    $con->closeDB();
    return $data;
}

// LIBERAR ESTUDIANTE
public function signStudent($id_student, $user, $full_name, $id_user, $fk_process_catalog){
    $con = new DBconnection();
    $con->openDB();
    $descrip = 'Autorizado por: '.$user;
    $clave = 'Lib3r4c10n-1N403';
    $algoritmo = 'SHA256';
    $version = 'FES_v1.0';

    session_start();
    $fk_area_real = $_SESSION["id_area"]; 

    // Fecha actual
    $date = date('Y-m-d H:i:s');
    
    //datos de documento y estudiante para hash
                        $dataDocumentStudentQuery = $con->query("
                            SELECT 
                                fk_process_catalog AS id_proceso, 
                                date_register AS fecha_registro, 
                                name AS nombre_estudiante, 
                                surname AS apellido_paterno, 
                                second_surname AS apellido_materno,
                                control_number AS matricula,
                                email AS correo,
                                fk_academic_programs AS programa,
                                fecha_conclusion
                            FROM students
                            WHERE id_student = $id_student
                        ");

// Obtener los datos en un array
$dataStudent = pg_fetch_assoc($dataDocumentStudentQuery);

if (!$dataStudent) {
    die("No se encontraron datos del estudiante con ID: $id_student");
}

// Construir los valores individuales
$id_proceso = trim($dataStudent['id_proceso']);
$fecha_registro = $dataStudent['fecha_registro'];
$nombre_estudiante = trim($dataStudent['nombre_estudiante']);
$apellidoP = trim($dataStudent['apellido_paterno']);
$apellidoM = trim($dataStudent['apellido_materno']);
$matricula = trim($dataStudent['matricula']);
$correo = trim($dataStudent['correo']);
$programa = trim($dataStudent['programa']);
$fecha_conclusion = trim($dataStudent['fecha_conclusion']);

// Obtener datos del firmante
$dataFirmanteQuery = $con->query("
        SELECT 
            a.name AS area_f,
            u.username AS correo_f,
            u.name AS nombre_f,
            u.surname AS apellido_paterno_f,
            u.second_surname AS apellido_materno_f
        FROM 
            users u
        INNER JOIN 
            user_area ua ON ua.fk_user = u.id_user
        INNER JOIN 
            areas a ON a.id_area = ua.fk_area
        WHERE 
            ua.fk_area = $fk_area_real
            AND ua.fk_user = $id_user
            AND u.status = 1
            AND a.status = 1
    ");

$dataFirmante = pg_fetch_assoc($dataFirmanteQuery);

    if (!$dataFirmante) {
        die("No se encontraron datos del firmante (área: $fk_area_real, usuario: $id_user)");
    }

    // Construir los valores del firmante
    $area_f = trim($dataFirmante['area_f']);
    $correo_f = trim($dataFirmante['correo_f']);
    $nombre_f = trim($dataFirmante['nombre_f']);
    $apellido_paterno_f = trim($dataFirmante['apellido_paterno_f']);
    $apellido_materno_f = trim($dataFirmante['apellido_materno_f']);

// Crear la cadena base para el hash
    $cadenaHash = 
        $id_student . '|' . 
        $id_proceso . '|' . 
        $fecha_registro . '|' . 
        $nombre_estudiante . '|' . 
        $apellidoP . '|' . 
        $apellidoM . '|' . 
        $matricula . '|' . 
        $correo . '|' . 
        $programa . '|' . 
        $fecha_conclusion . '|' .
        $area_f . '|' . 
        $correo_f . '|' . 
        $nombre_f . '|' . 
        $apellido_paterno_f . '|' . 
        $apellido_materno_f . '|' .
        $date . '|' .
        $clave . '|' .
        $algoritmo . '|' .
        $version;

    // Hash sha256
    $hash_release = hash('sha256', $cadenaHash);

    // Obtener id_user_area
    $userAreaQuery = $con->query("
        SELECT id_user_area 
        FROM user_area 
        WHERE fk_user = $id_user AND fk_area = $fk_area_real
    ");
    if(!$userAreaQuery || pg_num_rows($userAreaQuery) == 0){
        $con->closeDB();
        return ["success" => false, "message" => "No existe relación user_area para este usuario y área"];
    }
    $userAreaRow = pg_fetch_assoc($userAreaQuery);
    $id_user_area = $userAreaRow['id_user_area'];

    // Obtener fk_process_stage
    $dataProcess = $con->query("
        SELECT ps.id_process_stages
        FROM process_stages ps
        WHERE ps.status = 1
          AND ps.fk_process_manager = $id_user
          AND ps.fk_process_catalog = $fk_process_catalog
    ");
    $row = pg_fetch_assoc($dataProcess);
    if(!$row){
        $con->closeDB();
        return ["success" => false, "message" => "No se encontró proceso para este usuario y catálogo"];
    }
    $fk_process_stages = $row['id_process_stages'];

    // Insertar en trace_student_areas
    $insertQuery = "
        INSERT INTO trace_student_areas 
            (fk_student, description, date, fk_area, status, hash_release, fk_process_stage)
        VALUES 
            ($id_student, '$descrip', '$date', $id_user_area, 2, '$hash_release', $fk_process_stages)
        RETURNING id_trace_student_area
    ";
    $updateTurn = $con->query($insertQuery);
    if(!$updateTurn){
        $error = pg_last_error($con->connection);
        $con->closeDB();
        return ["success" => false, "message" => "Error insertando: $error"];
    }

    $validateUpdateTurn = pg_fetch_row($updateTurn);
    if ($validateUpdateTurn && $validateUpdateTurn[0] > 0){
        $con->closeDB();
        return ["success" => true, "id_trace_student_area" => $validateUpdateTurn[0]];
    } else {
        $con->closeDB();
        return ["success" => false, "message" => "Error desconocido al insertar trace_student_areas"];
    }
}

// LISTAR ESTUDIANTES LIBERADOS
public function listStudentFree(){
    $con = new DBconnection(); 
    $con->openDB();
    session_start();
    $fk_area_real = $_SESSION["id_area"]; // id de la tabla areas
    $id_user = $_SESSION["id_user"];      // id del usuario actual

    // Obtener id_user_area
    $userAreaQuery = $con->query("
        SELECT id_user_area 
        FROM user_area 
        WHERE fk_user = $id_user 
          AND fk_area = $fk_area_real
    ");
    if(!$userAreaQuery || pg_num_rows($userAreaQuery) == 0){
        $con->closeDB();
        return [];
    }
    $userAreaRow = pg_fetch_assoc($userAreaQuery);
    $id_user_area = $userAreaRow['id_user_area'];

    $dataR = $con->query("
        SELECT 
    s.id_student, 
    CONCAT(s.name, ' ', s.surname, ' ', s.second_surname) AS full_name,
    s.control_number,                                    
    s.status,
    s.fk_process_catalog,
    pc.description AS process_name
FROM students s
JOIN process_catalog pc 
    ON pc.id_process_catalog = s.fk_process_catalog
WHERE s.status = 2
  AND EXISTS (
      SELECT 1 
      FROM trace_student_areas tsa
      WHERE tsa.fk_student = s.id_student 
        AND tsa.fk_area = $id_user_area
  )
GROUP BY 
    s.id_student, 
    s.name, s.surname, s.second_surname,
    s.control_number,
    s.status,
    s.fk_process_catalog,
    pc.description
ORDER BY s.id_student;
    ");

    $data = [];
    while($row = pg_fetch_array($dataR)){
        $data[] = [
            "id_student"=>$row["id_student"],
            "full_name"=>$row["full_name"],
            "control_number"=>$row["control_number"],
            "status" => $row["status"],
            "process_name" => $row["process_name"]
        ];
    }

    $con->closeDB();
    return $data;
}


    public function noteStudent($id_student, $user, $motivo){
        $con=new DBconnection();
        $con->openDB();
        $descrip = 'Nota por el usuario: '.$user.' por el motivo: '.$motivo;

        session_start();
        $fk_area  = $_SESSION["id_area"];

        $updateTurn = $con->query("INSERT INTO notes (fk_student, fk_area, description, date) 
                                    VALUES (".$id_student.", ".$fk_area.", '".$descrip."', NOW()) RETURNING id_note ");

        $validateUpdateTurn = pg_fetch_row($updateTurn);

        if ( $validateUpdateTurn > 0)
        {            
            $con->closeDB();
            return $validateUpdateTurn[0];
        }
        else
        {
            $con->closeDB();
            return "error"; 
        }
    }

    public function notesStudent($id_student){
        $con=new DBconnection(); 
        $con->openDB();

        session_start();
        $fk_area  = $_SESSION["id_area"];

        $dataR = $con->query("SELECT notes.id_note, notes.fk_area, CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name, 
                                notes.description, to_char(notes.date, 'YYYY-MM-DD HH24:MI:SS') AS formatted_date, notes.status  FROM notes
                                INNER JOIN students ON students.id_student = notes.fk_student
                                WHERE fk_student= ".$id_student." AND fk_area = ". $fk_area ."
                                ORDER BY notes.date;
                            ");

        $data = array();

        while($row = pg_fetch_array($dataR)){
            $dat = array(
                "id_note"=>$row["id_note"],
                "fk_area"=>$row["fk_area"],
                "full_name"=>$row["full_name"],
                "formatted_date"=>$row["formatted_date"],
                "description"=>$row["description"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    public function passwordOk($password){
        $con=new DBconnection(); 
        $con->openDB();

        session_start();
        $id_user  = $_SESSION["id_user"];

        $dataR = $con->query("SELECT 
                            CASE
                                WHEN password = '".$password."' THEN true
                                ELSE false
                            END AS success,
                            CASE
                                WHEN password =  '".$password."' THEN ''
                                ELSE 'Contraseña incorrecta'
                            END AS message
                        FROM users
                        WHERE id_user = ".$id_user);


        $data = array();

        while($row = pg_fetch_array($dataR)){
            $dat = array(
                "success"=>$row["success"],
                "message"=>$row["message"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }



public function listStudentCancel()
    {
        $con = new DBconnection();
        $con->openDB();

        $dataR = $con->query("SELECT 
                                        s.id_student, 
                                        CONCAT(s.name, ' ', s.surname, ' ', s.second_surname) AS full_name,
                                        s.control_number, 
                                        COUNT(tsa.fk_area) AS areas_count,  
                                        DATE(tsa.date) AS date,
                                        s.status,
                                        pc.description AS process_name
                                    FROM students s
                                    LEFT JOIN trace_student_areas tsa 
                                        ON tsa.fk_student = s.id_student
                                    JOIN process_catalog pc
                                        ON pc.id_process_catalog = s.fk_process_catalog
                                    WHERE s.status = 4 
                                    AND tsa.status = 4
                                    GROUP BY 
                                        s.id_student, 
                                        s.name, s.surname, s.second_surname,
                                        s.control_number,
                                        DATE(tsa.date),
                                        s.status,
                                        pc.description
                                    ORDER BY 
                                        s.id_student;
                                    ");

        $data = array();

        while ($row = pg_fetch_array($dataR)) {
            $dat = array(
                "id_student" => $row["id_student"],
                "full_name" => $row["full_name"],
                "control_number" => $row["control_number"],
                "date" => $row["date"],
                "status" => $row["status"],
                "process_name" => $row["process_name"]
            );
            $data[] = $dat;
        }
        $con->closeDB();

        return $data;
    }


    public function studentNoteEdit($id_note, $user, $motivo){
    $con = new DBconnection();
    $con->openDB();
    $descrip = 'Nota por el usuario: '.$user.' por el motivo: '.$motivo;

    $updateNoteUser = $con->query("UPDATE notes SET description = '".$descrip."' 
                                        WHERE id_note = ".$id_note." ");

    // Verificar cuántas filas fueron afectadas
    $rowsAffected = pg_affected_rows($updateNoteUser);

    if ($rowsAffected > 0) {
        $con->closeDB();
        return "success";
    } else {
        $con->closeDB();
        return "error";
    }
}




public function getDetailsStudent($id_student)
{
    $con = new DBconnection();
    $con->openDB();

    $dataR = $con->query("SELECT s.id_student,
        CONCAT(s.name, ' ', s.surname, ' ', s.second_surname, ' ') AS full_name,
        s.control_number,
        s.email,
        s.institucion,
        s.fecha_conclusion,
        p.name AS programa_academico
        FROM students AS s
        JOIN academic_programs AS p
        ON s.fk_academic_programs = p.id_academic_programs
        WHERE s.id_student = " . $id_student . ";");

    $data = null;

    if ($row = pg_fetch_array($dataR)) {
        $data = array(
            "id_student" => $row["id_student"],
            "full_name" => $row["full_name"],
            "control_number" => $row["control_number"],
            "email" => $row["email"],
            "institucion" => $row["institucion"],
            "fecha_conclusion" => $row["fecha_conclusion"],
            "programa_academico" => $row["programa_academico"]
        );
    }

    $con->closeDB();

    return array("status" => 200, "data" => $data);
}





public function getAreaNameBySession(){
    $con = new DBconnection(); 
    $con->openDB();
    session_start();
    $fk_area  = $_SESSION["id_area"];

        $query = $con->query("SELECT name AS area_name FROM areas WHERE id_area = $fk_area LIMIT 1");

        $areaName = "";
        if($query && pg_num_rows($query) > 0){
            $row = pg_fetch_assoc($query);
            $areaName = $row['area_name'];
        }

        $con->closeDB();
        return ["area_name" => $areaName];

}


}
?>