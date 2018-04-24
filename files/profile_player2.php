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
	<div class="updatePage">
		<?php
			include "court.php";
			$user = $_COOKIE['username'];
			$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
			$query = "SELECT * FROM `player_profile` WHERE username = '$user'";
			$results = mysqli_query($connect, $query) or die ("Unable to run query");
			
				while($row = mysqli_fetch_assoc($results))
				{
					echo "<table>";
					echo "<form action='update_player.php' method='POST'>";
					echo "<tr><td><label for='firstname'>First Name:</label></td>";
					echo "<td><input type='text' name='firstname' id='firstname' value = $row[firstname]></td></tr>";
					echo "<tr><td><label for='lastname'>Last Name:</label></td>";
					echo "<td><input type='text' name='lastname' id='lastname' value = $row[lastname]></td></tr>";
					echo "<tr><td><label for='college'>College:</label></td>";
					echo "<td><input type='text' name='college' id='college' value = $row[college]></td></tr>";		
					echo "<tr><td><label for='highschool'>High School:</label></td>";
					echo "<td><input type='text' name='highschool' id='highschool' value = $row[highschool]></td></tr>";
					echo "<tr><td><label for='height'>Height:</label></td>";
					echo "<td><input type='text' name='height' id='height' value = $row[height]></td></tr>";
					echo "<tr><td><label for='weight'>Weight:</label></td>";
					echo "<td><input type='number' name='weight' id='weight' value = '$row[weight]'></td></tr>";				
					echo "<tr><td><label for='nickname'>Nickname:</label></td>";
					echo "<td><input type='text' name='nickname' id='nickname' value = $row[nickname]></td></tr>";		
					echo "<tr><td><label for='email'>Email:</label></td>";
					echo "<td><input type='text' name='email' id='email' value = $row[email]></td></tr>";
					echo "<tr><td><input type='submit' name='submit' value='Update My Profile'></td></tr>";
					echo "</form></table></body></html>";
				}
						
			mysqli_close($connect);
		?>
	</div>

<div class="updatePage" id="updatePic">
	<form action="picture_upload.php" method="post" enctype="multipart/form-data">
		<label for="file">Update My Picture:</label>
		<input type="file" name="file" id="file"><br>
		<input type="submit" name="submit" value="Submit!">
	</form>
</div>

</div>
</body>
</html>