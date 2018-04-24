<?php

function display_func($player)
{
	include ('../court.php');
	$my_player = $player;
	$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
	$query3 = "SELECT * FROM `player_profile` WHERE `username` = '$my_player'";
	$results3 = mysqli_query($connect, $query3) or die ("Unable to run query");
	$row_cnt = mysqli_num_rows($results3);
	$query4 = "SELECT * FROM `videos` WHERE username = '$my_player' ORDER BY upload_date DESC LIMIT 4";
	$results4 = mysqli_query($connect, $query4) or die ("Unable to run query ".mysqli_error($connect));
	$row_cnt2 = mysqli_num_rows($results4);
	$query5 = "SELECT * FROM `videos` WHERE username = '$my_player'";
	$results5 = mysqli_query($connect, $query5) or die ("Unable to run query ".mysqli_error($connect));
	$row_cnt3 = mysqli_num_rows($results5);
	while($row3 = mysqli_fetch_assoc($results3))
	{							
		echo "<div class=playerDisplay><div class=playerInfo>";
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
		
		echo "<div  id=playerDemographics><table>";
		
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
			echo "</table></div>";
		
		if(($row3['picture'] != "") && ($row3['college'] == "") && ($row3['highschool'] == "") && ($row3['nickname'] == "") 
			&& ($row3['height'] == "") && ($row3['weight'] == 0) && ($row3['age'] == 0))
		{
			echo "<div class='profilePic playerInfo'>
					<img id=playerPic src=/images/".$row3['picture'].">
				</div>";
		}
		else
		{
			echo "<div id='playerPagePic'>
					<img id=playerPic class='playerPic_class' src=/images/".$row3['picture'].">
				</div>";
		}
		echo "<div id='playerVideos'>";
				if($row_cnt2 < 1)
				{
					echo "<div id='noVideos_message'>
							<p>This user hasn't uploaded any videos yet</p>
						</div>";
				}
				else
				{
					while($row4 = mysqli_fetch_assoc($results4))
					{
						echo "<div class='playerVideo'>
								<h2>Upload Date: ".$row4['upload_date']."<span class='myVideoID' hidden>".$row4['upload_id']."</span></h2>
								<video class='currentVideo'>
									<source src=/videos/".$row4['file']." type='video/mp4'>
								</video>
								<button class='playBtn'></button>
								<button class='pauseBtn'></button>
							</div>";
					}
				}
		if($row_cnt3 > 4) {
			echo "<button type='button' id='moreVidBtnLeft' class='videoNavBtn'></button>
				<button type='button' id='moreVidBtnRight' class='videoNavBtn'></button>
				</div>";
		}
		else {
			echo "</div>";
		}
		echo "<button type='button' id='bioBtn' class='playerPageNavBtn active_btn'>Bio</button>";
		echo "<button type='button' id='vidsBtn' class='playerPageNavBtn'>Vids</button>";
		echo "<button type='button' id='backBtn' class='playerPageNavBtn'>Back</button>";
		echo "</div>";
	}
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>TTR Player Page</title>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name"viewport" content"width=device-width, intial-scale=1"/>
<meta name="author" content="Guru"/>
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
</head>
<body>
<?php include('../modal.php'); include('../menu3.php');
$player_name = "Billions";
display_func($player_name);
?>
</div>
<script src="/scripts/jquery-2.1.3.min.js"></script>
<script src="/scripts/totherec_2.js"></script>
</body>
</html>