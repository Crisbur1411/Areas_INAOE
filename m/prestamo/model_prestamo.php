<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
}



class prestamo{

public function listPrestamos(){
        $con=new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT 
                                            prestamo.id_prestamo, 
                                            prestamo.description, 
                                            prestamo.date_register, 
                                            CONCAT(students.name || ' ' || students.surname || ' ' || second_surname)
                                            AS student_name, prestamo.status
                                        FROM 
                                            prestamo
                                        INNER JOIN 
                                            students ON prestamo.fk_student = students.id_student
                                        WHERE 
                                            prestamo.status = 1;");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_prestamo"=>$row["id_prestamo"],
                "description"=>$row["description"],
                "date_register"=>$row["date_register"],
                "student_name"=>$row["student_name"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }




}