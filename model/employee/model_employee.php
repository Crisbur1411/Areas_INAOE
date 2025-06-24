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
                                        WHERE employee.status = 1;");

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






}