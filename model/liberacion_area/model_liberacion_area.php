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

    public function listStudentInProgress(){
        $con=new DBconnection(); 
        $con->openDB();
        session_start();
        $fk_area  = $_SESSION["id_area"];

        $dataR = $con->query("SELECT 
    students.id_student, 
    CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name,
    students.control_number,                                    
    students.status,
    students.fk_process_catalog,
    SUM(CASE WHEN notes.fk_area = ".$fk_area." THEN 1 ELSE 0 END) AS note_count
FROM students
LEFT JOIN trace_student_areas 
    ON trace_student_areas.fk_student = students.id_student
LEFT JOIN notes 
    ON notes.fk_student = students.id_student
WHERE students.status = 2
AND NOT EXISTS (
    SELECT 1 
    FROM trace_student_areas 
    WHERE fk_student = students.id_student 
    AND fk_area = ".$fk_area."
)
GROUP BY 
    students.id_student, 
    CONCAT(students.name, ' ', students.surname, ' ', students.second_surname),
    students.control_number,
    students.status,
    students.fk_process_catalog
ORDER BY students.id_student;
                                    ");

        $data = array();

        while($row = pg_fetch_array($dataR)){
            $dat = array(
                "id_student"=>$row["id_student"],
                "full_name"=>$row["full_name"],
                "control_number"=>$row["control_number"],
                "note_count"=>$row["note_count"],
                "status" => $row["status"],
                "fk_process_catalog" => $row["fk_process_catalog"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    public function signStudent($id_student, $user, $full_name, $id_user, $fk_process_catalog){
    $con = new DBconnection();
    $con->openDB();
    $descrip = 'Autorizado por: '.$user;
    $clave = 'Lib3r4c10n-1N403';

    session_start();
    $fk_area  = $_SESSION["id_area"];

    // Fecha actual desde PHP
    $date = date('Y-m-d H:i:s');

    // Hash sha256(id_student|user|fecha|clave)
    $hash_release = hash('sha256', $date . '|' . $full_name . '|' . $user . '|' . $clave);

    //Se genera el fk_process_stages para agregar el registro en la tabla trace_student_areas
    //Se obtiene mediante el id_user y el fk_area del usuario relacionados al proceso que se libero libero
    $dataProcess = $con->query("SELECT
                                            process_stages.id_process_stages,
											 process_stages.fk_process_manager,
                                            CONCAT(users.name, ' ', users.surname, ' ', users.second_surname) AS name_user,
											 areas.id_area AS id_area_user,
                                            areas.name AS area_user
                                        FROM process_stages
                                        INNER JOIN process_catalog ON process_stages.fk_process_catalog = process_catalog.id_process_catalog
                                        INNER JOIN users ON process_stages.fk_process_manager = users.id_user
                                        INNER JOIN user_area ON users.id_user = user_area.fk_user
                                        INNER JOIN areas ON user_area.fk_area = areas.id_area
                                        WHERE
                                            process_stages.status = 1
                                            AND process_stages.fk_process_manager = ".$id_user."
												AND areas.id_area = ".$fk_area."
                                                    AND process_stages.fk_process_catalog = ".$fk_process_catalog."");
    $row = pg_fetch_assoc($dataProcess);
    if($row){
        $fk_process_stages = $row['id_process_stages'];
    } else {
        $con->closeDB();
        return "error"; // No se encontró el proceso
    }

    $updateTurn = $con->query("INSERT INTO trace_student_areas (fk_student, description, date, fk_area, status, hash_release, fk_process_stage) 
                                VALUES (".$id_student.", '".$descrip."', '".$date."', ".$fk_area.", 2, '".$hash_release."' , ".$fk_process_stages.") 
                                RETURNING id_trace_student_area ");

    $validateUpdateTurn = pg_fetch_row($updateTurn);

    if ($validateUpdateTurn > 0)
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



    public function listStudentFree(){
        $con=new DBconnection(); 
        $con->openDB();
        session_start();
        $fk_area  = $_SESSION["id_area"];

        $dataR = $con->query("SELECT students.id_student, 
                                        CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name,
                                        students.control_number,                                    
                                        students.status
                                FROM students
                                LEFT JOIN trace_student_areas ON trace_student_areas.fk_student = students.id_student
                                WHERE students.status = 2 
                                AND EXISTS (
                                    SELECT 1 FROM trace_student_areas 
                                    WHERE fk_student = students.id_student 
                                    AND fk_area = ".$fk_area." 
                                )
                                GROUP BY students.id_student, 
                                        CONCAT(students.name, ' ', students.surname, ' ', students.second_surname),
                                        students.control_number,
                                        students.status
                                ORDER BY students.id_student;
                                    ");

        $data = array();

        while($row = pg_fetch_array($dataR)){
            $dat = array(
                "id_student"=>$row["id_student"],
                "full_name"=>$row["full_name"],
                "control_number"=>$row["control_number"],
                "status" => $row["status"]
            );
            $data[] = $dat;
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

        $dataR = $con->query("SELECT students.id_student, 
                                    CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name,
                                    students.control_number, 
                                    COUNT(trace_student_areas.fk_area) AS areas_count,  
                                    DATE(trace_student_areas.date) AS date,
                                    students.status
                                    FROM 
                                        students
                                    LEFT JOIN 
                                        trace_student_areas ON trace_student_areas.fk_student = students.id_student
                                    WHERE 
                                        students.status = 4 AND trace_student_areas.status= 4
                                    GROUP BY 
                                        students.id_student, 
                                        CONCAT(students.name, ' ', students.surname, ' ', students.second_surname),
                                        students.control_number,
                                        DATE(trace_student_areas.date),
                                        students.status
                                    ORDER BY 
                                        students.id_student;
                                    ");

        $data = array();

        while ($row = pg_fetch_array($dataR)) {
            $dat = array(
                "id_student" => $row["id_student"],
                "full_name" => $row["full_name"],
                "control_number" => $row["control_number"],
                "date" => $row["date"],
                "status" => $row["status"]
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



}
?>