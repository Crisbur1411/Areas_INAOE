<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
}

class liberacionArea{

    public function listStudentInProgress(){
        $con=new DBconnection(); 
        $con->openDB();
        session_start();
        $fk_area  = $_SESSION["id_area"];

        $dataR = $con->query("SELECT students.id_student, 
                                CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name,
                                students.control_number,                                    
                                students.status,
                                    COUNT(notes.id_note) AS note_count
                            FROM students
                            LEFT JOIN trace_student_areas ON trace_student_areas.fk_student = students.id_student
                            LEFT JOIN notes ON notes.fk_student = students.id_student
                            WHERE students.status = 2
                            AND NOT EXISTS (
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
                "note_count"=>$row["note_count"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    public function signStudent($id_student, $user){
    $con = new DBconnection();
    $con->openDB();
    $descrip = 'Autorizado por: '.$user;

    session_start();
    $fk_area  = $_SESSION["id_area"];

    // Fecha actual desde PHP
    $date = date('Y-m-d H:i:s');

    // Hash md5(id_student|user|fecha)
    $hash_release = md5($id_student . '|' . $user . '|' . $date);

    $updateTurn = $con->query("INSERT INTO trace_student_areas (fk_student, description, date, fk_area, status, hash_release) 
                                VALUES (".$id_student.", '".$descrip."', '".$date."', ".$fk_area.", 2, '".$hash_release."') 
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


}
?>