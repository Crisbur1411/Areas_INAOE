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
	    }
	}

    ?>