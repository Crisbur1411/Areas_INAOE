<?php
    require_once '../../model/login_prestamo/model_login_prestamo.php';

    class loginController{
    	private $login;

    	public function __construct(){
        	$this->challenges = new login();
    	}

    	public function loginUser(){
    		$this->login= new login();
	      	$data = $this->login->loginUser($_POST["email"], $_POST["password"]);
	      	echo $data;
		}

		public function logOut(){
			$_SESSION = array();
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}
			
    		session_destroy();
		}
    }

    $obj = new loginController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->loginUser();
	    }else if ($_POST["action"]==2){
	     	$obj->logOut();
	    }
	}
 ?>