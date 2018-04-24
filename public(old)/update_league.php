<?php require_once("../include/sessions.php"); ?>
<?php require_once("../include/court.php"); ?>
<?php require_once("../include/functions.php"); ?>
<?php
	if(isset($_POST["submit"])) {
		$leagues_commish = $_POST['leagues_commish'];
		$leagues_address = $_POST['leagues_address'];
		$leagues_comp = implode(' ."', $_POST['leagues_comp']);
		$leagues_ages = implode(' ."', $_POST['leagues_age']);
		$leagues_fee = $_POST['leagues_fee'];
		$ref_fee = $_POST['ref_fee'];
		$leagues_website = $_POST['leagues_website'];
		$leagues_phone = $_POST['leagues_phone'];
		$leagues_phone = $_POST['leagues_phone'];
		$leagues_email = $_POST['leagues_email'];
		$username = $_SESSION['user'];
		$date = date("Ymd");
		
		// echo "<pre>";
		// print_r($_POST);
		// echo $_SESSION['user'];
		// echo "</pre>";
	
		$updateQuery  = "UPDATE leagues_profile "; 
		$updateQuery .= "SET leagues_address='".$leagues_address."', ";
		$updateQuery .= "leagues_website='".$leagues_website."', ";
		$updateQuery .= "leagues_email='".$leagues_email."', ";
		$updateQuery .= "leagues_phone='".$leagues_phone."', ";
		$updateQuery .= "leagues_commish='".$leagues_commish."', ";
		$updateQuery .= "leagues_fee='".$leagues_fee."', ";
		$updateQuery .= "ref_fee='".$ref_fee."', ";
		$updateQuery .= "leagues_comp='".$leagues_comp."', ";
		$updateQuery .= "leagues_age='".$leagues_ages."' ";
		$updateQuery .= "WHERE username='".$username."';";
		$admin_set = mysqli_query($connect, $updateQuery);
		confirm_query($admin_set);
		if($admin_set) {
			//rename("../mobile/players/m.".$row['player_id']."_".$row['firstname']."_".$row['lastname'].".php", $_SERVER['DOCUMENT_ROOT']."/mobile/players/m.".$row['player_id']."_".$firstname."_".$lastname.".php");
			//rename("../players/".$row['player_id']."_".$row['firstname']."_".$row['lastname'].".php", $_SERVER['DOCUMENT_ROOT']."/players/".$row['player_id']."_".$firstname."_".$lastname.".php");
			$_SESSION["message"] .= "<li class='okItem'>User update was successfull</li>";
			redirect_to("league_page.php");
		} else {
			$_SESSION["errors"] .= "<li class='errorItem'>Unable to update profile. Please try again</li>";
		}
		mysqli_close($connect);
	} else {
		$_SESSION["errors"] .= "<li class='errorItem'>Form unable to be submitted. Please try again</li>";
	}
?>