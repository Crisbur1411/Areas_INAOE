<?php
date_default_timezone_set("America/Mexico_City");

require_once __DIR__ . '/../db_connection.php';

class EmailModel {

    public function listEmails(){
        $con = new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT username FROM users WHERE status = 3;");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $data[] = $row["username"];
        }

        $con->closeDB();
        
        return $data;
    } 


    public function getDataStudent($id_student) {
    $con = new DBconnection(); 
    $con->openDB();

    $dataTitle = $con->query("SELECT id_student, 
                                    CONCAT(name, ' ', surname, ' ', second_surname) AS full_name,
                                    email
                              FROM students 
                              WHERE id_student = '$id_student';");

    $data = array();
    while($row = pg_fetch_assoc($dataTitle)){
        $data[] = [
            'id_student'   => $row['id_student'],
            'full_name'    => $row['full_name'],
            'email'        => $row['email']
        ];
    }

    $con->closeDB();
    return $data;
}



}
?>
