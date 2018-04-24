<!DOCTYPE html>
<html lang="en-US">
<head>
<title>ToTheRec</title>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name"viewport" content"width=device-width, intial-scale=1"/>
<meta name="author" content="Guru"/>
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
</head>

<body>

<?php include "menu.php"; ?>
<div class="content">
	<div id="leagueDisplay">
		<form action="/profile2.php">
		<input type="submit" value="I WANT TO UPDATE MY LEAGUE." >
		</form>

		<table class="updatePage">
			
		<?php
		include "court.php";
		$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
		$username = $_COOKIE['username'];
		$query = "SELECT * FROM `leagues_profile` WHERE username = '$username'";
		$result = mysqli_query($connect, $query) or die("Unable to run query" .mysqli_errno($connect));
		$row = mysqli_fetch_assoc($result);

			echo "<h3>League Profile</h3>";
			echo "<tr><td>Name: ".$row['leagues_name']."</td></tr>";
			
			if($row['leagues_commish'] != "")	
			{
				echo "<tr><td>Owner: ".$row['leagues_commish']."</td></tr>";
			}	
			if($row['leagues_address'] != "")	
			{
				echo "<tr><td>Address: ".$row['leagues_address']."</td></tr>";
			}
			if($row['leagues_phone'] != "")	
			{
				echo "<tr><td>Phone #: ".$row['leagues_phone']."</td></tr>";
			}
			if($row['leagues_website'] != "")	
			{
				echo "<tr><td>Website: ".$row['leagues_website']."</td></tr>";
			}
			if($row['leagues_age'] != "")	
			{
				echo "<tr><td>Player Age Requirements: ".$row['leagues_age']."</td></tr>";
			}	
			if($row['leagues_comp'] != "")	
			{
				echo "<tr><td>Player Competition: ".$row['leagues_comp']."</td></tr>";
			}
			if($row['leagues_email'] != "")	
			{
				echo "<tr><td>League Email: ".$row['leagues_email']."</td></tr>";
			}
			
		?>
		</table>
		</br></br></br>
		<h3>Videos From The League</h3>
		<video width="320" league_phone="240" controls>
		<source src="" type="video/mp4">
		</video>
		<h3>Coming Soon To A Theater Near You!<h3>
	</div>
</div>

<footer>
	<p>Share With:</p>
</footer>

</body>
</html>