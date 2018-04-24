<?php require_once("../include/sessions.php"); ?>
<?php require_once("../include/court.php"); ?>
<?php require_once("../include/functions.php"); ?>
<?php 
	if(login_verification()) {
		if($leagueProfile = find_league_by_username($_SESSION["user"])) {
			$_SESSION["loggedInLeague"] = $leagueProfile["leagues_commish"];
			$_SESSION["user"] = $leagueProfile["username"];
			redirect_to("league_page.php");
		}
	} else {
		$_SESSION["errors"] .= "<li class='errorItem'>Login before accessing this page</li>";
		redirect_to("login.php");
	}
?>
<?php
	if(isset($_POST["submit"])) { 
		$video_id = $_POST["remove_video_id"];
		$playerInfo = find_player_by_username($_SESSION["user"]);
		$videoInfo = find_video_by_id($video_id);
		$logMsg = "Video#: " .$video_id. ", Uploaded By: " .$_SESSION["loggedInPlayer"];
		$deleteQuery  = "DELETE FROM videos ";
		$deleteQuery .= "WHERE player_id='".$playerInfo["player_id"]."' ";
		$deleteQuery .= "AND upload_id='".$video_id."';";
		
		$admin_set = mysqli_query($connect, $deleteQuery);
		confirm_query($admin_set);
		if($admin_set) {
			if(unlink("../uploads/".$videoInfo["file"])) {
				log_action("Delete Video", $logMsg);
				$_SESSION["message"] .= "Video deleted successfully.";
				redirect_to("player_page.php");
			} else {
				$_SESSION["errors"] .= "<li class='errorItem'>Unable to remove video from directory.</li>";
				redirect_to("player_page.php?remove_video=true");
			}
		} else {
			$_SESSION["errors"] .= "<li class='errorItem'>Unable to remove video to the database.</li>";
			redirect_to("player_page.php?remove_video=true");
		}
		
	} else {
		$_SESSION["errors"] .= "<li class='errorItem'>User not logged in or video has not been removed.</li>";
		redirect_to("player_page.php?remove_video=true");
	}
?>