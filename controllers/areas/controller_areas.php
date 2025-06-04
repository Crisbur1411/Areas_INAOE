<?php
    require_once '../../m/areas/model_areas.php';

    class areasController {
        private $areas;

        public function __construct() {
        }

        public function listAreas() {
            $this->areas = new areas();
            $data = $this->areas->listAreas();
            echo json_encode($data);
        }

		public function createArea() {
            $this->areas = new areas();
            // Crear el área en la base de datos
            $data = $this->areas->createArea($_POST["name"], $_POST["key"], $_POST["details"]);
            echo($data);

            
        }
        
		
		private function obtenerExtensionImagen($nombreArchivo) {
			$extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
			return "." . $extension;
		}
		
        public function deleteArea() {
            $this->areas = new areas();

            $identificadorArea = $_POST["identificador_area"];
            $data = $this->areas->deleteArea($identificadorArea);
            echo json_encode($data);
        }
            public function updateArea() {
                $this->areas = new areas();
                
                $nombreArea = $_POST["nombre_area"];
                $detallesArea = $_POST["detalles_area"];
                $identificadorArea = $_POST["identificador_area"];
                
                // Verificar si se ha subido una imagen
                if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                    $rutaTemporal = $_FILES['imagen']['tmp_name'];
                    $nombreImagen = basename($_FILES['imagen']['name']);
                    $extension = $this->obtenerExtensionImagen($nombreImagen);
                    $nombreImagenCompleto = $identificadorArea . $extension;
                    $rutaDestino = "../../res/imgs/" . $nombreImagenCompleto;
                } else {
                    // Establecer valores por defecto si no se sube imagen
                    $rutaTemporal = null;
                    $nombreImagen = null;
                    $extension = null;
                    $nombreImagenCompleto = null;
                    $rutaDestino = null;
                }
                
                // Actualizar datos del área en la base de datos
                $data = $this->areas->updateArea($nombreArea, $detallesArea, $identificadorArea, $extension, $rutaTemporal, $rutaDestino);
                echo json_encode($data);
            }
        

        public function obtenerExtension() {
            $this->areas = new areas();

            $identificadorArea = $_POST["area_id"];
            $data = $this->areas->obtenerExtension($identificadorArea);
            echo json_encode($data);

        }
        
        
    }

    $obj = new areasController();

    

    if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->listAreas();
	    }if ($_POST["action"]==2){
	     	$obj->createArea();
	    }if ($_POST["action"]==3){
	     	$obj->deleteArea();
	    }if ($_POST["action"]==4){
	     	$obj->updateArea();
	    }if ($_POST["action"]==5){
	     	$obj->obtenerExtension();
	    }
	}

?>