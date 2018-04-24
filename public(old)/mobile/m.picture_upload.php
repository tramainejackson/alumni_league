<!DOCTYPE html>
<html lang="en-US">
<head>
<title>ToTheRec</title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="author" content="Guru"/>
<meta name="handheldfriendly" content="true"/>
<link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.4.5.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/totherec.mobile.css"/>
<script src="/scripts/jquery-2.1.3.min.js"></script>
<script src="/scripts/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
<div data-role="page" id="my_player_page">
<div class="ui-content updatePage" data-role="main">
<?php

if(!empty($_COOKIE['username']))
{
	include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
	$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
	$user = $_COOKIE['username'];
	$query = "SELECT * FROM `player_profile` WHERE username = '$user'";
}
else
{
	/*header ('location: /mobile/m.totherec.php');*/
}
?>

<?php
include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
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
	}

	if(file_exists("images/".$_FILES["file"]["name"]))
	{
		echo $_FILES["file"]["name"]. " already exist";
		/*header ("location: /mobile/m.player_page.php");*/
	}
	else
	{
		$filename = "images/".$user."_".$_FILES["file"]["name"];
		move_uploaded_file($_FILES["file"]["tmp_name"], $filename);
		echo "Stored in: " .$filename;
		$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
		$user = $_COOKIE['username'];
		$query = "SELECT * FROM `player_profile` WHERE username = '$user'";
		$results = mysqli_query($connect, $query) or die ("Unable to run query");
		$row = mysqli_fetch_assoc($results);
		$filename1 = $user."_".$_FILES["file"]["name"];
		$query1 = "UPDATE `trajac4_db1`.`player_profile`
				  SET `picture` = '$filename1' 
				  WHERE `username` = '$user'";
		echo "<br>".$filename1;
		mysqli_query($connect, $query1) or die ("Unable to run insert query");			
		mysqli_close($connect);
		/*header ("location: /mobile/m.player_page.php");*/
	}
}
else
{
	echo "Invalid File";
}
?>
</div>
</div>
</body>
</html>

