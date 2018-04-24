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
<script src="/scripts/totherec-mobile.js"></script>
<style>	a#profile_panel_li {background-color: green;} </style>
</head>
<body>
	<div data-role="page" id="my_player_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>My Page</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>
		<div class="ui-content updatePage" data-role="main">
			<h2 class="update_profile_header">Update My Information</h2>
			<?php
				include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
				$user = $_COOKIE['username'];
				$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
				$query = "SELECT * FROM `player_profile` WHERE username = '$user'";
				$results = mysqli_query($connect, $query) or die ("Unable to run query");
				$query2 = "SELECT * FROM `player_profile` WHERE username = '$user'";
				$results2 = mysqli_query($connect, $query2) or die ("Unable to run query");
				$row2 = mysqli_fetch_assoc($results2);
				$league_query = "SELECT leagues_name FROM `leagues_profile`";
				$league_results = mysqli_query($connect, $league_query) or die ("Unable to run team query");
				$team_query = "SELECT team_name FROM `leagues_teams`";
				$team_results = mysqli_query($connect, $team_query) or die ("Unable to run team query");									
				
					while($row = mysqli_fetch_assoc($results))
					{									
						echo "<form name='form1' id='form1' action='/mobile/m.update_player.php' method='POST'>";
						echo "<table id='update_form_table'>";
						echo "<tr><td><label for='firstname'>First Name:</label></td>";
						echo "<td><input type='text' name='firstname' id='firstname' value = '$row[firstname]'></td></tr>";
						echo "<tr><td><label for='lastname'>Last Name:</label></td>";
						echo "<td><input type='text' name='lastname' id='lastname' value = '$row[lastname]'></td></tr>";
						echo "<tr><td><label for='college'>College:</label></td>";
						echo "<td><input type='text' name='college' id='college' value = '$row[college]'></td></tr>";		
						echo "<tr><td><label for='highschool'>High School:</label></td>";
						echo "<td><input type='text' name='highschool' id='highschool' value = '$row[highschool]'></td></tr>";
						echo "<tr><td><label for='height'>Height:</label></td>";
						echo "<td><input type='text' name='height' id='height' value = $row[height]></td></tr>";
						echo "<tr><td><label for='weight'>Weight:</label></td>";
						echo "<td><input type='number' name='weight' id='weight' value = '$row[weight]'></td></tr>";				
						echo "<tr><td><label for='nickname'>Nickname:</label></td>";
						echo "<td><input type='text' name='nickname' id='nickname' value = '$row[nickname]'></td></tr>";		
						echo "<tr><td><label for='email'>Email:</label></td>";
						echo "<td><input type='text' name='email' id='email' value = '$row[email]'></td></tr>";						
						echo "</table>";
						echo "<input type='submit' name='submit' id='regProfile_btn' value='Update My Profile'>";
						echo "</form>";
					}
							
				mysqli_close($connect);
			?>		

		<div id="current_pic_div">
			<h1 id="current_picture_label">My Picture</h1>
			<?php echo "<img id='current_pic' src=/images/".$row2['picture'].">"; ?>
		</div>		
		</div>
		<div data-role="footer" data-theme="b" data-position="fixed">
			<h1>Footer Text</h1>
		</div>
	</div>	
</body>
</html>