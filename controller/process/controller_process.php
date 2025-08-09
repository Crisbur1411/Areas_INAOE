<?php
    require_once '../../model/process/model_process.php';


    class processController{


        private $Process;

        public function __construct(){

    	}



        public function listProcess(){
    		$this->Process= new Process();

	      	$data = $this->Process->listProcess($_POST['id_process_catalog']);
	      	echo json_encode($data);
		}


        public function detailsProcess(){
    		$this->Process= new Process();

	      	$data = $this->Process->detailsProcess($_POST['id_process_stages']);
	      	echo json_encode($data);
		}


        public function getProcessCatalog(){
            $this->Process = new Process();
            $data = $this->Process->getProcessCatalog();
            echo json_encode($data);
        }

        public function getProcessManager(){
            $this->Process = new Process();
            $data = $this->Process->getProcessManager();
            echo json_encode($data);
        }

        public function getAreaUser(){
            $this->Process = new Process();
            $data = $this->Process->getAreaUser($_POST['id_user']);
            echo json_encode($data);
        }

        public function getExetcutionFlow(){
            $this->Process = new Process();
            $data = $this->Process->getExetcutionFlow();
            echo json_encode($data);
        }


        public function getNextExecutionFlow(){
            $this->Process = new Process();
            $data = $this->Process->getNextExecutionFlow();
            echo json_encode($data);
        }

        public function saveProcess(){
            $this->Process = new Process();
            $data = $this->Process->saveProcess($_POST['process_catalog'], $_POST['description'], $_POST['execution_flow'], $_POST['process_manager']);
            echo json_encode($data);
        }


        public function getProcessInfo(){
            $this->Process = new Process();
            $data = $this->Process->getProcessInfo($_POST['id_process_stages']);
            echo json_encode($data);
        }

        public function saveProcessEdit(){
            $this->Process = new Process();
            $data = $this->Process->saveProcessEdit($_POST['id_process_stages'], $_POST['process_catalog'], $_POST['description'], $_POST['execution_flow'], $_POST['process_manager']);
            echo json_encode($data);
        }

        public function deleteProcess(){
            $this->Process = new Process();
            $data = $this->Process->deleteProcess($_POST['id_process_stages']);
            echo json_encode($data);
        }
    }


    $obj = new processController();

    if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->listProcess();
	    } else if ($_POST["action"]==2){
         	$obj->detailsProcess();
        } else if ($_POST["action"]==3){
            $obj->getProcessCatalog();
        } else if ($_POST["action"]==4){
            $obj->getProcessManager();
        } else if ($_POST["action"]==5){
            $obj->saveProcess();
        } else if ($_POST["action"]==6){
            $obj->getProcessInfo();
        } else if ($_POST["action"]==7){
            $obj->saveProcessEdit();
        } else if ($_POST["action"]==8){
            $obj->deleteProcess();
        } else if ($_POST["action"]==9){
            $obj->getAreaUser();
        } else if ($_POST["action"]==10){
            $obj->getExetcutionFlow();
        } else if ($_POST["action"]==11){
            $obj->getNextExecutionFlow();
        }
	}

?>