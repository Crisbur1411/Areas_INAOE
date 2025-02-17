<?php
    require_once '../../m/alumnos/model_registro_alumnos.php';

    class registroAlumnosController{
    	private $registroalumnos;

    	public function __construct(){

    	}
    	public function getCourses(){
    		$this->registroalumnos= new registroalumnos();

	      	$data = $this->registroalumnos->getCourses($_POST["program"]);
	      	echo json_encode($data);
		}

		public function saveStudent(){
    		$this->registroalumnos= new registroalumnos();

	      	$data = $this->registroalumnos->saveStudent($_POST["name"], $_POST["surname"], $_POST["secondsurname"], $_POST["email"], $_POST["controlnumber"], $_POST["course"]);
	      	echo ($data);
		}

		
    }

    $obj = new registroAlumnosController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->getCourses();
	    }if ($_POST["action"]==2) {
	    	$obj->saveStudent();
	    }
	}
 ?>