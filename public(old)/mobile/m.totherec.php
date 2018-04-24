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
<style>	a#home_page_panel_li {background-color: green;} </style>
</head>
<body>
	<div data-role="page" id="home_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>To The Rec</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>
		<div data-role="main" class="ui-content">
			<div id="match_ups_headline">
				<h2>Upcoming Match-Up</h2>
			</div>
			<div id="contender_1" class="contenders match_ups_div">
				<?php include ($_SERVER['DOCUMENT_ROOT']. '/court.php'); 
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$query3 = "SELECT * FROM player_profile WHERE `player_id` = '1' ";
					$runquery3 = mysqli_query($connect, $query3) or die ("Unable to run query");				
					while ($players = mysqli_fetch_assoc($runquery3))
					{				
						echo "<table>";
						echo "<tr><td>".$players['firstname']." \"".$players['nickname']."\" ".$players['lastname']."</td></tr>";					
						echo "<tr><td>Height: ".$players['height']."</td></tr>";
						echo "<tr><td>Weight: ".$players['weight']." lbs</td></tr>";
						echo "<tr><td>College: ".$players['college']."</td></tr>";
						echo "</table>";
						echo "<img class=match_ups_player_pic1 src=/images/".$players['picture'].">";					
					}				
					$close_connection = mysqli_close($connect);
				?>			
			</div>
			<div id="versus" class="match_ups_div">			
				<h1>VS</h1>
			</div>
			<div id="contender_2" class="contenders match_ups_div">
				<?php
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$query3 = "SELECT * FROM player_profile WHERE `player_id` = '2' ";
					$runquery3 = mysqli_query($connect, $query3) or die ("Unable to run query");				
					while ($players = mysqli_fetch_assoc($runquery3))
					{														
						echo "<img class=match_ups_player_pic2 src=/images/".$players['picture'].">";	
						echo "<table>";
						echo "<tr><td>".$players['firstname']." \"".$players['nickname']."\" ".$players['lastname']."</td></tr>";					
						echo "<tr><td>Height: ".$players['height']."</td></tr>";
						echo "<tr><td>Weight: ".$players['weight']." lbs</td></tr>";
						echo "<tr><td>College: ".$players['college']."</td></tr>";
						echo "</table>";					
					}				
					$close_connection = mysqli_close($connect);
				?>
			</div>
			<div id="match_ups_information">
				<p>Location: </p>
				<p>Date:</p>
				<p>Time:</p>
				<p>Cost:</p>
			</div>
		</div>		
		<div data-role="footer" data-theme="b" data-position="fixed">
			<h1>Footer Text</h1>
		</div>
	</div>
	<div data-role="page" data-dialog="true" id="contact_info">
		<div data-role="header">
			<h1>Contact Us</h1>
		</div>
		<div data-role="main" class="ui-content">
			<div class="contact">
				<h4>Contact</h4>
				<p>Name: Tramaine</p>
				<p>Email: totherec.sports@gmail.com</p>
			</div>
			<div class="contact">
				<h4>Contact</h4>
				<p>Name: BC</p>
				<p>Email: bcaldwell86@yahoo.com</p>
			</div>			
		</div>
	</div>
	<div data-role="page" data-dialog="true" id="new_news">
		<div data-role="header">
			<h1>News</h1>
		</div>
		<div data-role="main" class="ui-content">	
			<h1>Hitting The News Stands In the Near Future</h1>
		</div>
	</div>
	<div data-role="page" data-dialog="true" id="videos">
		<div data-role="header">
			<h1>Videos</h1>
		</div>
		<div data-role="main" class="ui-content">	
			<h1>Coming Soon To A Theater Near You</h1>
		</div>
	</div>
</body>
</html>