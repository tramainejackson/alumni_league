<?php
if(!isset($_POST['submit']))
{
	header ("location: totherec.php");
}
?>

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
<?php include "menu2.php";?>
<div class="registrationPage">
	<div class="profile_setup">
	<?php
		include "court.php";
		$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server ".mysqli_error($connect) );
		$username = strtolower($_POST['username']);
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		$secure_password = hash('md5', $password2);
		$league_name = ucwords(strtolower($_POST['leagues_name']));
		$league_address = ucwords(strtolower($_POST['leagues_address']));
		$website = $_POST['leagues_website'];
		$email = $_POST['leagues_email'];
		$phone = $_POST['leagues_phone'];
		$commish = $_POST['leagues_commish'];
		$leagues_comp = implode(' ', $_POST['leagues_comp']);
		$leagues_ages = implode(' ', $_POST['leagues_age']);
		$leagues_fee = $_POST['leagues_fee'];
		$ref_fee = $_POST['ref_fee'];
		$date = date("Ymd");
		$under_10 = "under_10";
		$under_12 = "under_12";
		$under_14 = "under_14";
		$under_16 = "under_16";
		$under_18 = "under_18";
		$unlimited = "unlimited";
		$over_30 = "over_30";
		$over_50 = "over_50";
		$coed = "co_ed";
		$rec = "recreational";
		$interm = "intermediate";
		$competitive = "competitive";
		$admin = "administrator@totherec.com";
		$subject = "TTR League Registration";
		$query = "SELECT * FROM test_user WHERE `username` = '$username'";
		$insert_query1 = "INSERT INTO test_user (`owner_id`, `username`, `password`, `created_date`) 
						  VALUES('', '$username', '$secure_password', '$date');";
		$result = mysqli_query($connect, $query)
				  or die("Could not run query" .mysqli_error($connect));
		$row = mysqli_fetch_assoc($result);

			if($username == "")
			{
				echo "<h3 class='error_header'>Username cannot be blank.</h3>";
				display_new_league_form();
			}
			elseif($username == $row['username'])
			{
				echo "<h3 class='error_header'>Username ".strtolower($username)." already exist</h3>";
				display_new_league_form();
			}
			elseif($password1 != $password2)
			{
				echo "<h3 class='error_header'>Your passwords did not match. Please re-enter your passwords</h3>";
				display_new_league_form();
			}

			elseif($username == $password2)
			{
				echo "<h3 class='error_header'>Your password cannot be the same as your username. ";
				display_new_league_form();
			}

			elseif($password1 == "" || $password2 == "")
			{
				echo "<h3 class='error_header'>Your password cannot be empty</h3>";
				display_new_league_form();
			}	
			elseif($league_name == $row['league_name'])
			{
				echo "<h3 class='error_header'>League Name ".strtoupper($username)." already exist</h3>";
				display_new_league_form();
			}	
			elseif(!preg_match("/^[A-Za-z0-9' -]{1,50}$/", $league_name))
			{
				echo "<h3 class='error_header'>League Name cannot be empty and must contain only letter's, hyphens and apostrophe's.</h3>";	
				display_new_league_form();	
			}	
			elseif(!preg_match("/^[A-Za-z0-9' -]{1,100}$/", $league_address))
			{
				echo "<h3 class='error_header'>League Address cannot be empty and must contain only letter's, hyphens and apostrophe's.</h3>";	
				display_new_league_form();	
			}	
			elseif($website != "")
			{
				if(!preg_match("/.+\.com$/", $website))
				{
					echo "<h3 class='error_header'>Wrong format for your website.</h3>";
					display_new_league_form();
				}
			}	
			elseif(!preg_match("/^[A-Za-z0-9' -]{1,100}$/", $commish))
			{
				echo "<h3 class='error_header'>Commissioner cannot be empty and must contain only letter's, hyphens and apostrophe's.</h3>";	
				display_new_league_form();	
			}	
			elseif($phone != "")
			{
				if(!preg_match("/^(?:1(?:[. -])?)?(?:\((?=\d{3}\)))?([2-9]\d{2})(?:(?<=\(\d{3})\))? ?(?:(?<=\d{3})[.-])?([2-9]\d{2})[. -]?(\d{4})(?: (?i:ext)\.? ?(\d{1,5}))?$/", $phone))
				{
					echo "<h3 class='error_header'>Wrong format for phone number.</h3>";
					display_new_league_form();
				}
			}
			elseif($email != "")
			{
				if(!preg_match("/.+@.+\\..+$/", $email))
				{
					echo "<h3 class='error_header'>Wrong format for email</h3>";
					display_new_league_form();
					
				}
			}	
				
				$username = mysqli_real_escape_string($connect, $username);
				$password1 = mysqli_real_escape_string($connect, $password1);
				$password2 = mysqli_real_escape_string($connect, $password2);
				$leagues_name_insert = str_ireplace(" ", "_", $league_name);
				$ttr_league_name = "/leagues/".$leagues_name_insert.".php";
				$leagues_name = mysqli_real_escape_string($connect, $league_name);
				$leagues_address = mysqli_real_escape_string($connect, $league_address);
				$website = mysqli_real_escape_string($connect, $website);
				$email = mysqli_real_escape_string($connect, $email);
				$phone = mysqli_real_escape_string($connect, $phone);
				$commish = mysqli_real_escape_string($connect, $commish);
				$username = strip_tags(trim($username));
				$password1 = strip_tags(trim($password1));
				$password2 = strip_tags(trim($password2));
				$leagues_name = strip_tags(trim($league_name));
				$leagues_address = strip_tags(trim($league_address));
				$website = strip_tags(trim($website));
				$email = strip_tags(trim($email));
				$phone = strip_tags(trim($phone));
				$commish = strip_tags(trim($commish));
				$leagues_picture = "bball_court.jpg";
				$to = $email;
				$message = "Thank you for registering a league profile with TTR, we're excited that you are taking the next step in building your league by getting it online";
				$message .= "We do have online stat keeping if you interested in allowing your players the ability to go online and see their stats, schedule and standings.";
				$message .= "Please email us at <a href='mailto:administrator@totherec.com?subject=Leagues%20Stats%20SignUp&bcc=totherec.sports@gmail.com'>administrator@totherec.com</a> ";
				$message .= "if you would like to signup for online stat keeping or if you have general questions about what you can do with you league on the site.<br><br>";
				$message .= "I look forward to hearing from you,<br><br>Tramaine";
				$message2 = "A new user has just registered for a league profile.";
				$message2 .= "See below: <br/><strong>League Name:</strong> ".$league_name."<br/><strong>Commissioner Name: ".$commish."<br/><strong>Email:</strong>".$email;
				$email_message = wordwrap($message, 70, "\r\n");
				$email_message2 = wordwrap($message2, 70, "\r\n");
				$email_headers = "MIME-Version: 1.0" . "\r\n";
				$email_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$email_headers .= "From: Admin <administrator@totherec.com>" . "\r\n";
				
				//Create individual league profile
				$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
				$filename = $DOCUMENT_ROOT."/leagues/".$leagues_name_insert.".php";
				$insert_file = $DOCUMENT_ROOT."/league_template.php";
				$new_file = file_get_contents($insert_file);
				file_put_contents($filename, $new_file);
				$variable1 = "league_name";
				$open_file = fopen($filename, "a+");
				$to_file2 = "\n$".$variable1." = \"".$leagues_name."\";\n";
				$to_file3 = "display_func($".$variable1.");\n?>\n</div>";
				$to_file3 .= "\n<script src='/scripts/jquery-2.1.1.js'>\n</script><script src='/scripts/totherec_leagues.js'></script>";
				$to_file3 .= "\n</body>\n</html>";	
				fwrite($open_file, $to_file2);	
				fwrite($open_file, $to_file3);
				fclose($open_file);
				
				//Create mobile league profile
				$filename2 = $DOCUMENT_ROOT."/mobile/leagues/m.".$leagues_name_insert.".php";
				$insert_file2 = $DOCUMENT_ROOT."/mobile/league_mobile_template.php";
				$new_file2 = file_get_contents($insert_file2);
				file_put_contents($filename2, $new_file2);
				$open_file2 = fopen($filename2, "a+");
				$to_file4 = "\n$".$variable1." = \"".$leagues_name."\";\n";
				$to_file5 = "display_func($".$variable1.");\n?>\n<footer>\n\t<p>Share With:</p>\n</footer>\n</div>\n</body>\n</html>";			
				fwrite($open_file2, $to_file4);	
				fwrite($open_file2, $to_file5);
				fclose($open_file2);
				
				//Add league to leagues list
				$filename2 = $DOCUMENT_ROOT."/leagues/league_list.txt";
				$open_file2 = fopen($filename2, "a+");
				$to_file = "\n".$league_name;
				fwrite($open_file2, $to_file);	
				fclose($open_file2);
				
				mysqli_query($connect, $insert_query1)
					or die("Could not run query1 ".mysqli_error($connect));
					
				setcookie('username', $username);		
				$testid = mysqli_insert_id($connect);	
				$insert_query2 = "INSERT INTO leagues_profile
					(`ttr_league`, `ttr_league_site`, `owner_id`, `leagues_name`, `leagues_address`, `leagues_website`, `leagues_email`, `leagues_phone`, `leagues_commish`, `leagues_fee`, 
					`ref_fee`, `leagues_comp`, `leagues_age`, `leagues_picture`, `created_date`, `username`) 
					VALUES('N', '$ttr_league_name', '$testid', '$leagues_name', '$leagues_address', '$website', '$email', '$phone', '$commish','$leagues_fee', '$ref_fee', 
					'$leagues_comp', '$leagues_ages', '$leagues_picture', '$date', '$username');";
					
				mysqli_query($connect, $insert_query2)
					or die("Could not run query2 ".mysqli_error($connect));	
					
				mysqli_close($connect);		
				
				mail($to, $subject, $email_message, $email_headers);
				mail($admin, $subject, $email_message2, $email_headers);
				echo "<p class='confirmationBoxMessage'>New Registration Sucessful</p>";
				//header ("location: index.php");
		
	?>
		</div>
		<footer>
			<p>Share With:</p>
		</footer>
	</div>
	<?php
	function display_new_league_form()
	{	
		echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
		echo "<table id='leagues_registration_table'>";
		echo "<tr><td><label for='username'>Username:</label></td>";
		echo "<td><input type='text' name='username' id='username' value = '$_POST[username]'></td></tr>"; 
		echo "<tr><td><label for='password1'>Password:</label></td>";
		echo "<td><input type='password' id='password1' name='password1'></td></tr>";
		echo "<tr><td><label for='password2'>Confirm Password:</label></td>";
		echo "<td><input type='password' id='password2' name='password2'></td></tr>";
		echo "<tr><td><label for='league_name'>League Name:</label></td>";
		echo "<td><input type='text' name='league_name' id='league_name' value = '$_POST[leagues_name]'></td></tr>";
		echo "<tr><td><label for='commish'>League Commissioner:</label></td>";
		echo "<td><input type='text' name='commish' id='commish' value = '$_POST[leagues_commish]'><td></tr>";	
		echo "<tr><td><label for='league_address'>League Address:</label></td>";
		echo "<td><input type='text' name='league_address' id='league_address' value = '$_POST[leagues_address]'></td></tr>";
		echo "<tr><td><label for='leagues_comp'>League Comp:</label></td>";
		echo "<td><select id='leagues_comp' name='leagues_comp[]' size='4' multiple>";
								if(substr_count($leagues_comp, $coed) > 0 ){
									echo "<option name='comp_level' value='co_ed' selected>Co-Ed</option>";
								}
								else
								{
									echo "<option name='comp_level' value='co_ed'>Co-Ed</option>";
								}
								if(substr_count($leagues_comp, $rec) > 0 ){
									echo "<option name='comp_level' value='recreational' selected>Just For Fun</option>";
								}
								else
								{
									echo "<option name='comp_level' value='recreational'>Just For Fun</option>";
								}
								if(substr_count($leagues_comp, $interm) > 0 ){
									echo "<option name='comp_level' value='intermediate' selected>Intermediate</option>";
								}
								else
								{
									echo "<option name='comp_level' value='intermediate'>Intermediate</option>";
								}
								if(substr_count($leagues_comp, $coed) > 0 ){
									echo "<option name='comp_level' value='competitive' selected>Competitive</option></select></td></tr>";
								}
								else
								{
									echo "<option name='comp_level' value='competitive'>Competitive</option></select></td></tr>";
								}										
		echo"<tr><td><label for='leagues_age'>Competition Age Level:</label></td>
							<td><select id='leagues_age' name='leagues_age[]' size='4' multiple>";
								if(substr_count($leagues_ages, $under_10) > 0 ){
									echo "<option name='comp_age' value='10_and_under' selected>10 and under</option>";
								}
								else
								{
									echo "<option name='comp_age' value='10_and_under'>10 and under</option>";
								}
								if(substr_count($leagues_ages, $under_12) > 0){
									echo "<option name='comp_age' value='12_and_under' selected>12 and under</option>";
								}
								else
								{
									echo "<option name='comp_age' value='12_and_under'>12 and under</option>";
								}
								if(substr_count($leagues_ages, $under_14) > 0){
									echo "<option name='comp_age' value='14_and_under' selected>14 and under</option>";
								}
								else
								{
									echo "<option name='comp_age' value='14_and_under'>14 and under</option>";
								}
								if(substr_count($leagues_ages, $under_16) > 0){
									echo "<option name='comp_age' value='16_and_under' selected >16 and under</option>";
								}
								else
								{
									echo "<option name='comp_age' value='16_and_under'>16 and under</option>";
								}
								if(substr_count($leagues_ages, $under_18) > 0){
									echo "<option name='comp_age' value='18_and_under' selected>18 and under</option>";
								}
								else
								{
									echo "<option name='comp_age' value='18_and_under'>18 and under</option>";
								}
								if(substr_count($leagues_ages, $unlimited) > 0){
									echo "<option name='comp_age' value='unlimited' selected>No Age Limit</option>";
								}
								else
								{
									echo "<option name='comp_age' value='unlimited'>No Age Limit</option>";
								}
								if(substr_count($leagues_ages, $over_30) > 0){
									echo "<option name='comp_age' value='30_and_over' selected>30 and over</option>";
								}
								else
								{
									echo "<option name='comp_age' value='30_and_over'>30 and over</option>";
								}
								if(substr_count($leagues_ages, $over_50) > 0){
									echo "<option name='comp_age' value='50_and_over' selected>50 and over</option></select></td></tr>";
								}
								else
								{
									echo "<option name='comp_age' value='50_and_over'>50 and over</option></select></td></tr>";
								}										
		echo "<tr><td><label for='leagues_fee'>League Fee:</label></td>";
		echo "<td><input type='number' name='leagues_fee' id='leagues_fee' value = '$_POST[leagues_fee]'></td></tr>";		
		echo "<tr><td><label for='ref_fee'>Ref Fee:</label></td>";
		echo "<td><input type='number' name='ref_fee' id='ref_fee' value = '$_POST[ref_fee]'></td></tr>";	
		echo "<tr><td><label for='website'>Website:</label></td>";
		echo "<td><input type='text' name='website' id='website' value = '$_POST[leagues_website]'></td></tr>";	
		echo "<tr><td><label for='phone'>phone:</label></td>";
		echo "<td><input type='text' name='phone' id='phone' value = $_POST[leagues_phone]></td></tr>";
		echo "<tr><td><label for='email'>Email:</label></td>";
		echo "<td><input type='text' name='email' id='email' value = '$_POST[leagues_email]'></td></tr></table>";
		echo "<input type='submit' name='submit' id='regLeague_btn' value='Update My League'>";
		echo "</form></div><footer><p>Share With:</p></footer></div></body></html>";
		exit;
	}
	?>
</body>
</html>