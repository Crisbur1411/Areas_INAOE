<?php
date_default_timezone_set("America/Mexico_City");
require_once('../../res/tcpdf/tcpdf.php');

if (file_exists('./m/db_connection.php')) {
    require_once './m/db_connection.php';
} else if (file_exists('../../m/db_connection.php')) {
    require_once  '../../m/db_connection.php';
} else if (file_exists('../../../m/db_connection.php')) {
    require_once  '../../../m/db_connection.php';
}

class alumnos
{

    public function listStudent()
    {
        $con = new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT students.id_student, CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name,
                                    students.control_number, DATE(students.date_register) AS date, courses.name AS namecourse, students.status
                                FROM
                                    students
                                    INNER JOIN courses ON students.fk_course = courses.id_course   
                                WHERE
                                    students.status = 1
                                    AND NOT EXISTS (
                                        SELECT
                                            1
                                        FROM
                                        trace_student_areas
                                        WHERE
                                        trace_student_areas.fk_student = students.id_student
                                    ) ORDER BY students.id_student;");

        $data = array();

        while ($row = pg_fetch_array($dataTitle)) {
            $dat = array(
                "id_student" => $row["id_student"],
                "full_name" => $row["full_name"],
                "control_number" => $row["control_number"],
                "date" => $row["date"],
                "namecourse" => $row["namecourse"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();

        return $data;
    }

    public function deleteStudent($id_student)
    {
        $con = new DBconnection();
        $con->openDB();

        $updateDelete = $con->query("UPDATE students SET status = 0 WHERE id_student = " . $id_student . " RETURNING id_student ");

        $validateUpdateDelete = pg_fetch_row($updateDelete);

        if ($validateUpdateDelete > 0) {
            $con->closeDB();
            return $validateUpdateDelete[0];
        } else {
            $con->closeDB();
            return "error";
        }
    }

    public function turnSingAreas($id_student, $user)
    {
        $con = new DBconnection();
        $con->openDB();
        $descrip = 'Tramite iniciado por: ' . $user;

        $updateTurn = $con->query("INSERT INTO trace_student_areas (fk_student, description, date, status) 
                                    VALUES (" . $id_student . ", '" . $descrip . "', NOW(), 2) RETURNING fk_student ");

        $validateUpdateTurn = pg_fetch_row($updateTurn);

        if ($validateUpdateTurn > 0) {
            $con->closeDB();
            return $validateUpdateTurn[0];
        } else {
            $con->closeDB();
            return "error";
        }
    }

    public function turnSingAreas2($id_student)
    {
        $con = new DBconnection();
        $con->openDB();

        $updateTurn = $con->query("UPDATE students SET status = 2 WHERE id_student =" . $id_student);

        $validateUpdateTurn = pg_fetch_row($updateTurn);

        if ($validateUpdateTurn > 0) {
            $con->closeDB();
            return $validateUpdateTurn[0];
        } else {
            $con->closeDB();
            return "error";
        }
    }


    public function listStudentInProgress()
    {
        $con = new DBconnection();
        $con->openDB();

        $dataR = $con->query("SELECT students.id_student, 
                                    CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name,
                                    students.control_number, 
                                    COUNT(trace_student_areas.fk_area) AS areas_count,                                      
                                    students.status
                                    FROM 
                                        students
                                    LEFT JOIN 
                                        trace_student_areas ON trace_student_areas.fk_student = students.id_student
                                    WHERE 
                                        students.status = 2 
                                    GROUP BY 
                                        students.id_student, 
                                        CONCAT(students.name, ' ', students.surname, ' ', students.second_surname),
                                        students.control_number,
                                        students.status
                                    ORDER BY 
                                        students.id_student;
                                    ");

        $data = array();

        while ($row = pg_fetch_array($dataR)) {
            $dat = array(
                "id_student" => $row["id_student"],
                "full_name" => $row["full_name"],
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
                                students.id_student = " . $id_student . " 
                                OR trace_student_areas.id_trace_student_area IS NULL
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

    public function freeStudent($id_student, $user)
    {
        $con = new DBconnection();
        $con->openDB();
        $descrip = 'Trámite finalizado por ' . $user;

        $updateTurn = $con->query("INSERT INTO trace_student_areas (fk_student, description, date, status) 
                                    VALUES (" . $id_student . ", '" . $descrip . "', NOW(), 3) RETURNING id_trace_student_area ");

        $validateUpdateTurn = pg_fetch_row($updateTurn);

        if ($validateUpdateTurn > 0) {
            $con->closeDB();
            return $validateUpdateTurn[0];
        } else {
            $con->closeDB();
            return "error";
        }
    }

    public function freeStudent2($id_student)
    {
        $con = new DBconnection();
        $con->openDB();

        $updateTurn = $con->query("UPDATE students SET status = 3 WHERE id_student =" . $id_student);

        $validateUpdateTurn = pg_fetch_row($updateTurn);

        if ($validateUpdateTurn > 0) {
            $con->closeDB();
            return $validateUpdateTurn[0];
        } else {
            $con->closeDB();
            return "error";
        }
    }

    public function listStudentFree()
    {
        $con = new DBconnection();
        $con->openDB();

        $dataR = $con->query("SELECT students.id_student, 
                                    CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name,
                                    students.control_number, 
                                    COUNT(trace_student_areas.fk_area) AS areas_count,  
                                    DATE(trace_student_areas.date) AS date,
                                    students.status
                                    FROM 
                                        students
                                    LEFT JOIN 
                                        trace_student_areas ON trace_student_areas.fk_student = students.id_student
                                    WHERE 
                                        students.status = 3 AND trace_student_areas.status= 3
                                    GROUP BY 
                                        students.id_student, 
                                        CONCAT(students.name, ' ', students.surname, ' ', students.second_surname),
                                        students.control_number,
                                        DATE(trace_student_areas.date),
                                        students.status
                                    ORDER BY 
                                        students.id_student;
                                    ");

        $data = array();

        while ($row = pg_fetch_array($dataR)) {
            $dat = array(
                "id_student" => $row["id_student"],
                "full_name" => $row["full_name"],
                "control_number" => $row["control_number"],
                "date" => $row["date"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();

        return $data;
    }

    public function cancelStudent($id_student, $user, $motivo)
    {
        $con = new DBconnection();
        $con->openDB();
        $descrip = 'Trámite cancelado por ' . $user . ' por el motivo: ' . $motivo;

        $updateTurn = $con->query("INSERT INTO trace_student_areas (fk_student, description, date, status) 
                                    VALUES (" . $id_student . ", '" . $descrip . "', NOW(), 4) RETURNING id_trace_student_area ");

        $validateUpdateTurn = pg_fetch_row($updateTurn);

        if ($validateUpdateTurn > 0) {
            $con->closeDB();
            return $validateUpdateTurn[0];
        } else {
            $con->closeDB();
            return "error";
        }
    }

    public function cancelStudent2($id_student)
    {
        $con = new DBconnection();
        $con->openDB();

        $updateTurn = $con->query("UPDATE students SET status = 4 WHERE id_student =" . $id_student);

        $validateUpdateTurn = pg_fetch_row($updateTurn);

        if ($validateUpdateTurn > 0) {
            $con->closeDB();
            return $validateUpdateTurn[0];
        } else {
            $con->closeDB();
            return "error";
        }
    }

    public function listStudentCancel()
    {
        $con = new DBconnection();
        $con->openDB();

        $dataR = $con->query("SELECT students.id_student, 
                                    CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name,
                                    students.control_number, 
                                    COUNT(trace_student_areas.fk_area) AS areas_count,  
                                    DATE(trace_student_areas.date) AS date,
                                    students.status
                                    FROM 
                                        students
                                    LEFT JOIN 
                                        trace_student_areas ON trace_student_areas.fk_student = students.id_student
                                    WHERE 
                                        students.status = 4 AND trace_student_areas.status= 4
                                    GROUP BY 
                                        students.id_student, 
                                        CONCAT(students.name, ' ', students.surname, ' ', students.second_surname),
                                        students.control_number,
                                        DATE(trace_student_areas.date),
                                        students.status
                                    ORDER BY 
                                        students.id_student;
                                    ");

        $data = array();

        while ($row = pg_fetch_array($dataR)) {
            $dat = array(
                "id_student" => $row["id_student"],
                "full_name" => $row["full_name"],
                "control_number" => $row["control_number"],
                "date" => $row["date"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();

        return $data;
    }


    //desarrollaod por bryam el 09/04/2024 trae todo los datos que lleva el pdf

    public function generatePDF($id_student)
    {
        $con = new DBconnection();
        $con->openDB();

        $pdfinfo = $con->query("SELECT CONCAT(s.name, ' ', s.surname, ' ', s.second_surname) AS full_name,
                                                        a.name AS area_name,
                                                        a.key AS key, 
                                                        ta.description AS libera,
                                                        DATE(ta.date) AS date
                                                FROM students s
                                                JOIN trace_student_areas ta ON s.id_student = ta.fk_student
                                                JOIN areas a ON ta.fk_area = a.id_area
                                                WHERE s.id_student = '$id_student'
                                                ORDER BY ta.id_trace_student_area ASC;
                                    ");

        $pdfData = array();

        while ($row = pg_fetch_array($pdfinfo)) {
            $dat = array(
                "full_name" => $row["full_name"],
                "area_name" => $row["area_name"],
                "key" => $row["key"],
                "libera" => $row["libera"],
                "date" => $row["date"]
            );
            $pdfData[] = $dat;
        }

        $con->closeDB();

        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // Configuración del PDF
        $pdf->SetCreator('FDA');
        $pdf->SetAuthor('YO');
        $pdf->SetTitle('Student Certificate');
        $pdf->SetSubject('Certificate for Student');
        $pdf->SetKeywords('Certificate, Student, TCPDF');

        // Configuración de márgenes
        $pdf->SetMargins(10, 7, 10);
        $pdf->SetFooterMargin(10);

        $pdf->AddPage();

        $studentData = $pdfData[0];

        // Definir el contenido HTML para la tabla
        $html = '
                <center>
                <img src="../../res/temp/encabezadoo.png" style="width: 900px; height: 130px;">
                <div>
                <p>Por este medio los abajo firmantes hacemos constar que el (la) alumno(a): ' . $studentData["full_name"] . ' del Programa de: Maestría (  ) Doctorado (  ), NO TIENE ningún ADEUDO en los departamentos o laboratorios a nuestro cargo</p>
                </div>
                <br></br>
                <br></br>
                
                <table border="0.3" style="width: 100%;">
                    <thead>
                        <tr style="text-align: center;">
                            <td>Area</td>
                            <td>Libera</td>
                            <td>Fecha</td>
                            <td>Sello</td>
                        </tr>
                    </thead>
                    <tbody>';

                            foreach ($pdfData as $area) {
                                $imageName = $area["key"] . ".png";
                                $html .= '
                                                <tr>
                                                    <td height="60">' . $area["area_name"] . '</td>
                                                    <td>' . $area["libera"] . '</td>
                                                    <td>' . $area["date"] . '</td>
                                                    <td><img src="../../res/imgs/' . $imageName . '" style="width: 50px; height: 50px;"></td>
                                                </tr>';
                            }

                            $html .= '
                             </tbody>
                                 </table>
                                </center>
                                <div style="text-align: center;">
                                    <p>Formato acreditado por la FDA, Santa María Tonantzintla a Fecha: ' . date("d-m-Y") . '</p>
                                </div>
                        ';

        // Escribir el contenido HTML en el PDF
        $pdf->SetFont('helvetica', '', 12);
        $pdf->writeHTML($html, true, false, true, false, '');


        $pdfContent = $pdf->Output('student_certificate.pdf', 'S');
        $pdfPath = '../../res/temp/' . $_POST["id_student"] . '.pdf';
        file_put_contents($pdfPath, $pdfContent);
        $pdfUrl = '../../res/temp/' . $_POST["id_student"] . '.pdf';

        return array('pdf_url' => $pdfUrl);
    }
}
