<?php
    require_once '../../m/administracion/model_administracion.php';


    class documentController{
    	private $admin;

    	public function __construct(){} 


		public function titleList(){
    		$this->admin= new admin();

	      	$data = $this->admin->titleList();
	      	echo json_encode($data); 
		}
		public function showRegister(){
    		$this->admin= new admin();

	      	$data = $this->admin->showRegister($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function titleListSign(){
    		$this->admin= new admin();

	      	$data = $this->admin->titleListSign();
	      	echo json_encode($data);
		}

		public function titleListToSign(){
    		$this->admin= new admin();

	      	$data = $this->admin->titleListToSign();
	      	echo json_encode($data);
		}

		public function titleListDGP(){
    		$this->admin= new admin();

	      	$data = $this->admin->titleListDGP();
	      	echo json_encode($data);
		}


		public function titleListRefused(){
    		$this->admin= new admin();

	      	$data = $this->admin->titleListRefused();
	      	echo json_encode($data);
		}

		public function titleListIssue(){
    		$this->admin= new admin();

	      	$data = $this->admin->titleListIssue();
	      	echo json_encode($data);
		}
		public function confirmUser(){
    		$this->admin= new admin();

	      	$data = $this->admin->confirmUser( $_POST["user_password"]);
	      	echo ($data);
		}

		public function editRegister(){
    		$this->admin= new admin();

	      	$data = $this->admin->editRegister($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function updateDelete(){
    		$this->admin= new admin();

	      	$data = $this->admin->updateDelete($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function traceUpdateDelete(){
    		$this->admin= new admin();

	      	$data = $this->admin->traceUpdateDelete($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["user"]);
	      	echo json_encode($data);
		}

		public function updateSignature(){
    		$this->admin= new admin();

	      	$data = $this->admin->updateSignature($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function traceUpdateSignature(){
    		$this->admin= new admin(); 

	      	$data = $this->admin->traceUpdateSignature($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["user"]);
	      	echo json_encode($data);
		}

		public function updateSend(){
    		$this->admin= new admin();

	      	$data = $this->admin->updateSend($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function traceUpdateSend(){
    		$this->admin= new admin(); 

	      	$data = $this->admin->traceUpdateSend($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["numeroLote"],  $_POST["user"]);
	      	echo json_encode($data);
		}

		public function generateXML(){
    		$this->admin= new admin();

	      	$data = $this->admin->generateXML($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function userList(){
    		$this->admin= new admin();

	      	$data = $this->admin->userList();
	      	echo json_encode($data); 
		}

		public function optionUser(){
    		$this->admin= new admin();
	      	$data = $this->admin->optionUser($_POST["status"], $_POST["id_user"]);
	      	echo json_encode($data);
		}
		public function createUser(){
			$this->admin= new admin();
	      	$data = $this->admin->createUser($_POST["type"], $_POST["name_user"], $_POST["psw"]);
	      	echo json_encode($data);
		}

		public function extFile(){
			$this->admin= new admin(); 
	      	$data = $this->admin->extFile($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function traceDownload(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->traceDownload($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["user"]);
	      	echo json_encode($data);
		}

		public function consultStatus(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->consultStatus($_POST["id_titledata"]);
	      	echo json_encode($data);
		}
		
		public function traceConsult(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->traceConsult($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["user"]);
	      	echo json_encode($data); 
		}

		public function showHistory(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->showHistory($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function downloadTitle(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->downloadTitle($_POST["id_titledata"]);
	      	echo json_encode($data);
		}
		public function emitir(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->emitir($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function traceUpdateEmitir(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->traceUpdateEmitir($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["msg"]);
	      	echo json_encode($data); 
		}

		public function rechazar(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->rechazar($_POST["id_titledata"]);
	      	echo json_encode($data);
		}
		
		public function traceUpdateRechazar(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->traceUpdateRechazar($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["msg"]);
	      	echo json_encode($data); 
		}

		public function showDetailsDGP(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->showDetailsDGP($_POST["id_titledata"]);
	      	echo json_encode($data);
		}
		
		public function deleteInfo(){
    		$this->admin= new admin(); 
	      	$data = $this->admin->deleteInfo();
	      	echo json_encode($data);
		}

		public function toCancel(){
    		$this->admin= new admin();

	      	$data = $this->admin->toCancel($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function traceToCancel(){
    		$this->admin= new admin();

	      	$data = $this->admin->traceToCancel($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["user"]);
	      	echo json_encode($data);
		}

		public function toCancelList(){
    		$this->admin= new admin();

	      	$data = $this->admin->toCancelList();
	      	echo json_encode($data);
		}
		
		public function turnSingDocumentCancel(){
    		$this->admin= new admin();

	      	$data = $this->admin->turnSingDocumentCancel($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function traceTurnSingDocumentCancel(){
    		$this->admin= new admin(); 

	      	$data = $this->admin->traceTurnSingDocumentCancel($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["user"]);
	      	echo json_encode($data);
		}

		public function titleListToSignCancel(){
    		$this->admin= new admin();

	      	$data = $this->admin->titleListToSignCancel();
	      	echo json_encode($data);
		}




		public function readyDocumentCancel(){
    		$this->admin= new admin();

	      	$data = $this->admin->turnSingDocumentCancel($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function traceReadyDocumentCancel(){
    		$this->admin= new admin(); 

	      	$data = $this->admin->traceTurnSingDocumentCancel($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["user"]);
	      	echo json_encode($data);
		}

		public function readyCancel(){
    		$this->admin= new admin();

	      	$data = $this->admin->readyCancel();
	      	echo json_encode($data);
		}

		public function mCancel(){
    		$this->admin= new admin();

	      	$data = $this->admin->mCancel($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function tracemCancel(){
    		$this->admin= new admin();

	      	$data = $this->admin->tracemCancel($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["motivo"], $_POST["motivoDGP"], $_POST["user"]);
	      	echo json_encode($data);
		}

		public function titleListCancel(){
    		$this->admin= new admin();

	      	$data = $this->admin->titleListCancel();
	      	echo json_encode($data);
		}

		public function cancelDGP(){
    		$this->admin= new admin();

	      	$data = $this->admin->cancelDGP($_POST["id_titledata"]);
	      	echo json_encode($data);
		}

		public function traceCancelDGP(){
    		$this->admin= new admin(); 

	      	$data = $this->admin->traceCancelDGP($_POST["id_titledata"], $_POST["controlinvoice"], $_POST["dateDGP"], $_POST["dDGP"], $_POST["user"]);
	      	echo json_encode($data);
		}

		public function goTitleListSign(){
    		$this->admin= new admin();

	      	$data = $this->admin->goTitleListSign($_POST["id_documentdata"]);
	      	echo json_encode($data);
		}

		public function traceGoTitleListSign(){
    		$this->admin= new admin(); 

	      	$data = $this->admin->traceGoTitleListSign($_POST["id_titledata"], $_POST["controlinvoice"]);
	      	echo json_encode($data);
		}

    }

    $obj = new documentController();

	if (isset($_POST["action"])){
	    if ($_POST["action"]==1){
	     	$obj->titleList();		//status == 1
	    }if ($_POST["action"]==2) {
	    	$obj->confirmUser();
	    }if ($_POST["action"]==3) {  
	    	$obj->editRegister();
	    }if ($_POST["action"]==4) {
	    	$obj->updateDelete();   // cambiar a status == 0
	    }if ($_POST["action"]==5) {
	    	$obj->traceUpdateDelete();   //historico borrar
	    }if ($_POST["action"]==6) {
	    	$obj->updateSignature();	//turnar a firma 
	    }if ($_POST["action"]==7) {
	    	$obj->traceUpdateSignature();    //historico turnado a firma 
	    }if ($_POST["action"]==8) {
	    	$obj->generateXML();
	    }if ($_POST["action"]==9) { 
	    	$obj->showRegister();
	    }if ($_POST["action"]==11) {
	    	$obj->titleListSign();	//status == 3
	    }if ($_POST["action"]==12) {
	    	$obj->titleListDGP();	//status == 4
	    }if ($_POST["action"]==13) {
	    	$obj->titleListIssue();		//status == 5
	    }if ($_POST["action"]==14) {  
	    	$obj->titleListRefused(); //status == 6
	    }if ($_POST["action"]==15) {
	    	$obj->titleListToSign(); // status == 2
	    }if ($_POST["action"]==16) {
	    	$obj->updateSend(); // enviar DGP
	    }if ($_POST["action"]==17) {
	    	$obj->traceUpdateSend(); // historico enviar DGP
	    }if ($_POST["action"]==18) {
	    	$obj->userList(); 
	    }if ($_POST["action"]==19) {
	    	$obj->optionUser(); 
	    }if ($_POST["action"]==20) {
	    	$obj->createUser();
	    }if ($_POST["action"]==21) {
	    	$obj->extFile(); 
	    }if ($_POST["action"]==22) {
	    	$obj->traceDownload(); // historico enviar DGP
	    }if ($_POST["action"]==23) {
	    	$obj->consultStatus(); // historico enviar DGP
	    }if ($_POST["action"]==24) {
	    	$obj->emitir(); // DESCARGAR TITULO
	    }if ($_POST["action"]==25) {
	    	$obj->traceConsult(); // historico enviar DGP
	    }if ($_POST["action"]==26) {
	    	$obj->showHistory(); // historico enviar DGP
	    }if ($_POST["action"]==27) {
	    	$obj->downloadTitle(); // DESCARGAR TITULO
	    }if ($_POST["action"]==28) {
	    	$obj->traceUpdateEmitir(); // DESCARGAR TITULO
	    }if ($_POST["action"]==29) {
	    	$obj->rechazar(); // DESCARGAR TITULO
	    }if ($_POST["action"]==30) {
	    	$obj->traceUpdateRechazar(); // DESCARGAR TITULO
	    }if ($_POST["action"]==31) {
	    	$obj->showDetailsDGP(); // DESCARGAR TITULO
	    }if ($_POST["action"]==32) {
	    	$obj->deleteInfo(); //  Cambiar tipo de usuario director
	    }if ($_POST["action"]==33) {
	    	$obj->toCancel(); //  toCancel
	    }if ($_POST["action"]==34) {
	    	$obj->traceToCancel(); //  tracetoCancel
	    }if ($_POST["action"]==35) {
	    	$obj->toCancelList(); //  toCancelList
	    }if ($_POST["action"]==36) {
	    	$obj->turnSingDocumentCancel(); //  firma
	    }if ($_POST["action"]==37) {
	    	$obj->traceTurnSingDocumentCancel(); //  
	    }if ($_POST["action"]==38) {
	    	$obj->titleListToSignCancel(); //  
	    }if ($_POST["action"]==39) {
	    	$obj->readyDocumentCancel(); //  firma
	    }if ($_POST["action"]==40) {
	    	$obj->traceReadyDocumentCancel(); //  
	    }if ($_POST["action"]==41) {
	    	$obj->readyCancel(); //  
	    }if ($_POST["action"]==42) {
	    	$obj->mCancel(); // motivo 
	    }if ($_POST["action"]==43) {
	    	$obj->tracemCancel(); // motivo 
	    }if ($_POST["action"]==44) {
	    	$obj->titleListCancel(); // cancelacion DGP 
	    }if ($_POST["action"]==45) {
	    	$obj->cancelDGP(); // cancelacion OK 
	    }if ($_POST["action"]==46) {
	    	$obj->traceCancelDGP(); // cancelacion OK 
	    }if ($_POST["action"]==47) {
	    	$obj->goTitleListSign(); // Regresa status 3
	    }if ($_POST["action"]==48) {
	    	$obj->traceGoTitleListSign(); // Regresa status 3
	    }
		
		


	
	    
	}
 ?>