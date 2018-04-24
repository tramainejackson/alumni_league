<?php

function display_func($league)
{
	include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
	$my_league = $league;
	$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
	$query3 = "SELECT * FROM `recs_profile` WHERE `recs_name` = '$my_league'";
	$results3 = mysqli_query($connect, $query3) or die ("Unable to run query");
	$row_cnt = mysqli_num_rows($results3);
			while($row3 = mysqli_fetch_assoc($results3))
			{
				echo "<div class=leaguesPage><table id=leaguesPage>";		
				$no_site = "Under Construction";
				$indoors = $row3['indoor'];
				$outdoors = $row3['outdoor'];
				if($row3['recs_name'] != "")	
				{
					echo "<tr><th>".$row3['recs_name']."</th></tr>";
				}
				if($row3['recs_owner'] != "")
				{				
					echo "<tr><td>Rec Advisor: ".$row3['recs_owner']."</td></tr>";
				}
				if($row3['recs_address'] != "")
				{				
					echo "<tr><td>Address: ".$row3['recs_address']."</td></tr>";
				}	
						
				if($row3['recs_website'] == "")
				{
					echo "<tr><td>Website: ".$no_site."</a></td></tr>";
				}
				else
				{
					echo "<tr><td>Website: <a href=http://".$row3['recs_website']." target=_blank >".$row3['recs_website']."</a></td></tr>";
				}
				
				if($row3['indoor'] == "1")
				{
					$indoors = "Yes";
				}
				else
				{
					$indoors = "No";
				}
						
				if($row3['outdoor'] == "1")
				{
					$outdoors = "Yes";
				}
				else
				{
					$outdoors = "No";
				}
						
				echo "<tr><td>Indoor Gym: ".$indoors."</td></tr>";	
				echo "<tr><td>Blacktop: ".$outdoors."</td></tr>";
				echo "<tr><td>More Info: ".$row3['recs_phone']."</a></td></tr>";			
				echo "</table></div>";
					
			}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>ToTheRec</title>
<link rel="stylesheet" type="text/css" href="/css/style.css">
<style> 
</style>
</head>
<body>
<?php include ($_SERVER['DOCUMENT_ROOT']. '/menu.php'); ?>
<?php
<?php