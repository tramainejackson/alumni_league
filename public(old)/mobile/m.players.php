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
<style>	a#player_page_panel_li {background-color: green;} </style>
<style> 
</style>
</head>
<body>
	<div data-role="page" id="player_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>Players Page</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>	
		<div data-role="main" class="ui-content">
			<div class="playersPage">
				<form class="ui-filterable">
				  <input id="player_filter" data-type="search" placeholder="Search Name....">
				</form>
				<ul data-role="listview" data-filter="true" data-input="#player_filter" id="playersPage2">
					
					<li>A</li>
					
				<?php		
				$query_a = "SELECT * FROM `player_profile` WHERE lastname LIKE 'a%'";
				$runquery_a = mysqli_query($connect, $query_a) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_a))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>
				
					<li>B</li>
					
				<?php		
				$query_b = "SELECT * FROM `player_profile` WHERE lastname LIKE 'b%'";
				$runquery_b = mysqli_query($connect, $query_b) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_b))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>
				
					<li>C</li>
				
				<?php		
				$query_c = "SELECT * FROM `player_profile` WHERE lastname LIKE 'c%'";
				$runquery_c = mysqli_query($connect, $query_c) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_c))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>
					<li>D</li>
				
				<?php		
				$query_d = "SELECT * FROM `player_profile` WHERE lastname LIKE 'd%'";
				$runquery_d = mysqli_query($connect, $query_d) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_d))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>E</li>	
				
				<?php		
				$query_e = "SELECT * FROM `player_profile` WHERE lastname LIKE 'e%'";
				$runquery_e = mysqli_query($connect, $query_e) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_e))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>F</li>
					
				<?php		
				$query_f = "SELECT * FROM `player_profile` WHERE lastname LIKE 'f%'";
				$runquery_f = mysqli_query($connect, $query_f) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_f))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>G</li>
				
				<?php		
				$query_g = "SELECT * FROM `player_profile` WHERE lastname LIKE 'g%'";
				$runquery_g = mysqli_query($connect, $query_g) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_g))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>H</li>	
				
					<?php		
				$query_h = "SELECT * FROM `player_profile` WHERE lastname LIKE 'h%'";
				$runquery_h = mysqli_query($connect, $query_h) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_h))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>
					<li>I</li>	
				
				<?php		
				$query_i = "SELECT * FROM `player_profile` WHERE lastname LIKE 'i%'";
				$runquery_i = mysqli_query($connect, $query_i) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_i))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>J</li>
					
				<?php	
				$query_j = "SELECT * FROM `player_profile` WHERE lastname LIKE 'j%'";
				$runquery_j = mysqli_query($connect, $query_j) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_j))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>K</li>	
				
				<?php		
				$query_k = "SELECT * FROM `player_profile` WHERE lastname LIKE 'k%'";
				$runquery_k = mysqli_query($connect, $query_k) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_k))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>L</li>		
				
				<?php		
				$query_l = "SELECT * FROM `player_profile` WHERE lastname LIKE 'l%'";
				$runquery_l = mysqli_query($connect, $query_l) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_l))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>M</li>		
				
				<?php		
				$query_m = "SELECT * FROM `player_profile` WHERE lastname LIKE 'm%'";
				$runquery_m = mysqli_query($connect, $query_m) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_m))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>N</li>	
				
				<?php		
				$query_n = "SELECT * FROM `player_profile` WHERE lastname LIKE 'n%'";
				$runquery_n = mysqli_query($connect, $query_n) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_n))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>O</li>		
				
				<?php		
				$query_o = "SELECT * FROM `player_profile` WHERE lastname LIKE 'o%'";
				$runquery_o = mysqli_query($connect, $query_o) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_o))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>P</li>	
				
				<?php		
				$query_p = "SELECT * FROM `player_profile` WHERE lastname LIKE 'p%'";
				$runquery_p = mysqli_query($connect, $query_p) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_p))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>Q</li>	
				
				<?php		
				$query_q = "SELECT * FROM `player_profile` WHERE lastname LIKE 'q%'";
				$runquery_q = mysqli_query($connect, $query_q) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_q))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>R</li>		
				
				<?php		
				$query_r = "SELECT * FROM `player_profile` WHERE lastname LIKE 'r%'";
				$runquery_r = mysqli_query($connect, $query_r) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_r))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>S</li>
						
				<?php		
				$query_s = "SELECT * FROM `player_profile` WHERE lastname LIKE 's%'";
				$runquery_s = mysqli_query($connect, $query_s) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_s))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>
					
					<li>T</li>		
				
				<?php		
				$query_t = "SELECT * FROM `player_profile` WHERE lastname LIKE 't%'";
				$runquery_t = mysqli_query($connect, $query_t) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_t))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>U</li>	
				
				<?php		
				$query_u = "SELECT * FROM `player_profile` WHERE lastname LIKE 'u%'";
				$runquery_u = mysqli_query($connect, $query_u) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_u))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>V</li>	
				
				<?php		
				$query_v = "SELECT * FROM `player_profile` WHERE lastname LIKE 'v%'";
				$runquery_v = mysqli_query($connect, $query_v) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_v))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>W</li>	
				
				<?php		
				$query_w = "SELECT * FROM `player_profile` WHERE lastname LIKE 'w%'";
				$runquery_w = mysqli_query($connect, $query_w) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_w))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>X</li>	
				
				<?php		
				$query_x = "SELECT * FROM `player_profile` WHERE lastname LIKE 'x%'";
				$runquery_x = mysqli_query($connect, $query_x) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_x))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>Y</li>	
				
				<?php		
				$query_y = "SELECT * FROM `player_profile` WHERE lastname LIKE 'y%'";
				$runquery_y = mysqli_query($connect, $query_y) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_y))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<li>Z</li>	
				
				<?php		
				$query_z = "SELECT * FROM `player_profile` WHERE lastname LIKE 'z%'";
				$runquery_z = mysqli_query($connect, $query_z) or die ("Unable to run query");
				
					while ($players = mysqli_fetch_assoc($runquery_z))
					{
						echo "<li id='".$players['player_id']."'><a data-inset='true' href=/mobile/players/m.".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></li>";
					}
				?>	
					<?php
					mysqli_close($connect);
					?>
				</ul>
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