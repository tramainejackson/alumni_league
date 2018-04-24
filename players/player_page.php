<!DOCTYPE html>
<html lang="en-US">
<head>
<title>ToTheRec</title>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Guru"/>
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>	
<script src="/scripts/jquery-2.1.3.min.js"></script>
<script src="/scripts/totherec_2.js"></script>
<script src="/scripts/totherec.js"></script>
</head>
<body>
<?php include ('../modal.php'); include ('../menu.php');?>	
<div class="container">
	<div class="updatePage">
		<h2 class="update_profile_header">Update My Information</h2>
		<h3 class="error_place_holder">Action Jackson</h3>
		<?php
			include "../court.php";
			$user = $_COOKIE['username'];
			$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
			$query = "SELECT * FROM `player_profile` WHERE username = '$user'";
			$results = mysqli_query($connect, $query) or die ("Unable to run query");			
			$query2 = "SELECT * FROM `player_profile` WHERE username = '$user'";
			$results2 = mysqli_query($connect, $query2) or die ("Unable to run query");			
			$league_query = "SELECT leagues_name FROM `leagues_profile`";
			$league_results = mysqli_query($connect, $league_query) or die ("Unable to run team query");						
			$team_query = "SELECT team_name FROM `leagues_teams`";
			$team_results = mysqli_query($connect, $team_query) or die ("Unable to run team query");	
			$row2 = mysqli_fetch_assoc($results2);				
			$m_row2 = explode(" ", $row2['leagues_name']);	
			
			//Get all of the current leagues and put them into an array variable						
			while($row3 = mysqli_fetch_array($league_results))
			{
				global $create_list;
				$create_list .= " ".$row3['leagues_name'];
			}			
			$show_leagues = explode(" ", $create_list);
			$diff_result = array_diff($show_leagues, $m_row2);
			$same_result = array_intersect($show_leagues, $m_row2);
			/*print_r($diff_result);
			print_r($same_result);*/
			
				while($row = mysqli_fetch_assoc($results))
				{									
					echo "<form name='form1' id='form1' onsubmit='return validate_player_info();' action='../update_player.php' method='POST'>";
					echo "<table id='update_form_table'>";
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
					echo "<tr><td><label for='player_leagues'>My Leagues:</label></td>";
					
					/*echo "<tr><td><label for='player_leagues'>My Teams:</label></td>";					
					echo "<td><select size='2' id='player_teams' name='player_teams'>";										
					while($team_rows = mysqli_fetch_assoc($team_results))
					{		
						$team = $team_rows['team_name'];
						if($team == $row['player_teams'])
						{
							echo "<option name='current_team' value='".$team."' selected>".str_ireplace("_", " ", $team)."</option>";
						}	
						else
						{
							echo "<option name='current_team' value='".$team."'>".str_ireplace("_", " ", $team)."</option>";
						}
					}					
					echo "</select></td></tr>";*/
					
					echo "</table>";
					echo "<input type='submit' name='submit' id='regProfile_btn' value='Update My Profile'>";
					echo "</form>";
				}
									
		?>
	</div>
	<div class="updatePage" id="updateLeagues">
		<h2 class="update_profile_header">League Information</h2>
			<div class="my_leagues_form" id="current_leagues_list">
				<h2>My Leagues</h2>
				<ul style="list-syle-type:none" id="my_leagues_ul">					
					<?php 
					foreach($same_result as $same_value){
						$show_same = str_ireplace("_", " ", $same_value);
						echo "<li class='my_current_leagues' id='".$same_value."' value='".$same_value."' name='my_current_leagues'>".$show_same."</li><img src='/images/redx-300x297.jpg'/>";
					}?>
				</ul>	
			</div>		
			<div class="my_leagues_form" id="current_available_list">	
				<h2>Available Leagues</h2>
				<ul style="list-syle-type:none" id="not_my_leagues_ul">					
					<?php	
					foreach($diff_result as $diff_value){
						$show_diff = str_ireplace("_", " ", $diff_value);
						echo "<li class='not_my_current_leagues' id='".$diff_value."' value='".$diff_value."' name='my_current_leagues'>".$show_diff."</li>";
					}?>
				</ul>
			</div>
		<button id="my_leagues_btn" class="">Show My Leagues</button>
	</div>
	<div class="updatePage" id="updatePic">
		<form action="picture_upload.php" method="post" enctype="multipart/form-data">
			<label id="picture_label" for="file">Update My Picture:</label>
			<input type="file" name="file" id="file"/><br>
			<input type="submit" name="submit" id="updatePic_btn" value="Update"/>
		</form>
		<?php echo "<img id='current_pic' src=/images/".$row2['picture'].">"; ?>
	</div>	
</div>
<footer>
	<p>Share With:</p>
</footer>
</body>
</html>