<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./model/db_connection.php')){
    require_once './model/db_connection.php';
}else if(file_exists('../../model/db_connection.php')){
    require_once  '../../model/db_connection.php';
}else if(file_exists('../../../model/db_connection.php')){
    require_once  '../../../model/db_connection.php';
}



class prestamo{

public function listPrestamos(){
        $con=new DBconnection(); 
        $con->openDB();

        session_start();
        $id_user  = $_SESSION["id_user"];

        $dataTitle = $con->query("SELECT 
    prestamo.id_prestamo, 
    prestamo.description, 
    prestamo.date_register,
	prestamo.fk_employee,
	CONCAT(students.name || ' ' || students.surname || ' ' || second_surname)
    AS student_name, prestamo.status
FROM 
    prestamo
INNER JOIN 
    students ON prestamo.fk_student = students.id_student
WHERE 
    prestamo.status = 1 AND prestamo.fk_employee = $id_user  
    ORDER BY id_prestamo ASC;");

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




    
public function listPrestamosCancel(){
        $con=new DBconnection(); 
        $con->openDB();

        session_start();
        $id_user  = $_SESSION["id_user"];

        $dataTitle = $con->query("SELECT 
    prestamo.id_prestamo, 
    prestamo.description, 
    prestamo.date_register,
	prestamo.fk_employee,
	CONCAT(students.name || ' ' || students.surname || ' ' || second_surname)
    AS student_name, prestamo.status
FROM 
    prestamo
INNER JOIN 
    students ON prestamo.fk_student = students.id_student
WHERE 
    prestamo.status = 0 AND prestamo.fk_employee = $id_user  
 ORDER BY id_prestamo ASC;");

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


    public function listPrestamoFree(){
        $con=new DBconnection(); 
        $con->openDB();

        session_start();
        $id_user  = $_SESSION["id_user"];

        $dataTitle = $con->query("SELECT 
    prestamo.id_prestamo, 
    prestamo.description, 
    prestamo.date_register,
	prestamo.fk_employee,
	CONCAT(students.name || ' ' || students.surname || ' ' || second_surname)
    AS student_name, prestamo.status
FROM 
    prestamo
INNER JOIN 
    students ON prestamo.fk_student = students.id_student
WHERE 
    prestamo.status = 2 AND prestamo.fk_employee = $id_user  
 ORDER BY id_prestamo ASC;");

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



    public function getStudents(){
        $con=new DBconnection();
        $con->openDB();

        $ar = $con->query("SELECT students.id_student, 
                            CONCAT (students.name || ' ' || students.surname || ' ' || second_surname) 
                            AS full_name from students 
                            WHERE students.status = 1 ORDER BY full_name ASC;");

        $data = array();

        while($row = pg_fetch_array($ar)){
            $dat = array(
                "id_student"=>$row["id_student"],
                "full_name"=>$row["full_name"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        return $data;
    }


    public function getEmployee($email_employee){
        $con=new DBconnection();
        $con->openDB();

        $ar = $con->query("SELECT employee.id_employee, 
                            CONCAT (employee.name || ' ' || employee.surname || ' ' || second_surname) 
                            AS full_name_employee from employee 
                            WHERE employee.email = '$email_employee';");

        $data = array();

        while($row = pg_fetch_array($ar)){
            $dat = array(
                "id_employee"=>$row["id_employee"],
                "full_name_employee"=>$row["full_name_employee"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        return $data;
    }


public function savePrestamo($student, $description, $employee){

        $con=new DBconnection();
        $con->openDB();


        $prestamo = $con->query("INSERT INTO prestamo (description, fk_student, fk_employee, date_register) 
                                VALUES ('$description', $student, $employee, NOW())");


        $validateprestamo = pg_fetch_row($prestamo);


        if ($validateprestamo > 0)
        {
            $con->closeDB();
            return $validateprestamo[0];
        }

        else
        {
            
        $con->closeDB();
        return "error";
        }
    }



    public function getPrestamoInfo($id_prestamo){

        $con=new DBconnection(); 
        $con->openDB();

        $dataTypeUser = $con->query("SELECT prestamo.id_prestamo, prestamo.fk_student, prestamo.description FROM prestamo WHERE id_prestamo = $id_prestamo;");

        $row =  pg_fetch_array($dataTypeUser);

        $dataTypeUser = array(
            "id_prestamo"=>$row["id_prestamo"],
            "fk_student"=>$row["fk_student"],
            "description"=>$row["description"]
        );
        $con->closeDB();
        return array("status" => 200, "data" => $dataTypeUser);
    }



    public function savePrestamoEdit($id_prestamo, $fk_student, $description, $employee){

        $con=new DBconnection();
        $con->openDB();

        $prestamoDataEdit = $con->query("UPDATE prestamo SET fk_student = '".$fk_student."', description = '".$description."', fk_employee = '".$employee."' WHERE id_prestamo = ".$id_prestamo." RETURNING id_prestamo;");

        $validatePrestamoDataEdit = pg_fetch_row($prestamoDataEdit);

        if ($validatePrestamoDataEdit > 0)
        {
            $con->closeDB();
            return $validatePrestamoDataEdit[0];
        }

        else
        {
            
        $con->closeDB();
        return "error";
        }
    }



    public function deletePrestamo($id_prestamo){

        try{

        
        $con=new DBconnection();
        $con->openDB();

        $prestamoDataDelete = ("UPDATE prestamo SET status = 0 WHERE id_prestamo = '$id_prestamo'");
        $updateResult = $con->query($prestamoDataDelete);

        $con->closeDB();



        if ($updateResult )
        {
           $response = ['status' => 'success', 'message' => 'Prestamo eliminado correctamente'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error al eliminar el prestamo'];
        }
        }
        catch (Exception $e) {
            $response = ['status' => 'error', 'message' => 'Error al eliminar el prestamo: ' . $e->getMessage()];
        }
        return $response;
    }
 




    public function freePrestamo($id_prestamo){

        try{

        
        $con=new DBconnection();
        $con->openDB();

        $prestamoDataFree = ("UPDATE prestamo SET status = 2 WHERE id_prestamo = '$id_prestamo'");
        $updateResult = $con->query($prestamoDataFree);

        $con->closeDB();



        if ($updateResult )
        {
           $response = ['status' => 'success', 'message' => 'Prestamo liberado correctamente'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error al liberar el prestamo'];
        }
        }
        catch (Exception $e) {
            $response = ['status' => 'error', 'message' => 'Error al liberar el prestamo: ' . $e->getMessage()];
        }
        return $response;
    }

}