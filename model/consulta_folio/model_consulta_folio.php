<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./model/db_connection.php')){
    require_once './model/db_connection.php';
}else if(file_exists('../../model/db_connection.php')){
    require_once  '../../model/db_connection.php';
}else if(file_exists('../../../model/db_connection.php')){
    require_once  '../../../model/db_connection.php';
}


class validateFolio{


public function validateFolioStudent($folio)
    {
        $con = new DBconnection();
        $con->openDB();

        $dataR = $con->query("SELECT id_student, folio FROM students WHERE folio = '$folio'");

        $validateDataFolio =  pg_fetch_row($dataR);

        if ($validateDataFolio > 0) {
            $con->closeDB();
            return $validateDataFolio[0];
        } else {
            $con->closeDB();
            return "error";
        }
    }


    public function listStudentFree($folio)
{
    $con = new DBconnection();
    $con->openDB();

    $dataR = $con->query("SELECT id_student, CONCAT(name, ' ', surname, ' ', second_surname) AS full_name
	FROM students 
	WHERE folio = '$folio' AND status = 3;");

    $data = array();

    while ($row = pg_fetch_array($dataR)) {
        $dat = array(
            "id_student" => $row["id_student"],
            "full_name" => $row["full_name"]
        );
        $data[] = $dat;
    }
    $con->closeDB();

    return $data;
}



public function getDetailsStudent($id_student)
{
    $con = new DBconnection();
    $con->openDB();

    $dataR = $con->query("SELECT s.id_student,
		CONCAT(s.name, ' ', s.surname, ' ', s.second_surname, ' ') AS full_name,
		s.control_number AS control_number,
		s.email,
		s.institucion,
		s.fecha_conclusion,
		s.folio,
		s.status,
		p.name AS programa_academico
		FROM students AS s
		JOIN academic_programs AS p
		ON s.fk_academic_programs = p.id_academic_programs
		WHERE s.id_student = " . $id_student . ";");

    $data = null;

    if ($row = pg_fetch_array($dataR)) {
        $data = array(
            "id_student" => $row["id_student"],
            "full_name" => $row["full_name"],
            "control_number" => $row["control_number"],
            "email" => $row["email"],
            "institucion" => $row["institucion"],
            "fecha_conclusion" => $row["fecha_conclusion"],
            "folio" => $row["folio"],
            "status" => $row["status"],
            "programa_academico" => $row["programa_academico"]
        );
    }

    $con->closeDB();

    return array("status" => 200, "data" => $data);
}


}