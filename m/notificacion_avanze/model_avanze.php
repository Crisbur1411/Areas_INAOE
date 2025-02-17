<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
}

class avanze{

    
    public function listAreas($matricula){
        $con=new DBconnection(); 
        $con->openDB();

            $dataTitle = $con->query("SELECT s.control_number, s.id_student, a.id_area, a.name, a.details,
            CASE WHEN t.fk_area IS NOT NULL THEN 'Liberado' ELSE 'No Liberado' END AS estado_liberacion
            FROM students s
            CROSS JOIN areas a
            LEFT JOIN trace_student_areas t ON s.id_student = t.fk_student AND t.fk_area = a.id_area
            WHERE s.control_number = '$matricula' AND a.status = 1
            ORDER BY a.name ASC;
");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "name"=>$row["name"],
                "details"=>$row["details"],
                "estado_liberacion" => $row["estado_liberacion"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }
    
    public function loginEstudiante($matricula){
        $con = new DBconnection(); 
        $con->openDB();
    
        $controlNumber = $con->query("SELECT control_number FROM students WHERE control_number='$matricula'");
    
        $data = array();
    
        while($row = pg_fetch_array($controlNumber)){
            $dat = array(
                "control_number" => $row["control_number"],
            );
            $data[] = $dat;
        }
    
        $con->closeDB();
    
        if(!empty($data)){
            return "success"; 
            return "false"; // Retorna false si el array $data está vacío
        }
    }
    

}
?>