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





public function getNotes($id_student){
    $con = new DBconnection(); 
    $con->openDB();

    session_start();
    $area  = $_SESSION["id_area"];

                        $dataTitle = $con->query("SELECT 
                        a.details AS area_name,
                        n.description AS note_description
                    FROM 
                        notes n
                    INNER JOIN 
                        areas a ON n.fk_area = a.id_area
                    WHERE 
                        n.status = 1
                        AND a.status = 1
                        AND a.id_area = '$area'
                        AND n.fk_student = '$id_student';");

    $data = array();
    while($row = pg_fetch_assoc($dataTitle)){
        $data[] = [
            'area_name'   => $row['area_name'],
            'note_description'    => $row['note_description']
        ];
    }

    $con->closeDB();
    return $data;
}


}
?>
