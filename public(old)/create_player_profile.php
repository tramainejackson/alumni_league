<?php require_once("../include/sessions.php"); ?>
<?php require_once("../include/court.php"); ?>
<?php require_once("../include/functions.php"); ?>
<?php
	if(isset($_POST["submit"])) { 
		$date = date("Ymd");
		$registrationCheck = checkPlayerRegistration($_POST['username'], $_POST['password1'], $_POST['password2'], $_POST['firstname'], $_POST['lastname'], $_POST['nickname'], 
			$_POST['email'], $_POST['highschool'], $_POST['college'], $_POST['height'], $_POST['weight']);	
		$admin = "administrator@totherec.com";
		$subject = "TTR Player Registration";
		$email_headers = "MIME-Version: 1.0" . "\r\n";
		$email_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$email_headers .= "From: Admin <administrator@totherec.com>" . "\r\n";
		$firstname = $registrationCheck[2];
		$lastname = $registrationCheck[3];
		$nickname = $registrationCheck[4];
		$email = $registrationCheck[5];
		$highschool = $registrationCheck[6];
		$college = $registrationCheck[7];
		$height = $registrationCheck[8];
		$weight = $registrationCheck[9];
		
		if($registrationCheck != false) {
			$createAccount = createUserAccount($registrationCheck);
			if($createAccount != false) {
				$createProfile = createPlayerProfile($registrationCheck);
				if($createProfile != false) {
					$to = $email;
					//Message to new registred player profile account
					$message = "Thank you for being one of the first to register a player profile with TTR. Make sure to go to your player page and upload a picture and video flossin your skills.";
					$message .= "Click <a href='http://totherec.com/login.php'>here</a> to go to your player page and don't forget to check out other players pages.<br>";
					$message .= "<b>First Name:</b> ".$firstname."<br><b>Last Name:</b> ".$lastname."<br><b>Email:</b> ".$email."<br><b>Username:</b> ".$username;
					$email_message = wordwrap($message, 70, "\r\n");
					
					//Message to website owner for new registration notification
					$message2 = "A new user has just registered for a player profile.";
					$message2 .= "See below: <br/><strong>Name:</strong> ".$firstname." ".$lastname."<br/><strong>Email:</strong> ".$email;
					$email_message2 = wordwrap($message2, 70, "\r\n");
					
					//Send confirmation email		
					mail($to, $subject, $email_message, $email_headers);
					mail($admin, $subject, $email_message2, $email_headers);
					
					mysqli_close($connect);
					
					log_action("Create Player Profile", "New Account Created");
					redirect_to("player_page.php");
				} else {
					$_SESSION["errors"] .= "<li class='errorItem'>Profile not created</li>";
					log_action("Create Player Profile", "New Account Not Created");
					redirect_to("register.php?player_reg=true");
				}
			} else {
				$_SESSION["errors"] .= "<li class='errorItem'>Account not created</li>";
				log_action("Create Player Profile", "New Account Not Created");
				redirect_to("register.php?player_reg=true");
			}
		} else {
			$_SESSION["errors"] .= "<li class='errorItem'>Registration form has errors. Please try again</li>";
			log_action("Create Player Profile", "New Account Not Created");
			redirect_to("register.php?player_reg=true");
		}
	} else {
		$_SESSION["errors"] .= "<li class='errorItem'>Form not submitted correctly. Please try again</li>";
		redirect_to("register.php?player_reg=true");
	}
?>