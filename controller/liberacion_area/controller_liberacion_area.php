<?php
    require_once '../../model/liberacion_area/model_liberacion_area.php';

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

	      	$data = $this->liberacionArea->signStudent($_POST["id_student"], $_POST["user"], $_POST["full_name"], $_POST["id_user"]);
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

		public function listStudentCancel(){
		$this->liberacionArea = new liberacionArea();

		$data = $this->liberacionArea->listStudentCancel();
		echo json_encode($data);
		}


		public function getDetailsStudent()
	{
		$this->liberacionArea = new liberacionArea();

		$data = $this->liberacionArea->getDetailsStudent($_POST["id_student"]);
		echo json_encode($data);
	}

	public function studentNoteEdit(){
    $this->liberacionArea = new liberacionArea();

    $data = $this->liberacionArea->studentNoteEdit($_POST["id_note"], $_POST["user"], $_POST["motivo"]);
    if ($data === "success") {
        echo json_encode(["status" => "success", "message" => "Nota actualizada en el trámite!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar la nota"]);
    }
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
		}if ($_POST["action"]==7){
			$obj->listStudentCancel();
		} if ($_POST["action"]==8){
			$obj->getDetailsStudent();
		} if ($_POST["action"]==9){
			$obj->studentNoteEdit();
		}
	}
 ?>