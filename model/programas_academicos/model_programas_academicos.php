<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./model/db_connection.php')){
    require_once './model/db_connection.php';
}else if(file_exists('../../model/db_connection.php')){
    require_once  '../../model/db_connection.php';
}else if(file_exists('../../../model/db_connection.php')){
    require_once  '../../../model/db_connection.php';
}


class programasAcademicos{

    public function listPrograms(){
        $con=new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT id_academic_programs, cve, name, type_program, status FROM academic_programs
                                        WHERE status = 1 ORDER BY id_academic_programs ASC;");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_academic_programs"=>$row["id_academic_programs"],
                "cve"=>$row["cve"],
                "name"=>$row["name"],
                "type_program"=>$row["type_program"],
                "status"=>$row["status"],
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }



    public function getProgramInfo($id_academic_programs){

        $con=new DBconnection(); 
        $con->openDB();

        $dataPrograms = $con->query("SELECT id_academic_programs, name, cve, type_program, type FROM academic_programs WHERE id_academic_programs = $id_academic_programs;");

        $row =  pg_fetch_array($dataPrograms);

        $dataPrograms = array(
            "id_academic_programs"=>$row["id_academic_programs"],
            "name"=>$row["name"],
            "cve"=>$row["cve"],
            "type_program"=>$row["type_program"],
            "type"=>$row["type"]

        );
        $con->closeDB();
        return array("status" => 200, "data" => $dataPrograms);
    }



    


    public function savePrograms($cve, $name, $type_program, $type){

        $con=new DBconnection();
        $con->openDB();


        $programData = $con->query("INSERT INTO academic_programs (cve, name, type, type_program) 
        VALUES ('".$cve."', '".$name."', '".$type."', '".$type_program."')
        RETURNING id_academic_programs;");


        $validateProgramData = pg_fetch_row($programData);


        if ($validateProgramData > 0)
        {
            $con->closeDB();
            return $validateProgramData[0];
        }

        else
        {
            
        $con->closeDB();
        return "error";
        }
    }


public function saveProgramEdit($id_academic_programs, $cve, $name, $type, $type_program){

        $con=new DBconnection();
        $con->openDB();

        $programDataEdit = $con->query("UPDATE academic_programs SET cve = '".$cve."', name = '".$name."', type = '".$type."', type_program = '".$type_program."' WHERE id_academic_programs = ".$id_academic_programs." RETURNING id_academic_programs;");

        $validateProgramDataEdit = pg_fetch_row($programDataEdit);

        if ($validateProgramDataEdit > 0)
        {
            $con->closeDB();
            return $validateProgramDataEdit[0];
        }

        else
        {
            
        $con->closeDB();
        return "error";
        }
    }






    public function deleteProgram($id_academic_programs){

        try{

        
        $con=new DBconnection();
        $con->openDB();

        $programDataDelete = ("UPDATE academic_programs SET status = 0 WHERE id_academic_programs = '$id_academic_programs'");
        $updateResult = $con->query($programDataDelete);

        $con->closeDB();



        if ($updateResult )
        {
           $response = ['status' => 'success', 'message' => 'Programa académico eliminado correctamente'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error al eliminar el programa académico'];
        }
        }
        catch (Exception $e) {
            $response = ['status' => 'error', 'message' => 'Error al eliminar el programa académico: ' . $e->getMessage()];
        }
        return $response;
    }

}

?>