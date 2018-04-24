<?php

function display_func($player)
{
	include ('../court.php');
	$my_player = $player;
	$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
	$query3 = "SELECT * FROM `player_profile` WHERE `username` = '$my_player'";
	$results3 = mysqli_query($connect, $query3) or die ("Unable to run query");
	$row_cnt = mysqli_num_rows($results3);
	while($row3 = mysqli_fetch_assoc($results3))
	{							
		echo "<div class=playerDisplay><div class=playerInfo id=playerDemographics>";
		echo "<h2 id='about_header'>".$row3['firstname'];
			if($row3['nickname'] != "")
			{
				echo " \"".$row3['nickname']."\" ";
				echo $row3['lastname']."</h2>";	
			}
			else
			{
				echo $row3['lastname']."</h2>";	
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
			echo "<div class=profilePic>
			<button tye='button' class='playerPic_class playerPic_btn'><a href='javascript:history.back()'>&#8666 Back</a></button>
			<img id=playerPic class='playerPic_class' src=/images/".$row3['picture'].">
			</div>";
		}
			
		echo "</div>";
	}
}
?>
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
<?php include ('../menu2.php'); ?>
<?php
$player_name = "Mac";
display_func($player_name);
?>
</body>
</html>