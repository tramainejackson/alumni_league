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
<style> 
</style>
</head>

<body>
<?php include "menu.php"; ?>

<div class="playerDisplay">
	<div class="updateForm">
		<button><a href="profile.php">I WANT TO UPDATE MY PROFILE</a></button>
	</div>	
		<div class="playerInfo">
			<table border-style="hidden">	
				<?php
					include "court.php";
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$username = $_COOKIE['username'];
					$query = "SELECT * FROM `player_profile` WHERE username = '$username'";
					$result = mysqli_query($connect, $query) or die("Unable to run query" .mysqli_errno($connect));
					$row = mysqli_fetch_assoc($result);
	
						echo "<tr><th>Player Profile</th></tr>";
						echo "<tr><td>First Name: ".$row['firstname']."</td></tr>";
						echo "<tr><td>Last Name: ".$row['lastname']."</td></tr>";
						
						if($row['college'] != "")	
						{
							echo "<tr><td>College: ".$row['college']."</td></tr>";
						}	
						if($row['highschool'] != "")	
						{
							echo "<tr><td>Highschool: ".$row['highschool']."</td></tr>";
						}
						if($row['height'] != "")	
						{
							echo "<tr><td>Height: ".$row['height']."</td></tr>";
						}
						if($row['weight'] != 0)	
						{
							echo "<tr><td>Weight: ".$row['weight']." lbs</td></tr>";
						}
						if($row['age'] != 0)	
						{
							echo "<tr><td>Age: ".$row['age']."</td></tr>";
						}	
						if($row['nickname'] != "")	
						{
							echo "<tr><td>Nickname: ".$row['nickname']."</td></tr>";
						}
						if($row['email'] != "")	
						{
							echo "<tr><td>Email: ".$row['email']."</td></tr>";
						}
							
				?>
			</table></div>
	<?php
		echo "<div class=playerInfo id=profilePic>";
		echo "<img id=playerPic src=/images/".$row['picture'].">";
		echo "</div>";
		mysqli_close($connect);
	?>

</div>
</div>
<footer>
	<p>Share With:</p>
</footer>
</body>
</html>