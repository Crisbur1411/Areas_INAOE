<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
}

class areas{

    
    public function listAreas(){
        $con=new DBconnection(); 
        $con->openDB();

            $dataTitle = $con->query("SELECT id_area, name, key, details, status FROM areas WHERE status = 1 ORDER BY id_area ASC;");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_area"=>$row["id_area"],
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
    public function createArea($name, $key, $details) {
        $con = new DBconnection(); 
        $con->openDB();
    
        $areasData = $con->query("INSERT INTO areas (name, key, details) VALUES ('".$name."', '".$key."', '".$details."') RETURNING id_area");
        
        $validateAreas = pg_fetch_row($areasData);

        if ($validateAreas > 0)
        {
            $con->closeDB();
            return $validateAreas[0];
        }

        else
        {
            
        $con->closeDB();
        return "error";
        }
        
    }
    
    public function updateArea($id_area, $name, $key,$details) {
        $con = new DBconnection(); 
        $con->openDB();
    
        $areaDataEdit = $con->query("UPDATE areas SET name = '".$name."', key = '".$key."', details = '".$details."' WHERE id_area = ".$id_area." RETURNING id_area;");
        
        $validatAreaDataEdit = pg_fetch_row($areaDataEdit);

        if ($validatAreaDataEdit > 0) {
            $con->closeDB();
            return $validatAreaDataEdit[0];
        } else {
            $con->closeDB();
            return "error";
        }

    }

    
        public function deleteArea($identificadorArea) {
        $con = new DBconnection(); 
        $con->openDB();
    
        try {
            // Actualizar el estado de un área a 0 (inactivo)
            $query = "UPDATE public.areas SET status = 0 WHERE key = '$identificadorArea'";
            $con->query($query);
    
            $con->closeDB();
            http_response_code(200); 
            return array("status" => 200, "message" => "Área eliminada correctamente");
        } catch (Exception $e) {
            $con->closeDB();
            http_response_code(500);
            return array("status" => 500, "message" => "Error al eliminar el área: " . $e->getMessage());
        }
    }

    public function getAreaInfo($id_area){

        $con=new DBconnection(); 
        $con->openDB();

        $dataArea = $con->query("SELECT id_area,name, key, details FROM areas WHERE id_area = $id_area;");

        $row =  pg_fetch_array($dataArea);

        $dataArea = array(
            "id_area"=>$row["id_area"],
            "name"=>$row["name"],
            "key"=>$row["key"],
            "details"=>$row["details"]
        );
        $con->closeDB();
        return array("status" => 200, "data" => $dataArea);
    }
    
    
    
}
?>