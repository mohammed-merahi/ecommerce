<?php
		include('../db.php');

		$email			= $_POST['email'];
		//check if email is available
		$query = "SELECT * FROM clients WHERE mail = '" . $email . "'";     
		$res = mysql_query( $query );
		if( mysql_num_rows($res) > 0 ){
			echo "false";
		}else{
			$raison			= $_POST['raison'];
			$pass			= md5($_POST['pass']);
			$telephone		= $_POST['telephone'];
			$pays			= $_POST['pays'];
			$departement	= $_POST['departement'];
			$ville			= $_POST['ville'];
			$adresse		= $_POST['adresse'];
			//insert the client
			$q   = "SELECT max(codeclient)+1 AS NB FROM clients";
			$res = mysql_query( $q );
			while( $i = mysql_fetch_assoc($res) ){
				$codeclient = $i['NB'];
				if( $codeclient < 10 )
					$codeclient = '000' . $codeclient;
				else if( $codeclient < 100 )
					$codeclient = '00' . $codeclient;
				else if( $codeclient < 1000 )
					$codeclient = '0' . $codeclient;
			}

			$query = "INSERT INTO clients(codeclient,raison,telephone,adresse,ville,departement,pays,mail,pass) 
								  VALUES( '$codeclient','$raison','$telephone','$adresse','$ville','$departement','$pays','$email','$pass' ) ";
			mysql_query( $query );
			//SESSIONS
			$_SESSION['typeCompte']   = 'Client';
	        $_SESSION['mail']         = $email;
	        $_SESSION['codeclient']   = $codeclient;
	        $_SESSION['ville']        = $ville;
	        $_SESSION['raison']       = $raison;

			echo "true";
		}		
?>