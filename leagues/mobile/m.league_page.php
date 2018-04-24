<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="handheldfriendly" content="true"/>
<link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.4.5.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/totherec.mobile.css"/>
<script src="/scripts/jquery-2.1.3.min.js"></script>
<script src="/scripts/jquery.mobile-1.4.5.min.js"></script>
<script src="/scripts/totherec-mobile.js"></script>
<style>	a#profile_panel_li {background-color: green;} </style>
</head>
<body>
	<div data-role="page" id="my_leagues_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>My League Information</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>
		<div class="ui-content updatePage" data-role="main">
			<h2 class="update_profile_header">Update My League</h2>
			<?php
			include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
			$user = $_COOKIE['username'];
			$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
			$query = "SELECT * FROM `leagues_profile` WHERE username = '$user'";
			$results = mysqli_query($connect, $query) or die ("Unable to run query");
			$query2 = "SELECT * FROM `leagues_profile` WHERE username = '$user'";
			$results2 = mysqli_query($connect, $query2) or die ("Unable to run query");
			$row2 = mysqli_fetch_assoc($results2);

				while($row = mysqli_fetch_assoc($results))
				{			
					echo "<form name='form2' id='form2' action='/mobile/m.update_league.php' method='POST'>";
					echo "<table id='leagues_validate_form'>";
					echo "<tr><td><label for='leagues_name'>League Name:</label></td>";
					echo "<td><input type='text' name='leagues_name' id='leagues_name' value = '$row[leagues_name]' disabled></td></tr>";
					echo "<tr><td><label for='commish'>Commissioner:</label></td>";
					echo "<td><input type='text' name='leagues_commish' id='leagues_commish' value = '$row[leagues_commish]'><td></tr>";
					echo "<tr><td><label for='leagues_address'>League Address:</label></td>";
					echo "<td><input type='text' name='leagues_address' id='leagues_address' value = '$row[leagues_address]'></td></tr>";																				
					echo "<tr><td><label for='leagues_fee'>League Fee:</label></td>";
					echo "<td><input type='number' name='leagues_fee' id='leagues_fee' value = '$row[leagues_fee]'></td></tr>";		
					echo "<tr><td><label for='ref_fee'>Ref Fee:</label></td>";
					echo "<td><input type='number' name='ref_fee' id='ref_fee' value = '$row[ref_fee]'></td></tr>";	
					echo "<tr><td><label for='website'>Website:</label></td>";
					echo "<td><input type='text' name='leagues_website' id='leagues_website' value = '$row[leagues_website]'></td></tr>";	
					echo "<tr><td><label for='phone'>Phone:</label></td>";
					echo "<td><input type='text' name='leagues_phone' id='leagues_phone' value = '$row[leagues_phone]'></td></tr>";	
					echo "<tr><td><label for='email'>Email:</label></td>";
					echo "<td><input type='text' name='leagues_email' id='leagues_email' value = '$row[leagues_email]'></td></tr></table>";		
					echo "<input class='ui-btn' type='submit' name='submit' id='regLeague_btn' value='Update My League'>";
					echo "</form>";	
				}

			mysqli_close($connect);
		?>	

	<div id="current_pic">
		<h1>League Picture</h1>
		<?php echo "<img id='current_pic' src=/images/".$row['leagues_picture'].">"; ?>
	</div>
	</div>
	<div data-role="footer" data-theme="b" data-position="fixed">
		<h1>Footer Text</h1>
	</div>
</div>
</body>
</html>