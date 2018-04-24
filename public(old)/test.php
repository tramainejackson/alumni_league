<?php require_once("../include/sessions.php"); ?>
<?php require_once("../include/court.php"); ?>
<?php require_once("../include/functions.php"); ?>
<body>
	<?php
		$test;
		
		// $test = password_hash("1234567", PASSWORD_DEFAULT);
		// echo $test;
		// $test = duplicate_leaguename_check("thehef");
		// echo "<pre>";
		// print_r($test);
		// echo "</pre>";
		
		echo password_hash("1234567", PASSWORD_BCRYPT);
	?>
</body>
<html>