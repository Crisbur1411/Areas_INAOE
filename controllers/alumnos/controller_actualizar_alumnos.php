<?php
    require_once '../../m/alumnos/model_actualizar_alumnos.php';

    class actualizar_alumnosController{
    	private $actualizar_alumnos; 

    	public function __construct(){

    	}
    	
		public function getCourses(){
    		$this->actualizar_alumnos= new actualizar_alumnos();

	      	$data = $this->actualizar_alumnos->getCourses($_POST["program"]);
	      	echo json_encode($data);
		}

		public function coursesAds(){
    		$this->actualizar_alumnos= new actualizar_alumnos();

			$data = $this->actualizar_alumnos->coursesAds($_POST["id_student"]);
	      	echo json_encode($data);
		}

		public function getStudent(){
    		$this->actualizar_alumnos= new actualizar_alumnos();

			$data = $this->actualizar_alumnos->getStudent($_POST["id_student"]);
	      	echo json_encode($data);
		}

		public function updateStudent(){
    		$this->actualizar_alumnos= new actualizar_alumnos();

	      	$data = $this->actualizar_alumnos->updateStudent($_POST["id_student"], $_POST["name"], $_POST["surname"], $_POST["secondsurname"], $_POST["email"], $_POST["controlnumber"], $_POST["course"]);
	      	echo ($data);
		}    	
    }

    $obj = new actualizar_alumnosController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->getCourses();
	    }if ($_POST["action"]==2) {
	    	$obj->coursesAds();
	    }if ($_POST["action"]==3) {
	    	$obj->getStudent();
	    }if ($_POST["action"]==4) {
	    	$obj->updateStudent();
	    }	
	}
 ?>