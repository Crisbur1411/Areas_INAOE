<?php
    require_once '../../m/tipo_usuarios/model_registro_tipo_usuario.php';


    class registroTipoUsuarioController{

        private $registroTipoUsuario;

        public function __construct(){

    	}


        public function saveTypeUser(){
            $this->registroTipoUsuario= new registroTipoUsuario();
            $data = $this->registroTipoUsuario->saveTypeUser($_POST['name'], $_POST['key'], $_POST['details']);
            echo($data);
        }


    }

    $obj = new registroTipoUsuarioController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->saveTypeUser();
	    }
	}

?>