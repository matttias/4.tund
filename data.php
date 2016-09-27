<?php
require("functions.php");
//kui ei ole kasutaja id'd
if (!isset($_SESSION["userId"])){
	//suunan sisselogimise lehele
	header("Location: login.php");	
}

//kui on ?logout aadressireal siis login välja
if (isset($_GET["logout"])) {
	session_destroy();
	header("Location: login.php");
}
?>
<h1>DATA<h1>

<p>Tere tulemast <?=$_SESSION["firstName"];?> <?=$_SESSION["lastName"];?>!</p>
<p>Kasutajanimi: <?=$_SESSION["userName"];?></p>
<p>E-mail: <?=$_SESSION["userEmail"];?></p>
<p>Loodud: <?=$_SESSION["created"];?></p>
<a href="?logout=1">Logi välja</a>