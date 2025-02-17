<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
}

class tipoUsuarios{

    public function listTypeUsers(){
        $con=new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT id_type_users, name, key, details, status FROM type_users WHERE status = 1;");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_type_users"=>$row["id_type_users"],
                "name"=>$row["name"],
                "key"=>$row["key"],
                "details"=>$row["details"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }
    
}
?>