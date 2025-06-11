<?php
require_once '../../m/usuarios/model_usuarios.php';

class usuariosController
{
	private $usuarios;

	public function __construct()
	{
	}
	public function listUser()
	{
		$this->usuarios = new usuarios();

		$data = $this->usuarios->listUser();
		echo json_encode($data);
	}
	public function deleteUser()
	{
		$this->usuarios = new usuarios();

		$data = $this->usuarios->deleteUser($_POST['identificador_usuario']);
		echo json_encode($data);
	}

// desarrollado por BRYAM el 29/03/2024 esta funcion llama al la funcion getUserInfo y convierte el array en JSON
public function getUserInfo()
{
    if (!isset($_POST["id_user"])) {
        echo json_encode([
            "status" => "error",
            "message" => "Parámetro id_user no recibido."
        ]);
        return;
    }

    $this->usuarios = new usuarios();
    $dataUser = $this->usuarios->getUserInfo($_POST["id_user"]);
    echo json_encode($dataUser);
}


	public function getUserInfoById()
	{
		$this->usuarios = new usuarios();
		$data = $this->usuarios->getUserInfoById($_POST['id_usuario']);
		echo json_encode($data);
	}


	public function updatePassword()
	{
		$this->usuarios = new usuarios();
		$updateResult = $this->usuarios->updatePassword($_POST["id_user"], $_POST["currentPassword"], $_POST["newPassword"]);
		if ($updateResult) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('error' => 'Error al actualizar la contraseña.'));
		}
	}

	public function updatePasswordWithoutCheck()
	{
		$this->usuarios = new usuarios();

		$data = $this->usuarios->updatePasswordWithoutCheck($_POST['id_usuario'], $_POST['new_passsword']);
		echo json_encode($data);
	}




public function getAreas(){
    		$this->usuarios= new usuarios();

	      	$data = $this->usuarios->getAreas();
	      	echo json_encode($data);
		}

		public function typeUsers(){
    		$this->usuarios= new usuarios();

	      	$data = $this->usuarios->typeUsers();
	      	echo json_encode($data);
		}

		public function saveUser(){
    		$this->usuarios= new usuarios();

	      	$data = $this->usuarios->saveUser($_POST["name"], $_POST["surname"], $_POST["secondsurname"], $_POST["email"], $_POST["type_user"], $_POST["password"]);
	      	echo ($data);
		}
		public function saveUserEdit(){
    		$this->usuarios= new usuarios();
			
	      	$data = $this->usuarios->updateUserEdit($_POST["user_id"],$_POST["area"],$_POST["name"], $_POST["surname"], $_POST["secondsurname"], $_POST["email"], $_POST["type_user"]);
	      	echo json_encode($data);
		}

		public function userArea(){
    		$this->usuarios= new usuarios();

	      	$data = $this->usuarios->userArea($_POST["id_user"], $_POST["area"]);
	      	echo ($data);
		}
		public function changePassword(){
    		$this->usuarios= new usuarios();

	      	$data = $this->usuarios->changePassword($_POST["id_user"], $_POST["new_password"]);
	      	echo json_encode($data);
		}


}

$obj = new usuariosController();



if (isset($_POST["action"])) {
	if ($_POST["action"] == 1) {
		$obj->listUser();
	}if ($_POST["action"] == 2) {
    	$obj->getUserInfo();
    }if ($_POST["action"] == 3) {
        $obj->updatePassword();
    }
	if ($_POST["action"]==5){
		$obj->deleteUser();
   }
	if ($_POST["action"] == 6) {
		$obj->getUserInfoById();
	}
	if ($_POST["action"] == 7) {
		$obj->updatePasswordWithoutCheck();
	}
	if ($_POST["action"]==8){
	     	$obj->getAreas();
	    }if ($_POST["action"]==9) {
	    	$obj->typeUsers();
	    }if ($_POST["action"]==10) {
	    	$obj->saveUser();
	    }if ($_POST["action"]==11) {
	    	$obj->userArea();
	    }if ($_POST["action"]==12) {
	    	$obj->saveUserEdit();
	    }if ($_POST["action"]==13) {
	    	$obj->changePassword();
	    }
}
