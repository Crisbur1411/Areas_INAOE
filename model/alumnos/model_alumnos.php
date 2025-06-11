<?php
date_default_timezone_set("America/Mexico_City");
require_once('../../res/tcpdf/tcpdf.php');

if (file_exists('./model/db_connection.php')) {
    require_once './model/db_connection.php';
} else if (file_exists('../../model/db_connection.php')) {
    require_once  '../../model/db_connection.php';
} else if (file_exists('../../../model/db_connection.php')) {
    require_once  '../../../model/db_connection.php';
}

class alumnos
{

    public function listStudent()
    {
        $con = new DBconnection();
        $con->openDB();

            $dataTitle = $con->query("SELECT students.id_student, 
                                 CONCAT(students.name, ' ', students.surname, ' ', students.second_surname) AS full_name,
                                 students.control_number, 
                                 DATE(students.date_register) AS date, 
                                 academic_programs.name AS namecourse, 
                                 students.status
                          FROM
                              students
                          INNER JOIN academic_programs 
                              ON students.fk_academic_programs = academic_programs.id_academic_programs   
                          WHERE
                              students.status = 1
                              AND NOT EXISTS (
                                  SELECT 1
                                  FROM trace_student_areas
                                  WHERE trace_student_areas.fk_student = students.id_student
                              )
                          ORDER BY students.id_student;");


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

        public function getCourses($program){
        $con=new DBconnection();
        $con->openDB();

        $ar = $con->query("SELECT id_academic_programs, name FROM academic_programs WHERE status = 1 AND type = ".$program.";");

        $data = array();

        while($row = pg_fetch_array($ar)){
            $dat = array(
                "id_academic_programs"=>$row["id_academic_programs"],
                "name"=>$row["name"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        return $data;
    }

    public function saveStudent ($name, $surname, $secondsurname, $email, $controlnumber, $course, $institucion, $date_conclusion)
    {
        $con=new DBconnection();
        $con->openDB();

        $studentData = $con->query("INSERT INTO students (name, surname, second_surname, control_number, email, fk_academic_programs, institucion, fecha_conclusion, date_register) 
        VALUES ('".$name."','".$surname."', '".$secondsurname."','".$controlnumber."','".$email."',".$course.", '".$institucion."', '".$date_conclusion."', NOW()) 
        RETURNING id_student");

        
        $validateStudentData = pg_fetch_row($studentData);

        if ( $validateStudentData > 0)
        {            
            $con->closeDB();
            return $validateStudentData[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
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

    // Fecha actual desde PHP para el hash
    $date = date('Y-m-d H:i:s');

    // Hash md5(id_estudiante|user|fecha)
    $hash_release = md5($id_student . '|' . $user . '|' . $date);

    $updateTurn = $con->query("INSERT INTO trace_student_areas (fk_student, description, date, status, hash_release) 
                                VALUES (" . $id_student . ", '" . $descrip . "', '" . $date . "', 2, '" . $hash_release . "') 
                                RETURNING fk_student ");

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
    areas
LEFT JOIN 
    trace_student_areas ON areas.id_area = trace_student_areas.fk_area 
        AND trace_student_areas.fk_student = " . $id_student . "
LEFT JOIN 
    students ON students.id_student = trace_student_areas.fk_student
WHERE 
    areas.status = 1
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

    // Fecha actual desde PHP para el hash
    $date = date('Y-m-d H:i:s');

    // Hash md5(id_student|user|fecha)
    $hash_release = md5($id_student . '|' . $user . '|' . $date);

    $updateTurn = $con->query("INSERT INTO trace_student_areas (fk_student, description, date, status, hash_release) 
                                VALUES (" . $id_student . ", '" . $descrip . "', '" . $date . "', 3, '" . $hash_release . "') 
                                RETURNING id_trace_student_area ");

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

    // Fecha actual desde PHP para el hash
    $date = date('Y-m-d H:i:s');

    // Hash md5(id_student|user|fecha)
    $hash_release = md5($id_student . '|' . $user . '|' . $date);

    $updateTurn = $con->query("INSERT INTO trace_student_areas (fk_student, description, date, status, hash_release) 
                                VALUES (" . $id_student . ", '" . $descrip . "', '" . $date . "', 4, '" . $hash_release . "') 
                                RETURNING id_trace_student_area ");

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

    public function generatePDF($id_student, $full_name)
{
    $con = new DBconnection();
    $con->openDB();

    // Obtener el valor del curso del estudiante
    $academicProgramQuery = $con->query("SELECT c.type FROM students s JOIN academic_programs c ON s.fk_academic_programs = c.id_academic_programs WHERE s.id_student = '$id_student'");
    $academicProgramRow = pg_fetch_array($academicProgramQuery);

    if (!$academicProgramRow) {
        $con->closeDB();
        return array('error' => 'No se encontró el programa académico del estudiante.');
    }

    $type = $academicProgramRow['type'];

    $pdfinfo = $con->query("SELECT CONCAT(s.name, ' ', s.surname, ' ', s.second_surname) AS full_name,
                                                    a.name AS area_name,
                                                    a.key AS key, 
                                                    ta.description AS libera,
													 ta.hash_release AS firma,	
                                                    DATE(ta.date) AS date
                                            FROM students s
                                            JOIN trace_student_areas ta ON s.id_student = ta.fk_student
                                            JOIN areas a ON ta.fk_area = a.id_area
                                            WHERE s.id_student = '$id_student'
                                            ORDER BY ta.id_trace_student_area ASC;");

    $pdfData = array();

    while ($row = pg_fetch_array($pdfinfo)) {
        $dat = array(
            "full_name" => $row["full_name"],
            "area_name" => $row["area_name"],
            "key" => $row["key"],
            "libera" => $row["libera"],
            "firma" => $row["firma"],
            "date" => $row["date"]
        );
        $pdfData[] = $dat;
    }

    $con->closeDB();

    // Validar si hay datos para generar PDF
    if (count($pdfData) === 0) {
        return array('error' => 'No se encontraron registros de áreas para este estudiante.');
    }

    // Generar el folio, de este modo si el id del estudiane y el nombre es el mismo, el folio siempre será el mismo
    $folioSeed = $id_student . '-' . $full_name;
    $folioHash = strtoupper(substr(md5($folioSeed), 0, 16)); // puedes cambiar 8 por la longitud que gustes
    $folio = 'DFA-' . $folioHash;

    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('FDA');
    $pdf->SetAuthor('YO');
    $pdf->SetTitle('Student Certificate');
    $pdf->SetSubject('Certificate for Student');
    $pdf->SetKeywords('Certificate, Student, TCPDF');
    $pdf->SetMargins(10, 7, 10);
    $pdf->SetFooterMargin(10);
    $pdf->AddPage();

    $studentData = $pdfData[0];

    $programNames = [
    1 => 'Maestría',
    2 => 'Doctorado',
    3 => 'Externo de Licenciatura',
    4 => 'Externo de Bachillerato'
    ];

    $programName = isset($programNames[$type]) ? $programNames[$type] : 'Programa desconocido';


    $html = '
        <center>
        <img src="../../res/temp/encabezado2.png" style="width: 900px; height: 130px;">
        <div>
        <p style="text-align:right;"><strong>Folio: ' . $folio . '</strong></p>
        <p>Por este medio los abajo firmantes hacemos constar que el (la) alumno(a): ' . $studentData["full_name"] . ' del Programa de: ' . $programName . ', NO TIENE ningún ADEUDO en los departamentos o laboratorios a nuestro cargo.</p>
        </div>
        <br></br>
        <br></br>
        <table border="0.3" style="width: 100%;">
            <thead>
                <tr style="text-align: center;">
                    <td>Área</td>
                    <td>Firmante</td>
                    <td>Fecha de Liberación</td>
                    <td>Sello de Área</td>
                </tr>
            </thead>
            <tbody>';

    foreach ($pdfData as $area) {
        $imageName = $area["key"] . ".png";
        $html .= '<tr>
                    <td height="60">' . $area["area_name"] . '</td>
                    <td>' . $area["libera"] . '</td>
                    <td>' . $area["date"] . '</td>
                    <td>' . $area["firma"] . '</td>
                  </tr>';
    }

    $html .= '</tbody>
        </table>
        </center>
        <div style="text-align: center;">
            <p>Formato acreditado por la DFA, Santa María Tonantzintla a Fecha: ' . date("d-m-Y") . '</p>
        </div>';

    $pdf->SetFont('helvetica', '', 12);
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdfContent = $pdf->Output('student_certificate.pdf', 'S');
    $pdfPath = '../../res/temp/' . $folio . '.pdf';
    file_put_contents($pdfPath, $pdfContent);
    $pdfUrl = '../../res/temp/' . $folio . '.pdf';

    return array('pdf_url' => $pdfUrl);
}




//Funciones para actualizar alumnos
public function coursesAds($id_student){
        $con=new DBconnection();
        $con->openDB();

        $dataCourseAd = $con->query("SELECT academic_programs.id_academic_programs AS id_academic_programs, academic_programs.name FROM students
                                        INNER JOIN academic_programs ON students.fk_academic_programs = academic_programs.id_academic_programs
                                        WHERE id_student = ". $id_student);

        $data = array();

        while($row = pg_fetch_array($dataCourseAd)){
            $dat = array(
                "id_academic_programs" =>$row["id_academic_programs"],
                "name" =>$row["name"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }


   public function getStudent($id_student){
        $con=new DBconnection();
        $con->openDB();

        $dataR = $con->query("SELECT students.id_student, students.name, students.surname, students.second_surname, students.control_number, students.email, students.status, students.institucion,students.fecha_conclusion FROM students WHERE id_student=". $id_student);

        $row = pg_fetch_array($dataR);
        
        $dataR = array(
            "id_student" =>$row["id_student"],
            "name" =>$row["name"], 
            "surname" =>$row["surname"],
            "second_surname" =>$row["second_surname"],
            "control_number" =>$row["control_number"],
            "email" =>$row["email"],
            "status" =>$row["status"],
            "institucion" =>$row["institucion"],
            "date_conclusion" =>$row["fecha_conclusion"]
        );

        $con->closeDB();
        
        return array("status" => 200, "data" => $dataR);
    }


    public function updateStudent ($id_student, $name, $surname, $secondsurname, $email, $controlnumber, $course, $institucion, $date_conclusion)    {
        $con=new DBconnection();
        $con->openDB();

        $updateData = $con->query("UPDATE students SET name = '".$name."', surname = '" .$surname."', second_surname = '" .$secondsurname."', email = '" .$email."', control_number = '" .$controlnumber."', fk_academic_programs = " .$course.", institucion = '" .$institucion."', fecha_conclusion = '" .$date_conclusion."'
         WHERE id_student= ". $id_student ." RETURNING id_student ");

        $validateupdateData = pg_fetch_row($updateData);

        if ( $validateupdateData > 0)
        {            
            $con->closeDB();
            return $validateupdateData[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }

}
