<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
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



    public function savePrograms($cve, $name, $type_program, $valor_tipo){

        $con=new DBconnection();
        $con->openDB();


        $programData = $con->query("INSERT INTO academic_programs (cve, name, type, type_program) 
        VALUES ('".$cve."', '".$name."', '".$valor_tipo."', '".$type_program."')
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




}

?>