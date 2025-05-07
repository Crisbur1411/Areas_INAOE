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

        $dataUser = $con->query("SELECT users.id_user,
                                    CONCAT(users.name, ' ', users.surname, ' ', users.second_surname) AS full_name,
                                    CASE
                                        WHEN users.fk_type = type_users.id_type_users THEN areas.name
                                        ELSE 'Sin área asignada'
                                    END AS area_name,
                                    type_users.name AS type_name, DATE(users.date_register)  AS date,
                                    users.username AS email 
                                    FROM users
                                    INNER JOIN type_users ON users.fk_type = type_users.id_type_users
                                    INNER JOIN user_area ON users.id_user = user_area.fk_user
                                    INNER JOIN areas ON user_area.fk_area = areas.id_area
                                    WHERE users.id_user = $id_user");
        $row = pg_fetch_array($dataUser);

        $dataUser = array(
            "id_user" => $row["id_user"],
            "full_name" => $row["full_name"],
            "area_name" => $row["area_name"],
            "type_name" => $row["type_name"],
            "date" => $row["date"],
            "email" => $row["email"]
        );

        $con->closeDB();
        return $dataUser;
    }




    // desarrollado por Julian el 29/03/2024 esta función extrae los datos de la cuenta del usuario activo

    public function getUserInfoById($id_user)
    {
        $con = new DBconnection();
        $con->openDB();

        $dataUser = $con->query("SELECT users.id_user,users.name, users.surname, users.second_surname,users.email,users.username, users.fk_type,user_area.fk_area
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
            "email" => $row["email"],
            "username" => $row["username"],
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

}
