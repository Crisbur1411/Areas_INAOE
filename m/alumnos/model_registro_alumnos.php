<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
}

class registroalumnos{

    public function getCourses($program){
        $con=new DBconnection();
        $con->openDB();

        $ar = $con->query("SELECT id_academic_programs, name FROM academic_programs WHERE status = 1 AND type = ".$program.";");

        $data = array();

        while($row = pg_fetch_array($ar)){
            $dat = array(
                "id_academic_programs"=>$row["id_academic_programs"],
                "name"=>$row["name"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        return $data;
    }

    public function saveStudent ($name, $surname, $secondsurname, $email, $controlnumber, $course)
    {
        $con=new DBconnection();
        $con->openDB();

        $studentData = $con->query("INSERT INTO students (name, surname, second_surname, control_number, email, fk_academic_programs, date_register) 
        VALUES ('".$name."','".$surname."', '".$secondsurname."','".$controlnumber."','".$email."',".$course.",NOW()) 
        RETURNING id_student");

        
        $validateStudentData = pg_fetch_row($studentData);

        if ( $validateStudentData > 0)
        {            
            $con->closeDB();
            return $validateStudentData[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }

    public function userArea($id_user, $area){
        $con=new DBconnection();
        $con->openDB();

        $userAreaData = $con->query("INSERT INTO user_area (fk_user, fk_area) 
        VALUES (".$id_user.",".$area.") 
        RETURNING id_user_area");

        
        $validateUserAreaData = pg_fetch_row($userAreaData);

        if ( $validateUserAreaData > 0)
        {            
            $con->closeDB();
            return $validateUserAreaData[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }

    
}
?>