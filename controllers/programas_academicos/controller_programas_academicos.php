<?php
require_once '../../m/programas_academicos/model_programas_academicos.php';

class programasAcademicosController{

    private $programasAcademicos;


    public function __construct(){
   
   
    }

    public function listPrograms(){
        $this->programasAcademicos = new programasAcademicos();

        $data = $this->programasAcademicos->listPrograms();
        echo json_encode($data);
    }

    public function savePrograms(){
        $this->programasAcademicos = new programasAcademicos();
        $data = $this->programasAcademicos->savePrograms($_POST["cve"], $_POST["name"], $_POST["type_program"], $_POST["type"]);
        echo json_encode($data);
    }


    public function getProgramInfo(){
			$this->programasAcademicos= new programasAcademicos();
			$data = $this->programasAcademicos->getProgramInfo($_POST['id_academic_programs']);
			echo json_encode($data);
		
		}


        public function saveProgramEdit(){
			$this->programasAcademicos= new programasAcademicos();
			$data = $this->programasAcademicos->saveProgramEdit($_POST['id_academic_programs'], $_POST['cve'], $_POST['name'], $_POST['type'], $_POST['type_program']);
			echo json_encode($data);
		
		}


}


$obj = new programasAcademicosController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->listPrograms();
	    }if ($_POST["action"]==2){
         	$obj->savePrograms();
        }if ($_POST["action"]==3){
         	$obj->getProgramInfo();
        }if ($_POST["action"]==4){
         	$obj->saveProgramEdit();
        }
	}

?>