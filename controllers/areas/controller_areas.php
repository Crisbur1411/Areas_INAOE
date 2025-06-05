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
            $this->areas= new areas();
			$data = $this->areas->updateArea($_POST['id_area'], $_POST['name'], $_POST['key'], $_POST['details']);
			echo($data);
            }
        

        public function getAreaInfo(){
			$this->areas= new areas();
			$data = $this->areas->getAreaInfo($_POST['id_area']);
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
         	$obj->getAreaInfo();
        }
	}

?>