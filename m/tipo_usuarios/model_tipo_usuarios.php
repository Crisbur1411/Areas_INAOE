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


    public function saveTypeUserEdit($id_type_users, $name, $key, $details){

        $con=new DBconnection();
        $con->openDB();

        $typeUserDataEdit = $con->query("UPDATE type_users SET name = '".$name."', key = '".$key."', details = '".$details."' WHERE id_type_users = ".$id_type_users." RETURNING id_type_users;");

        $validateTypeUserDataEdit = pg_fetch_row($typeUserDataEdit);

        if ($validateTypeUserDataEdit > 0)
        {
            $con->closeDB();
            return $validateTypeUserDataEdit[0];
        }

        else
        {
            
        $con->closeDB();
        return "error";
        }
    }



    public function deleteTypeUser($id_type_users){

        try{

        
        $con=new DBconnection();
        $con->openDB();

        $typeUserDataDelete = ("UPDATE type_users SET status = 0 WHERE id_type_users = '$id_type_users'");
        $updateResult = $con->query($typeUserDataDelete);

        $con->closeDB();



        if ($updateResult )
        {
           $response = ['status' => 'success', 'message' => 'Usuario eliminado correctamente'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error al eliminar el usuario'];
        }
        }
        catch (Exception $e) {
            $response = ['status' => 'error', 'message' => 'Error al eliminar el usuario: ' . $e->getMessage()];
        }
        return $response;
    }
    
}
?>