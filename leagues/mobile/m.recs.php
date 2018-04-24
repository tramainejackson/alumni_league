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
<style>	a#rec_page_panel_li {background-color: green;} </style>
</head>
<body>
	<div data-role="page" id="recs_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>Rec Centers</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>	
		<div class="recsPage">
				<form class="ui-filterable">
				  <input id="recs_filter" data-type="search" placeholder="Search Rec....">
				</form>
		<div data-role="main" class="ui-content">
			<?php include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
			$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
			$query3 = "SELECT * FROM `rec_profile` ORDER BY `recs_name`";
			$results3 = mysqli_query($connect, $query3) or die ("Unable to run query1");
			$row_cnt = mysqli_num_rows($results3);
			for($ii = 1; $ii <= 1; $ii++)
			{
				while($row3 = mysqli_fetch_assoc($results3))
				{
					echo "<div class=recs_div data-filter='true' data-input='#recs_filter'><table id=".str_ireplace(" ", "_", $row3['recs_name']).">";		
					$no_site = "None";
					$indoors = $row3['indoor'];
					$outdoors = $row3['outdoor'];
					if($row3['recs_name'] != "")	
					{
						echo "<tr><th id=recs_header>".$row3['recs_name']." ";
						if($row3['recs_nickname'] != "")	
						{
							echo "<b>\"".$row3['recs_nickname']."\"</b></th></tr>";
						}
						else
						{
							"</th></tr>";
						}
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
						echo "<tr><td>Website: <a href=http://".$row3['recs_website']." target=_blank > Click Here For ".$row3['recs_name']." Website</a></td></tr>";
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
			}		
			mysqli_close($connect);
			?>
		</div>	
		</div>
	</div>	
	<div data-role="footer" data-theme="b" data-position="fixed">
		<h1>Footer Text</h1>
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