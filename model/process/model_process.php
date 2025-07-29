<?php
date_default_timezone_set("America/Mexico_City");

if(file_exists('./model/db_connection.php')){
    require_once './model/db_connection.php';
}else if(file_exists('../../model/db_connection.php')){
    require_once  '../../model/db_connection.php';
}else if(file_exists('../../../model/db_connection.php')){
    require_once  '../../../model/db_connection.php';
}

class Process {

    public function listProcess() {
        $con = new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT
                                        process_stages.id_process_stages,
                                        process_stages.description,
                                        process_stages.execution_flow AS flujo_ejecucion,
                                        process_stages.status,
                                        process_catalog.name AS name_process
                                    FROM
                                        process_stages
                                    INNER JOIN
                                        process_catalog ON process_stages.fk_process_catalog = process_catalog.id_process_catalog
                                    WHERE
                                        process_stages.status = 1
                                    ORDER BY execution_flow ASC;");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_process_stages" => $row["id_process_stages"],
                "description" => $row["description"],
                "flujo_ejecucion" => $row["flujo_ejecucion"],
                "status" => $row["status"],
                "name_process" => $row["name_process"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }





    public function detailsProcess($id_process_stages) {
        $con = new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT
                                            process_stages.id_process_stages,
                                            process_stages.stage,
                                            process_stages.description,
                                            process_stages.execution_flow AS flujo_ejecucion,
                                            process_stages.status,
                                            process_stages.status_process_stages,
                                            process_stages.creation_date,
                                            process_catalog.name AS name_process,
                                            CONCAT(users.name, ' ', users.surname, ' ', users.second_surname) AS name_user,
                                            areas.name AS area_user
                                        FROM
                                            process_stages
                                        INNER JOIN
                                            process_catalog ON process_stages.fk_process_catalog = process_catalog.id_process_catalog
                                        INNER JOIN
                                            users ON process_stages.fk_process_manager = users.id_user
                                        INNER JOIN
                                            user_area ON users.id_user = user_area.fk_user
                                        INNER JOIN 
                                            areas ON user_area.fk_area = areas.id_area
                                        WHERE
                                            process_stages.status = 1
                                            AND process_stages.id_process_stages = ".$id_process_stages."
                                        ORDER BY
                                            execution_flow ASC;");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_process_stages" => $row["id_process_stages"],
                "stage" => $row["stage"],
                "description" => $row["description"],
                "flujo_ejecucion" => $row["flujo_ejecucion"],
                "status" => $row["status"],
                "status_process_stages" => $row["status_process_stages"],
                "creation_date" => $row["creation_date"],
                "name_process" => $row["name_process"],
                "name_user" => $row["name_user"],
                "area_user" => $row["area_user"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }



    public function getProcessCatalog() {
        $con = new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT
                                        id_process_catalog,
                                        name
                                    FROM
                                        process_catalog
                                    WHERE
                                        status = 1
                                    ORDER BY id_process_catalog ASC;");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_process_catalog" => $row["id_process_catalog"],
                "name" => $row["name"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }



    public function getProcessManager() {
        $con = new DBconnection(); 
        $con->openDB();

        $dataTitle = $con->query("SELECT
                                        id_user,
                                        CONCAT (name, ' ' , surname, ' ' , second_surname) AS name_user
                                    FROM
                                        users
                                    WHERE
                                        status = 1
                                    ORDER BY id_user ASC;");

        $data = array();

        while($row = pg_fetch_array($dataTitle)){
            $dat = array(
                "id_user" => $row["id_user"],
                "name_user" => $row["name_user"]
            );
            $data[] = $dat;
        }
        $con->closeDB();
        
        return $data;
    }


    public function saveProcess($process_catalog, $description, $execution_flow, $process_manager) {
        $con = new DBconnection(); 
        $con->openDB();

        $stage = 1;

        $processData = $con->query ("INSERT INTO process_stages (fk_process_catalog, description, execution_flow, fk_process_manager, creation_date, stage) 
        VALUES (".$process_catalog.", '".$description."', ".$execution_flow.", ".$process_manager.", NOW(), ".$stage.") RETURNING id_process_stages;");
        
        $validateProcessData = pg_fetch_row($processData);

        if ( $validateProcessData > 0)
        {            
            $con->closeDB();
            return $validateProcessData[0];
        }
        else
        {
            $con->closeDB();
            return "error";
        }
    }


    public function getProcessInfo($id_process_stages) {
        $con = new DBconnection(); 
        $con->openDB();

        $dataProcess = $con->query("SELECT
                                        process_stages.id_process_stages,
                                        process_stages.stage,
                                        process_stages.description,
                                        process_stages.execution_flow,
                                        process_stages.status,
                                        process_stages.status_process_stages,
                                        process_stages.creation_date,
                                        process_stages.fk_process_catalog,
                                        process_stages.fk_process_manager
                                    FROM
                                        process_stages
                                    WHERE
                                        id_process_stages = $id_process_stages;");

            $row = pg_fetch_array($dataProcess);
        
            $dataProcess = array(
                "id_process_stages" => $row["id_process_stages"],
                "stage" => $row["stage"],
                "description" => $row["description"],
                "execution_flow" => $row["execution_flow"],
                "status" => $row["status"],
                "status_process_stages" => $row["status_process_stages"],
                "creation_date" => $row["creation_date"],
                "fk_process_catalog" => $row["fk_process_catalog"],
                "fk_process_manager" => $row["fk_process_manager"]
            );
        $con->closeDB();
        return array("status" => 200, "data" => $dataProcess);
    }


    public function saveProcessEdit ($id_process_stages, $process_catalog, $description, $execution_flow, $process_manager) {
        $con = new DBconnection(); 
        $con->openDB();

        $processData = $con->query("UPDATE process_stages
                                    SET fk_process_catalog = ".$process_catalog.",
                                        description = '".$description."',
                                        execution_flow = ".$execution_flow.",
                                        fk_process_manager = ".$process_manager."
                                    WHERE id_process_stages = ".$id_process_stages.";");
        
        if ($processData) {
            $con->closeDB();
            return "success";
        } else {
            $con->closeDB();
            return "error";
        }
    }


    public function deleteProcess($id_process_stages) {
        try{

        
        $con=new DBconnection();
        $con->openDB();

        $processDataDelete = ("UPDATE process_stages SET status = 0 WHERE id_process_stages = '$id_process_stages'");
        $updateResult = $con->query($processDataDelete);

        $con->closeDB();



        if ($updateResult )
        {
           $response = ['status' => 'success', 'message' => 'Paso eliminado correctamente'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error al eliminar el paso'];
        }
        }
        catch (Exception $e) {
            $response = ['status' => 'error', 'message' => 'Error al eliminar el paso: ' . $e->getMessage()];
        }
        return $response;
    }
    
}