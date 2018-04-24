<?php

if(!empty($_COOKIE['username']))
{
	header ("location: /mobile/m.totherec.php");
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="handheldfriendly" content="true"/>
<link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.4.5.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/totherec.mobile.css"/>
<script src="/scripts/jquery-2.1.3.min.js"></script>
<script src="/scripts/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>				
	<?php include ($_SERVER['DOCUMENT_ROOT']. '/court.php');
	$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
	$username = strtolower($_POST['username']);
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$secure_password = hash('md5', $password2);
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$nickname = $_POST['nickname'];
	$highschool = $_POST['highschool'];
	$height = $_POST['height'];
	$weight = $_POST['weight'];
	$college = $_POST['college'];
	$email = $_POST['email'];
	$date = date("Ymd");
	$query = "SELECT * FROM test_user WHERE `username` = '$username'";
	$insert_query1 = "INSERT INTO `trajac4_db1`.`test_user` (`id`, `username`, `password`, `created_date`) 
					  VALUES('', '$username', '$secure_password', $date);";
	$result = mysqli_query($connect, $query)
			  or die("Could not run query33" .mysqli_errno($connect));
	$row = mysqli_fetch_assoc($result);


		if(isset($_POST['submit']))
		{			
			echo "<div data-role='page' class='registration_page'>";
			include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); 
			echo "<div data-role='header' data-theme='b' data-position='fixed'><h1>Player Account Registration</h1><a href='#menu_panel' class='ui-btn'>Menu</a></div>";
			echo "<div data-role='main' class='profile_setup ui-content'>";	
			if($username == "")
			{
				echo "<h3 class='error_header'>Username cannot be blank</h3>";
				display_player_info();
			}
			elseif($username == $row['username'])
			{
				echo "<h3 class='error_header'>Username ".strtolower($username)." already exist</h3>";
				display_player_info();
			}
			elseif($password1 == "" || $password2 == "")
			{
				echo "<h3 class='error_header'>Your password cannot be empty</h3>";
				display_player_info();
			}	
			elseif($password1 != $password2)
			{
				echo "<h3 class='error_header'>Your passwords did not match. Please re-enter your passwords</h3>";
				display_player_info();
			}
			elseif($username == $password2)
			{
				echo "<h3 class='error_header'>Your password cannot be the same as your username. ";
				display_player_info();
			}
			elseif(!preg_match("/[A-Za-z0-9']{1,50}/", $_POST['password1']))
			{
				echo "<h3 class='error_header'>Password must contain only letter's and numbers.</h3>";
				display_player_info();
			}	
			elseif(!preg_match("/^[A-Za-z' -]{1,50}$/", $firstname))
			{
				echo "<h3 class='error_header'>First Name cannot be empty and must contain only letter's, hyphens and apostrophe's.</h3>";
				display_player_info();		
			}
			elseif(!preg_match("/^[A-Za-z' -]{1,50}$/", $lastname))
			{
				echo "<h3 class='error_header'>Lastname cannot be empty and must contain only letter's, hyphens and apostrophe's.</h3>";
				display_player_info();
			}	
			elseif(($nickname != "") && (!preg_match("/^[A-Za-z0-9' -]{1,50}$/", $nickname)))
			{
				echo "<h3 class='error_header'>Nickname can only contain letters, numbers hyphens and apostrophe's</h3>";
				display_player_info();
			}	
			elseif(($highschool != "") && (!preg_match("/^[A-Za-z' -]{1,50}$/", $highschool)))
			{
				echo "<h3 class='error_header'>Special characters are not allowed for a highschool</h3>";
				display_player_info();
			}
			elseif(($college != "") && (!preg_match("/^[A-Za-z' -]{1,50}$/", $college)))
			{
				echo "<h3 class='error_header'>College cannot contain special characters</h3>";
				display_player_info();
			}		
			elseif(($email != "") && (!preg_match("/.+@.+\\..+$/", $email)))
			{
				echo "<h3 class='error_header'>Wrong format for email</h3>";
				display_player_info();
			}	
			elseif(($height != "") && (!preg_match("/^[0-9' ]{1,4}$/", $height)))
			{
				echo "<h3 class='error_header'>Height format should be: #'#</h3>";
				display_player_info();
			}
			
			elseif($weight < 0)
			{
				echo "<h3 class='error_header'>Only numbers allowed for weight</h3>";
				display_player_info();
			}	

			setcookie('username', $username);
			$username = mysqli_real_escape_string($connect, strip_tags(trim($username)));
			$password1 = mysqli_real_escape_string($connect, strip_tags(trim($password1)));
			$password2 = mysqli_real_escape_string($connect, strip_tags(trim($password2)));
			$firstname = mysqli_real_escape_string($connect, strip_tags(trim($firstname)));
			$lastname = mysqli_real_escape_string($connect, strip_tags(trim($lastname)));
			$nickname = mysqli_real_escape_string($connect, strip_tags(trim($nickname)));
			$highschool = mysqli_real_escape_string($connect, strip_tags(trim($highschool)));
			$college = mysqli_real_escape_string($connect, strip_tags(trim($college)));
			$height = mysqli_real_escape_string($connect, strip_tags(trim($height)));
			$weight = mysqli_real_escape_string($connect, strip_tags(trim($weight)));		
			$email = mysqli_real_escape_string($connect, strip_tags(trim($email)));
			$picture = "emptyface.jpg";
			mysqli_query($connect, $insert_query1)
				or die("Could not run query44" .mysqli_errno($connect));
				
			$testid = mysqli_insert_id($connect);	
			$insert_query2 = "INSERT INTO `player_profile` 
				(`owner_id`, `firstname`, `lastname`, `nickname`, `highschool`, `college`, `email`, `picture`, `height`, `weight`, `username`) 
				VALUES('$testid', '$firstname', '$lastname', '$nickname', '$highschool', '$college', '$email', '$picture', '$height', '$weight', 
					'$username');";
			mysqli_query($connect, $insert_query2)
				or die("Could not run query55" .mysqli_errno($connect));					
			
			$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
			$query2 = "SELECT * FROM player_profile WHERE `firstname` = '$firstname' AND `lastname` = '$lastname'";
			$query4 = "SELECT * FROM player_profile WHERE `firstname` = '$firstname' AND `lastname` = '$lastname'";
			$get_rows = mysqli_query($connect, $query2) or die ("Unable to run query" .mysqli_error($connect));
			$run_query4 = mysqli_query($connect, $query4) or die ("Unable to run query" .mysqli_error($connect));
			$num_rows = mysqli_num_rows($get_rows);
			$get_player_id = mysqli_fetch_assoc($run_query4);
			$player_id = $get_player_id['player_id'];
						
			//Create player individual page				
			$filename1 = $DOCUMENT_ROOT."/players/".$player_id."_".$firstname."_".$lastname.".php";
			$insert_file1 = $DOCUMENT_ROOT."/player_template.php";			
			$new_file1 = file_get_contents($insert_file1);
			file_put_contents($filename1, $new_file1);			
			$variable1 = "player_name";
			$open_file1 = fopen($filename1, "a+");
			$to_file2 = "\n$".$variable1." = \"".$username."\";\n";
			$to_file3 = "display_func($".$variable1.");\n?>\n</div>";
			$to_file3 .= "\n<script src='/scripts/jquery-2.1.1.js'>\n</script><script src='/scripts/totherec_leagues.js'></script>";
			$to_file3 .= "\n</body>\n</html>";	
			fwrite($open_file1, $to_file2);	
			fwrite($open_file1, $to_file3);
			fclose($open_file1);
			
			//Create player individual mobile page
			$filename2 = $DOCUMENT_ROOT."/mobile/players/m.".$player_id."_".$firstname."_".$lastname.".php";
			$insert_file2 = $DOCUMENT_ROOT."/mobile/player_mobile_template.php";
			$new_file2 = file_get_contents($insert_file2);
			file_put_contents($filename2, $new_file2);	
			$variable2 = "player_name";
			$open_file2 = fopen($filename2, "a+");
			$to_file4 = "\n$".$variable2." = \"".$username."\";\n";
			$to_file5 = "display_func($".$variable1.");\n?>\n</body>\n</html>";			
			fwrite($open_file2, $to_file4);	
			fwrite($open_file2, $to_file5);
			fclose($open_file2);
			
			//Add player name to the player list file
			$filename3 = $DOCUMENT_ROOT."/players/name_list.txt";
			$open_file3 = fopen($filename3, "a+");
			$to_file6 = "\n".$firstname. "|" .$lastname;
			fwrite($open_file3, $to_file6);	
			fclose($open_file3);			
			mysqli_close($connect);	
			header ("location: /mobile/m.totherec.php");
					
		}	
		?>

</div>
</div>
<?php
function display_player_info()
{
	echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
	echo "<table id='player_registration_table'>";
	echo "<tr><td><label for='username'>Username:</label></td>";
	echo "<td><input type='text' name='username' id='username' value = $_POST[username]></td></tr>"; 
	echo "<tr><td><label for='password1'>Password:</label></td>";
	echo "<td><input type='password' id='password1' name='password1'></td></tr>";
	echo "<tr><td><label for='password2'>Confirm Password:</label></td>";
	echo "<td><input type='password' id='password2' name='password2'></td></tr>";
	echo "<tr><td><label for='firstname'>First Name:</label></td>";
	echo "<td><input type='text' name='firstname' id='firstname' value = $_POST[firstname]></td></tr>";
	echo "<tr><td><label for='lastname'>Last Name:</label></td>";
	echo "<td><input type='text' name='lastname' id='lastname' value = $_POST[lastname]></td></tr>";
	echo "<tr><td><label for='college'>College:</label></td>";
	echo "<td><input type='text' name='college' id='college' value = $_POST[college]></td></tr>";	
	echo "<tr><td><label for='highschool'>High School:</label></td>";
	echo "<td><input type='text' name='highschool' id='highschool' value = $_POST[highschool]></td></tr>";				
	echo "<tr><td><label for='nickname'>Nickname:</label></td>";
	echo "<td><input type='text' name='nickname' id='nickname' value = $_POST[nickname]></td></tr>";
	echo "<tr><td><label for='height'>Height:</label></td>";
	echo "<td><input type='text' name='height' id='height' value = $_POST[height]></td></tr>";
	echo "<tr><td><label for='weight'>Weight:</label></td>";
	echo "<td><input type='text' name='weight' id='weight' value = $_POST[weight]></td></tr>";
	echo "<tr><td><label for='email'>Email:</label></td>";
	echo "<td><input type='text' name='email' id='email' value = '$_POST[email]'></td></tr></table>";
	echo "<input type='submit' name='submit' id='regProfile_btn' value='Register My Profile'>";
	echo "</form></div></div>";
	echo "<div data-role='page' data-dialog='true' id='contact_info'>";
	echo "<div data-role='header'><h1>Contact Us</h1></div>";
	echo "<div data-role='main' class='ui-content'>";				
	echo "<table><tr><th>Contact</th><th>Email</th></tr>";
	echo "<tr><td>Tramaine</td><td>totherec.sports@gmail.com</td></tr>";
	echo "<tr><td>BC</td><td>bcaldwell86@yahoo.com</td></tr></table></div></div>";
	echo "<div data-role='page' data-dialog='true' id='new_news'>";
	echo "<div data-role='header'><h1>News</h1></div>";
	echo "<div data-role='main' class='ui-content'><h1>Hitting The News Stands In the Near Future</h1></div></div>";
	echo "<div data-role='page' data-dialog='true' id='videos'><div data-role='header'><h1>Videos</h1></div>";
	echo "<div data-role='main' class='ui-content'><h1>Coming Soon To A Theater Near You</h1></div></div></body></html>";
	exit;
}
?>
</body>
</html>