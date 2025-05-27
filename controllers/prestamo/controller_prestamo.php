<?php
    require_once '../../m/prestamo/model_prestamo.php';

class prestamoController{

private $prestamo;

    	public function __construct(){

    	}

public function listPrestamos(){
    		$this->prestamo= new prestamo();

	      	$data = $this->prestamo->listPrestamos();
	      	echo json_encode($data);
		}

		public function listPrestamosCancel(){
    		$this->prestamo= new prestamo();

	      	$data = $this->prestamo->listPrestamosCancel();
	      	echo json_encode($data);
		}

		public function listPrestamoFree(){
			$this->prestamo = new prestamo();

			$data = $this->prestamo->listPrestamoFree();
	      	echo json_encode($data);	
		}

public function getStudents(){
    		$this->prestamo= new prestamo();

	      	$data = $this->prestamo->getStudents();
	      	echo json_encode($data);
		}


public function getEmployee(){
    		$this->prestamo= new prestamo();

	      	$data = $this->prestamo->getEmployee($_POST["email_employee"]);
	      	echo json_encode($data);
		}



		public function savePrestamo(){
    $this->prestamo = new prestamo();
    $data = $this->prestamo->savePrestamo($_POST['student'], $_POST['description'], $_POST['employee']);

    if($data == "success"){
        echo json_encode(array("status" => "success", "message" => "Préstamo registrado correctamente"));
    } else {
        echo json_encode(array("status" => "error", "message" => "No se pudo registrar el préstamo"));
    }
    exit;
}


public function getPrestamoInfo(){
			$this->prestamo= new prestamo();
			$data = $this->prestamo->getPrestamoInfo($_POST['id_prestamo']);
			echo json_encode($data);
		
		}

		public function savePrestamoEdit(){
			$this->prestamo= new prestamo();
			$data = $this->prestamo->savePrestamoEdit($_POST['id_prestamo'], $_POST['fk_student'], $_POST['description']);
			echo($data);
		}



}



$obj = new prestamoController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->listPrestamos();
	    }if ($_POST["action"]==2){
	     	$obj->getStudents();
	    }if ($_POST["action"]==3){
	     	$obj->getEmployee();
	    }if ($_POST["action"]==4){
	     	$obj->savePrestamo();
	    }if ($_POST["action"]==5){
	     	$obj->getPrestamoInfo();
	    }if ($_POST["action"]==6){
	     	$obj->savePrestamoEdit();
	    }if ($_POST["action"]==7){
	     	$obj->listPrestamosCancel();
	    }if ($_POST["action"]==8){
	     	$obj->listPrestamoFree();
	    }
	}

    ?>