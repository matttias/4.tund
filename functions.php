<?php
/*
//functions.php
//function sum($x, $y) {
//	return $x + $y;
//}
//echo sum (246352566, 1231651864);
//echo "<br>";
//echo sum(2,3)
function hello($m, $b) {
	return "Tere tulemst " .$m." ".$b. "!";
}
echo hello("Mattias", "Blehner")
*/

//see vail peab olema kõigil lehtedel, kus tahan kasutada session muutujat
session_start();

//************
//***Signup***
//************

function signUp($signupUsername, $password, $signupEmail, $signupFirstName, $signupLastName) {
	//echo $serverUsername;
	//Ühendus
	$database = "if16_mattbleh_2";

		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		// mysqli rida
		$stmt = $mysqli->prepare("INSERT INTO login (username, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?)");
		echo $mysqli->error;
		// stringina üks täht iga muutuja kohta (?), mis t��p t
		// string - s
		// integer - i
		// float (double) - d
		// küsimärgid asendada muutujaga
		$stmt->bind_param("sssss",$signupUsername, $password, $signupEmail, $signupFirstName, $signupLastName);
		
		//täida käu
		if($stmt->execute()) {
			echo "Salvestamine õnnestus";
			
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		//panen Ühenduse kinni
		$stmt->close();
		$mysqli->close();
	}


function login($email, $password) {
	
	$error = "";
	
	$database = "if16_mattbleh_2";
		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("
		SELECT id, username, password, email, firstname, lastname, created
		FROM login
		WHERE email = ?");
		
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määrna väärtused muutujasse
		$stmt->bind_result($id, $usernameFromDB, $passwordFromDB,  $emailFromDB, $firstnameFromDB, $lastnameFromDB, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist või mitte
		//on tõene kui on vähemalt üks vastus
		
		if($stmt->fetch()){
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDB) {
				echo "Kasutaja logis sisse ".$id;
			} else {
				$error = "Vale parool";
			}
			//määran sessiooni muutujad
			$_SESSION["userId"] = $id;
			$_SESSION["userEmail"] = $emailFromDB;
			$_SESSION["userName"] = $usernameFromDB;
			$_SESSION["firstName"] = $firstnameFromDB;
			$_SESSION["lastName"] = $lastnameFromDB;
			$_SESSION["created"] = $created;
			
			header("Location: login.php");
			
		} else {
			//ei ole sellist kasutajat selle meiliga
			$error = "Ei ole sellist e-maili";
		}
	
		return $error;
	}
	

?>