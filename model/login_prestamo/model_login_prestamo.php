<?php
	date_default_timezone_set("America/Mexico_City");
	require_once  '../../model/db_connection.php';
	function getRealIpAddr() {
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	class login {

		// Usuario Existe
		function loginUser($email, $password){
			
			session_start();
			$con=new DBconnection();
			$con->openDB();			
			
			$user=$con->query("SELECT id_employee, email, fk_type_employee, CONCAT (name || ' ' || surname || ' ' || second_surname) AS name , area FROM employee
			 					WHERE employee.email = '".$email."' AND employee.password = '".$password."' AND employee.status=1");		

			$validateUser = pg_fetch_row($user);

			if ( $validateUser > 0)
			{				
				$_SESSION['id_user'] = $validateUser[0];
				$_SESSION["email"] = $validateUser[1];
				$_SESSION["type"] = $validateUser[2];
				$_SESSION["name"] = $validateUser[3];
				$_SESSION["area"] = $validateUser[4];
				$con->closeDB();
				return $validateUser[2];
			}
			else
			{
				$con->closeDB();
				return "no exit";
			}
		}		
	}
?>