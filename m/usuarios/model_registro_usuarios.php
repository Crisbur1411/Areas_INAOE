<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
}

class registrousuarios{

    public function getAreas(){
        $con=new DBconnection();
        $con->openDB();

        $ar = $con->query("SELECT id_area, name FROM  areas WHERE status=1");

        $data = array();

        while($row = pg_fetch_array($ar)){
            $dat = array(
                "id_area"=>$row["id_area"],
                "name"=>$row["name"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        return $data;
    }

    public function typeUsers(){
        $con=new DBconnection();
        $con->openDB();

        $ar = $con->query("SELECT id_type_users, name FROM  type_users WHERE status=1");

        $data = array();

        while($row = pg_fetch_array($ar)){
            $dat = array(
                "id_type_users"=>$row["id_type_users"],
                "name"=>$row["name"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        return $data;
    }
   
    public function saveUser ($name, $surname, $secondsurname, $email, $type_user, $username, $password)
    {
        $con=new DBconnection();
        $con->openDB();

        $userData = $con->query("INSERT INTO users (username, password, name, surname, second_surname,email,fk_type, date_register) 
        VALUES ('".$username."','".$password."', '".$name."','".$surname."', '".$secondsurname."','".$email."',".$type_user.",NOW()) 
        RETURNING id_user");

        
        $validateUserData = pg_fetch_row($userData);

        if ( $validateUserData > 0)
        {            
            $con->closeDB();
            return $validateUserData[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }
    public function updateUserEdit($id_user, $area, $name, $surname, $second_surname, $email, $type_user, $username)
{
    $con = new DBconnection();
    $con->openDB();

    try{

    $updateUser = $con->query("UPDATE users SET name = '".$name."', surname = '".$surname."', 
        second_surname = '".$second_surname."', email = '".$email."', fk_type = ".$type_user.", 
        username = '".$username."' WHERE id_user = ".$id_user);

    if ($updateUser) {
        $updateAreaUser = $con->query("UPDATE public.user_area
            SET  fk_area = ".$area."
            WHERE fk_user = ".$id_user);

        if ($updateAreaUser) {
            $con->closeDB();
            return array("status" => 200, "message" => "Usuario actualizado correctamente");
        } else {
            $con->closeDB();
            return array("status" => 500, "message" => "Fallo al actualizar el área del usuario");
        }
    } else {
        $con->closeDB();
        return array("status" => 500, "message" => "Fallo al actualizar usuario");
    }   
    }catch (Exception $e) {
        $con->closeDB();
        http_response_code(500);
        return array("status" => 500, "message" => "Error al eliminar el usuario: " . $e->getMessage());
    }


}
    public function changePassword($id_user,$password)
{
    $con = new DBconnection();
    $con->openDB();

    try{

    $updateUser = $con->query("UPDATE users SET  password = '".$password."' WHERE id_user = ".$id_user);

    if ($updateUser) {
        $con->closeDB();
        return array("status" => 200, "message" => "Contraseña Usuario actualizado correctamente");
    } else {
        $con->closeDB();
        return array("status" => 500, "message" => "Fallo al actualizar contraseña usuario");
    }
    }catch (Exception $e) {
        $con->closeDB();
        http_response_code(500);
        return array("status" => 500, "message" => "Error al actulizar contraseña el usuario: " . $e->getMessage());
    }


}



    public function userArea($id_user, $area){
        $con=new DBconnection();
        $con->openDB();

        $userAreaData = $con->query("INSERT INTO user_area (fk_user, fk_area) 
        VALUES (".$id_user.",".$area.") 
        RETURNING id_user_area");

        
        $validateUserAreaData = pg_fetch_row($userAreaData);

        if ( $validateUserAreaData > 0)
        {            
            $con->closeDB();
            return $validateUserAreaData[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }

    
}
?>