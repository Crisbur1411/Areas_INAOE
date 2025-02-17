<?php
date_default_timezone_set("America/Mexico_City");


if(file_exists('./m/db_connection.php')){
    require_once './m/db_connection.php';
}else if(file_exists('../../m/db_connection.php')){
    require_once  '../../m/db_connection.php';
}else if(file_exists('../../../m/db_connection.php')){
    require_once  '../../../m/db_connection.php';
}


class admin{
    public function titleList(){
        $con=new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT id_titledata, CONCAT (professional_name, ' ', professional_surname, ' ', professional_secondsurname ) AS names, course_name, DATE(date_register), status  FROM titledata WHERE status=1 order by id_titledata");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_titledata"=>$row["id_titledata"],
                "names"=>$row["names"],
                "course_name"=>$row["course_name"],
                "date"=>$row["date"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    public function editRegister($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $dataTitleR = $con->query("SELECT id_titledata, controlinvoice, professional_curp, professional_name, professional_surname, professional_secondsurname, professional_email, institution_cveinstitution, institution_nameinstitution, course_cvecourse, course_name, course_startdate, course_finishdate, course_idreconnaissanceauthorization, course_reconnaissanceauthorization, expedition_date, expedition_iddegreemodality, expedition_degreemodality, expedition_dateprofessionalexam, expedition_socialservice, expedition_idlegalbasissocialservice, expedition_legalbasissocialservice, expedition_idstate, expedition_state, antecedent_institutionorigin, antecedent_idtypestudy, antecedent_typestudy, antecedent_idstate, antecedent_state, antecedent_finishdate, antecedent_document, status FROM titledata WHERE id_titledata=". $id_titledata);

        $data = array();

        while($row = pg_fetch_array($dataTitleR)){
            $dat = array(
                "id_titledata" =>$row["id_titledata"],
                "controlinvoice" =>$row["controlinvoice"],
                "professional_curp" =>$row["professional_curp"],
                "professional_name" =>$row["professional_name"],
                "professional_surname" =>$row["professional_surname"],
                "professional_secondsurname" =>$row["professional_secondsurname"],
                "professional_email" =>$row["professional_email"],
                "institution_cveinstitution" =>$row["institution_cveinstitution"],
                "institution_nameinstitution" =>$row["institution_nameinstitution"],
                "course_cvecourse" =>$row["course_cvecourse"],
                "course_name" =>$row["course_name"],
                "course_startdate" =>$row["course_startdate"],
                "course_finishdate" =>$row["course_finishdate"],
                "course_idreconnaissanceauthorization" =>$row["course_idreconnaissanceauthorization"],
                "course_reconnaissanceauthorization" =>$row["course_reconnaissanceauthorization"],
                "expedition_date" =>$row["expedition_date"],
                "expedition_iddegreemodality" =>$row["expedition_iddegreemodality"],
                "expedition_degreemodality" =>$row["expedition_degreemodality"],
                "expedition_dateprofessionalexam" =>$row["expedition_dateprofessionalexam"],
                "expedition_socialservice" =>$row["expedition_socialservice"],
                "expedition_idlegalbasissocialservice" =>$row["expedition_idlegalbasissocialservice"],
                "expedition_legalbasissocialservice" =>$row["expedition_legalbasissocialservice"],
                "expedition_idstate" =>$row["expedition_idstate"],
                "expedition_state" =>$row["expedition_state"],
                "antecedent_institutionorigin" =>$row["antecedent_institutionorigin"],
                "antecedent_idtypestudy" =>$row["antecedent_idtypestudy"],
                "antecedent_typestudy" =>$row["antecedent_typestudy"],
                "antecedent_idstate" =>$row["antecedent_idstate"],
                "antecedent_state" =>$row["antecedent_state"],
                "antecedent_finishdate" =>$row["antecedent_finishdate"],
                "antecedent_document" =>$row["antecedent_document"],
                "status" =>$row["status"]
            );
            $data[] = $dat;
        } 
        $con->closeDB();
        
        return $data;
    }

    public function showRegister($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $dataTitleR = $con->query("SELECT id_titledata, controlinvoice, professional_curp, professional_name, professional_surname, professional_secondsurname, professional_email, institution_cveinstitution, institution_nameinstitution, course_cvecourse, course_name, course_startdate, course_finishdate, course_idreconnaissanceauthorization, course_reconnaissanceauthorization, expedition_date, expedition_iddegreemodality, expedition_degreemodality, expedition_dateprofessionalexam, expedition_socialservice, expedition_idlegalbasissocialservice, expedition_legalbasissocialservice, expedition_idstate, expedition_state, antecedent_institutionorigin, antecedent_idtypestudy, antecedent_typestudy, antecedent_idstate, antecedent_state, antecedent_finishdate, antecedent_document, status FROM titledata WHERE id_titledata=". $id_titledata);

        $data = array();

        while($row = pg_fetch_array($dataTitleR)){
            $dat = array(
                "id_titledata" =>$row["id_titledata"],
                "controlinvoice" =>$row["controlinvoice"],
                "professional_curp" =>$row["professional_curp"],
                "professional_name" =>$row["professional_name"],
                "professional_surname" =>$row["professional_surname"],
                "professional_secondsurname" =>$row["professional_secondsurname"],
                "professional_email" =>$row["professional_email"],
                "institution_cveinstitution" =>$row["institution_cveinstitution"],
                "institution_nameinstitution" =>$row["institution_nameinstitution"],
                "course_cvecourse" =>$row["course_cvecourse"],
                "course_name" =>$row["course_name"],
                "course_startdate" =>$row["course_startdate"],
                "course_finishdate" =>$row["course_finishdate"],
                "course_idreconnaissanceauthorization" =>$row["course_idreconnaissanceauthorization"],
                "course_reconnaissanceauthorization" =>$row["course_reconnaissanceauthorization"],
                "expedition_date" =>$row["expedition_date"],
                "expedition_iddegreemodality" =>$row["expedition_iddegreemodality"],
                "expedition_degreemodality" =>$row["expedition_degreemodality"],
                "expedition_dateprofessionalexam" =>$row["expedition_dateprofessionalexam"],
                "expedition_socialservice" =>$row["expedition_socialservice"],
                "expedition_idlegalbasissocialservice" =>$row["expedition_idlegalbasissocialservice"],
                "expedition_legalbasissocialservice" =>$row["expedition_legalbasissocialservice"],
                "expedition_idstate" =>$row["expedition_idstate"],
                "expedition_state" =>$row["expedition_state"],
                "antecedent_institutionorigin" =>$row["antecedent_institutionorigin"],
                "antecedent_idtypestudy" =>$row["antecedent_idtypestudy"],
                "antecedent_typestudy" =>$row["antecedent_typestudy"],
                "antecedent_idstate" =>$row["antecedent_idstate"],
                "antecedent_state" =>$row["antecedent_state"],
                "antecedent_finishdate" =>$row["antecedent_finishdate"],
                "antecedent_document" =>$row["antecedent_document"],
                "status" =>$row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    public function showHistory($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $dataTitleR = $con->query("SELECT fk_documentdata, status, description, controlinvoice, lote, date FROM traceelectronicdocument WHERE fk_documentdata=". $id_titledata." order by date");

        $data = array();

        while($row = pg_fetch_array($dataTitleR)){
            $dat = array(
                "fk_documentdata" =>$row["fk_documentdata"],
                "status" =>$row["status"],
                "description" =>$row["description"],
                "controlinvoice" =>$row["controlinvoice"],
                "lote" =>$row["lote"],
                "date" =>$row["date"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    public function titleListToSign(){
        $con=new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT id_titledata, CONCAT (professional_name, ' ', professional_surname, ' ', professional_secondsurname ) AS names, course_name, DATE(date_register), status  FROM titledata WHERE status=2 ORDER BY id_titledata");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_titledata"=>$row["id_titledata"],
                "names"=>$row["names"],
                "course_name"=>$row["course_name"],
                "date"=>$row["date"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    // Document status = 3
    public function titleListSign(){
        $con=new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT titledata.id_titledata, CONCAT (titledata.professional_name, ' ', titledata.professional_surname, ' ', titledata.professional_secondsurname ) AS names,
        titledata.course_name, DATE(titledata.date_register) AS datedocument, DATE(electronicsign.date) AS datesign, titledata.status  
        FROM titledata
        INNER JOIN electronicsign ON electronicsign.id_electronicsign = titledata.fk_electronicsign
        WHERE titledata.status=3 ORDER BY id_titledata");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_titledata"=>$row["id_titledata"],
                "names"=>$row["names"],
                "course_name"=>$row["course_name"],
                "datedocument"=>$row["datedocument"],
                "datesign"=>$row["datesign"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    // Document status = 4
    public function titleListDGP(){
        $con=new DBconnection();
        $con->openDB();

        /*
        $dataTitle = $con->query("SELECT titledata.id_titledata, CONCAT (titledata.professional_name, ' ', titledata.professional_surname, ' ', titledata.professional_secondsurname ) AS names,
            titledata.course_name, DATE(titledata.date_register) AS datedocument, DATE(traceelectronicdocument.date) AS datedgp, titledata.status  
            FROM titledata
            INNER JOIN traceelectronicdocument ON traceelectronicdocument.fk_documentdata = titledata.id_titledata
            WHERE titledata.status=4  AND traceelectronicdocument.status=400 ORDER BY id_titledata");
        */
        $dataTitle = $con->query("SELECT titledata.id_titledata, CONCAT (titledata.professional_name, ' ', titledata.professional_surname, ' ', titledata.professional_secondsurname ) AS names,
        titledata.course_name, DATE(titledata.date_register) AS datedocument, MAX(DATE(traceelectronicdocument.date)) AS datedgp, titledata.status  
        FROM titledata
        INNER JOIN traceelectronicdocument ON traceelectronicdocument.fk_documentdata = titledata.id_titledata
        WHERE titledata.status=4  AND (traceelectronicdocument.status=400 or traceelectronicdocument.status=700)    
        GROUP BY titledata.id_titledata ");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_titledata"=>$row["id_titledata"],
                "names"=>$row["names"],
                "course_name"=>$row["course_name"],
                "datedocument"=>$row["datedocument"],
                "datedgp"=>$row["datedgp"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }


    //registrar consulta 
    public function traceConsult($id_titledata, $controlinvoice, $user){
        $descrip = 'Consultado por '.$user;
        $con=new DBconnection();
        $con->openDB();

        $traceConsult = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, date)
                        VALUES (".$id_titledata.", 700, '".$descrip."', '".$controlinvoice."', NOW()) RETURNING fk_documentdata");

         $validatetTraceConsult = pg_fetch_row($traceConsult);

        if ( $validatetTraceConsult > 0)
        {            
            $con->closeDB();
            return $validatetTraceConsult[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }    
    }

    //ultima consulta dgp

    public function lastConsult($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT MAX (date) AS date FROM traceelectronicdocument 
        where fk_documentdata=".$id_titledata." and (status= 700)");
        
        $validatetSelect = pg_fetch_row($dataTitle);

        if ( $validatetSelect > 0)
        {            
            $con->closeDB();
            return $validatetSelect[0];
        }
        else
        {
            $con->closeDB();
            return "error"; 
        }
    }

    // Document status = 5 
    public function titleListIssue(){
        $con=new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT titledata.id_titledata, CONCAT (titledata.professional_name, ' ', titledata.professional_surname, ' ', titledata.professional_secondsurname ) AS names,
            titledata.course_name, DATE(titledata.date_register) AS datedocument, DATE(traceelectronicdocument.date) AS dateissue, titledata.status  
            FROM titledata
            INNER JOIN traceelectronicdocument ON traceelectronicdocument.fk_documentdata = titledata.id_titledata
            WHERE titledata.status=5 AND traceelectronicdocument.status=500 ORDER BY id_titledata");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){ 
            $dat = array(
                "id_titledata"=>$row["id_titledata"],
                "names"=>$row["names"],
                "course_name"=>$row["course_name"],
                "datedocument"=>$row["datedocument"],
                "dateissue"=>$row["dateissue"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    // Document status = 6
    public function titleListRefused(){
        $con=new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT titledata.id_titledata, CONCAT (titledata.professional_name, ' ', titledata.professional_surname, ' ', titledata.professional_secondsurname ) AS names,
        titledata.course_name, DATE(titledata.date_register) AS datedocument, DATE(traceelectronicdocument.date) AS daterefused, titledata.status  
        FROM titledata
    INNER JOIN traceelectronicdocument ON traceelectronicdocument.fk_documentdata = titledata.id_titledata
        WHERE titledata.status=6 AND traceelectronicdocument.status=600 ORDER BY id_titledata");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_titledata"=>$row["id_titledata"],
                "names"=>$row["names"],
                "course_name"=>$row["course_name"],
                "datedocument"=>$row["datedocument"],
                "daterefused"=>$row["daterefused"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    // Document status=20
    public function titleListToSignCancel(){
        $con=new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT id_titledata, CONCAT (professional_name, ' ', professional_surname, ' ', professional_secondsurname ) AS names, course_name, DATE(date_register), status  FROM titledata WHERE status=20 ORDER BY id_titledata");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_titledata"=>$row["id_titledata"],
                "names"=>$row["names"],
                "course_name"=>$row["course_name"],
                "date"=>$row["date"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }


    // Document status=30
    public function readyCancel(){
        $con=new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT titledata.id_titledata, CONCAT (titledata.professional_name, ' ', titledata.professional_surname, ' ', titledata.professional_secondsurname ) AS names,
        titledata.course_name, DATE(titledata.date_register) AS datedocument, DATE(electronicsign.date) AS datesignc, titledata.status  
        FROM titledata
        INNER JOIN electronicsign ON electronicsign.id_electronicsign = titledata.fk_electronicsign
        WHERE titledata.status=30 AND electronicsign.status=10 ORDER BY id_titledata");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_titledata"=>$row["id_titledata"],
                "names"=>$row["names"],
                "course_name"=>$row["course_name"],
                "datedocument"=>$row["datedocument"],
                "datesignc"=>$row["datesignc"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    // Document status=50
    public function titleListCancel(){
        $con=new DBconnection();
        $con->openDB();

        $dataTitle = $con->query("SELECT titledata.id_titledata, CONCAT (titledata.professional_name, ' ', titledata.professional_surname, ' ', titledata.professional_secondsurname ) AS names,
        titledata.course_name, DATE(traceelectronicdocument.date) AS datesignc, details, titledata.status  
        FROM titledata
        INNER JOIN traceelectronicdocument ON traceelectronicdocument.fk_documentdata = titledata.id_titledata
        WHERE titledata.status=50 AND traceelectronicdocument.status=5000 ORDER BY id_titledata");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_titledata"=>$row["id_titledata"],
                "names"=>$row["names"],
                "course_name"=>$row["course_name"],                
                "datesignc"=>$row["datesignc"],
                "details"=>$row["details"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }


    public function updateDelete($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $updateDelete = $con->query("UPDATE titledata SET status = 0 WHERE id_titledata = ".$id_titledata." RETURNING controlinvoice ");

        $validateUpdateDelete = pg_fetch_row($updateDelete);

        if ( $validateUpdateDelete > 0)
        {            
            $con->closeDB();
            return $validateUpdateDelete[0];
        }
        else
        {
            $con->closeDB();
            return "error"; 
        }
    }

    public function traceUpdateDelete($id_titledata, $controlinvoice, $user){
        $descrip = 'Eliminado por '.$user;

        $con=new DBconnection();
        $con->openDB();

        $traceUpdateDelete = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, date)
                        VALUES (".$id_titledata.", 000,'".$descrip."', '".$controlinvoice."', NOW()) RETURNING fk_documentdata");

         $validatetTraceUpdateDelete = pg_fetch_row($traceUpdateDelete);

        if ( $validatetTraceUpdateDelete > 0)
        {            
            $con->closeDB();
            return $validatetTraceUpdateDelete[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }    
    }

    public function updateSignature($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $updateSignature = $con->query("UPDATE titledata SET status = 2 WHERE id_titledata = ".$id_titledata." RETURNING controlinvoice ");

        $validateUpdateSignature = pg_fetch_row($updateSignature);

        if ( $validateUpdateSignature > 0)
        {            
            $con->closeDB();
            return $validateUpdateSignature[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }

    public function traceUpdateSignature($id_titledata, $controlinvoice, $user){
        $descrip = 'Turnado por '.$user;
        $con=new DBconnection();
        $con->openDB();

        $traceUpdateSignature = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, date)
                        VALUES (".$id_titledata.", 200, '".$descrip."', '".$controlinvoice."', NOW()) RETURNING fk_documentdata");

         $validatetTraceUpdateSignature = pg_fetch_row($traceUpdateSignature);

        if ( $validatetTraceUpdateSignature > 0)
        {            
            $con->closeDB();
            return $validatetTraceUpdateSignature[0];
        }
        else 
        {
            $con->closeDB();
            return "error";
        }    
    }

    //Enviar -- DGP
    public function updateSend($id_titledata){


        $con=new DBconnection();
        $con->openDB();

        $updateSend = $con->query("UPDATE titledata SET status = 4 WHERE id_titledata = ".$id_titledata." RETURNING controlinvoice ");

        $validateUpdateSend = pg_fetch_row($updateSend);

        if ( $validateUpdateSend > 0)  
        {            
            $con->closeDB();
            return $validateUpdateSend[0];
        }
        else
        {
            $con->closeDB();
            return "error"; 
        }
    }

    public function emitir($id_titledata){


        $con=new DBconnection();
        $con->openDB();

        $updateSend = $con->query("UPDATE titledata SET status = 5 WHERE id_titledata = ".$id_titledata." RETURNING controlinvoice ");

        $validateUpdateSend = pg_fetch_row($updateSend);

        if ( $validateUpdateSend > 0)  
        {            
            $con->closeDB();
            return $validateUpdateSend[0];
        }
        else
        {
            $con->closeDB();
            return "error"; 
        }
    }

    public function rechazar($id_titledata){


        $con=new DBconnection();
        $con->openDB();

        $updateSend = $con->query("UPDATE titledata SET status = 6 WHERE id_titledata = ".$id_titledata." RETURNING controlinvoice ");

        $validateUpdateSend = pg_fetch_row($updateSend);

        if ( $validateUpdateSend > 0)  
        {            
            $con->closeDB();
            return $validateUpdateSend[0];
        }
        else
        {
            $con->closeDB();
            return "error"; 
        }
    }

    public function traceUpdateSend($id_titledata, $controlinvoice, $numeroLote, $user){
        $descrip = 'Enviado por '.$user;
        $con=new DBconnection();
        $con->openDB();

        $traceUpdateSend = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, lote, date)
                        VALUES (".$id_titledata.", 400, '".$descrip."', '".$controlinvoice."',".$numeroLote.", NOW()) RETURNING fk_documentdata");

         $validatetTraceUpdateSend = pg_fetch_row($traceUpdateSend);

        if ( $validatetTraceUpdateSend > 0)
        {            
            $con->closeDB();
            return $validatetTraceUpdateSend[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }    
    }

    public function traceUpdateEmitir($id_titledata, $controlinvoice, $msg){
        $con=new DBconnection();
        $con->openDB();

        $traceUpdateSend = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice,details, date)
                        VALUES (".$id_titledata.", 500, 'Emitido', '".$controlinvoice."','".$msg."', NOW()) RETURNING fk_documentdata");

         $validatetTraceUpdateSend = pg_fetch_row($traceUpdateSend);

        if ( $validatetTraceUpdateSend > 0)
        {            
            $con->closeDB();
            return $validatetTraceUpdateSend[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }    
    }

    public function traceUpdateRechazar($id_titledata, $controlinvoice, $msg){
        $con=new DBconnection();
        $con->openDB();

        $traceUpdateSend = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, details, date)
                        VALUES (".$id_titledata.", 600, 'Rechazado', '".$controlinvoice."','".$msg."', NOW()) RETURNING fk_documentdata");

         $validatetTraceUpdateSend = pg_fetch_row($traceUpdateSend);

        if ( $validatetTraceUpdateSend > 0)
        {            
            $con->closeDB();
            return $validatetTraceUpdateSend[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }    
    }

    //---CANCELAR--

    public function toCancelList(){
        $con=new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT id_titledata, CONCAT (professional_name, ' ', professional_surname, ' ', professional_secondsurname ) AS names, course_name, DATE(date_register), status  FROM titledata WHERE status=10 OR status = 15 order by id_titledata");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_titledata"=>$row["id_titledata"],
                "names"=>$row["names"],
                "course_name"=>$row["course_name"],
                "date"=>$row["date"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }

    public function toCancel($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $updateSignature = $con->query("UPDATE titledata SET status = 10 WHERE id_titledata = ".$id_titledata." RETURNING controlinvoice ");

        $validateUpdateSignature = pg_fetch_row($updateSignature);

        if ( $validateUpdateSignature > 0)
        {            
            $con->closeDB();
            return $validateUpdateSignature[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }

    public function traceToCancel($id_titledata, $controlinvoice, $user){
        $descrip = 'Inicio de cancelación por '.$user;
        $con=new DBconnection();
        $con->openDB();

        $traceUpdateSignature = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, date)
                        VALUES (".$id_titledata.", 1000, '".$descrip."', '".$controlinvoice."', NOW()) RETURNING fk_documentdata");

         $validatetTraceUpdateSignature = pg_fetch_row($traceUpdateSignature);

        if ( $validatetTraceUpdateSignature > 0)
        {            
            $con->closeDB();
            return $validatetTraceUpdateSignature[0];
        }
        else 
        {
            $con->closeDB();
            return "error";
        }    
    }

    public function mCancel($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $updateSignature = $con->query("UPDATE titledata SET status = 15 WHERE id_titledata = ".$id_titledata." RETURNING controlinvoice ");

        $validateUpdateSignature = pg_fetch_row($updateSignature);

        if ( $validateUpdateSignature > 0)
        {            
            $con->closeDB();
            return $validateUpdateSignature[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }

    public function tracemCancel($id_titledata, $controlinvoice, $motivo, $motivoDGP, $user){
        $descrip = 'Motivo interno: '.$motivo.'. Registrado por '.$user;
        $con=new DBconnection();
        $con->openDB();

        $traceUpdateSignature = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, date, details)
                        VALUES (".$id_titledata.", 1500, '".$descrip."', '".$controlinvoice."', NOW(), '".$motivoDGP."') RETURNING fk_documentdata");

         $validatetTraceUpdateSignature = pg_fetch_row($traceUpdateSignature);

        if ( $validatetTraceUpdateSignature > 0)
        {            
            $con->closeDB();
            return $validatetTraceUpdateSignature[0];
        }
        else 
        {
            $con->closeDB();
            return "error";
        }    
    }

    public function turnSingDocumentCancel($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $updateSignature = $con->query("UPDATE titledata SET status = 20 WHERE id_titledata = ".$id_titledata." RETURNING controlinvoice ");

        $validateUpdateSignature = pg_fetch_row($updateSignature);

        if ( $validateUpdateSignature > 0)
        {            
            $con->closeDB();
            return $validateUpdateSignature[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }

    public function traceTurnSingDocumentCancel($id_titledata, $controlinvoice, $user){
        $descrip = 'Turnado para cancelación por: '.$user;
        $con=new DBconnection();
        $con->openDB();

        $traceUpdateSignature = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, date)
                        VALUES (".$id_titledata.", 2000, '".$descrip."', '".$controlinvoice."', NOW()) RETURNING fk_documentdata");

         $validatetTraceUpdateSignature = pg_fetch_row($traceUpdateSignature);

        if ( $validatetTraceUpdateSignature > 0)
        {            
            $con->closeDB();
            return $validatetTraceUpdateSignature[0];
        }
        else 
        {
            $con->closeDB();
            return "error";
        }    
    }

    public function cancelDGP($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $updateSignature = $con->query("UPDATE titledata SET status = 50 WHERE id_titledata = ".$id_titledata." RETURNING controlinvoice ");

        $validateUpdateSignature = pg_fetch_row($updateSignature);

        if ( $validateUpdateSignature > 0)
        {            
            $con->closeDB();
            return $validateUpdateSignature[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }

    public function traceCancelDGP($id_titledata, $controlinvoice, $dateDGP, $dDGP, $user){
        $descrip = 'Cancelación registrada por '.$user;
        $con=new DBconnection();
        $con->openDB();

        $traceUpdateSignature = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, date, details)
                        VALUES (".$id_titledata.", 5000, '".$descrip."', '".$controlinvoice."', '".$dateDGP."', '".$dDGP."') RETURNING fk_documentdata");

         $validatetTraceUpdateSignature = pg_fetch_row($traceUpdateSignature);

        if ( $validatetTraceUpdateSignature > 0)
        {            
            $con->closeDB();
            return $validatetTraceUpdateSignature[0];
        }
        else 
        {
            $con->closeDB();
            return "error";
        }    
    }

    

    // ----

    //Consultar LOTE

    public function consultStatus($id_titledata){
        $con=new DBconnection();
        $con->openDB();
    
        $dataTitle = $con->query("SELECT lote,controlinvoice FROM traceelectronicdocument where fk_documentdata=".$id_titledata." and status = 400");
        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "lote"=>$row["lote"],
                "controlinvoice"=>$row["controlinvoice"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
        
    }



    public function showDetailsDGP($id_titledata){
        $con=new DBconnection();
        $con->openDB();
    
        $dataTitle = $con->query("SELECT details,controlinvoice FROM traceelectronicdocument where fk_documentdata=".$id_titledata." and status = 600");
        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "details"=>$row["details"],
                "controlinvoice"=>$row["controlinvoice"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
        
    }


    public function downloadTitle($id_titledata){
        $con=new DBconnection();
        $con->openDB();
    
        $dataTitle = $con->query("SELECT lote,controlinvoice FROM traceelectronicdocument where fk_documentdata=".$id_titledata." and status = 400");
        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "lote"=>$row["lote"],
                "controlinvoice"=>$row["controlinvoice"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
        
    }

    // Generar XML
    public function generateXML($id_titledata){
        $con=new DBconnection();
        $con->openDB();

        $dataTitleR = $con->query("SELECT id_titledata, titledata.controlinvoice, encode(electronicsign.stamp::bytea, 'base64')  AS stamp, signer_name, signer_surname, signer_secondsurname, signer_curp, signer_idappointment, signer_appointment, encode(signer_certificate::bytea, 'base64')  AS signer_certificate, encode(signer_idcertificate::bytea, 'base64')  AS signer_idcertificate, professional_curp, professional_name, professional_surname, professional_secondsurname, professional_email, institution_cveinstitution, institution_nameinstitution, course_cvecourse, course_name, DATE(course_startdate) AS course_startdate, DATE(course_finishdate) AS course_finishdate, course_idreconnaissanceauthorization, course_reconnaissanceauthorization, DATE(expedition_date) AS expedition_date, expedition_iddegreemodality, expedition_degreemodality, DATE(expedition_dateprofessionalexam) AS expedition_dateprofessionalexam , expedition_socialservice, expedition_idlegalbasissocialservice, expedition_legalbasissocialservice, expedition_idstate, expedition_state, antecedent_institutionorigin, antecedent_idtypestudy, antecedent_typestudy, antecedent_idstate, antecedent_state, DATE(antecedent_finishdate) AS antecedent_finishdate, antecedent_document,
        titledata.status AS titlestatus, traceelectronicdocument.date AS datesign 
        FROM titledata
        INNER JOIN electronicsign ON id_electronicsign = fk_electronicsign
        INNER JOIN  traceelectronicdocument  ON (fk_documentdata = id_titledata)and(traceelectronicdocument.status=300)
        WHERE id_titledata=". $id_titledata);


        /*$dataTitleR = $con->query("SELECT id_titledata, titledata.controlinvoice, electronicsign.stamp AS stamp, signer_name, signer_surname, signer_secondsurname, signer_curp, signer_idappointment, signer_appointment, signer_certificate, signer_idcertificate, professional_curp, professional_name, professional_surname, professional_secondsurname, professional_email, institution_cveinstitution, institution_nameinstitution, course_cvecourse, course_name, DATE(course_startdate) AS course_startdate, DATE(course_finishdate) AS course_finishdate, course_idreconnaissanceauthorization, course_reconnaissanceauthorization, DATE(expedition_date) AS expedition_date, expedition_iddegreemodality, expedition_degreemodality, DATE(expedition_dateprofessionalexam) AS expedition_dateprofessionalexam , expedition_socialservice, expedition_idlegalbasissocialservice, expedition_legalbasissocialservice, expedition_idstate, expedition_state, antecedent_institutionorigin, antecedent_idtypestudy, antecedent_typestudy, antecedent_idstate, antecedent_state, DATE(antecedent_finishdate) AS antecedent_finishdate, antecedent_document,
        titledata.status AS titlestatus, DATE(traceelectronicdocument.date) AS datesign
        FROM titledata
        INNER JOIN electronicsign ON id_electronicsign = fk_electronicsign
        INNER JOIN  traceelectronicdocument  ON (fk_documentdata = id_titledata)and(traceelectronicdocument.status=300)
        WHERE id_titledata=". $id_titledata);*/




      
        $data = array();

        while($row = pg_fetch_array($dataTitleR)){ 
            $dat = array(
                "id_titledata" =>$row["id_titledata"],
                "controlinvoice" =>$row["controlinvoice"],
                "stamp" =>$row["stamp"],
                "signer_name" =>$row ["signer_name"],
                "signer_surname" =>$row ["signer_surname"],
                "signer_secondsurname" =>$row ["signer_secondsurname"],
                "signer_curp" =>$row ["signer_curp"],
                "signer_idappointment" =>$row ["signer_idappointment"],
                "signer_appointment" =>$row ["signer_appointment"],
                "signer_certificate" =>$row ["signer_certificate"],
                "signer_idcertificate" =>$row ["signer_idcertificate"],
                "professional_curp" =>$row["professional_curp"],
                "professional_name" =>$row["professional_name"],
                "professional_surname" =>$row["professional_surname"],
                "professional_secondsurname" =>$row["professional_secondsurname"],
                "professional_email" =>$row["professional_email"],
                "institution_cveinstitution" =>$row["institution_cveinstitution"],
                "institution_nameinstitution" =>$row["institution_nameinstitution"],
                "course_cvecourse" =>$row["course_cvecourse"],
                "course_name" =>$row["course_name"],
                "course_startdate" =>$row["course_startdate"],
                "course_finishdate" =>$row["course_finishdate"],
                "course_idreconnaissanceauthorization" =>$row["course_idreconnaissanceauthorization"],
                "course_reconnaissanceauthorization" =>$row["course_reconnaissanceauthorization"],
                "expedition_date" =>$row["expedition_date"],
                "expedition_iddegreemodality" =>$row["expedition_iddegreemodality"],
                "expedition_degreemodality" =>$row["expedition_degreemodality"],
                "expedition_dateprofessionalexam" =>$row["expedition_dateprofessionalexam"],
                "expedition_socialservice" =>$row["expedition_socialservice"],
                "expedition_idlegalbasissocialservice" =>$row["expedition_idlegalbasissocialservice"],
                "expedition_legalbasissocialservice" =>$row["expedition_legalbasissocialservice"],
                "expedition_idstate" =>$row["expedition_idstate"],
                "expedition_state" =>$row["expedition_state"],
                "antecedent_institutionorigin" =>$row["antecedent_institutionorigin"],
                "antecedent_idtypestudy" =>$row["antecedent_idtypestudy"],
                "antecedent_typestudy" =>$row["antecedent_typestudy"],
                "antecedent_idstate" =>$row["antecedent_idstate"],
                "antecedent_state" =>$row["antecedent_state"],
                "antecedent_finishdate" =>$row["antecedent_finishdate"],
                "antecedent_document" =>$row["antecedent_document"],
                "titlestatus" =>$row["titlestatus"],
                "datesign" =>$row["datesign"]
            );
            $data[] = $dat; 
        }
        $con->closeDB();
        
        return $data; 
    }

    public function userList(){ 
        $con=new DBconnection(); 
        $con->openDB();

        $dataUser = $con->query("SELECT id_user, username, password, type, permission, status FROM users order by id_user");
        $data = array();

        while($row = pg_fetch_array($dataUser)){
            $dat = array(
                "id_user"=>$row["id_user"],
                "name"=>$row["username"],
                "type"=>$row["type"],
                "permission"=>$row["permission"],
                "status" => $row["status"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }


    //Cambiar status 
    public function optionUser($status, $id_user){
        $con=new DBconnection();
        $con->openDB();
        if($status == 1){
            $updateStatus = $con->query("UPDATE users SET status = 0 WHERE id_user = ".$id_user." RETURNING status ");
        }
        if($status == 0){
            $updateStatus = $con->query("UPDATE users SET status = 1 WHERE id_user = ".$id_user." RETURNING status ");
        }
        $validateUpdateStatus = pg_fetch_row($updateStatus);

        if ( $validateUpdateStatus > 0)
        {            
            $con->closeDB();
            return $validateUpdateStatus[0];
        }
        else
        {
            $con->closeDB();
            return "error"; 
        }
    }

    public function createUser($type, $name_user, $psw){
        $con=new DBconnection();
        $con->openDB();


        $userData = $con->query("INSERT INTO users (username, password, type) VALUES ('".$name_user."', '" .$psw."', '" .$type."', NOW()) RETURNING id_user ");

        $validateUserData = pg_fetch_row($userData);

        if ( $validateUserData > 0)
        {            
            $con->closeDB();
            return $validateUserData[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }


    public function extFile($id_titledata){
        $con=new DBconnection();
        $con->openDB();
    
        $dataFile = $con->query("SELECT
        MAX (date) AS date,
        controlinvoice
    FROM
        traceelectronicdocument where fk_documentdata=".$id_titledata." and (status= 300)
    GROUP BY
        controlinvoice;");
        
        $data = array();

        while($row = pg_fetch_array($dataFile)){
            $dat = array(
                "date"=>$row["date"],
                "controlinvoice"=>$row["controlinvoice"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
        
    }

   public function traceDownload($id_titledata, $controlinvoice, $user){
        $descrip = 'Generado por '.$user;
        $con=new DBconnection();
        $con->openDB();

        $traceUpdateDownload = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, date)
                        VALUES (".$id_titledata.", 800,  '".$descrip."', '".$controlinvoice."', NOW()) RETURNING fk_documentdata");

         $validatetTraceUpdateSend = pg_fetch_row($traceUpdateDownload);

        if ( $validatetTraceUpdateSend > 0)
        {            
            $con->closeDB();
            return $validatetTraceUpdateSend[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }    
    }

    public function deleteInfo(){
        $con=new DBconnection();
        $con->openDB();

        $updateinfo = $con->query("UPDATE users SET type=1 WHERE permission=1");

        $validate = pg_fetch_row($updateinfo);

        if ( $validate > 0)
        {            
            $con->closeDB();
            return $validate[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }

    public function goTitleListSign ( $id_documentdata){

        $con=new DBconnection();
        $con->openDB();


        $updateDataTitle = $con->query("UPDATE titledata SET  status=3 WHERE id_titledata=". $id_documentdata." RETURNING controlinvoice");

        $validate = pg_fetch_row($updateDataTitle);

        if ( $validate > 0)
        {            
            $con->closeDB();
            return $validate[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }          

    }

    public function traceGoTitleListSign($id_titledata, $controlinvoice){
        $descrip = 'RechazadoDGP';
        $con=new DBconnection();
        $con->openDB();

        $traceSignDocument = $con->query("INSERT INTO traceelectronicdocument (fk_documentdata, status, description, controlinvoice, date)
                        VALUES (".$id_titledata.", 300,'".$descrip."', '".$controlinvoice."', NOW()) RETURNING fk_documentdata");

         $validateTraceSignDocument = pg_fetch_row($traceSignDocument);

        if ( $validateTraceSignDocument > 0)
        {            
            $con->closeDB();
            return $validateTraceSignDocument[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }    
    }








}
?>