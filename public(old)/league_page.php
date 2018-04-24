<?php require_once("../include/initialize.php"); ?>
<?php 
	if(login_verification()) { 
		if(!empty($player = Player_Profile::find_by_sql("SELECT * FROM player_profile WHERE user_account_id = '$session->user_id';"))) {
			redirect_to("player_page.php");
		} else {
			$leagueProfile = League_Profile::find_by_sql("SELECT * FROM leagues_profile WHERE user_account_id = '$session->user_id';");
		}
	} else {
		$_SESSION["errors"] = "Login before accessing the profile page.";
		redirect_to("login.php");
	}
?>
<?php require_once("../include/header.php"); ?>
<body>
	<?php require_once("../public/modal.php"); ?>
	<?php require_once("../public/about.html"); ?>
	<?php require_once("menu.php"); ?>
	<div class="container" id="leaguesProfileContainer">
		<div class="updatePage">
			<h1 class=""><?php echo $leagueProfile->leagues_name; ?></h1>
			<form name="form2" id="form2" onsubmit="return validate_league_info();" action="update_league.php" method="POST" enctype="multipart/form-data">
				<div id="update_pic" class="updateLeagueForm">
					<img id="current_pic" src="../uploads/<?php echo $leagueProfile->leagues_picture; ?>">
					<span class="changeSpan">Change Photo</span>
					<input type="file" name="file" id="file">
				</div>
				<div class="updateLeagueForm">
					<table id="leagues_validate_form">
						<tr>
							<td><input type="text" name="leagues_name" id="leagues_name" placeholder="League Name" value="<?php echo $leagueProfile->leagues_name; ?>" disabled></td>
						</tr>
						<tr>
							<td><input type="text" name="leagues_commish" id="leagues_commish" placeholder="Commissioner" value="<?php echo $leagueProfile->leagues_commish; ?>"><td>
						</tr>
						<tr>
							<td><input type="text" name="leagues_address" id="leagues_address" placeholder="Address" value="<?php echo $leagueProfile->leagues_address; ?>"></td>
						</tr>
						<tr>
							<td><input type="text" name="leagues_phone" id="leagues_phone" placeholder="Phone" value="<?php echo $leagueProfile->leagues_phone; ?>"></td>
						</tr>
						<tr>
							<td><input type="text" name="leagues_email" id="leagues_email" placeholder="Email" value="<?php echo $leagueProfile->leagues_email; ?>"</td>
						</tr>
						<tr>
							<td><input type="text" name="leagues_website" id="leagues_website" placeholder="Website" value="<?php echo $leagueProfile->leagues_website; ?>"></td>
						</tr>
						<tr>
							<td><input type="number" name="leagues_fee" id="league_fee" placeholder="League Fee" value="<?php echo $leagueProfile->leagues_fee; ?>"></td>
						</tr>
						<tr>
							<td><input type="number" name="ref_fee" id="ref_fee" placeholder="Ref Fee" value="<?php echo $leagueProfile->ref_fee; ?>"></td>
						</tr>
						<tr>
							<td>
								<select class="" name="leagues_comp[]" size="3" multiple>
									<option value="blank">------ League Competition ------</option>
									<?php $ages = find_all_ages(); ?>
									<?php $ageArray =  explode(" ", $leagueProfile->leagues_age);?>
									<?php foreach($ages as $age) { ?>
										<?php if(in_array($age, $ageArray)) { ?>
											<option value="<?php echo $age; ?>" selected><?php echo str_ireplace("_", " ", ucwords($age)); ?></option>
										<?php } else { ?>
											<option value="<?php echo $age; ?>"><?php echo str_ireplace("_", " ", ucwords($age)); ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<select class="" name="leagues_age[]" size="3" multiple>
									<option value="blank">---------- League Ages ----------</option>
									<?php $getComp = find_competitions(); ?>
									<?php $compArray =  explode(" ", $leagueProfile->leagues_comp);?>
									<?php foreach($getComp as $showComp) { ?>
										<?php if(in_array($showComp, $compArray)) { ?>
											<option value="<?php echo $showComp; ?>" selected><?php echo str_ireplace(" ", "", ucwords(str_ireplace("_", " ", $showComp))); ?></option>
										<?php } else { ?>
											<option value="<?php echo $showComp; ?>"><?php echo str_ireplace(" ", "", ucwords(str_ireplace("_", " ", $showComp))); ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<input type="submit" name="submit" id="regLeague_btn" value="Update My League" />
			</form>
		</div>
	</div>
	<?php require_once("../include/footer.php"); ?>
</body>
</html>