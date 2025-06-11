<?php
    require_once '../../model/tipo_usuarios/model_tipo_usuarios.php';

    class tipoUsuariosController{
    	private $tipoUsuarios;

    	public function __construct(){

    	}
    	public function listTypeUsers(){
    		$this->tipoUsuarios= new tipoUsuarios();

	      	$data = $this->tipoUsuarios->listTypeUsers();
	      	echo json_encode($data);
		}


		public function saveTypeUser(){
            $this->tipoUsuarios= new tipoUsuarios();
            $data = $this->tipoUsuarios->saveTypeUser($_POST['name'], $_POST['key'], $_POST['details']);
            echo($data);
        }


		public function getTypeUserInfo(){
			$this->tipoUsuarios= new tipoUsuarios();
			$data = $this->tipoUsuarios->getTypeUserInfo($_POST['id_type_users']);
			echo json_encode($data);
		
		}



		public function saveTypeUserEdit(){
			$this->tipoUsuarios= new tipoUsuarios();
			$data = $this->tipoUsuarios->saveTypeUserEdit($_POST['id_type_users'], $_POST['name'], $_POST['key'], $_POST['details']);
			echo($data);
		}


		public function deleteTypeUser(){
			$this->tipoUsuarios= new tipoUsuarios();
			$data = $this->tipoUsuarios->deleteTypeUser($_POST['id_type_users']);
			echo json_encode($data);




		}
	}


    

    $obj = new tipoUsuariosController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->listTypeUsers();
	    }if ($_POST["action"]==2){
	     	$obj->saveTypeUser();
	    }if ($_POST["action"]==3){
	     	$obj->getTypeUserInfo();
	    }if ($_POST["action"]==4){
	     	$obj->saveTypeUserEdit();
	    }if ($_POST["action"]==5){
	     	$obj->deleteTypeUser();
	    }
	}
 ?>