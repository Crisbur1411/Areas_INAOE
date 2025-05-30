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

}
?>
