<?php require_once("../include/sessions.php"); ?>
<?php require_once("../include/court.php"); ?>
<?php require_once("../include/functions.php"); ?>
<?php
	if(isset($_POST["submit"])) {			
		$date = date("Ymd");
		$registrationCheck = checkLeagueRegistration($_POST['username'], $_POST['password1'], $_POST['password2'], $_POST['leagues_name'], $_POST['leagues_commish'], $_POST['leagues_address'], 
			$_POST['leagues_email'], $_POST['leagues_phone'], $_POST['leagues_website'], $_POST['leagues_comp'], $_POST['leagues_age'], $_POST['leagues_fee'], $_POST['ref_fee']);
		$admin = "administrator@totherec.com";
		$subject = "TTR Player Registration";
		$email_headers = "MIME-Version: 1.0" . "\r\n";
		$email_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$email_headers .= "From: Admin <administrator@totherec.com>" . "\r\n";
		$name = $registrationCheck[2];
		$commish = $registrationCheck[3];
		$address = $registrationCheck[4];
		$email = $registrationCheck[5];
		$phone = $registrationCheck[6];
		$website = $registrationCheck[7];
		$comp = $registrationCheck[8];
		$ages = $registrationCheck[9];
		$fee = $registrationCheck[10];
		$ref = $registrationCheck[11];
		

		if($registrationCheck != false) {
			$createAccount = createUserAccount($registrationCheck);
			if($createAccount != false) {
				$_SESSION["message"] .= "User account created successfully";
				$createProfile = createLeagueProfile($registrationCheck);
				if($createProfile != false) {
					$to = $email;
					//Message to new registred league commish
					$message = "Thank you for registering a league profile with TTR, we're excited that you are taking the next step in building your league by getting it online";
					$message .= "We do have online stat keeping if you interested in allowing your players the ability to go online and see their stats, schedule and standings.";
					$message .= "Please email us at <a href='mailto:administrator@totherec.com?subject=Leagues%20Stats%20SignUp&bcc=totherec.sports@gmail.com'>administrator@totherec.com</a> ";
					$message .= "if you would like to signup for online stat keeping or if you have general questions about what you can do with you league on the site.<br><br>";
					$message .= "I look forward to hearing from you,<br><br>Tramaine";
					$email_message = wordwrap($message, 70, "\r\n");
					
					//Message to website owner for new registration notification
					$message2 = "A new user has just registered for a league profile.";
					$message2 .= "See below: <br/><strong>League Name:</strong> ".$league_name."<br/><strong>Commissioner Name: ".$commish."<br/><strong>Email:</strong>".$email;
					$email_message2 = wordwrap($message2, 70, "\r\n");
					
					//Send confirmation email		
					mail($to, $subject, $email_message, $email_headers);
					mail($admin, $subject, $email_message2, $email_headers);
					
					mysqli_close($connect);
					
					$_SESSION["message"] .= "League registration created successfully";
					log_action("Create League Profile", "New Account Created");
					redirect_to("league_page.php");
				} else {
					$_SESSION["errors"] .= "League registration failed to be created";
					log_action("Create League Profile", "New Account Not Created");
					redirect_to("register.php?league_reg=true");
				}
			} else {
				$_SESSION["errors"] .= "User account failed to be created";
				log_action("Create League Profile", "New Account Not Created");
				redirect_to("register.php?league_reg=true");
			}
		} else {
			$_SESSION["errors"] .= "";
			log_action("Create League Profile", "New Account Not Created");
			redirect_to("register.php?league_reg=true");
		}
	} else {
		$_SESSION["errors"] .= "Form not submitted correctly. Please try again";
		redirect_to("register.php?league_reg=true");
	}
?>