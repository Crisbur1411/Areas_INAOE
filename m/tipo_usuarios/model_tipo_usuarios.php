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



    public function getTypeUserInfo($id_type_users){

        $con=new DBconnection(); 
        $con->openDB();

        $dataTypeUser = $con->query("SELECT id_type_users, name, key, details FROM type_users WHERE id_type_users = $id_type_users;");

        $row =  pg_fetch_array($dataTypeUser);

        $dataTypeUser = array(
            "id_type_users"=>$row["id_type_users"],
            "name"=>$row["name"],
            "key"=>$row["key"],
            "details"=>$row["details"]
        );
        $con->closeDB();
        return array("status" => 200, "data" => $dataTypeUser);
    }



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