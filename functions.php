<?php
	// functions.php
	//var_dump($GLOBALS);
	
	//***************
	//**** SIGNUP ***
	//***************

	//see failpeab olla koigidel lehtedel kus tahan kasutada SESSION muutujad
	session_start();
	
	
	function signUp ($email, $password, $username) {
		
		$error = "";
		
		
		//echo($username);
		
		
		
		$database = "if16_juri";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, username) VALUES (?, ?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("sss", $email, $password, $username);
		
		if($stmt->execute()) {
			echo "salvestamine onnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	function login ($email, $password, $username) {
		
		$database = "if16_juri";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("
		SELECT id, email, password, username, created 
		FROM user_sample
		WHERE email = ?");
	
		echo $mysqli->error;
		
		//asendan kusimargi
		$stmt->bind_param("s", $email);
		
		//maaran vaartused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $usernameFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist voi mitte
		// on toene kui on vahemalt uks vaste
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				echo "Kasutaja logis sisse ".$id;
				$_SESSION["userId"]= $id;
				$_SESSION["userEmail"]= $emailFromDb;
				
				header("Location: data.php");
			
			
			
			
			}else {
				$error = "vale parool";
			}
			
			
		} else {
			
			// ei leidnud kasutajat selle meiliga
			$error = "ei ole sellist emaili";
		}
		
	return $error;	
	}
	
	

?>