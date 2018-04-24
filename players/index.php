<!DOCTYPE html>
<html lang="en-US">
<head>
<title>ToTheRec</title>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="author" content="Guru"/>
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<style> 
#backgroundImageP {
    background-image: url("/images/background_step3.gif");
    background-repeat: no-repeat;
    background-size: 100%;
    width: 100%;
	height: 100%;
    position: fixed;
    height: 1068px;
}
</style>
</head>
<body>
<div id="backgroundImageP"></div>
<div class="playersPage">
	<table id="playersPage2">
		
		<tr><th>A</th></tr>
		
	<?php		
	$query_a = "SELECT * FROM `player_profile` WHERE lastname LIKE 'a%'";
	$runquery_a = mysqli_query($connect, $query_a) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_a))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>
	
		<tr><th>B</th></tr>
		
	<?php		
	$query_b = "SELECT * FROM `player_profile` WHERE lastname LIKE 'b%'";
	$runquery_b = mysqli_query($connect, $query_b) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_b))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>
	
		<tr><th>C</th></tr>
	
	<?php		
	$query_c = "SELECT * FROM `player_profile` WHERE lastname LIKE 'c%'";
	$runquery_c = mysqli_query($connect, $query_c) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_c))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>
		<tr><th>D</th></tr>
	
	<?php		
	$query_d = "SELECT * FROM `player_profile` WHERE lastname LIKE 'd%'";
	$runquery_d = mysqli_query($connect, $query_d) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_d))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>E</th></tr>	
	
	<?php		
	$query_e = "SELECT * FROM `player_profile` WHERE lastname LIKE 'e%'";
	$runquery_e = mysqli_query($connect, $query_e) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_e))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>F</th></tr>
		
	<?php		
	$query_f = "SELECT * FROM `player_profile` WHERE lastname LIKE 'f%'";
	$runquery_f = mysqli_query($connect, $query_f) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_f))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>G</th></tr>
	
	<?php		
	$query_g = "SELECT * FROM `player_profile` WHERE lastname LIKE 'g%'";
	$runquery_g = mysqli_query($connect, $query_g) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_g))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>H</th></tr>	
	
		<?php		
	$query_h = "SELECT * FROM `player_profile` WHERE lastname LIKE 'h%'";
	$runquery_h = mysqli_query($connect, $query_h) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_h))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>
		<tr><th>I</th></tr>	
	
	<?php		
	$query_i = "SELECT * FROM `player_profile` WHERE lastname LIKE 'i%'";
	$runquery_i = mysqli_query($connect, $query_i) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_i))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>J</th></tr>
		
	<?php	
	$query_j = "SELECT * FROM `player_profile` WHERE lastname LIKE 'j%'";
	$runquery_j = mysqli_query($connect, $query_j) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_j))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>K</th></tr>	
	
	<?php		
	$query_k = "SELECT * FROM `player_profile` WHERE lastname LIKE 'k%'";
	$runquery_k = mysqli_query($connect, $query_k) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_k))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>L</th></tr>		
	
	<?php		
	$query_l = "SELECT * FROM `player_profile` WHERE lastname LIKE 'l%'";
	$runquery_l = mysqli_query($connect, $query_l) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_l))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>M</th></tr>		
	
	<?php		
	$query_m = "SELECT * FROM `player_profile` WHERE lastname LIKE 'm%'";
	$runquery_m = mysqli_query($connect, $query_m) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_m))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>N</th></tr>	
	
	<?php		
	$query_n = "SELECT * FROM `player_profile` WHERE lastname LIKE 'n%'";
	$runquery_n = mysqli_query($connect, $query_n) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_n))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>O</th></tr>		
	
	<?php		
	$query_o = "SELECT * FROM `player_profile` WHERE lastname LIKE 'o%'";
	$runquery_o = mysqli_query($connect, $query_o) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_o))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>P</th></tr>	
	
	<?php		
	$query_p = "SELECT * FROM `player_profile` WHERE lastname LIKE 'p%'";
	$runquery_p = mysqli_query($connect, $query_p) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_p))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>Q</th></tr>	
	
	<?php		
	$query_q = "SELECT * FROM `player_profile` WHERE lastname LIKE 'q%'";
	$runquery_q = mysqli_query($connect, $query_q) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_q))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>R</th></tr>		
	
	<?php		
	$query_r = "SELECT * FROM `player_profile` WHERE lastname LIKE 'r%'";
	$runquery_r = mysqli_query($connect, $query_r) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_r))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>S</th></tr>
			
	<?php		
	$query_s = "SELECT * FROM `player_profile` WHERE lastname LIKE 's%'";
	$runquery_s = mysqli_query($connect, $query_s) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_s))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>
		
		<tr><th>T</th></tr>		
	
	<?php		
	$query_t = "SELECT * FROM `player_profile` WHERE lastname LIKE 't%'";
	$runquery_t = mysqli_query($connect, $query_t) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_t))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>U</th></tr>	
	
	<?php		
	$query_u = "SELECT * FROM `player_profile` WHERE lastname LIKE 'u%'";
	$runquery_u = mysqli_query($connect, $query_u) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_u))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>V</th></tr>	
	
	<?php		
	$query_v = "SELECT * FROM `player_profile` WHERE lastname LIKE 'v%'";
	$runquery_v = mysqli_query($connect, $query_v) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_v))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>W</th></tr>	
	
	<?php		
	$query_w = "SELECT * FROM `player_profile` WHERE lastname LIKE 'w%'";
	$runquery_w = mysqli_query($connect, $query_w) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_w))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>X</th></tr>	
	
	<?php		
	$query_x = "SELECT * FROM `player_profile` WHERE lastname LIKE 'x%'";
	$runquery_x = mysqli_query($connect, $query_x) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_x))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>Y</th></tr>	
	
	<?php		
	$query_y = "SELECT * FROM `player_profile` WHERE lastname LIKE 'y%'";
	$runquery_y = mysqli_query($connect, $query_y) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_y))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<tr><th>Z</th></tr>	
	
	<?php		
	$query_z = "SELECT * FROM `player_profile` WHERE lastname LIKE 'z%'";
	$runquery_z = mysqli_query($connect, $query_z) or die ("Unable to run query");
	
		while ($players = mysqli_fetch_assoc($runquery_z))
		{
			echo "<tr><th><a href=/players/".$players['player_id']."_".$players['firstname']."_".$players['lastname'].".php>".$players['lastname'].", ".$players['firstname']."</a></th></tr>";
		}
	?>	
		<?php
		mysqli_close($connect);
		?>
	</table>
</div>
</div>
<footer>
	<p>Share With:</p>
</footer>
<script src="/scripts/jquery-2.1.1.js"></script>
<script src="/scripts/totherec.js"></script>
</body>
</html>