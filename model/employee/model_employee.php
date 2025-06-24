<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./model/db_connection.php')){
    require_once './model/db_connection.php';
}else if(file_exists('../../model/db_connection.php')){
    require_once  '../../model/db_connection.php';
}else if(file_exists('../../../model/db_connection.php')){
    require_once  '../../../model/db_connection.php';
}


class employees{

public function listEmployee()
{
        $con = new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT employee.id_employee,
                                        CONCAT(employee.name, ' ', employee.surname, ' ', employee.second_surname) AS full_name,
                                        type_employee.name AS type_name,
                                        employee.area,
                                        employee.email,
                                        employee.status
                                        FROM employee
                                        JOIN 
                                            type_employee ON employee.fk_type_employee = type_employee.id_type_employee
                                        WHERE employee.status = 1 ORDER BY id_employee ASC ;");

        $data = array();

        while ($row = pg_fetch_array($dataTitle)) {
            $dat = array(
                "id_employee" => $row["id_employee"],
                "full_name" => $row["full_name"],
                "type_name" => $row["type_name"],
                "area" => $row["area"],
                "email" => $row["email"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();

        return $data;
    }



    public function saveEmployee ($name, $surname, $secondsurname, $email, $area, $password)
    {
        $con=new DBconnection();
        $con->openDB();

        $type_employee = 4;

        $employeeData = $con->query("INSERT INTO employee (email, password, name, surname, second_surname,area, fk_type_employee) 
        VALUES ('".$email."','".$password."', '".$name."','".$surname."', '".$secondsurname."','".$area."' , ".$type_employee.") 
        RETURNING id_employee");

        
        $validateEmployeeData = pg_fetch_row($employeeData);

        if ( $validateEmployeeData > 0)
        {            
            $con->closeDB();
            return $validateEmployeeData[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }



    public function getEmployeeInfoById($id_employee)
    {
        $con = new DBconnection();
        $con->openDB();

        $dataEmployee = $con->query("SELECT employee.id_employee,employee.name, employee.surname, employee.second_surname,employee.email, employee.area
    FROM employee
    WHERE employee.id_employee = $id_employee AND employee.status = 1;
");
        $row = pg_fetch_array($dataEmployee);

        $dataEmployee = array(
            "id_employee" => $row["id_employee"],
            "name" => $row["name"],
            "surname" => $row["surname"],
            "second_surname" => $row["second_surname"],
            "email" => $row["email"],
            "area" => $row["area"]
        );

        $con->closeDB();
        return array("status" => 200, "data" => $dataEmployee);
    }




    public function saveEmployeeEdit($id_employee, $area, $name, $surname, $secondsurname, $email){

        $con=new DBconnection();
        $con->openDB();

        $employeeDataEdit = $con->query("UPDATE employee SET name = '".$name."', surname = '".$surname."', second_surname = '".$secondsurname."', email = '".$email."', area = '".$area."' WHERE id_employee = ".$id_employee." RETURNING id_employee;");

        $validateEmployeeDataEdit = pg_fetch_row($employeeDataEdit);

        if ($validateEmployeeDataEdit > 0)
        {
            $con->closeDB();
            return $validateEmployeeDataEdit[0];
        }

        else
        {
            
        $con->closeDB();
        return "error";
        }
    }





}