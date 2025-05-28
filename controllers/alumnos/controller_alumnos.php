<?php
require_once '../../m/alumnos/model_alumnos.php';
require_once('../../res/tcpdf/tcpdf.php');

class alumnosController
{
	private $alumnos;

	public function __construct()
	{
	}
	public function listStudent()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->listStudent();
		echo json_encode($data);
	}


	public function getCourses(){
    		$this->alumnos= new alumnos();

	      	$data = $this->alumnos->getCourses($_POST["program"]);
	      	echo json_encode($data);
		}

		public function saveStudent(){
    		$this->alumnos= new alumnos();

	      	$data = $this->alumnos->saveStudent($_POST["name"], $_POST["surname"], $_POST["secondsurname"], $_POST["email"], $_POST["controlnumber"], $_POST["course"]);
	      	echo ($data);
		}

	public function deleteStudent()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->deleteStudent($_POST["id_student"]);
		echo json_encode($data);
	}

	public function turnSingAreas()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->turnSingAreas($_POST["id_student"], $_POST["user"]);
		echo json_encode($data);
	}

	public function turnSingAreas2()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->turnSingAreas2($_POST["id_student"]);
		echo json_encode($data);
	}

	public function listStudentInProgress()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->listStudentInProgress();
		echo json_encode($data);
	}

	public function showRegisterAreas()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->showRegisterAreas($_POST["id_student"]);
		echo json_encode($data);
	}

	public function freeStudent()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->freeStudent($_POST["id_student"], $_POST["user"]);
		echo json_encode($data);
	}

	public function freeStudent2()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->freeStudent2($_POST["id_student"]);
		echo json_encode($data);
	}

	public function listStudentFree()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->listStudentFree();
		echo json_encode($data);
	}

	public function cancelStudent()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->cancelStudent($_POST["id_student"], $_POST["user"], $_POST["motivo"]);
		echo json_encode($data);
	}

	public function cancelStudent2()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->cancelStudent2($_POST["id_student"]);
		echo json_encode($data);
	}

	public function listStudentCancel()
	{
		$this->alumnos = new alumnos();

		$data = $this->alumnos->listStudentCancel();
		echo json_encode($data);
	}

	//Hecho por bryam el 03/04/2024 genera el pdf
	public function generatePDF()
	{
		$this->alumnos = new alumnos();
		$pdfData= $this->alumnos->generatePDF($_POST["id_student"]);
		return json_encode($pdfData);
	}



	//De aqui en adelante son las funciones para actualizar alumnos

		public function coursesAds(){
    		$this->alumnos= new alumnos();

			$data = $this->alumnos->coursesAds($_POST["id_student"]);
	      	echo json_encode($data);
		}

		public function getStudent(){
    		$this->alumnos= new alumnos();

			$data = $this->alumnos->getStudent($_POST["id_student"]);
	      	echo json_encode($data);
		}

		public function updateStudent(){
    		$this->alumnos= new alumnos();

	      	$data = $this->alumnos->updateStudent($_POST["id_student"], $_POST["name"], $_POST["surname"], $_POST["secondsurname"], $_POST["email"], $_POST["controlnumber"], $_POST["course"]);
	      	echo ($data);
		}
}

$obj = new alumnosController();

if (isset($_POST["action"])) {
	if ($_POST["action"] == 1) {
		$obj->listStudent();
	}
	if ($_POST["action"] == 2) {
		$obj->deleteStudent();
	}
	if ($_POST["action"] == 3) {
		$obj->turnSingAreas();
	}
	if ($_POST["action"] == 4) {
		$obj->listStudentInProgress();
	}
	if ($_POST["action"] == 5) {
		$obj->showRegisterAreas();
	}
	if ($_POST["action"] == 6) {
		$obj->freeStudent();
	}
	if ($_POST["action"] == 7) {
		$obj->freeStudent2();
	}
	if ($_POST["action"] == 8) {
		$obj->listStudentFree();
	}
	if ($_POST["action"] == 9) {
		$obj->turnSingAreas2();
	}
	if ($_POST["action"] == 10) {
		$obj->cancelStudent();
	}
	if ($_POST["action"] == 11) {
		$obj->cancelStudent2();
	}
	if ($_POST["action"] == 12) {
		$obj->listStudentCancel();
	} if ($_POST["action"] == 13) {
		$pdfUrl = $obj->generatePDF();
		echo $pdfUrl;
	}
	if ($_POST["action"] == 14) {
		$obj->getCourses();
	}
	if ($_POST["action"] == 15) {
		$obj->saveStudent();
	}
	if ($_POST["action"] == 16) {
		$obj->coursesAds();
	}
	if ($_POST["action"] == 17) {
		$obj->getStudent();
	}
	if ($_POST["action"] == 18) {
		$obj->updateStudent();
	}
	
}
