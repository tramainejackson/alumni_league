<?php
	require_once('database.php');
	date_default_timezone_set("America/New_York");
	$date = date("Y-m-d");
	$datetime = date("Y-m-d H:i:s");
	
	function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

	function showTeams($i) {
		global $connect;
		$getSchedule = mysqli_query($connect, "SELECT * FROM leagues_schedule WHERE season_week='$i' ORDER BY game_id");
		while($showSchedule = mysqli_fetch_assoc($getSchedule))
		{
			$getTeams = array(mysqli_query($connect, "SELECT * FROM leagues_teams"),
							mysqli_query($connect, "SELECT * FROM leagues_teams"),
							mysqli_query($connect, "SELECT * FROM leagues_teams"),
							mysqli_query($connect, "SELECT * FROM leagues_teams")
						);
			$getTimes = mysqli_query($connect, "SELECT * FROM game_times");
	
			echo "<tr>
					<td>
						<select class='away_team_select teamSelect' name='away_team_select[]' disabled>";
						while($allTeams = mysqli_fetch_assoc($getTeams[0])){
							if($showSchedule['away_team'] == $allTeams['team_name']){
								echo "<option id='team".$allTeams['team_id']."' class='teamSelectOption' name='away_team'selected>".$allTeams['team_name']."</option>";
							}
							else {
								echo "<option id='team".$allTeams['team_id']."' class='teamSelectOption' name='away_team'>".$allTeams['team_name']."</option>";
							}
						}
				echo "</select>
					</td>
					<td>
						<span class='matchUpVS'>vs</span>
					</td>
					<td>
						<select class='home_team_select teamSelect' name='home_team_select[]' disabled>";
						while($allTeams = mysqli_fetch_assoc($getTeams[1])){
							if($showSchedule['home_team'] == $allTeams['team_name']){
								echo "<option id='team".$allTeams['team_id']."' class='teamSelectOption' name='home_team' selected>".$allTeams['team_name']."</option>";
							}
							else {
								echo "<option id='team".$allTeams['team_id']."' class='teamSelectOption' name='home_team'>".$allTeams['team_name']."</option>";
							}
						} 
				echo "</select></td>
					<td>
						<input type='number' name='awayTeamScore[]' class='awayTeamScore teamScore' id='' placeholder='Score' value='".$showSchedule['away_team_score']."' min='0' disabled />
					</td>
					<td>
						<input type='number' name='homeTeamScore[]' class='homeTeamScore teamScore' id='' placeholder='Score' value='".$showSchedule['home_team_score']."' min='0' disabled />
					</td>
					<td>
						<select class='game_time_select' name='game_time_select[]' disabled>";
						while($allTimes = mysqli_fetch_assoc($getTimes)){
							if($showSchedule['game_time'] == $allTimes['standard_time']){
								echo "<option name='game_time' selected>".$allTimes['standard_time']."</option>";
							}
							else{
								echo "<option name='game_time'>".$allTimes['standard_time']."</option>";
							}
						}
				echo "</select></td>
					<td><input class='game_date' name='game_date[]' type='date' value='".$showSchedule['game_date']."' disabled /></td>
					<td class='editScoreTD'><button class='editScoreBtn'>Edit Score</button></td>
					<td class='editGameTD'><button class='editGameBtn'>Edit Game</button></td>
					<td class='updateTD'><button class='updateGameBtn' disabled>Update Game</button></td>
					<td class='removeTD'><button class='removeGameBtn'>Remove Game</button></td>
					<td class='updateTD'><button class='cancelGameBtn'>Cancel Update</button></td>
					<td hidden>";
						while($allTeams = mysqli_fetch_assoc($getTeams[2]))
						{
							if($showSchedule['home_team'] == $allTeams['team_name']){
								echo "<input class='homeTeamIdInput' name='home_team_id[]' type='number' value='".$showSchedule['home_team_id']."'/>";
							}
						}	
						
						while($allTeams = mysqli_fetch_assoc($getTeams[3]))
						{
							if($showSchedule['away_team'] == $allTeams['team_name']){
								echo "<input class='awayTeamIdInput' name='away_team_id[]' type='number' value='".$showSchedule['away_team_id']."'/>";
							}
						}
						echo "<input class='gameIdInput' name='game_id[]' type='number' value='".$showSchedule['game_id']."'/>
						<input class='seasonWeekInput' name='season_week[]' type='number' value='".$showSchedule['season_week']."' />
					</td>
				</tr>";
		}		
	}
	
	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	
	function datetime_to_text($datetime="") {
	  $unixdatetime = strtotime($datetime);
	  return strftime("%B %d, %Y", $unixdatetime);
	}
	
	function datetime_to_slash($datetime="") {
	  $unixdatetime = strtotime($datetime);
	  return strftime("%m/%d/%Y", $unixdatetime);
	}
	
	function find_admin_by_id($admin_id) {
		global $connect;
		
		$safe_admin_id = mysqli_real_escape_string($connect, $admin_id);
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connect, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	function find_admin_by_username($username) {
		global $connect;
		
		$safe_username = mysqli_real_escape_string($connect, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM user_account ";
		$query .= "WHERE username = '".$safe_username."' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connect, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return false;
		}
	}
	
	function find_profile_type($username) {
		if($playerProfile = find_player_by_username($user["username"])) {
			$_SESSION["loggedIn"] = $playerProfile["firstname"] . " " . $playerProfile["lastname"];
			$_SESSION["user"] = $playerProfile["username"];
			return "player";
		} elseif($leagueProfile = find_league_by_username($user["username"])) {
			$_SESSION['loggedIn'] = $leagueProfile["leagues_commish"];
			$_SESSION["user"] = $leagueProfile["username"];
			return "league";
		} else {
			$_SESSION["errors"] = "Unable to find player or league profile";
			redirect_to("register.php?player_reg=true");
		}
	}
	
	function find_all_ages() {
		$ages = array('10_and_under', '12_and_under', '14_and_under', '16_and_under', 
			'18_and_under', 'unlimited', '30_and_over', '50_and_over');
		
		return $ages;
	}
	
	function find_all_days() {
		$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'); 
		return $days;
	}
	
	function find_competitions() {
		$comp = array('coed', 'recreational', 'intermediate', 'competitive');
		return $comp;
	}
	
	function find_alphabet() {
		$alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
			'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
		
		return $alphabet;
	}
	
	function find_all_times() {
		$times = array('1:00', '1:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '2:00', '2:30', '3:00', '3:30', 
			'4:00', '4:30', '5:00', '5:30', '6:00', '6:30', '7:00', '7:30', '8:00', '8:30', '9:00', '9:30');
		return $times;
	}

	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		if($admin != false) {
			// found player, now check password
			if(password_check($password, $admin["password"])) {
				// password matches
				$player = find_player_by_username($username);
				$league = find_league_by_username($username);
				if($league != false) {
					$_SESSION["loggedInLeague"] = $league["leagues_commish"];
					$_SESSION["user"] = $league["username"];
					return "league";
				} elseif($player != false) {
					$_SESSION["loggedInPlayer"] = $player["firstname"] . " " . $player["lastname"];
					$_SESSION["user"] = $player["username"];
					return "player";
				} else {
					$_SESSION["errors"] = "Unable to find a league profile or player profile";
					false;
				}
			} else {
				// password does not match
				$_SESSION["errors"] = "Incorrect username/password combination.";
				return false;
			}
		}	
	}
	
	function login_verification() {
		if(!isset($_SESSION["user_id"])) {
			return false;
		} else {
			return true;
		}
	}
	
	function cleanValues($values) {
		global $database;
		$returnValue = null;
		
		if(is_array($values)) {
			$returnValue = array();
			$arrayValues = $values;
			
			for($i=0; $i < count($arrayValues); $i++) {
				$newValue = $database->escape_value(trim($arrayValues[$i]));
				array_push($returnValue, $newValue);
			}
		} else {
			$returnValue = "";
			$returnValue = $database->escape_value(trim($values));
		}
		
		return $returnValue;
	}

	function display_player_info(){
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
		echo "<input type='submit' name='submit' id='regProfile_btn' value='Update My Profile'>";
		echo "</form></div></div></body></html>";
		exit;
	}
	
	function display_func($player) {
		$my_player = $player;
		$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
		$query3 = "SELECT * FROM `player_profile` WHERE `username` = '$my_player'";
		$results3 = mysqli_query($connect, $query3) or die ("Unable to run query results 3 ".mysql_error($connect));
		$row_cnt = mysqli_num_rows($results3);
		while($row3 = mysqli_fetch_assoc($results3))
		{							
			echo "<div class=playerDisplay><div class=playerInfo id=playerDemographics>";
			echo "<h2 id='about_header'>".$row3['firstname']." ";
				if($row3['nickname'] != "")
				{
					echo " \"".$row3['nickname']."\" ";
					echo $row3['lastname']."</h2>";	
				}
				else
				{
					echo " ".$row3['lastname']."</h2>";	
				}	
			
			echo "<table>";
			
			if($row3['college'] != "")
			{
				echo "<tr><td><b>College:</b> ".$row3['college']."</td></tr>";
			}
			
			if($row3['highschool'] != "")
			{
				echo "<tr><td><b>High School:</b> ".$row3['highschool']."</td></tr>";
			}

			if($row3['height'] != "")
			{
				echo "<tr><td><b>Height:</b> ".$row3['height']."</td></tr>";
			}
			
			if($row3['weight'] != 0)
			{
				echo "<tr><td><b>Weight</b>: ".$row3['weight']." lbs</td></tr>";
			}

			if($row3['age'] != 0)
			{
				echo "<tr><td><b>Age:</b> ".$row3['age']."</td></tr>";
			}

			if($row3['email'] != "")
			{
				echo "<tr><td><b>Email:</b> ".$row3['email']."</td></tr>";
			}
				echo "</table>";
			
			if(($row3['picture'] != "") && ($row3['college'] == "") && ($row3['highschool'] == "") && ($row3['nickname'] == "") 
				&& ($row3['height'] == "") && ($row3['weight'] == 0) && ($row3['age'] == 0))
			{
				echo "<div class=profilePic>";
				echo "<img id=playerPic src=/images/".$row3['picture'].">";
				echo "</div>";
			}
			else
			{
				echo "<div class=profilePic>";
				echo "<button tye='button' class='playerPic_class playerPic_btn'><a href='javascript:history.back()'>&#8666 Back</a></button>";
				echo "<img id=playerPic class='playerPic_class' src=/images/".$row3['picture'].">";
				echo "<button tye='button' class='playerPic_class playerPic_btn'><a href='javascript:history.back()'>&#8666 Back</a></button>";
				echo "</div>";
			}
				
			echo "</div>";
		}
	}

	function createPassword($value) {
		$hash_password = password_hash($value, PASSWORD_DEFAULT);
		return $hash_password;
	}
	
	function checkNewPassword($value1, $value2) {
		$values = [$value1, $value2];
		$password = cleanValues($values);
		$errors = 0;
		
		if($password[0] == "" || $password[1] == "")
		{
			$_SESSION['errors'] .= "<li class='error_item'>Password / Confirm Password cannot be empty</li>";
			$errors++;
		}	
		
		if($password[0] != $password[1])
		{
			$_SESSION['errors'] .= "<li class='error_item'>Your passwords did not match. Please re-enter your passwords</li>";
			$errors++;
		}
		
		if(strlen($password[0]) < 7) {
			$_SESSION['errors'] .= "<li class='error_item'>Password must be atleast 7 characters long</li>";
		}
		
		if(!preg_match("/[A-Za-z0-9]{7,50}/", $password[0]) && $password[0] != "")
		{
			
			$_SESSION['errors'] .= "<li class='error_item'>Password must contain only letter's and numbers</li>";
			$errors++;
		}
		
		if(!preg_match("/[A-Za-z]+/", $password[0]) && $password[0] != "")
		{
			
			$_SESSION['errors'] .= "<li class='error_item'>Password must contain at least one letter</li>";
			$errors++;
		}
		
		if(!preg_match("/[0-9]+/", $password[0]) && $password[0] != "")
		{
			
			$_SESSION['errors'] .= "<li class='error_item'>Password must contain at least one number</li>";
			$errors++;
		}
		
		if($errors > 0) {
			return $errors;
		} else {
			
			return $password[0];
		}
	}
	
	function checkNewUsername($value) {
		$username = cleanValues($value);
		$usernameDupe = find_admin_by_username($username);
		$errors = 0;
		
		if($username == "") {
			$_SESSION['errors'] .= "<li class='error_item'>Username cannot be empty</li>";
			$errors++;
		} elseif($username == $usernameDupe['username']) {
			$_SESSION['errors'] .= "<li class='error_item'>Username \"".strtolower($username)."\" already exist</li>";
			$errors++;
		} elseif(strlen($username) < 6) {
			$_SESSION['errors'] .= "<li class='error_item'>Username must be atleast 7 characters long</li>";
			$errors++;
		} elseif(strlen($username) > 25) {
			$_SESSION['errors'] .= "<li class='error_item'>Username must be not be more than 25 characters</li>";
			$errors++;
		}
		
		if($errors > 0) {
			return $errors;
		} else {
			return $username;
		}
	}
	
	function checkNewName($value1="", $value2="", $value3="") {
		$firstname = ucwords(strtolower($value1));
		$lastname = ucwords(strtolower($value2));
		$nickname = $value3;
		$names = [$firstname, $lastname, $nickname];
		$errors = 0;
		
		if($firstname == "") {
			$_SESSION['errors'] .= "<li class='error_item'>Firstname cannot be empty</li>";
			$errors++;	
		}
		
		if(!preg_match("/^[A-Za-z' -]{1,50}$/", $firstname)) {
			$_SESSION['errors'] .= "<li class='error_item'>Firstname must contain only letter's, hyphens and apostrophe's</li>";
			$errors++;	
		}
		
		if($lastname == "")	{
			$_SESSION['errors'] .= "<li class='error_item'>Lastname cannot be empty</li>";
			$errors++;
		}
		
		if(!preg_match("/^[A-Za-z' -]{1,50}$/", $lastname)) {
			$_SESSION['errors'] .= "<li class='error_item'>Lastname must contain only letter's, hyphens and apostrophe's</li>";
			$errors++;
		}	
		
		if(($nickname != "") && (!preg_match("/^[A-Za-z0-9' -]{1,50}$/", $nickname))) {
			$_SESSION['errors'] .= "<li class='error_item'>Nickname can only contain letters, numbers hyphens and apostrophe's</li>";
			$errors++;
		}
		
		if($errors > 0) {
			return $errors;
		} else {
			return $names;
		}
	}
	
	function checkNewEmail($value) {
		
		$email = cleanValues(strtolower($value));
		$errors = 0;
		
		if($email == "") {
			$_SESSION['errors'] .= "<li class='error_item'>Email cannot be empty</li>";
			$errors++;
		}
		
		if(($email != "") && (!preg_match("/.+@.+\\..+$/", $email))) {
			$_SESSION['errors'] .= "<li class='error_item'>Wrong format for email</li>";
			$errors++;
		}
		
		if($errors > 0) {
			return $errors;
		} else {
			return $email;
		}
	}
	
	function checkPlayerRegistration($usernameCheck, $password1Check, $password2Check, $firstnameCheck, $lastnameCheck, 
		$nicknameCheck, $emailCheck, $highschoolCheck, $collegeCheck, $heightCheck, $weightCheck) {
		global $connect;
		
		$username = checkNewUsername($usernameCheck);
		$password = checkNewPassword($password1Check, $password2Check);
		$name = checkNewName($firstnameCheck, $lastnameCheck, $nicknameCheck);
		$email = checkNewEmail($emailCheck);
		$highschool = $highschoolCheck;
		$college = $collegeCheck;
		$height = $heightCheck;
		$errors = 0;
		
		if($username == $password[0])
		{
			$_SESSION['errors'] .= "<li class='error_item'>Your password cannot be the same as your username</li>";
			$errors++;
		}
		
		if(($highschool != "") && (!preg_match("/^[A-Za-z' -]{1,50}$/", $highschool)))
		{
			$_SESSION['errors'] .= "<li class='error_header'>High School cannot contain special characters</li>";
			$errors++;
		}
		
		if(($college != "") && (!preg_match("/^[A-Za-z' -]{1,50}$/", $college)))
		{
			$_SESSION['errors'] .= "<li class='error_header'>College cannot contain special characters</li>";
			$errors++;
		}		
			
		if(($height != "") && (!preg_match("/^[3-7]{1}\'+[0-1]{1}([0-9]{1})*$/", $height)))
		{
			$_SESSION['errors'] .= "<li class='error_header'>Height format should be: #'##</li>";
			$errors++;
		}
		
		if($weight < 0)
		{
			$_SESSION['errors'] .= "<li class='error_header'>Only numbers allowed for weight</li>";
			$errors++;
		}
		
		if(is_numeric($username) || is_numeric($password) || is_numeric($name) || is_numeric($email) || ($errors > 0)) {
			$_SESSION["username"] =	$usernameCheck;
			$_SESSION["firstname"] = $firstnameCheck;
			$_SESSION["lastname"] = $lastnameCheck;
			$_SESSION["nickname"] = $nicknameCheck;
			$_SESSION["email"] = $emailCheck;
			$_SESSION["highschool"] = $highschoolCheck;
			$_SESSION["college"] = $collegeCheck;
			$_SESSION["height"] = $heightCheck;
			$_SESSION["weight"] = $weightCheck;
			return false;
		} else {
			$allValues = [	
							$username,
							$password,
							$name[0],
							$name[1],
							$name[2],
							$email,
							$highschool,
							$college,
							$height,
							$weight
						 ];
			return $allValues;
		}
	}
	
	function checkPlayerUpdate($firstname, $lastname, $nickname, $email, $highschool, $college, $height, $weight,
		$recname, $dayname, $timename, $timeOfDay) {
		global $connect;
		
		$name = checkNewName($firstname, $lastname, $nickname);
		$email = checkNewEmail($email);
		$highschool = $highschool;
		$college = $college;
		$height = $height;
		$recsStr = "";
		$errors = 0;
		
		for($i=0; $i < count($recname); $i++) {
			if($recname[$i] != "") {
				$recsStr .= $recname[$i] . " " . $dayname[$i] . " " . $timename[$i] . " " . $timeOfDay[$i] . "; ";
			}
		}
		
		$lastSemiPos = strrpos($recsStr, "; ");
		$recsStr = substr_replace($recsStr, "", $lastSemiPos, 2);
		
		if(($highschool != "") && (!preg_match("/^[A-Za-z' -]{1,50}$/", $highschool)))
		{
			$_SESSION['errors'] .= "<li class='error_header'>High School cannot contain special characters</li>";
			$errors++;
		}
		
		if(($college != "") && (!preg_match("/^[A-Za-z' -]{1,50}$/", $college)))
		{
			$_SESSION['errors'] .= "<li class='error_header'>College cannot contain special characters</li>";
			$errors++;
		}		
			
		if(($height != "") && (!preg_match("/^[3-7]{1}\'+[0-1]{1}([0-9]{1})*$/", $height)))
		{
			$_SESSION['errors'] .= "<li class='error_header'>Height format should be: #'##</li>";
			$errors++;
		}
		
		if($weight < 0)
		{
			$_SESSION['errors'] .= "<li class='error_header'>Only numbers allowed for weight</li>";
			$errors++;
		}
		
		if(is_numeric($name) || is_numeric($email) || ($errors > 0)) {
			return false;
		} else {
			$allValues = [	$name[0],
							$name[1],
							$name[2],
							$email,
							$highschool,
							$college,
							$height,
							$weight,
							$recsStr
						 ];
			return $allValues;
		}
	}
	
	function checkLeagueRegistration($usernameCheck, $password1Check, $password2Check, $leagueNameCheck, $commishCheck, $leagueAddressCheck, 
		$emailCheck, $phoneCheck, $websiteCheck, $compCheck, $agesCheck, $leagueFeeCheck, $refFeeCheck) {
		
		$username = checkNewUsername($usernameCheck);
		$password = checkNewPassword($password1Check, $password2Check);
		$leagueName = checkNewLeagueName($leagueNameCheck);
		$commish = $commishCheck;
		$leagueAddress = $leagueAddressCheck;
		$website = $websiteCheck;
		$email = $emailCheck;
		$phone = cleanValues($phoneCheck);
		$leagues_comp = implode(" ", $compCheck);
		$leagues_ages = implode(" ", $agesCheck);
		$leaguesFee = cleanValues($leagueFeeCheck);
		$refFee = cleanValues($refFeeCheck);
		$errors = 0;
		
		if(!preg_match("/^[A-Za-z0-9' -]{1,100}$/", $commish))
		{
			$_SESSION['errors'] .= "<li class='error_header'>Commissioner cannot be empty.</li>";	
			$errors++;
		}
		if(!preg_match("/^[A-Za-z0-9' -]{1,100}$/", $leagueAddress))
		{
			$_SESSION['errors'] .= "<li class='error_header'>League Address cannot be empty.</li>";	
			$errors++;
		}
		if(($email != "") && (!preg_match("/.+@.+\\..+$/", $email))) {
			$_SESSION['errors'] .= "<li class='error_item'>Wrong format for email</li>";
			$errors++;
		}
		if($phone != "" && (!preg_match("/^(?:1(?:[. -])?)?(?:\((?=\d{3}\)))?([2-9]\d{2})(?:(?<=\(\d{3})\))? ?(?:(?<=\d{3})[.-])?([2-9]\d{2})[. -]?(\d{4})(?: (?i:ext)\.? ?(\d{1,5}))?$/", $phone)))
		{
			$_SESSION['errors'] .= "<li class='error_header'>Wrong format for phone number.</li>";
			$errors++;
		}
		if($website != "" && (!preg_match("/.+\.com$/", $website)))
		{
			$_SESSION['errors'] .= "<li class='error_header'>Wrong format for your website.</li>";
			$errors++;
		}
		if(is_numeric($username) || is_numeric($password) || is_numeric($email) || ($errors > 0)) {
			$_SESSION["username"] =	$usernameCheck;
			$_SESSION["leagues_name"] = $leagueNameCheck;
			$_SESSION["leagues_commish"] = $commishCheck;
			$_SESSION["leagues_address"] = $leagueAddressCheck;
			$_SESSION["leagues_email"] = $emailCheck;
			$_SESSION["leagues_phone"] = $phoneCheck;
			$_SESSION["leagues_website"] = $websiteCheck;
			$_SESSION["leagues_fee"] = $leagueFeeCheck;
			$_SESSION["ref_fee"] = $refFeeCheck;
			return false;
		} else {
			$allValues = [	
							$username,
							$password,
							$leagueName,
							$commish,
							$leagueAddress,
							$email,
							$phone,
							$website,
							$leagues_comp,
							$leagues_ages,
							$leaguesFee,
							$refFee
						 ];
			return $allValues;
		}
	}
	
	function createUserAccount($arrayValue) {
		global $connect;
		$timestamp = date("Y-m-d H:i:s");
		$hashed_password = createPassword($arrayValue[1]);
		$query  = "INSERT INTO user_account";
		$query .= "(username, password, created_date) ";
		$query .= "VALUES ('".$arrayValue[0]."', '".$hashed_password."', '".$timestamp."'); ";
		$admin_set = mysqli_query($connect, $query);
		
		if(confirm_query($admin_set)) {
			$_SESSION["user"] = $arrayValue[0];
			$_SESSION["message"] .= "<li class='okItem'>User account created successfully</li>";
			return $arrayValue[0];
		} else {
			$_SESSION["errors"] .= "<li class='errorItem'>User account failed to be created</li>";
			return false;
		}
	}
	
	function createMobilePlayerPage() {
		$filename = $DOCUMENT_ROOT."/mobile/players/m.".$player_id."_".$firstname."_".$lastname.".php";
		$template = $DOCUMENT_ROOT."/mobile/player_mobile_template.php";
		$new = file_exists($filename) ? false : true;

		if($new) {
			$template = file_get_contents($DOCUMENT_ROOT."/player_template.php");
			$template = str_ireplace("*TripLocation*", $location, $template);
			$template = str_ireplace("*TripLocationID*", str_ireplace(" ", "_", strtolower($location)), $template);
			file_put_contents($filename, $template);
		} else {
				echo "Unable to create file, this account already exist";
		}
	}

	function sortArray($a, $b) {
		if ($a==$b) return 0;
		return ($b<$a)?-1:1;
	}
	
	function log_action($action, $message="") {
		$logfile = "../files/logs.txt";
		$new = file_exists($logfile) ? false : true;
		$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		if($handle = fopen($logfile, "a")) {
			$content = $timestamp . " | " . $action . ": " . $message . "\n";
			fwrite($handle, $content);
			fclose($handle);
			if($new) {
				$handle = fopen($logfile, "w");
				$content = $timestamp . " | " . $action . ": " . $message . "\n";
				fwrite($handle, $content);
				fclose($handle);
			} 
		} else {
				echo "Unable to create file";
		}
	}

	function __autoload($class_name) {
		$class_name = strtolower($class_name);
		$path = "../includes/{$class_name}.php";
		if(file_exists($path)) {
		require_once($path);
		} else {
			die("The file {$class_name}.php could not be found.");
		}
	}

?>
