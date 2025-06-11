<?php
date_default_timezone_set("America/Mexico_City");

if (file_exists('./model/db_connection.php')) {
    require_once './model/db_connection.php';
} else if (file_exists('../../model/db_connection.php')) {
    require_once  '../../model/db_connection.php';
} else if (file_exists('../../../model/db_connection.php')) {
    require_once  '../../../model/db_connection.php';
}


class proceso
{


public function listStudentInProgress($email)
{
    $con = new DBconnection();
    $con->openDB();

    $dataR = $con->query("SELECT students.id_student, 
                                CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name,
                                students.control_number,
                                students.email, 
                                COUNT(trace_student_areas.fk_area) AS areas_count,                                      
                                students.status
                            FROM 
                                students
                            LEFT JOIN 
                                trace_student_areas ON trace_student_areas.fk_student = students.id_student
                            WHERE 
                                students.status = 2 
                                AND students.email = '$email'
                            GROUP BY 
                                students.id_student, 
                                CONCAT(students.name, ' ', students.surname, ' ', students.second_surname),
                                students.control_number,
                                students.email,
                                students.status
                            ORDER BY 
                                students.id_student;
                        ");

    $data = array();

    while ($row = pg_fetch_array($dataR)) {
        $dat = array(
            "id_student" => $row["id_student"],
            "full_name" => $row["full_name"],
            "email" => $row["email"],
            "control_number" => $row["control_number"],
            "areas_count" => $row["areas_count"],
            "status" => $row["status"]
        );
        $data[] = $dat;
    }
    $con->closeDB();

    return $data;
}



    public function showRegisterAreas($id_student)
{
    $con = new DBconnection();
    $con->openDB();
    $id_student = intval($id_student); // <-- aquí casteas a entero

    $dataR = $con->query("SELECT 
                            trace_student_areas.id_trace_student_area, 
                            students.id_student, 
                            CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name, 
                            COALESCE(areas.name, '-') AS namearea, 
                            COALESCE(to_char(trace_student_areas.date, 'YYYY-MM-DD HH24:MI:SS'), '-') AS formatted_date, 
                            COALESCE(trace_student_areas.description, 'Sin autorizar') AS description, 
                            COALESCE(students.status, 0) AS status
                        FROM 
                            students
                        LEFT JOIN 
                            trace_student_areas ON students.id_student = trace_student_areas.fk_student
                        RIGHT JOIN 
                            areas ON areas.id_area = trace_student_areas.fk_area
                        WHERE 
                            students.id_student = '$id_student'
                            OR trace_student_areas.id_trace_student_area IS NULL AND areas.status = 1
                        ORDER BY 
                            areas.id_area;
                        ");

    $data = array();

    while ($row = pg_fetch_array($dataR)) {
        $dat = array(
            "id_trace_student_area" => $row["id_trace_student_area"],
            "id_student" => $row["id_student"],
            "full_name" => $row["full_name"],
            "namearea" => $row["namearea"],
            "formatted_date" => $row["formatted_date"],
            "description" => $row["description"],
            "status" => $row["status"]
        );
        $data[] = $dat;
    }
    $con->closeDB();

    return $data;
}



    public function validateEmail($email)
    {
        $con = new DBconnection();
        $con->openDB();

        $dataR = $con->query("SELECT id_student, email FROM students WHERE email = '$email'");

        $validateDataEmail =  pg_fetch_row($dataR);

        if ($validateDataEmail > 0) {
            $con->closeDB();
            return $validateDataEmail[0];
        } else {
            $con->closeDB();
            return "error";
        }
    }


    public function userAutoricedLiberation()
    {
        $con = new DBconnection();
        $con->openDB();

        $dataR = $con->query("SELECT
                                CONCAT(users.name, ' ', users.surname, ' ', users.second_surname) AS full_name,
                                CASE
                                    WHEN users.fk_type = type_users.id_type_users THEN areas.name
                                    ELSE 'Sin área asignada'
                                END AS area_name
                                FROM users
                                INNER JOIN type_users ON users.fk_type = type_users.id_type_users
                                INNER JOIN user_area ON users.id_user = user_area.fk_user
                                INNER JOIN areas ON user_area.fk_area = areas.id_area
                                WHERE users.status = 1
                                ORDER BY users.id_user
                                    ");

        $data = array();

        while ($row = pg_fetch_array($dataR)) {
            $dat = array(
                "area_name" => $row["area_name"],
                "full_name" => $row["full_name"]
            );
            $data[] = $dat;
        }

        $con->closeDB();
        return $data;



    }







    
}