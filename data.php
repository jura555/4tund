<?php







require("functions.php");
//kui ei ole kasutaja id
if (!isset($_SESSION["userId"])) {
	header("Location: logi3.php");
//siis suunan tagasisisselogimise lehele	
}



if(isset($_GET["logout"])) {
	session_destroy();
	header("location: logi3.php");
}













?>
<h1>DATA<h1>

<p>TERE TULEMAS <?=$_SESSION["userEmail"];?>
<a href="?logout=1">Logi Valja</a>
</p>
