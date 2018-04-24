<!DOCTYPE html>
<html lang="en-US">
<head>
<title>League Registration</title>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="viewport" content="width=device-width, intial-scale=1">
<meta name="author" content="Guru"/>
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<script src="/scripts/jquery-2.1.1.js"></script>
<script src="/scripts/totherec_2.js"></script>
</head>
<body>
	<div data-role="page" id="leagues_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>My League Information</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>			
		<div data-role="main" class="ui-content">
				<?php
				include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
				$username = $_COOKIE['username'];
				$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
				$leagues_commish = $_POST['leagues_commish'];
				$leagues_address = $_POST['leagues_address'];
				$leagues_fee = $_POST['leagues_fee'];
				$ref_fee = $_POST['ref_fee'];
				$leagues_website = $_POST['leagues_website'];
				$leagues_phone = $_POST['leagues_phone'];
				$leagues_phone = $_POST['leagues_phone'];
				$leagues_email = $_POST['leagues_email'];
				$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
				$query = "SELECT * FROM leagues_profile WHERE `username` = '$username'";			  
				$result = mysqli_query($connect, $query)
					  or die("Could not run query" .mysqli_errno($connect));
				$row = mysqli_fetch_assoc($result);
				$date = date("Ymd");

				if(isset($_POST['submit']))
				{
					if(!preg_match("/^[A-Za-z0-9' -]{1,50}$/", $leagues_commish))
					{
						echo "<h3>Commissioner cannot be empty and must contain only letter's, hyphens and apostrophe's.</h3>";	
						display_league_info();
					}
					elseif(!preg_match("/^[A-Za-z0-9' -.]{1,100}$/", $leagues_address))
					{
						echo "<h3>League Address cannot be empty and must contain only letter's, hyphens and apostrophe's.</h3>";
						display_league_info();
					}	
					elseif($leagues_fee < 0)
					{
						echo "<h3>League Fee cannot be negative</h3>";
						display_league_info();
					}
					elseif($ref_fee < 0)
					{
						echo "<h3>Ref fee cannot be negative.</h3>";
						display_league_info();
					}	
					elseif($leagues_website != "")
					{
						if(!preg_match("/.+\.com$/", $leagues_website))
						{
							echo "<h3>Wrong format for your website.</h3>";
							display_league_info();
						}
					}		
					elseif($leagues_phone != "")
					{
						if(!preg_match("/^[0-9]{3}\-[0-9]{3}\-[0-9]{4}$/", $leagues_phone))
						{
							echo "<h3>Wrong format for phone number. Ex: XXX-XXX-XXXX</h3>";
							display_league_info();
						}
					}
					elseif($leagues_email != "")
					{
						if(!preg_match("/.+@.+\\..+$/", $leagues_email))
						{
							echo "<h3>Wrong format for email</h3>";
							display_league_info();
						}
					}
				}
						$leagues_address = mysqli_real_escape_string($connect, $leagues_address);
						$leagues_website = mysqli_real_escape_string($connect, $leagues_website);
						$leagues_email = mysqli_real_escape_string($connect, $leagues_email);
						$leagues_phone = mysqli_real_escape_string($connect, $leagues_phone);
						$leagues_commish = mysqli_real_escape_string($connect, $leagues_commish);
						$leagues_address = strip_tags(trim($leagues_address));
						$leagues_website = strip_tags(trim($leagues_website));
						$leagues_email = strip_tags(trim($leagues_email));
						$leagues_phone = strip_tags(trim($leagues_phone));
						$leagues_commish = strip_tags(trim($leagues_commish));	
						
						$update_query2 = "UPDATE `trajac4_db1`.`leagues_profile`
									SET `leagues_address` = '$leagues_address', 
										`leagues_website` = '$leagues_website', 
										`leagues_email` = '$leagues_email', 
										`leagues_phone` = '$leagues_phone', 
										`leagues_commish` = '$leagues_commish',	
										`leagues_fee` = '$leagues_fee',
										`ref_fee` = '$ref_fee'
									WHERE `username` = '$username'";	
							
						mysqli_query($connect, $update_query2)
							or die("Could not run query2 " .mysqli_error($connect));	
							
						mysqli_close($connect);		
						header ("location: /mobile/leagues/m.".str_ireplace(" ", "_", $row['leagues_name']).".php");
								
				?>
			</div>
		</div>
	
	<?php 
	function display_league_info(){
	include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
	$username = $_COOKIE['username'];
	$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
	$query = "SELECT * FROM leagues_profile WHERE `username` = '$username'";			  
	$result = mysqli_query($connect, $query)
		  or die("Could not run query" .mysqli_errno($connect));
	$row = mysqli_fetch_assoc($result);
	echo "<form name='form2' id='form2' action='$_SERVER[PHP_SELF]' method='POST'>";
	echo "<table id='leagues_validate_form'>";
	echo "<tr><td><label for='leagues_name'>League Name:</label></td>";
	echo "<td><input type='text' name='leagues_name' id='leagues_name' value = '$row[leagues_name]' disabled></td></tr>";
	echo "<tr><td><label for='commish'>League Commissioner:</label></td>";
	echo "<td><input type='text' name='leagues_commish' id='leagues_commish' value = '$_POST[leagues_commish]'><td></tr>";
	echo "<tr><td><label for='leagues_address'>League Address:</label></td>";
	echo "<td><input type='text' name='leagues_address' id='leagues_address' value = '$_POST[leagues_address]'></td></tr>";										
	echo "<tr><td><label for='leagues_fee'>League Fee:</label></td>";
	echo "<td><input type='number' name='leagues_fee' id='leagues_fee' value = '$_POST[leagues_fee]'></td></tr>";		
	echo "<tr><td><label for='ref_fee'>Ref Fee:</label></td>";
	echo "<td><input type='number' name='ref_fee' id='ref_fee' value = '$_POST[ref_fee]'></td></tr>";	
	echo "<tr><td><label for='website'>Website:</label></td>";
	echo "<td><input type='text' name='leagues_website' id='leagues_website' value = '$_POST[leagues_website]'></td></tr>";	
	echo "<tr><td><label for='phone'>Phone:</label></td>";
	echo "<td><input type='text' name='leagues_phone' id='leagues_phone' value = '$_POST[leagues_phone]'></td></tr>";	
	echo "<tr><td><label for='email'>Email:</label></td>";
	echo "<td><input type='text' name='leagues_email' id='leagues_email' value = '$_POST[leagues_email]'></td></tr></table>";		
	echo "<input class='ui-btn' type='submit' name='submit' id='regLeague_btn' value='Update My League'></form>";
	exit;
	}

	mysqli_close($connect);		
	?>
</body>
</html>