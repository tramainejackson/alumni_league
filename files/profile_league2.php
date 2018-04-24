<!DOCTYPE html>
<html>
<head>
<title>ToTheRec</title>
<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<div id="container">
<?php include "menu.php";?>

	<div class="updatePage">
		<?php
		include "court.php";
		$user = $_COOKIE['username'];
		$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
		$query = "SELECT * FROM `leagues_profile` WHERE username = '$user'";
		$results = mysqli_query($connect, $query) or die ("Unable to run query");

			while($row = mysqli_fetch_assoc($results))
			{
				echo "<table id='leagues_validate_form'>";
				echo "<form action='update_league.php' method='POST'";
				echo "<tr><td><label for='leagues_name'>League Name:</label></td>";
				echo "<td><input type='text' name='leagues_name' id='leagues_name' value = '$row[leagues_name]' disabled></td></tr>";
				echo "<tr><td><label for='leagues_address'>League Address:</label></td>";
				echo "<td><input type='text' name='leagues_address' id='leagues_address' value = '$row[leagues_address]'></td></tr>";
				echo "<tr><td><label for='commish'>Commissioner:</label></td>";
				echo "<td><input type='text' name='leagues_commish' id='leagues_commish' value = '$row[leagues_commish]'><td></tr>";
				echo "<tr><td><label for='leagues_comp'>League Comp:</label></td>";
				echo "<td><select id='leagues_comp' name='leagues_comp[]' multiple>
										<option>Co-Ed</option>
										<option>Just For Fun</option>
										<option>Competitive</option>							
										<option>Advanced</option>
									</select></td></tr>";
				echo"<tr><td><label for='leagues_age'>Competition Age Level:</label></td>
									<td><select id='leagues_age' name='leagues_age[]' multiple>
										<option>10 and under</option>
										<option>12 and under</option>
										<option>14 and under</option>							
										<option>16 and under</option>
										<option>18 and under</option>
										<option>No Age Limit</option>
										<option>30 and over</option>
										<option>50 and over</option>
									</select></td></tr>";
				echo "<tr><td><label for='leagues_fee'>League Fee:</label></td>";
				echo "<td><input type='number' name='leagues_fee' id='leagues_fee' value = '$row[leagues_fee]'></td></tr>";		
				echo "<tr><td><label for='ref_fee'>Ref Fee:</label></td>";
				echo "<td><input type='number' name='ref_fee' id='ref_fee' value = '$row[ref_fee]'></td></tr>";	
				echo "<tr><td><label for='website'>Website:</label></td>";
				echo "<td><input type='text' name='leagues_website' id='leagues_website' value = '$row[leagues_website]'></td></tr>";	
				echo "<tr><td><label for='phone'>Phone:</label></td>";
				echo "<td><input type='text' name='leagues_phone' id='leagues_phone' value = '$row[leagues_phone]'></td></tr>";	
				echo "<tr><td><label for='email'>Email:</label></td>";
				echo "<td><input type='text' name='leagues_email' id='leagues_email' value = '$row[leagues_email]'></td></tr>";		
				echo "<tr><td><input type='submit' name='submit' value='Update My League'></td></tr>";
				echo "</form></table>";				
			}
			
		mysqli_close($connect);
		?>
	</div>

	<div class="updatePage" id="updatePic">
		<form action="picture_upload.php" method="post" enctype="multipart/form-data">
			<label for="file">Add A League Profile Picture:</label>
			<input type="file" name="file" id="file"><br>
			<input type="submit" name="submit" value="Submit!">
		</form>
	</div>
</div>
<script src="/scripts/totherec.js"></script>
<script src="/scripts/jquery-2.1.1.min.js"></script>
</body>
</html>