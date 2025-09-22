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
                                students.status,
                                students.fk_process_catalog
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
            "status" => $row["status"],
            "fk_process_catalog" => $row["fk_process_catalog"]
        );
        $data[] = $dat;
    }
    $con->closeDB();

    return $data;
}



    public function showRegisterAreas($id_student, $fk_process_catalog)
{
    $con = new DBconnection();
    $con->openDB();

    $sql = "
        SELECT 
            tsa.id_trace_student_area,
            s.id_student,
            CONCAT(s.name, ' ', s.surname, ' ', s.second_surname) AS full_name,
            COALESCE(a.name, '-') AS namearea,
            COALESCE(to_char(tsa.date, 'YYYY-MM-DD HH24:MI:SS'), '-') AS formatted_date,
            COALESCE(tsa.description, 'Sin autorizar') AS description,
            COALESCE(s.status, 0) AS status
        FROM (
            -- 🔑 Subconsulta: áreas que pertenecen a un catálogo específico
            SELECT DISTINCT 
                a.id_area, 
                a.name
            FROM process_stages ps
            INNER JOIN process_catalog pc 
                ON pc.id_process_catalog = ps.fk_process_catalog
            INNER JOIN users u 
                ON u.id_user = ps.fk_process_manager
            INNER JOIN user_area ua 
                ON ua.fk_user = u.id_user
            INNER JOIN areas a 
                ON a.id_area = ua.fk_area
            WHERE ps.status = 1
              AND pc.id_process_catalog = $fk_process_catalog
              AND a.status = 1
        ) a
        LEFT JOIN trace_student_areas tsa 
            ON tsa.fk_area = a.id_area 
           AND tsa.fk_student = $id_student
        LEFT JOIN students s 
            ON s.id_student = tsa.fk_student
        ORDER BY a.id_area, tsa.date
    ";

    $dataR = $con->query($sql);

    $data = array();

    while ($row = pg_fetch_array($dataR)) {
        $dat = array(
            "id_trace_student_area" => $row["id_trace_student_area"],
            "id_student"            => $row["id_student"],
            "full_name"             => $row["full_name"],
            "namearea"              => $row["namearea"],
            "formatted_date"        => $row["formatted_date"],
            "description"           => $row["description"],
            "status"                => $row["status"]
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

        $dataR = $con->query("SELECT a.name AS area_name,
                                    CONCAT (u.name, ' ', u.surname, ' ', u.second_surname) AS full_name
                                    FROM 
                                        user_area AS ua
                                    JOIN
                                        areas AS a ON ua.fk_area = a.id_area
                                    JOIN
                                        users AS u ON ua.fk_user = u.id_user
                                    WHERE 
                                        u.status = 1
                                    ORDER BY a.name ASC
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