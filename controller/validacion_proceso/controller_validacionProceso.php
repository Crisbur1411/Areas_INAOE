<?php
require_once '../../m/validacion_proceso/model_validacion.php';


class validacionController{

    private $proceso;

    public function __construct(){
    }


	public function listStudentInProgress()
	{
		$this->proceso = new proceso();

		$data = $this->proceso->listStudentInProgress($_POST["email"]);
		echo json_encode($data);
	}



    public function showRegisterAreas()
	{
		$this->proceso = new proceso();

		$data = $this->proceso->showRegisterAreas($_POST["id_student"]);
		echo json_encode($data);
	}


    public function validateEmail(){
        $this->proceso = new proceso();

        $data = $this->proceso->validateEmail($_POST["email"]);
        echo json_encode($data);
    }

	public function userAutoricedLiberation()
	{
		$this->proceso = new proceso();

		$data = $this->proceso->userAutoricedLiberation();
		echo json_encode($data);
	}



}



$obj = new validacionController();



if (isset($_POST["action"])) {
	if ($_POST["action"] == 1) {
		$obj->listStudentInProgress();
	} if ($_POST["action"] == 2) {
    	$obj->showRegisterAreas();
    }if ($_POST["action"] == 3) {
    	$obj->validateEmail();
    }if ($_POST["action"] == 4) {
		$obj->userAutoricedLiberation();
	}
}

?>