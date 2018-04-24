<?php

function display_func($leagues)
{
	include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
	$my_leagues = $leagues;
	$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
	$query3 = "SELECT * FROM `leagues_profile` WHERE `leagues_name` = '$my_leagues'";
	$results3 = mysqli_query($connect, $query3) or die ("Unable to run query");
	$row_cnt = mysqli_num_rows($results3);
	
	echo "<div data-role='main' class='ui-content league_info' id='league_demographics'>";
	while($row3 = mysqli_fetch_assoc($results3))
	{
		$no_site = "None";
		echo "<button class='ui-btn ui-icon-back ui-btn-icon-notext' data-rel='back'>Back</button>";
		echo "<h1>".$row3['leagues_name']."</h1>";
		echo "<ul data-role='listview' data-inset='true' id='league_stats'><li><a  class='schedule' target='_blank' href='/mobile/leagues/".str_ireplace(" ", "_", $row3['leagues_name'])."/schedule.php'>Schedule</a></li><li><a class='standings' target='_blank' href='/mobile/leagues/".str_ireplace(" ", "_", $row3['leagues_name'])."/mobile/standings.php'>Standings</a></li><li><a class='stats' target='_blank' href='/mobile/leagues/".str_ireplace(" ", "_", $row3['leagues_name'])."/stats.php'>Player Stats</a></li></ul>";
		echo "<table class=leagues_page_table>";
		echo "<tr><td><b>League Owner:</b> ".$row3['leagues_commish']."</td></tr>";				
		echo "<tr><td><b>Competition Level:</b> ".str_ireplace("_", "-", str_ireplace(" ", ", ", ucwords($row3['leagues_comp'])))."</td></tr>";
		echo "<tr><td><b>Leagues Age:</b> ".str_ireplace("_", " ", str_ireplace(" ", ", ", ucwords($row3['leagues_age'])))."</td></tr>";
		if($row3['leagues_fee'] > 0)
		{
			echo "<tr><td><b>Entry Fee:</b> $".$row3['leagues_fee']."</td></tr>";
		}
		else
		{
			echo "<tr><td><b>Entry Fee:</b> Call for more information</td></tr>";
		}
		if($row3['ref_fee'] > 0)
		{
			echo "<tr><td><b>Ref Fees per/g:</b> $".$row3['ref_fee']."</td></tr>";					
		}
		else
		{
			echo "<tr><td><b>Ref Fees per/g:</b> Call for more information</td></tr>";					
		}				
		
		if($row3['leagues_website'] == "")
		{
			echo "<tr><td><b>Website:</b> ".$no_site."</a></td></tr>";
		}
		else 
		{
			echo "<tr><td><b>Website:</b> <a href=http://".$row3['leagues_website']." target=_blank>".$row3['leagues_website']."</a></td></tr>";
		}
		
		echo "<tr><td><b>More Info:</b> ".$row3['leagues_phone']."</td></tr>";									
		echo "<tr><td><b>League Address:</b> ".$row3['leagues_address']."</td></tr>";	
		echo "</table>";
		if($row3['leagues_picture'] != "")
		{
			echo "<img id='my_leagues_photo' src=/images/".$row3['leagues_picture'].">";			
		}	
			echo "<a href='#' class='ui-btn ui-icon-back ui-btn-icon-notext ui-shadow' data-rel='back'>Back</a></div>";
			echo "<div data-role='footer' data-theme='b' data-position='fixed'><h1>Footer Text</h1></div>";
	}
}
?>
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
</head>
<body>
<div data-role='page' class='league_display'>
<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?>
<div data-role="header" data-theme="b" data-position="fixed">
	<h1>League Profile</h1>
	<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
</div>
<?php
$league_name = "Chill Don't Pay The Bills";
display_func($league_name);
?>
<footer>
	<p>Share With:</p>
</footer>
</div>
</body>
</html>