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

            $dataTitle = $con->query("SELECT id_area, name, key, details, status FROM areas WHERE status = 1;");

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
    public function createArea($nameArea, $detailsArea, $identificadorArea, $extension, $rutaTemporal, $rutaDestino) {
        $con = new DBconnection(); 
        $con->openDB();
    
        try {
            if (isset($rutaTemporal) && !empty($rutaTemporal) && move_uploaded_file($rutaTemporal, $rutaDestino)) {
                $query = "INSERT INTO public.areas (name, key, details, status, extension) VALUES ('$nameArea', '$identificadorArea', '$detailsArea', 1, '$extension')";
                $con->query($query);
    
                $con->closeDB();
                http_response_code(200); 
                return array("status" => 200, "message" => "Área creada correctamente");
            } else {
                $query = "INSERT INTO public.areas (name, key, details, status) VALUES ('$nameArea', '$identificadorArea', '$detailsArea', 1)";
                $con->query($query);
    
                $con->closeDB();
                http_response_code(200); 
                return array("status" => 200, "message" => "Área creada correctamente"); 
            }
        } catch (Exception $e) {
            $con->closeDB();
            http_response_code(500);
            return array("status" => 500, "message" => "Error al insertar el área: " . $e->getMessage());
        }
    }
    
    public function updateArea($nameArea, $detailsArea, $identificadorArea,$extension,$rutaTemporal,$rutaDestino ) {
        $con = new DBconnection(); 
        $con->openDB();
    
        try {
            if (!empty($rutaTemporal) && is_uploaded_file($rutaTemporal)) {

                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {

                    
                    $archivosEnCarpeta = glob('../../res/imgs/' . $identificadorArea . '.*');

                    foreach ($archivosEnCarpeta as $archivo) {
                        
                        if (is_file($archivo) && $archivo !== $rutaDestino) {
                            unlink($archivo);
                        }
                    }
                } else {
                    return array("status" => 500, "message" => "Error al insertar imagen ");
                }

                $query = "UPDATE public.areas SET name = '$nameArea', details = '$detailsArea', extension = '$extension' WHERE key = '$identificadorArea'";
                $con->query($query);
        
                $con->closeDB();
                http_response_code(200); 
                return array("status" => 200, "message" => "Área modificada correctamente");
            }else{
              
                $query = "UPDATE public.areas SET name = '$nameArea', details = '$detailsArea' WHERE key = '$identificadorArea'";
                $con->query($query);
        
                $con->closeDB();
                http_response_code(200); 
                return array("status" => 200, "message" => "Área modificada correctamente");  
            }

           
        } catch (Exception $e) {
            $con->closeDB();
            http_response_code(500);
            return array("status" => 500, "message" => "Error al modificar el área: " . $e->getMessage());
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

        public function obtenerExtension($identificadorArea) {
            $con = new DBconnection(); 
            $con->openDB();
        
            try {
                

                $extensionObtenida = $con->query("SELECT extension FROM areas WHERE key = '$identificadorArea';");

                $data = array();

                while($row = pg_fetch_array($extensionObtenida)){
                    $dat = array(
                        "extension_imagen"=>$row["extension"]
                    );
                    $data[] = $dat;
                }
            
                $con->closeDB();
                http_response_code(200); 
                return array("status" => 200, "message" => "Extension obtenida correctamente","extension"=> $data);
            } catch (Exception $e) {
                $con->closeDB();
                http_response_code(500);
                return array("status" => 500, "message" => "Fallo al obtener Extension " . $e->getMessage());
            }
        }
    
    
    
}
?>