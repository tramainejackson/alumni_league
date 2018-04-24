<?php

function display_func($player)
{
	include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
	$my_player = $player;
	$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
	$query3 = "SELECT * FROM `player_profile` WHERE `username` = '$my_player'";
	$results3 = mysqli_query($connect, $query3) or die ("Unable to run query");
	$row_cnt = mysqli_num_rows($results3);
	
	echo "<div data-role='main' class='ui-content player_info' id='player_demographics'>";
	while($row3 = mysqli_fetch_assoc($results3))
	{													
		echo "<h2 id='name_header'>".$row3['firstname']." ";
			if($row3['nickname'] != "")
			{
				echo " \"".$row3['nickname']."\" ";
				echo $row3['lastname']."</h2>";	
			}
			else
			{
				echo " ".$row3['lastname']."</h2>";	
			}	
		
		echo "<table>";
		
		if($row3['college'] != "")
		{
			echo "<tr><td><b>College:</b> ".$row3['college']."</td></tr>";
		}
		
		if($row3['highschool'] != "")
		{
			echo "<tr><td><b>High School:</b> ".$row3['highschool']."</td></tr>";
		}

		if($row3['height'] != "")
		{
			echo "<tr><td><b>Height:</b> ".$row3['height']."</td></tr>";
		}
		
		if($row3['weight'] != 0)
		{
			echo "<tr><td><b>Weight</b>: ".$row3['weight']." lbs</td></tr>";
		}

		if($row3['age'] != 0)
		{
			echo "<tr><td><b>Age:</b> ".$row3['age']."</td></tr>";
		}

		if($row3['email'] != "")
		{
			echo "<tr><td><b>Email:</b> ".$row3['email']."</td></tr>";
		}
			echo "</table>";
		
		if(($row3['picture'] != "") && ($row3['college'] == "") && ($row3['highschool'] == "") && ($row3['nickname'] == "") 
			&& ($row3['height'] == "") && ($row3['weight'] == 0) && ($row3['age'] == 0))
		{
			echo "<div class=profilePic>";
			echo "<img id=playerPic src=/images/".$row3['picture'].">";
			echo "</div>";
		}
		else
		{
			echo "<div class=profilePic>";			
			echo "<img id=playerPic class='playerPic_class' src=/images/".$row3['picture'].">";			
			echo "</div>";
		}
			
		echo "</div></div>";
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
</head>
<body>
<div data-role='page' data-dialog="true" class='player_display'>
<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?>
<div data-role="header">
	<h1>Player Profile</h1>
</div>
<?php
$player_name = "Mac";
display_func($player_name);
?>
</div>
</body>
</html>