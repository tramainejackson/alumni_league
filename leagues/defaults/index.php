<!DOCTYPE html>
<html lang="en-US">
<head>
<title>ToTheRec</title>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="author" content="Tramaine"/>
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<style>
#backgroundImageL {
    background-image: url("/images/mybackground1.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    width: 100%;
	height: 100%;
    position: fixed;
    min-height: 1068px;
}
</style>
</head>
<body>
<div id="backgroundImageL"></div>
<?php include "modal.php"; include "menu2.php"; ?>
<div class="container">
	<div id="leagues">
		<table id="leagues_select">
			<caption>City Leagues</caption>
			<tr>
				<th class="comp_age10 comp_age_levels"><p class="leagues_arrows leagues_arrows_10">+</p><p class="leagues_age_header">10 and Under</p><p class="leagues_arrows leagues_arrows_10">+</p></th>
				<?php
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%10%' ORDER BY leagues_name";
					$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
					$num_rows = mysqli_num_rows($runquery5);

						
					if ($num_rows > 0)
					{						
						while ($leagues = mysqli_fetch_assoc($runquery5))
						{				
							echo "<tr class='under10'><td><a target='_blank' class='under10_link leagues_link' href=leagues/".str_ireplace(" ", "_", $leagues['leagues_name']).".php>" .ucwords(strtolower($leagues['leagues_name']))."</a></td></tr>";
						}
					}	
					else
					{
						echo "<tr class=under10><td>No leagues have been added yet for this age range</td></tr>";
					}
					$close_connection = mysqli_close($connect);
				?>				
			</tr>
			<tr>
				<th class="comp_age12 comp_age_levels"><p class="leagues_arrows leagues_arrows_12">+</p><p class="leagues_age_header">12 and Under</p><p class="leagues_arrows leagues_arrows_12">+</p></th>
				<?php
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%12%' ORDER BY leagues_name";
					$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
					$num_rows = mysqli_num_rows($runquery5);

						
					if ($num_rows > 0)
					{						
						while ($leagues = mysqli_fetch_assoc($runquery5))
						{				
							echo "<tr class='under12'><td><a class='under12_link leagues_link' target='_blank' href=leagues/".str_ireplace(" ", "_", $leagues['leagues_name']).".php>" .ucwords(strtolower($leagues['leagues_name']))."</a></td></tr>";
						}
					}	
					else
					{
						echo "<tr class=under12><td>No leagues have been added yet for this age range</td></tr>";
					}
					$close_connection = mysqli_close($connect);
				?>				
			</tr>
			<tr>
				<th class="comp_age14 comp_age_levels"><p class="leagues_arrows leagues_arrows_14">+</p><p class="leagues_age_header">14 and Under</p><p class="leagues_arrows leagues_arrows_14">+</p></th>
				<?php
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%14%' ORDER BY leagues_name";
					$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
					$num_rows = mysqli_num_rows($runquery5);
						
					if ($num_rows > 0)
					{		
						while ($leagues = mysqli_fetch_assoc($runquery5))
						{				
							echo "<tr class='under14'><td><a class='under14_link leagues_link' target='_blank' href=leagues/".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a></td></tr>";
						}	
					}
					else
					{
						echo "<tr class=under14><td>No leagues have been added yet for this age range</td></tr>";
					}
					$close_connection = mysqli_close($connect);
				?>				
			</tr>	
			<tr>
				<th class="comp_age16 comp_age_levels"><p class="leagues_arrows leagues_arrows_16">+</p><p class="leagues_age_header">16 and Under</p><p class="leagues_arrows leagues_arrows_16">+</p></th>
				<?php
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%16%' ORDER BY leagues_name";
					$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
					$num_rows = mysqli_num_rows($runquery5);
						
					if ($num_rows > 0)
					{		
						while ($leagues = mysqli_fetch_assoc($runquery5))
						{				
							echo "<tr class='under16'><td><a class='under16_link leagues_link' target='_blank' href=leagues/".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a></td></tr>";
						}	
					}
					else
					{
						echo "<tr class=under16><td>No leagues have been added yet for this age range</td></tr>";
					}
					$close_connection = mysqli_close($connect);
				?>					
			</tr>
			<tr>
				<th class="comp_age18 comp_age_levels"><p class="leagues_arrows leagues_arrows_18">+</p><p class="leagues_age_header">18 and Under</p><p class="leagues_arrows leagues_arrows_18">+</p></th>
				<?php
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%18%' ORDER BY leagues_name";
					$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
					$num_rows = mysqli_num_rows($runquery5);
						
					if ($num_rows > 0)
					{		
						while ($leagues = mysqli_fetch_assoc($runquery5))
						{				
							echo "<tr class='under18'><td><a class='under18_link leagues_link' target='_blank' href=leagues/".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a></td></tr>";
						}	
					}
					else
					{
						echo "<tr class=under18><td>No leagues have been added yet for this age range</td></tr>";
					}
					$close_connection = mysqli_close($connect);
				?>					
			</tr>
			<tr>
				<th class="comp_age30 comp_age_levels"><p class="leagues_arrows leagues_arrows_30">+</p><p class="leagues_age_header">30 and Up</p><p class="leagues_arrows leagues_arrows_30">+</p></th>
				<?php
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%30%' ORDER BY leagues_name";
					$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
					$num_rows = mysqli_num_rows($runquery5);
						
					if ($num_rows > 0)
					{		
						while ($leagues = mysqli_fetch_assoc($runquery5))
						{				
							echo "<tr class='over30'><td><a class='over30_link leagues_link' target='_blank' href=leagues/".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a></td></tr>";
						}	
					}
					else
					{
						echo "<tr class=over30><td>No leagues have been added yet for this age range</td></tr>";
					}
					$close_connection = mysqli_close($connect);
				?>					
			</tr>
			<tr>
				<th class="comp_age50 comp_age_levels"><p class="leagues_arrows leagues_arrows_50">+</p><p class="leagues_age_header">50 and Up</p><p class="leagues_arrows leagues_arrows_50">+</p></th>
				<?php
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%50%' ORDER BY leagues_name";
					$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
					$num_rows = mysqli_num_rows($runquery5);
						
					if ($num_rows > 0)
					{		
						while ($leagues = mysqli_fetch_assoc($runquery5))
						{				
							echo "<tr class='over50'><td><a class='over50_link leagues_link' target='_blank' href=leagues/".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a></td></tr>";
						}	
					}
					else
					{
						echo "<tr class=over50><td>No leagues have been added yet for this age range</td></tr>";
					}
					$close_connection = mysqli_close($connect);
				?>				
			</tr>
			<tr>
				<th class="comp_age_none comp_age_levels"><p class="leagues_arrows leagues_arrows_none">+</p><p class="leagues_age_header">Unlimited</p><p class="leagues_arrows leagues_arrows_none">+</p></th>
				<?php
					$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
					$query5 = "SELECT * FROM leagues_profile WHERE leagues_age LIKE '%unlimit%' ORDER BY leagues_name";
					$runquery5 = mysqli_query($connect, $query5) or die ("Unable to run query");
					$num_rows = mysqli_num_rows($runquery5);
					
					if ($num_rows > 0)
					{		
						while ($leagues = mysqli_fetch_assoc($runquery5))
						{				
							echo "<tr class='unlimited'><td><a class='unlimited_link leagues_link' target='_blank' href=leagues/".str_ireplace(" ", "_", $leagues['leagues_name']).".php>".ucwords(strtolower($leagues['leagues_name']))."</a></td></tr>";
						}	
					}
					else
					{
						echo "<tr class=unlimited><td>No leagues have been added yet for this age range</td></tr>";
					}
					$close_connection = mysqli_close($connect);
				?>				
			</tr>							
		</table>
	</div>	
</div>
<footer>
	<p>Share With:</p>
	<div id="addtData"></div>
</footer>
<script src="/scripts/jquery-2.1.3.js"></script>
<script src="/scripts/totherec.js"></script>
</body>
</html>