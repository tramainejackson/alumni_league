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
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$nickname = $_POST['nickname'];
		$highschool = $_POST['highschool'];
		$college = $_POST['college'];
		$email = $_POST['email'];
		$height = $_POST['height'];
		$weight = $_POST['weight'];
		$username = $_COOKIE['username'];		
		
		if(isset($_POST['submit']))
		{	
			if(!preg_match("/^[A-Za-z' -]{1,50}$/", $firstname))
			{
				echo "<h3>First Name cannot be empty and must contain only letter's, hyphens and apostrophe's.</h3>";
				display_player_info();		
			}
			elseif(!preg_match("/^[A-Za-z' -]{1,50}$/", $lastname))
			{
				echo "<h3>Lastname cannot be empty and must contain only letter's, hyphens and apostrophe's.</h3>";
				display_player_info();
			}	
			elseif(($nickname != "") && (!preg_match("/^[A-Za-z0-9' -]{1,50}$/", $nickname)))
			{
				echo "<h3>Nickname can only contain letters, numbers hyphens and apostrophe's</h3>";
				display_player_info();
			}	
			elseif(($highschool != "") && (!preg_match("/^[A-Za-z' -]{1,50}$/", $highschool)))
			{
				echo "<h3>Special characters are not allowed for a highschool</h3>";
				display_player_info();
			}
			elseif(($college != "") && (!preg_match("/^[A-Za-z' -]{1,50}$/", $college)))
			{
				echo "<h3>College cannot contain special characters</h3>";
				display_player_info();
			}		
			elseif(($email != "") && (!preg_match("/.+@.+\\..+$/", $email)))
			{
				echo "<h3>Wrong format for email</h3>";
				display_player_info();
			}	
			elseif(($height != "") && (!preg_match("/^[3-8]{1}(\'[0-9]{0,2})?$/", $height)))
			{
				echo "<h3>Height format should be: #'##</h3>";
				display_player_info();
			}
			
			elseif($weight < 0)
			{
				echo "<h3>Weight cannot be negative.</h3>";
				display_player_info();						
			}
			
			elseif($weight > 799)
			{
				echo "<h3>Weight cannot be negative.</h3>";
				display_player_info();						
			}
		
			//If all the data is ok
			$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
			$username = $_COOKIE['username'];
			$firstname = mysqli_real_escape_string($connect, strip_tags(trim($firstname)));
			$lastname = mysqli_real_escape_string($connect, strip_tags(trim($lastname)));
			$nickname = mysqli_real_escape_string($connect, strip_tags(trim($nickname)));
			$highschool = mysqli_real_escape_string($connect, strip_tags(trim($highschool)));
			$college = mysqli_real_escape_string($connect, strip_tags(trim($college)));
			$weight = mysqli_real_escape_string($connect, strip_tags(trim($weight)));
			$height = mysqli_real_escape_string($connect, strip_tags(trim($height)));
			$email = mysqli_real_escape_string($connect, strip_tags(trim($email)));
			$query1 = "UPDATE `trajac4_db1`.`player_profile`
					SET `firstname` = '$firstname', 
						`lastname` = '$lastname', 
						`nickname` = '$nickname', 
						`highschool` = '$highschool', 
						`college` = '$college',	
						`weight` = '$weight',
						`height` = '$height',
						`email` = '$email'
					WHERE `username` = '$username'";
			
			mysqli_query($connect, $query1)
						or die("Could not add to database22" .mysqli_errno($connect));
			mysqli_close($connect);		
			rename($_SERVER['DOCUMENT_ROOT']."/players/".$row['player_id']."_".$row['firstname']."_".$row['lastname'].".php", $_SERVER['DOCUMENT_ROOT']."/players/".$row['player_id']."_".$firstname."_".$lastname.".php");
			rename($_SERVER['DOCUMENT_ROOT']."/mobile/players/m.".$row['player_id']."_".$row['firstname']."_".$row['lastname'].".php", $_SERVER['DOCUMENT_ROOT']."/mobile/players/m.".$row['player_id']."_".$firstname."_".$lastname.".php");
			header ("location: /mobile/players/m.".$row['player_id']."_".$firstname."_".$lastname.".php");
		}	
		?>
		</div>
	</div>		
<?php
function display_player_info()
{
	include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
	$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
	$username = $_COOKIE['username'];
	$query = "SELECT * FROM test_user WHERE `username` = '$username'";
	$result = mysqli_query($connect, $query)
			  or die("Could not run query" .mysqli_errno($connect));
	$row = mysqli_fetch_assoc($result);					
	echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
	echo "<table id='profile_validate_form'>";
	echo "<tr><td><label for='firstname'>First Name:</label></td>";
	echo "<td><input type='text' name='firstname' id='firstname' value = $_POST[firstname]></td></tr>";
	echo "<tr><td><label for='lastname'>Last Name:</label></td>";
	echo "<td><input type='text' name='lastname' id='lastname' value = $_POST[lastname]></td></tr>";
	echo "<tr><td><label for='college'>College:</label></td>";
	echo "<td><input type='text' name='college' id='college' value = $_POST[college]></td></tr>";	
	echo "<tr><td><label for='highschool'>High School:</label></td>";
	echo "<td><input type='text' name='highschool' id='highschool' value = $_POST[highschool]><td></tr>";				
	echo "<tr><td><label for='nickname'>Nickname:</label></td>";
	echo "<td><input type='text' name='nickname' id='nickname' value = $_POST[nickname]></td></tr>";
	echo "<tr><td><label for='height'>Height:</label></td>";
	echo "<td><input type='text' name='height' id='height' value = $_POST[height]><td></tr>";
	echo "<tr><td><label for='weight'>Weight:</label></td>";
	echo "<td><input type='number' name='weight' id='weight' value = '$_POST[weight]'><td></tr>";
	echo "<tr><td><label for='email'>Email:</label></td>";
	echo "<td><input type='text' name='email' id='email' value = $_POST[email]></td></tr>";
	echo "<tr><td><input type='submit' name='submit' value='Update My Profile'></td></tr>";
	echo "</table></form></div></div></body></html>";
	exit;
	}
?>
</body>
</html>