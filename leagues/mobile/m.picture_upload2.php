<?php
include ($_SERVER['DOCUMENT_ROOT'].'/court.php');
if(!empty($_COOKIE['username']))
{
	include "court.php";
	$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
	$user = $_COOKIE['username'];
}
else
{
	header ("location: /mobile/m.totherec.php");
}
if ($_POST['submit'])
{
	if ($_FILES["file"]["error"] > 0)
	{
		echo "Error: ".$_FILES["file"]["error"]. "<br>";
	}
	else
	{
		echo "Upload: ".$_FILES["file"]["name"]. "<br>";
		echo "Type: ".$_FILES["file"]["type"]. "<br>";
		echo "Size: ".$_FILES["file"]["size"]. "<br>";
		echo "Stored in: ".$_FILES["file"]["tmp_name"]. "<br>";
		header ("location: /mobile/m.league_page.php");
	}

	if(file_exists("images/".$_FILES["file"]["name"]))
	{
		echo $_FILES["file"]["name"]. " already exist";
	}
	else
	{
		$filename = "images/".$user."_".$_FILES["file"]["name"];
		move_uploaded_file($_FILES["file"]["tmp_name"], $filename);
		echo "Stored in: " .$filename;
		$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
		$user = $_COOKIE['username'];
		$query = "SELECT * FROM `leagues_profile` WHERE username = '$user'";
		$results = mysqli_query($connect, $query) or die ("Unable to run query");
		$row = mysqli_fetch_assoc($results);
		$filename1 = $user."_".$_FILES["file"]["name"];
		$query1 = "UPDATE `trajac4_db1`.`leagues_profile`
				  SET `leagues_picture` = '$filename1' 
				  WHERE `username` = '$user'";
		echo "<br>".$filename1;
		mysqli_query($connect, $query1) or die ("Unable to run insert query");			
		mysqli_close($connect);
		header ("location: /mobile/m.league_page.php");
	}
}
else
{
	echo "Invalid File";
}
?>

</body>
</html>

