<?php
	date_default_timezone_set("America/Mexico_City");
	require_once  '../../m/db_connection.php';
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
		function loginUser($username, $password){
			
			session_start();
			$con=new DBconnection();
			$con->openDB();			
			
			$user=$con->query("SELECT id_user, username, fk_type, permission, CONCAT (name || ' ' || surname || ' ' || second_surname) AS name , fk_area FROM users
								LEFT JOIN user_area ON user_area.fk_user = users.id_user
			 					WHERE users.username = '".$username."' AND users.password = '".$password."' AND users.status=1");		

			$validateUser = pg_fetch_row($user);

			if ( $validateUser > 0)
			{				
				$_SESSION['id_user'] = $validateUser[0];
				$_SESSION["username"] = $validateUser[1];
				$_SESSION["type"] = $validateUser[2];
				$_SESSION["permission"] = $validateUser[3];
				$_SESSION["name"] = $validateUser[4];
				$_SESSION["id_area"] = $validateUser[5];
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