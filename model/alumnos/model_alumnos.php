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

    public function saveStudent ($name, $surname, $secondsurname, $email, $controlnumber, $course, $institucion, $date_conclusion, $process_catalog)
    {
        $con=new DBconnection();
        $con->openDB();

        $studentData = $con->query("INSERT INTO students (name, surname, second_surname, control_number, email, fk_academic_programs, institucion, fecha_conclusion, date_register, fk_process_catalog) 
        VALUES ('".$name."','".$surname."', '".$secondsurname."','".$controlnumber."','".$email."',".$course.", '".$institucion."', '".$date_conclusion."', NOW(), ".$process_catalog.") 
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
                                    students.status,
                                    students.fk_process_catalog
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
                                        students.status,
                                        students.fk_process_catalog
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
                "status" => $row["status"],
                "fk_process_catalog" => $row["fk_process_catalog"]
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
									 students.date_register,
									 students.folio,
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
                "status" => $row["status"],
                "folio" => $row["folio"],
                "date_register" => $row["date_register"]
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

    public function generatePDF($id_student, $full_name, $control_number, $date_register)
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
													 p.name AS academic_program,
                                                    a.name AS area_name,
                                                    a.key AS key, 
                                                    ta.description AS libera,
													 ta.hash_release AS firma,	
                                                    DATE(ta.date) AS date
                                            FROM students s
                                            JOIN trace_student_areas ta ON s.id_student = ta.fk_student
                                            JOIN areas a ON ta.fk_area = a.id_area
											 JOIN academic_programs p ON s.fk_academic_programs = p.id_academic_programs
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
            "date" => $row["date"],
            "academic_program" => $row["academic_program"]
        );
        $pdfData[] = $dat;
    }

    $con->closeDB();

    // Validar si hay datos para generar PDF
    if (count($pdfData) === 0) {
        return array('error' => 'No se encontraron registros de áreas para este estudiante.');
    }

    // Generar el folio, de este modo si el id del estudiane y el nombre es el mismo, el folio siempre será el mismo
    $folioSeed = $id_student . '-' . $full_name . '-' . $control_number . '-' . $date_register;
    $folioHash = strtoupper(substr(md5($folioSeed), 0, 16)); // puedes cambiar 8 por la longitud que gustes
    $folio = 'DFA-' . $folioHash;

    //Se inserta el folio al estudiante en la base de datos
    $con = new DBconnection();
    $con->openDB();
    $con->query("UPDATE students SET folio = '$folio' WHERE id_student = '$id_student'");
    $con->closeDB();


    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('DFA');
    $pdf->SetAuthor('YO');
    $pdf->SetTitle('Student Certificate');
    $pdf->SetSubject('Certificate for Student');
    $pdf->SetKeywords('Certificate, Student, TCPDF');
    $pdf->SetMargins(10, 7, 10);
    $pdf->SetFooterMargin(10);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->AddPage();
    $pdf->Image('../../res/temp/logo_inaoe.jpeg', 10, 17, 30, 30, 'JPG', '', '', false, 300);



    //Se genera el pdf y se inserta en la hoja
    $style = array(
    'border' => 0,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, 
    'module_width' => 1,
    'module_height' => 1
);


    $studentData = $pdfData[0];

    $programNames = [
    1 => 'Maestría',
    2 => 'Doctorado',
    3 => 'Externo de Licenciatura',
    4 => 'Externo de Bachillerato'
    ];

    $programName = isset($programNames[$type]) ? strtoupper($programNames[$type]) : 'PROGRAMA DESCONOCIDO';
    $area_program = $studentData["academic_program"];


    $html = '
        <center>
        <br></br>
        <p style="text-align: right;"><strong>Constancia de no adeudo al INAOE<br>ALUMNOS GRADUADOS</strong></p>
        <br></br>
        <div>
        <br></br>
        <p style="text-align:left;"><strong>Folio: ' . $folio . '</strong></p>
        <p>Por este medio los abajo firmantes hacemos constar que el(la) estudiante: <strong>' . strtoupper($studentData["full_name"]) . '</strong> del Programa de: ' . $programName . ', en el área de ' . $area_program . ', <strong>NO TIENE NINGÚN ADEUDO</strong> en los departamentos o laboratorios a nuestro cargo.</p>
        </div>
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
    //$urlToEncode = 'http://adria.inaoep.mx:11038/liberacion_maina_funcional/view/consulta_folio/consulta_folio.php?folio=' . $folio;
    $urlToEncode = 'http://localhost/liberacion-maina/view/consulta_folio/consulta_folio.php?folio=' . $folio;

    $pdf->write2DBarcode($urlToEncode, 'QRCODE,H', 170, 240, 30, 30, $style, 'N');
    $pdf->SetFont('helvetica', '', 10); // Fuente para el texto
    $pdf->SetXY(170, 239 + 30 + 2); // Posición: misma X, Y + alto del QR + margen
    $pdf->Cell(30, 5, 'QR de verificación', 0, 0, 'C'); // Texto alineado centrado debajo del QR

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

        $dataR = $con->query("SELECT students.id_student, 
        students.name, 
        students.surname, 
        students.second_surname, 
        students.control_number, 
        students.email, 
        students.status, 
        students.institucion,
        students.fecha_conclusion,
        students.fk_process_catalog 
        FROM students 
        WHERE id_student=". $id_student);

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
            "date_conclusion" =>$row["fecha_conclusion"],
            "fk_process_catalog" =>$row["fk_process_catalog"]
        );

        $con->closeDB();
        
        return array("status" => 200, "data" => $dataR);
    }


    public function updateStudent ($id_student, $name, $surname, $secondsurname, $email, $controlnumber, $course, $institucion, $date_conclusion, $process_catalog)    {
        $con=new DBconnection();
        $con->openDB();

        $updateData = $con->query("UPDATE students SET name = '".$name."', surname = '" .$surname."', second_surname = '" .$secondsurname."', email = '" .$email."', control_number = '" .$controlnumber."', fk_academic_programs = " .$course.", institucion = '" .$institucion."', fecha_conclusion = '" .$date_conclusion."', fk_process_catalog = " .$process_catalog."
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

    public function getDetailsStudent($id_student)
{
    $con = new DBconnection();
    $con->openDB();

    $dataR = $con->query("SELECT s.id_student,
        CONCAT(s.name, ' ', s.surname, ' ', s.second_surname, ' ') AS full_name,
        s.control_number,
        s.email,
        s.institucion,
        s.fecha_conclusion,
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
            "programa_academico" => $row["programa_academico"]
        );
    }

    $con->closeDB();

    return array("status" => 200, "data" => $data);
}



public function getProcessCatalog() {
        $con = new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT
                                        id_process_catalog,
                                        name,
                                        description
                                    FROM
                                        process_catalog
                                    WHERE
                                        status = 1
                                    ORDER BY id_process_catalog ASC;");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_process_catalog" => $row["id_process_catalog"],
                "name" => $row["name"],
                "description" => $row["description"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }


    // Funcion que obtniene todos los flujos de ejecucion y los agrupa para realizan la validacion de si se cumplen o no
    public function authorizationProcess($id_student, $fk_process_catalog) {
    $con = new DBconnection();
    $con->openDB();

    // Paso 1: Obtener todos los pasos activos ordenados
    $result = $con->query("SELECT id_process_stages, execution_flow 
                           FROM process_stages 
                           WHERE status = 1 
                           AND fk_process_catalog = $fk_process_catalog
                           ORDER BY execution_flow ASC;");

    $flows = array();

    // Paso 2: Agrupar por execution_flow
    while ($row = pg_fetch_array($result)) {
        $flow = $row["execution_flow"];
        $stepId = $row["id_process_stages"];

        if (!isset($flows[$flow])) {
            $flows[$flow] = array();
        }
        $flows[$flow][] = $stepId;
    }

    $data = array();

    // Paso 3: Validar cada grupo de pasos
    foreach ($flows as $execution_flow => $stepIds) {
        $allStepsCompleted = true;

        foreach ($stepIds as $stepId) {
            $check = $con->query("SELECT 1 AS status_paso FROM trace_student_areas 
                                  WHERE fk_student = '$id_student' 
                                  AND fk_process_stage = '$stepId' 
                                  AND status = 2 
                                  LIMIT 1;");

            if (pg_num_rows($check) === 0) {
                $allStepsCompleted = false;
                break;
            }
        }

        $data[] = array(
            "execution_flow" => $execution_flow,
            "total_steps" => count($stepIds),
            "completed" => $allStepsCompleted
        );
    }

    $con->closeDB();

    return array("status" => 200, "data" => $data);
}


// Funcion para obtener el flujo de ejecucion al que pertenece cada accion que se esta realizando
    public function getExecutionFlow($id_user, $id_student, $fk_process_catalog) {
    $con = new DBconnection();
    $con->openDB();

    session_start();
    $fk_area  = $_SESSION["id_area"];

    // Paso 1: Obtener todos los process_stages asignados al usuario
    $query = "SELECT ps.id_process_stages, ps.execution_flow
              FROM process_stages ps
              INNER JOIN users u ON ps.fk_process_manager = u.id_user
              INNER JOIN user_area ua ON u.id_user = ua.fk_user
              INNER JOIN areas a ON ua.fk_area = a.id_area
              WHERE ps.status = 1 
              AND ps.fk_process_manager = $id_user 
              AND a.id_area = $fk_area AND ps.fk_process_catalog = $fk_process_catalog
              ORDER BY ps.execution_flow ASC";

    $result = $con->query($query);

    $pendingFlows = [];

    // Paso 2: Verificar cuáles no han sido completados por el estudiante
    while ($row = pg_fetch_array($result)) {
        $stageId = $row["id_process_stages"];
        $flow = $row["execution_flow"];

        // Verificamos si ese paso ya está completado por el estudiante
        $check = $con->query("SELECT 1 FROM trace_student_areas 
                              WHERE fk_student = '$id_student' 
                              AND fk_process_stage = '$stageId' 
                              AND status = 2 LIMIT 1");

        if (pg_num_rows($check) === 0) {
            // Si no está completado, lo agregamos como pendiente
            $pendingFlows[] = $flow;
        }
    }

    $con->closeDB();

    $nextFlow = !empty($pendingFlows) ? min($pendingFlows) : null;

    return array(
        "status" => 200,
        "data" => array(
            "execution_flow" => $nextFlow,
            "all_pending_flows" => $pendingFlows
        )
    );
}





}
