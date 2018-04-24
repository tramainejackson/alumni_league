<!DOCTYPE html>
<html lang="en-US">
<head>
<title>ToTheRec</title>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="handheldfriendly" content="true"/>
<link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.4.5.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/totherec.mobile.css"/>
<script src="/scripts/jquery-2.1.3.min.js"></script>
<script src="/scripts/jquery.mobile-1.4.5.min.js"></script>
<script src="/scripts/totherec-mobile.js"></script>
<style>	a#league_page_panel_li {background-color: green;} </style>
</head>
<body>
	<div data-role="page" id="leagues_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>Leagues</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>			
		<div data-role="main" class="ui-content">
			<div class="leagues" data-role="collapsible" data-collapsed="true">				
				<h1>Leagues for ages 10 and Under</h1>
					<?php include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
						$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
						$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%10%' ORDER BY leagues_name";
						$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
						$num_rows = mysqli_num_rows($runquery5);
							
						if ($num_rows > 0)
						{						
							while ($leagues = mysqli_fetch_assoc($runquery5))
							{				
								echo "<a target='_blank' data-corners='true' class='under10 ui-btn ui-corner-all ui-shadow' id=".str_ireplace(" ", "_", $leagues['leagues_name'])." href=/mobile/leagues/m.".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a>";
							}
						}	
						else
						{
							echo "<p class=under10>No leagues have been added yet for this age range</p>";
						}
					?>
			</div>		
			<div class="leagues" data-role="collapsible" data-collapsed="true">						
				<h1>Leagues for ages 12 and Under</h1>
					<?php 
						$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
						$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%12%' ORDER BY leagues_name";
						$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
						$num_rows = mysqli_num_rows($runquery5);
							
						if ($num_rows > 0)
						{						
							while ($leagues = mysqli_fetch_assoc($runquery5))
							{				
								echo "<a target='_blank' class='under12 ui-btn ui-corner-all ui-shadow' id=".str_ireplace(" ", "_", $leagues['leagues_name'])." href=/mobile/leagues/m.".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a>";
							}
						}	
						else
						{
							echo "<p class=under12>No leagues have been added yet for this age range</p>";
						}
					?>
			</div>		
			<div class="leagues" data-role="collapsible" data-collapsed="true">						
				<h1>Leagues for ages 14 and Under</h1>	
					<?php
						$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
						$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%14%' ORDER BY leagues_name";
						$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
						$num_rows = mysqli_num_rows($runquery5);
							
						if ($num_rows > 0)
						{		
							while ($leagues = mysqli_fetch_assoc($runquery5))
							{				
								echo "<a target='_blank' class='under14 ui-btn ui-corner-all ui-shadow' id=".str_ireplace(" ", "_", $leagues['leagues_name'])." href=/mobile/leagues/m.".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a>";
							}	
						}
						else
						{
							echo "<p class=under14>No leagues have been added yet for this age range</p>";
						}
					?>
			</div>	
			<div class="leagues" data-role="collapsible" data-collapsed="true">	
				<h1>Leagues for ages 16 and Under</h1>	
					<?php
						$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
						$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%16%' ORDER BY leagues_name";
						$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
						$num_rows = mysqli_num_rows($runquery5);
							
						if ($num_rows > 0)
						{		
							while ($leagues = mysqli_fetch_assoc($runquery5))
							{				
								echo "<a target='_blank' class='under16 ui-btn ui-corner-all ui-shadow' id=".str_ireplace(" ", "_", $leagues['leagues_name'])." href=/mobile/leagues/m.".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a>";
							}	
						}
						else
						{
							echo "<p class=under16>No leagues have been added yet for this age range</p>";
						}
					?>
			</div>
			<div class="leagues" data-role="collapsible" data-collapsed="true">	
				<h1>Leagues for ages 18 and Under</h1>	
					<?php
						$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
						$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%18%' ORDER BY leagues_name";
						$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
						$num_rows = mysqli_num_rows($runquery5);
							
						if ($num_rows > 0)
						{		
							while ($leagues = mysqli_fetch_assoc($runquery5))
							{				
								echo "<a target='_blank' class='under18 ui-btn ui-corner-all ui-shadow' id=".str_ireplace(" ", "_", $leagues['leagues_name'])." href=/mobile/leagues/m.".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a>";
							}	
						}
						else
						{
							echo "<p class=under18>No leagues have been added yet for this age range</p>";
						}
					?>
			</div>
			<div class="leagues" data-role="collapsible" data-collapsed="true">	
				<h1>Leagues for ages 30 and Over</h1>	
					<?php
						$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
						$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%30%' ORDER BY leagues_name";
						$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
						$num_rows = mysqli_num_rows($runquery5);
							
						if ($num_rows > 0)
						{		
							while ($leagues = mysqli_fetch_assoc($runquery5))
							{				
								echo "<a target='_blank' class='over30 ui-btn ui-corner-all ui-shadow' id=".str_ireplace(" ", "_", $leagues['leagues_name'])." href=/mobile/leagues/m.".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a>";
							}	
						}
						else
						{
							echo "<p class=over30>No leagues have been added yet for this age range</p>";
						}
					?>	
			</div>
			<div class="leagues" data-role="collapsible" data-collapsed="true">	
				<h1>Leagues for ages 50 and Over</h1>	
					<?php
						$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
						$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%50%' ORDER BY leagues_name";
						$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
						$num_rows = mysqli_num_rows($runquery5);
							
						if ($num_rows > 0)
						{		
							while ($leagues = mysqli_fetch_assoc($runquery5))
							{				
								echo "<a target='_blank' class='over50 ui-btn ui-corner-all ui-shadow' id=".str_ireplace(" ", "_", $leagues['leagues_name'])." href=/mobile/leagues/m.".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a>";
							}	
						}
						else
						{
							echo "<p class=over50>No leagues have been added yet for this age range</p>";
						}
					?>
			</div>
			<div class="leagues" data-role="collapsible" data-collapsed="true">	
				<h1>Leagues for any age</h1>	
					<?php
						$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
						$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%unlimit%' ORDER BY leagues_name";
						$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
						$num_rows = mysqli_num_rows($runquery5);
						
						if ($num_rows > 0)
						{		
							while ($leagues = mysqli_fetch_assoc($runquery5))
							{				
								echo "<a target='_blank' class='unlimited ui-btn ui-corner-all ui-shadow' id=".str_ireplace(" ", "_", $leagues['leagues_name'])." href=/mobile/leagues/m.".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a>";
							}	
						}
						else
						{
							echo "<p class=unlimited>No leagues have been added yet for this age range</p>";
						}
						$close_connection = mysqli_close($connect);
					?>
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