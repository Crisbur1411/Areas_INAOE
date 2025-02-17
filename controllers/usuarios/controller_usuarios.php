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
}

$obj = new usuariosController();



if (isset($_POST["action"])) {
	if ($_POST["action"] == 1) {
		$obj->listUser();
	} elseif ($_POST["action"] == 2) {
    	$obj->getUserInfo();
    }elseif ($_POST["action"] == 3) {
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
}
