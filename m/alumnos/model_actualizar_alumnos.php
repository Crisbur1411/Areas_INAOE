<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
}

class actualizar_alumnos{

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

    public function coursesAds($id_student){
        $con=new DBconnection();
        $con->openDB();

        $dataCourseAd = $con->query("SELECT academic_programs.id_academic_programs AS id_academic_programs, academic_programs.name FROM students
                                        INNER JOIN academic_programs ON students.fk_academic_programs = academic_programs.id_academic_programs
                                        WHERE id_student = ". $id_student);

        $data = array();

        while($row = pg_fetch_array($dataCourseAd)){
            $dat = array(
                "id_academic_programs" =>$row["id_academic_programs"],
                "name" =>$row["name"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    public function getState(){
        $con=new DBconnection();
        $con->openDB();

        $inst = $con->query("SELECT id, name FROM  states");

        $data = array();

        while($row = pg_fetch_array($inst)){
            $dat = array(
                "id"=>$row["id"],
                "name"=>$row["name"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        return $data;
    }

   public function getStudent($id_student){
        $con=new DBconnection();
        $con->openDB();

        $dataR = $con->query("SELECT students.id_student, students.name, students.surname, students.second_surname, students.control_number, students.email, students.status FROM students WHERE id_student=". $id_student);
        $data = array();

        while($row = pg_fetch_array($dataR)){
            $dat = array(
                "id_student" =>$row["id_student"],
                "name" =>$row["name"], 
                "surname" =>$row["surname"],
                "second_surname" =>$row["second_surname"],
                "control_number" =>$row["control_number"],
                "email" =>$row["email"],
                "status" =>$row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }


    public function updateStudent ($id_student, $name, $surname, $secondsurname, $email, $controlnumber, $course)    {
        $con=new DBconnection();
        $con->openDB();

        $updateData = $con->query("UPDATE students SET name = '".$name."', surname = '" .$surname."', second_surname = '" .$secondsurname."', email = '" .$email."', control_number = '" .$controlnumber."', fk_academic_programs = " .$course."
         WHERE id_student= ". $id_student ." RETURNING id_student ");

        $validateupdateData = pg_fetch_row($updateData);

        if ( $validateupdateData > 0)
        {            
            $con->closeDB();
            return $validateupdateData[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }
}
?>