<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
}


class registroTipoUsuario{


    public function saveTypeUser($name, $key, $details){

        $con=new DBconnection();
        $con->openDB();


        $typeUserData = $con->query("INSERT INTO type_users (name, key, details) 
VALUES ('".$name."', '".$key."', '".$details."')
RETURNING id_type_users");


        $validateTypeUserData = pg_fetch_row($typeUserData);


        if ($validateTypeUserData > 0)
        {
            $con->closeDB();
            return $validateTypeUserData[0];
        }

        else
        {
            
        $con->closeDB();
        return "error";
        }
    }


}




?>