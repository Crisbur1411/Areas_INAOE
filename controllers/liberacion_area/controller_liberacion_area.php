<?php
    require_once '../../m/liberacion_area/model_liberacion_area.php';

    class liberacionAreaController{
    	private $liberacionArea;

    	public function __construct(){

    	}
    	
		public function listStudentInProgress(){
    		$this->liberacionArea= new liberacionArea();

	      	$data = $this->liberacionArea->listStudentInProgress();
	      	echo json_encode($data);
		}

		public function signStudent(){
    		$this->liberacionArea= new liberacionArea();

	      	$data = $this->liberacionArea->signStudent($_POST["id_student"], $_POST["user"]);
	      	echo json_encode($data);
		}
		
		public function listStudentFree(){
    		$this->liberacionArea= new liberacionArea();

	      	$data = $this->liberacionArea->listStudentFree();
	      	echo json_encode($data);
		}

		public function noteStudent(){
    		$this->liberacionArea= new liberacionArea();

	      	$data = $this->liberacionArea->noteStudent($_POST["id_student"], $_POST["user"], $_POST["motivo"]);
	      	echo json_encode($data);
		}

		public function notesStudent(){
    		$this->liberacionArea= new liberacionArea();

	      	$data = $this->liberacionArea->notesStudent($_POST["id_student"]);
	      	echo json_encode($data);
		}

		public function passwordOk(){
    		$this->liberacionArea= new liberacionArea();

	      	$data = $this->liberacionArea->passwordOk($_POST["password"]);
	      	echo json_encode($data);
		}
    }

    $obj = new liberacionAreaController();

	if (isset($_POST["action"])){
	   if ($_POST["action"]==1){
			$obj->listStudentInProgress();
		}if ($_POST["action"]==2){
			$obj->signStudent();
		}if ($_POST["action"]==3){
			$obj->listStudentFree();
		}if ($_POST["action"]==4){
			$obj->noteStudent();
		}if ($_POST["action"]==5){
			$obj->notesStudent();
		}if ($_POST["action"]==6){
			$obj->passwordOk();
		}
	}
 ?>