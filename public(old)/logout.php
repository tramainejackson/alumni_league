<?php require_once("../include/session.php"); ?>
<?php require_once("../include/functions.php"); ?>
<?php
	if(!empty($_SESSION["user_id"]) || !empty($_SESSION["player"]) || !empty($_SESSION["league"]) || !empty($_SESSION["user_name"]))
	{
		session_unset();
		session_destroy(); 
		redirect_to("login.php");
	} else {
		redirect_to("login.php");
	}
?>