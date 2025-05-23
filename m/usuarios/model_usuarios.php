<?php
date_default_timezone_set("America/Mexico_City");

if (file_exists('./m/db_connection.php')) {
    require_once './m/db_connection.php';
} else if (file_exists('../../m/db_connection.php')) {
    require_once  '../../m/db_connection.php';
} else if (file_exists('../../../m/db_connection.php')) {
    require_once  '../../../m/db_connection.php';
}

class usuarios
{

    public function listUser()
    {
        $con = new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT users.id_user,
                                CONCAT(users.name, ' ', users.surname, ' ', users.second_surname) AS full_name,
                                CASE
                                    WHEN users.fk_type = type_users.id_type_users THEN areas.name
                                    ELSE 'Sin área asignada'
                                END AS area_name,
                                type_users.name AS type_name, DATE(users.date_register)  AS date, users.status
                                FROM users
                                INNER JOIN type_users ON users.fk_type = type_users.id_type_users
                                INNER JOIN user_area ON users.id_user = user_area.fk_user
                                INNER JOIN areas ON user_area.fk_area = areas.id_area
                                WHERE users.status = 1
                                ORDER BY users.id_user;");

        $data = array();

        while ($row = pg_fetch_array($dataTitle)) {
            $dat = array(
                "id_user" => $row["id_user"],
                "full_name" => $row["full_name"],
                "area_name" => $row["area_name"],
                "type_name" => $row["type_name"],
                "date" => $row["date"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();

        return $data;
    }

    // desarrollado por BRYAM el 29/03/2024 esta función extrae los datos de la cuenta del usuario activo

    public function getUserInfo($id_user)
{
    $con = new DBconnection();
    $con->openDB();

    $id_user = intval($id_user); // sanitiza para seguridad

    $query = "SELECT 
                users.id_user,
                CONCAT(users.name, ' ', users.surname, ' ', users.second_surname) AS full_name,
                COALESCE(areas.name, 'Sin área asignada') AS area_name,
                type_users.name AS type_name,
                DATE(users.date_register) AS date,
                users.username
              FROM users
              INNER JOIN type_users ON users.fk_type = type_users.id_type_users
              LEFT JOIN user_area ON users.id_user = user_area.fk_user
              LEFT JOIN areas ON user_area.fk_area = areas.id_area
              WHERE users.id_user = $id_user";

    $dataUser = $con->query($query);
    $row = pg_fetch_array($dataUser);

    if ($row) {
        $dataUser = array(
            "id_user"    => $row["id_user"],
            "full_name"  => $row["full_name"],
            "area_name"  => $row["area_name"],
            "type_name"  => $row["type_name"],
            "date"       => $row["date"],
            "username"   => $row["username"]
        );
    } else {
        $dataUser = array(
            "id_user"    => null,
            "full_name"  => null,
            "area_name"  => null,
            "type_name"  => null,
            "date"       => null,
            "username"   => null
        );
    }

    $con->closeDB();
    return $dataUser;
}





    // desarrollado por Julian el 29/03/2024 esta función extrae los datos de la cuenta del usuario activo

    public function getUserInfoById($id_user)
    {
        $con = new DBconnection();
        $con->openDB();

        $dataUser = $con->query("SELECT users.id_user,users.name, users.surname, users.second_surname,users.username, users.fk_type,user_area.fk_area
    FROM users
    INNER JOIN type_users ON users.fk_type = type_users.id_type_users
    INNER JOIN user_area ON users.id_user = user_area.fk_user
    INNER JOIN areas ON user_area.fk_area = areas.id_area
    WHERE users.id_user = $id_user;
");
        $row = pg_fetch_array($dataUser);

        $dataUser = array(
            "id_user" => $row["id_user"],
            "name" => $row["name"],
            "surname" => $row["surname"],
            "second_surname" => $row["second_surname"],
            "email" => $row["username"],
            "fk_type" => $row["fk_type"],
            "fk_area" => $row["fk_area"]
        );

        $con->closeDB();
        return array("status" => 200, "data" => $dataUser);
    }

    // desarrollado por BRYAM el 02/04/2024 esta funcion hace una peticion a la bd para extraer la contraseña del usuario actual, si es correcta hace el update

    public function updatePassword($id_user, $currentPassword, $newPassword)
    {
        $con = new DBconnection();
        $con->openDB();

        $dataPassword = $con->query("SELECT password FROM users WHERE id_user = $id_user");
        $row = pg_fetch_array($dataPassword);
        $storedPassword = $row["password"];

        if ($storedPassword !== $currentPassword) {
            return false;
        }
        $updateQuery = "UPDATE users SET password = '$newPassword' WHERE id_user = $id_user";
        $updateResult = $con->query($updateQuery);

        $con->closeDB();

        return $updateResult;
    }

    public function updatePasswordWithoutCheck($id_user, $newPassword)
    {
        $con = new DBconnection();
        $con->openDB();

        try {
            $updateQuery = "UPDATE users SET password = '$newPassword' WHERE id_user = $id_user";
            $updateResult = $con->query($updateQuery);

            $con->closeDB();

            return array('status' => 200, 'error' => null);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $con->closeDB();

            return array('status' => 500, 'error' => $errorMessage);
        }
    }

   public function deleteUser($id_user)
{
    try {
        $con = new DBconnection();
        $con->openDB();

        $updateQuery = "UPDATE users SET status = 0 WHERE id_user = '$id_user'";
        $updateResult = $con->query($updateQuery);

        $con->closeDB();

        if ($updateResult) {
            $response = ['status' => 'success', 'message' => 'Usuario eliminado correctamente.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error al eliminar usuario.'];
        }
    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => 'Error: ' . $e->getMessage()];
    }

    return $response;
}





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
   
    public function saveUser ($name, $surname, $secondsurname, $email, $type_user, $password)
    {
        $con=new DBconnection();
        $con->openDB();

        $userData = $con->query("INSERT INTO users (username, password, name, surname, second_surname,fk_type, date_register) 
        VALUES ('".$email."','".$password."', '".$name."','".$surname."', '".$secondsurname."',".$type_user.",NOW()) 
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
    public function updateUserEdit($id_user, $area, $name, $surname, $second_surname, $email, $type_user)
{
    $con = new DBconnection();
    $con->openDB();

    try{

    $updateUser = $con->query("UPDATE users SET name = '".$name."', surname = '".$surname."', 
        second_surname = '".$second_surname."', username = '".$email."', fk_type = ".$type_user." WHERE id_user = ".$id_user);

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
