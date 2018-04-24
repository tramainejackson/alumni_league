<!DOCTYPE html>
<html lang="en-US">
<head>
<title>ToTheRec</title>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, recs and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Guru"/>
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<style src="//html5shiv.googlecode.com/svn/trunk/html5.js">
#backgroundImageR {
    background-image: url("/images/mybackground1.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    width: 100%;
	height: 100%;
    position: fixed;
    min-height: 1068px;
	z-index: -1;
}
</style>
</head>
<body>
<div id="backgroundImageR"></div>
<?php include ('/modal.php'); include ('/menu2.php');?>
	<div id="search_box"><input id="searchBox_text" name="search" type="search" placeholder="Search Center"/></div>
	<div id="all_recs_frame">
		<div id="all_recs">
		<?php
				$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
				$query3 = "SELECT * FROM `rec_profile` ORDER BY `recs_name`";
				$results3 = mysqli_query($connect, $query3) or die ("Unable to run query1");
				$row_cnt = mysqli_num_rows($results3);
				while($row3 = mysqli_fetch_assoc($results3))
				{
					echo "<div class=recsPage>";
					if($row3['recs_name'] != "")	
					{
						if($row3['recs_nickname'] != "")	
						{
						echo "<h3 id='".strtolower(str_ireplace(" ", "", $row3['recs_name']))."' class='recs_header'>".$row3['recs_name']." <b>\"".$row3['recs_nickname']."\"</b></h3>";
						}
						else
						{
							echo "<h3 id='".strtolower(str_ireplace(" ", "", $row3['recs_name']))."' class='recs_header'>".$row3['recs_name']."</h3>";
						}
					}
					echo "<table class=recsPageTable>";		
					$no_site = "None";
					$indoors = $row3['indoor'];
					$outdoors = $row3['outdoor'];
					if($row3['recs_owner'] != "")
					{				
						echo "<tr><td>Rec Advisor: ".$row3['recs_owner']."</td></tr>";
					}
					else
					{
						echo "<tr><td>Rec Advisor: None Available </td></tr>";
					}
					
					if($row3['recs_address'] != "")
					{				
						echo "<tr><td>Address: ".$row3['recs_address']."</td></tr>";
					}	
					else
					{
						echo "<tr><td>Address: See website for address</td></tr>";
					}	
					
					if($row3['recs_website'] == "")
					{
						echo "<tr><td>Website: ".$no_site."</td></tr>";
					}
					else
					{
						echo "<tr><td>Website: <a href=http://".$row3['recs_website']." target=_blank > Click Here For Website</a></td></tr>";
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
					echo "<tr><td>$$$: ".$row3['fee']."</td></tr>";
					echo "<tr><td>More Info: ".$row3['recs_phone']."</a></td></tr>";			
					echo "</table></div>";
						
				}
		mysqli_close($connect);
		?>
		</div>
	</div>
	<button id="showAllRecs">Show All Rec Centers</button>
	<button id="scroll_to_top"></button>
<footer>
	<p>Share With:</p>
</footer>
<script src="/scripts/jquery-2.1.1.min.js"></script>
<script src="/scripts/totherec.js"></script>
</body>
</html>