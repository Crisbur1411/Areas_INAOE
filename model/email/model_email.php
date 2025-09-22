<?php
date_default_timezone_set("America/Mexico_City");

require_once __DIR__ . '/../db_connection.php';

class EmailModel {

    public function getDataStudent($id_student) {
        $con = new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT id_student, 
                                        CONCAT(name, ' ', surname, ' ', second_surname) AS full_name,
                                        email
                                  FROM students 
                                  WHERE id_student = '$id_student';");

        $data = array();
        while($row = pg_fetch_assoc($dataTitle)){
            $data[] = [
                'id_student'   => $row['id_student'],
                'full_name'    => $row['full_name'],
                'email'        => $row['email']
            ];
        }

        $con->closeDB();
        return $data;
    }

    // 🔹 Traer responsables de cada etapa del proceso
    public function getProcessEmails($fk_process_catalog) {
        $con = new DBconnection();
        $con->openDB();

        $query = "SELECT 
                    ps.id_process_stages,
                    ps.execution_flow,
                    a.id_area,
                    a.details AS area_name,
                    u.id_user,
                    u.username AS email,
                    u.name || ' ' || u.surname || ' ' || u.second_surname AS full_name
                  FROM process_stages ps
                  INNER JOIN users u ON ps.fk_process_manager = u.id_user
                  INNER JOIN user_area ua ON u.id_user = ua.fk_user
                  INNER JOIN areas a ON ua.fk_area = a.id_area
                  WHERE ps.status = 1
                  AND ps.fk_process_catalog = $fk_process_catalog
                  ORDER BY ps.execution_flow ASC";

        $result = $con->query($query);

        $stages = [];
        while ($row = pg_fetch_assoc($result)) {
            $stages[] = $row;
        }

        $con->closeDB();
        return $stages;
    }

    // 🔹 Verificar si ya se cumplieron todos los flujos anteriores
    public function isPreviousFlowCompleted($id_student, $fk_process_catalog, $currentFlow) {
        $con = new DBconnection();
        $con->openDB();

        $query = "SELECT ps.id_process_stages
                  FROM process_stages ps
                  WHERE ps.status = 1
                  AND ps.fk_process_catalog = $fk_process_catalog
                  AND ps.execution_flow < $currentFlow";

        $result = $con->query($query);

        while ($row = pg_fetch_assoc($result)) {
            $stageId = $row["id_process_stages"];

            $check = $con->query("SELECT 1 
                                  FROM trace_student_areas 
                                  WHERE fk_student = '$id_student' 
                                  AND fk_process_stage = '$stageId' 
                                  AND status = 2 
                                  LIMIT 1");

            if (pg_num_rows($check) === 0) {
                $con->closeDB();
                return false; // un paso anterior no está completo
            }
        }

        $con->closeDB();
        return true;
    }

    // 🔹 Recuperar notas del estudiante (lo que tenías antes)
    public function getNotes($id_student) {
        $con = new DBconnection(); 
        $con->openDB();

        session_start();
        $area  = $_SESSION["id_area"];

        $dataTitle = $con->query("SELECT 
                                    a.details AS area_name,
                                    n.description AS note_description
                                  FROM notes n
                                  INNER JOIN areas a ON n.fk_area = a.id_area
                                  WHERE n.status = 1
                                  AND a.status = 1
                                  AND a.id_area = '$area'
                                  AND n.fk_student = '$id_student';");

        $data = [];
        while($row = pg_fetch_assoc($dataTitle)){
            $data[] = [
                'area_name'        => $row['area_name'],
                'note_description' => $row['note_description']
            ];
        }

        $con->closeDB();
        return $data;
    }


    // 🔹 Obtener el flujo actual del estudiante
public function getCurrentFlow($id_student, $fk_process_catalog) {
    $con = new DBconnection();
    $con->openDB();

    $query = "SELECT MAX(ps.execution_flow) AS current_flow
              FROM trace_student_areas tsa
              INNER JOIN process_stages ps ON tsa.fk_process_stage = ps.id_process_stages
              WHERE tsa.fk_student = '$id_student'
              AND ps.fk_process_catalog = '$fk_process_catalog'
              AND tsa.status = 2";

    $result = $con->query($query);
    $row = pg_fetch_assoc($result);

    $con->closeDB();
    return $row && $row["current_flow"] ? (int)$row["current_flow"] : 0;
}


// Verificar si todos los responsables del flujo actual han liberado al estudiante
public function isCurrentFlowCompleted($id_student, $fk_process_catalog, $currentFlow) {
    $con = new DBconnection();
    $con->openDB();

    // Traer todos los stages del flujo actual
    $query = "SELECT ps.id_process_stages
              FROM process_stages ps
              WHERE ps.status = 1
              AND ps.fk_process_catalog = $fk_process_catalog
              AND ps.execution_flow = $currentFlow";

    $result = $con->query($query);

    while ($row = pg_fetch_assoc($result)) {
        $stageId = $row["id_process_stages"];

        // Verificar que cada stage tenga liberación completada
        $check = $con->query("SELECT 1
                              FROM trace_student_areas
                              WHERE fk_student = '$id_student'
                              AND fk_process_stage = '$stageId'
                              AND status = 2
                              LIMIT 1");

        if (pg_num_rows($check) === 0) {
            $con->closeDB();
            return false; // aún hay liberaciones pendientes
        }
    }

    $con->closeDB();
    return true; // todos los encargados del flujo actual completaron
}
}
?>
