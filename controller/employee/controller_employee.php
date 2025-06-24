<?php
require_once '../../model/employee/model_employee.php';

class employeeController{

    private $employees;

    public function __construct()
    {
    }

    public function listEmployee(){
        $this->employees = new employees();

        $data = $this->employees->listEmployee();
        echo json_encode($data);
    }

    public function saveEmployee(){
    		$this->employees= new employees();

	      	$data = $this->employees->saveEmployee($_POST["name"], $_POST["surname"], $_POST["secondsurname"], $_POST["email"], $_POST["area"], $_POST["password"]);
	      	echo ($data);
		}

}

$obj = new employeeController();

if (isset ($_POST['action'])){
    if ($_POST['action'] == 1) {
        $obj->listEmployee();
    } if ($_POST['action'] == 2) {
        $obj->saveEmployee();
    }
}