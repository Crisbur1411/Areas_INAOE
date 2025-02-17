<?php
    require_once '../../m/tipo_usuarios/model_tipo_usuarios.php';

    class tipoUsuariosController{
    	private $tipoUsuarios;

    	public function __construct(){

    	}
    	public function listTypeUsers(){
    		$this->tipoUsuarios= new tipoUsuarios();

	      	$data = $this->tipoUsuarios->listTypeUsers();
	      	echo json_encode($data);
		}
    }

    $obj = new tipoUsuariosController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->listTypeUsers();
	    }
	}
 ?>