<?php require_once("../include/initialize.php"); ?>
<?php if(login_verification() == true) { redirect_to("player_page.php"); } ?>
<?php require_once("../include/header.php"); ?>
<body>
	<?php require_once("../public/modal.php"); ?>
	<?php require_once("../public/about.html"); ?>
	<?php //$session->showSessionMessage(); ?>
	<?php require_once("menu.php"); ?>
	<div class="container" id="registrationPageContainer">
		<?php if(isset($_GET["league_reg"])) { ?>
		<div id="registerPage">
			<div id="league_registration" class="registrationPage">
				<div class="profile_setup">
					<h3 class="registration_header">Create League Account</h3>
					<form id="leagueRegisterForm" name="form1" method="POST" action="create_league_profile.php">
						<table id="leagues_registration_table">
							<tr>
								<td><input type="text" id="username" name="username" placeholder="Username" value="<?php echo isset($_SESSION["username"]) ? $_SESSION["username"]  : ""; ?>" autofocus></td>
							</tr>
							<tr>
								<td><input type="password" id="password1" name="password1" placeholder="Password"></td>
							</tr>
							<tr>
								<td><input type="password" id="password2" name="password2" placeholder="Confirm Password"></td>
							</tr>
							<tr>
								<td><input type="text" id="leagues_name" name="leagues_name" placeholder="League Name" value="<?php echo isset($_SESSION["leagues_name"]) ? $_SESSION["leagues_name"]  : ""; ?>" /></td>
							</tr>
							<tr>
								<td><input type="text" id="leagues_commish" name="leagues_commish" placeholder="League Commissioner" value="<?php echo isset($_SESSION["leagues_commish"]) ? $_SESSION["leagues_commish"]  : ""; ?>" /></td>
							</tr>	
							<tr>
								<td><input type="text" id="leagues_address" name="leagues_address" placeholder="League Address" value="<?php echo isset($_SESSION["leagues_address"]) ? $_SESSION["leagues_address"]  : ""; ?>" /></td>
							</tr>
							<tr>
								<td><input type="email" id="leagues_email" name="leagues_email" placeholder="League Email" value="<?php echo isset($_SESSION["leagues_email"]) ? $_SESSION["leagues_email"]  : ""; ?>" /></td>
							</tr>
							<tr>
								<td><input type="text" id="leagues_phone" name="leagues_phone" placeholder="League Phone Number" value="<?php echo isset($_SESSION["leagues_phone"]) ? $_SESSION["leagues_phone"]  : ""; ?>" /></td>
							</tr>
							<tr>
								<td><input type="text" id="leagues_website" name="leagues_website" placeholder="League Website" value="<?php echo isset($_SESSION["leagues_website"]) ? $_SESSION["leagues_website"]  : ""; ?>" /></td>
							</tr>
							<tr>
								<td><select size="3" id="leagues_comp" name="leagues_comp[]" placeholder="League Competition Level" multiple>
									<option name="comp_level" value="default" disabled>Competition Level</option>
									<option name="comp_level" value="co_ed" selected>Co-Ed</option>
									<option name="comp_level" value="recreational">Recreational</option>
									<option name="comp_level" value="intermediate">Intermediate</option>							
									<option name="comp_level" value="competitive">Competitive</option>
								</select></td>
							</tr>
							<tr>
								<td><select size="3" id="leagues_age" name="leagues_age[]"  placeholder="League Age Level" multiple>
									<option name="comp_age" value="default" disabled>Competition Age Level</option>
									<option name="comp_age" value="10_and_under" selected>10 and under</option>
									<option name="comp_age" value="12_and_under">12 and under</option>
									<option name="comp_age" value="14_and_under">14 and under</option>							
									<option name="comp_age" value="16_and_under">16 and under</option>
									<option name="comp_age" value="18_and_under">18 and under</option>
									<option name="comp_age" value="unlimited">No Age Limit</option>
									<option name="comp_age" value="30_and_over">30 and over</option>
									<option name="comp_age" value="50_and_over">50 and over</option>
								</select></td>
							</tr>
							<tr>
								<td><input type="number" id="leagues_fee" name="leagues_fee" placeholder="League Entry Fee" value="<?php echo isset($_SESSION["leagues_fee"]) ? $_SESSION["leagues_fee"]  : ""; ?>" max="5000" min="0" /></td>
							</tr>					
							<tr>
								<td><input type="number" id="ref_fee" name="ref_fee" placeholder="League Referee Fee" value="<?php echo isset($_SESSION["ref_fee"]) ? $_SESSION["ref_fee"]  : ""; ?>" max="500" min="0" /></td>
							</tr>
						</table>
						<input type="submit" name="submit" id="regLeague_btn" value="Register My League">	
					</form>
					<a id="player_reg_link" class="changeRegistrationLink" href="register.php?player_reg=true">Register Player Profile</a>
				</div>
			</div>
		<?php } else { ?>
			<div id="player_registration" class="registrationPage">
				<div id="profile_setup1" class="profile_setup">
					<h3 class="registration_header">Create Player Profile</h3>
					<form name="form2" id="playerRegisterForm" method="POST" action="create_player_profile.php">
						<table id="player_registration_table">
							<tr>
								<td><input type="text" id="username" name="username" placeholder="Username" value="<?php echo isset($_SESSION["username"]) ? $_SESSION["username"]  : ""; ?>" autofocus /></td>
							</tr>				
							<tr>
								<td><input type="password" id="password1" name="password1" placeholder="Password" /></td>
							</tr>				
							<tr>
								<td><input type="password" id="password2" name="password2" placeholder="Confirm Password" /></td>
							</tr>					
							<tr>
								<td><input type="text" id="firstname" name="firstname" placeholder="Firstname" value="<?php echo isset($_SESSION["firstname"]) ? $_SESSION["firstname"] : ""; ?>" /></td>
							</tr>
							<tr>
								<td><input type="text" id="lastname" name="lastname" placeholder="Lastname" value="<?php echo isset($_SESSION["lastname"]) ? $_SESSION["lastname"] : ""; ?>" /></td>
							</tr>
							<tr>
								<td><input type="text" id="nickname" name="nickname" placeholder="Nickname" value="<?php echo isset($_SESSION["nickname"]) ? $_SESSION["nickname"] : ""; ?>" /></td>
							</tr>
							<tr>
								<td><input type="email" id="email" name="email" placeholder="Email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : ""; ?>" /></td>
							</tr>
							<tr>
								<td><input type="text" id="highschool" name="highschool" placeholder="High School" value="<?php echo isset($_SESSION["highschool"]) ? $_SESSION["highschool"] : ""; ?>" /></td>
							</tr>					
							<tr>
								<td><input type="text" id="college" name="college" placeholder="College" value="<?php echo isset($_SESSION["college"]) ? $_SESSION["college"] : ""; ?>" /></td>
							</tr>
							<tr>
								<td><input type="text" id="height" name="height" placeholder="Height" value="<?php echo isset($_SESSION["height"]) ? $_SESSION["height"] : ""; ?>" /></td>
							</tr>				
							<tr>
								<td><input type="number" id="weight" name="weight" placeholder="Weight" value="<?php echo isset($_SESSION["weight"]) ? $_SESSION["weight"] : ""; ?>" max="500" min="0"/></td>
							</tr>					
						</table>
						<input type="submit" name="submit" id="regProfile_btn" value="Register My Profile" />
					</form>
					<a id="league_reg_link" class="changeRegistrationLink" href="register.php?league_reg=true">Register League Account</a>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php require_once("../include/footer.php"); ?>
	<?php $_SESSION["username"] = null; ?>
	<?php $_SESSION["firstname"] = null; ?>
	<?php $_SESSION["lastname"] = null; ?>
	<?php $_SESSION["nickname"] = null; ?>
	<?php $_SESSION["email"] = null; ?>
	<?php $_SESSION["highschool"] = null; ?>
	<?php $_SESSION["college"] = null; ?>
	<?php $_SESSION["height"] = null; ?>
	<?php $_SESSION["weight"] = null; ?>
	<?php $_SESSION["leagues_name"] = null; ?>
	<?php $_SESSION["leagues_commish"] = null; ?>
	<?php $_SESSION["leagues_address"] = null; ?>
	<?php $_SESSION["leagues_phone"] = null; ?>
	<?php $_SESSION["leagues_website"] = null; ?>
	<?php $_SESSION["leagues_email"] = null; ?>
	<?php $_SESSION["ref_fee"] = null; ?>
	<?php $_SESSION["leagues_fee"] = null; ?>
</body>
</html>