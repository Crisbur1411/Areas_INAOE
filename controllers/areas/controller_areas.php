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
            
            $nombreArea = $_POST["nombre_area"] ?? "";
            $detallesArea = $_POST["detalles_area"] ?? "";
            $identificadorArea = $_POST["identificador_area"] ?? "";
            
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
            
            // Crear el área en la base de datos
            $data = $this->areas->createArea($nombreArea, $detallesArea, $identificadorArea, $extension, $rutaTemporal, $rutaDestino);
            echo json_encode($data);
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

    
/*
Desarrollado por Julian 
El 29/03/2024
Funcionalidades del controlador para areas
*/

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST["action"])) {
            $action = $_POST["action"];
            switch ($action) {
                case 1:
                    $obj->listAreas();
                    break;
                case 2:
                    $obj->createArea();
                    break;
                case 3:
                    $obj->deleteArea();
                    break;
                case 4:
                    $obj->updateArea();
                    break;
                case 5:
                    $obj->obtenerExtension();
                    break;
                default:
                    echo "La clave 'action' no se ha recibido en la solicitud POST.";
            }
        } else {
            echo "La clave 'action' no se ha recibido en la solicitud POST.";
        }
    } else {
        echo "La solicitud no es de tipo POST.";
    }
?>