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

    public function getEmployeeInfoById()
	{
		$this->employees = new employees();
		$data = $this->employees->getEmployeeInfoById($_POST['id_employee']);
		echo json_encode($data);
	}


    public function saveEmployeeEdit(){
    		$this->employees= new employees();
			
	      	$data = $this->employees->saveEmployeeEdit($_POST["employee_id"],$_POST["area"],$_POST["name"], $_POST["surname"], $_POST["secondsurname"], $_POST["email"]);
	      	echo json_encode($data);
		}


    public function deleteEmployee()
	{
		$this->employees = new employees();

		$data = $this->employees->deleteEmployee($_POST['id_employee']);
		echo json_encode($data);
	}


    public function updatePasswordWithoutCheck()
	{
		$this->employees = new employees();

		$data = $this->employees->updatePasswordWithoutCheck($_POST['id_employee'], $_POST['new_passsword']);
		echo json_encode($data);
	}

}

$obj = new employeeController();

if (isset ($_POST['action'])){
    if ($_POST['action'] == 1) {
        $obj->listEmployee();
    } if ($_POST['action'] == 2) {
        $obj->saveEmployee();
    } if ($_POST['action'] == 3) {
        $obj->getEmployeeInfoById();
    } if ($_POST['action'] == 4) {
        $obj->saveEmployeeEdit();
    } if ($_POST['action'] == 5) {
        $obj->deleteEmployee();
    } if ($_POST['action'] == 6) {
        $obj->updatePasswordWithoutCheck();
    }
}