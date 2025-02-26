<?php
    require_once '../../m/usuarios/model_registro_usuarios.php';

    class registrousuariosController{
    	private $registrousuarios;

    	public function __construct(){

    	}
    	public function getAreas(){
    		$this->registrousuarios= new registrousuarios();

	      	$data = $this->registrousuarios->getAreas();
	      	echo json_encode($data);
		}

		public function typeUsers(){
    		$this->registrousuarios= new registrousuarios();

	      	$data = $this->registrousuarios->typeUsers();
	      	echo json_encode($data);
		}

		public function saveUser(){
    		$this->registrousuarios= new registrousuarios();

	      	$data = $this->registrousuarios->saveUser($_POST["name"], $_POST["surname"], $_POST["secondsurname"], $_POST["email"], $_POST["type_user"], $_POST["password"]);
	      	echo ($data);
		}
		public function saveUserEdit(){
    		$this->registrousuarios= new registrousuarios();
			
	      	$data = $this->registrousuarios->updateUserEdit($_POST["user_id"],$_POST["area"],$_POST["name"], $_POST["surname"], $_POST["secondsurname"], $_POST["email"], $_POST["type_user"], $_POST["username"]);
	      	echo json_encode($data);
		}

		public function userArea(){
    		$this->registrousuarios= new registrousuarios();

	      	$data = $this->registrousuarios->userArea($_POST["id_user"], $_POST["area"]);
	      	echo ($data);
		}
		public function changePassword(){
    		$this->registrousuarios= new registrousuarios();

	      	$data = $this->registrousuarios->changePassword($_POST["id_user"], $_POST["new_password"]);
	      	echo json_encode($data);
		}
    }

    $obj = new registrousuariosController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->getAreas();
	    }if ($_POST["action"]==2) {
	    	$obj->typeUsers();
	    }if ($_POST["action"]==3) {
	    	$obj->saveUser();
	    }if ($_POST["action"]==4) {
	    	$obj->userArea();
	    }if ($_POST["action"]==5) {
	    	$obj->saveUserEdit();
	    }if ($_POST["action"]==6) {
	    	$obj->changePassword();
	    }
	}
 ?>