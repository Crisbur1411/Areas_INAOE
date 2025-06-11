<?php
require_once '../../model/consulta_folio/model_consulta_folio.php';

class FolioController {
    
    private $validateFolio;

    public function __construct() {
    }


    public function validateFolioStudent(){
        $this->validateFolio = new validateFolio();

        $data = $this->validateFolio->validateFolioStudent($_POST["folio"]);
        echo json_encode($data);
    }

    public function listStudentFree()
	{
		$this->validateFolio = new validateFolio();

		$data = $this->validateFolio->listStudentFree($_POST["folio"]);
		echo json_encode($data);
	}

    public function getDetailsStudent()
	{
		$this->validateFolio = new validateFolio();

		$data = $this->validateFolio->getDetailsStudent($_POST["id_student"]);
		echo json_encode($data);
	}


}

$obj = new FolioController();



if (isset($_POST["action"])) {
	if ($_POST["action"] == 1) {
		$obj->validateFolioStudent();
	} if ($_POST["action"] == 2) {
        $obj->listStudentFree();
    } if ($_POST["action"] == 3) {
        $obj->getDetailsStudent();
    }
}

?>