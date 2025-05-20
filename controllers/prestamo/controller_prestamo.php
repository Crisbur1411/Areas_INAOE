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



}



$obj = new prestamoController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->listPrestamos();
	    }
	}

    ?>