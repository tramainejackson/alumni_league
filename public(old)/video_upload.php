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
	if($_POST['submit']) {
		$video = checkNewVideo($_FILES["file"]);
		// echo"<pre>";
		// print_r($video);
		// echo"</pre>";
		if($video[0] == true) {
			$playerInfo = find_player_by_username($_SESSION["user"]);
			$query  = "INSERT INTO videos";
			$query .= "(player_id, name, nickname, file) ";
			$query .= "VALUES('".$playerInfo["player_id"]."', '".$playerInfo["firstname"]." ".$playerInfo["lastname"]."', ";
			$query .= "'".$playerInfo["nickname"]."', '".$video[1]."')";
			echo $query;
			$admin_set = mysqli_query($connect, $query);
			confirm_query($admin_set);
			if($admin_set) {
				redirect_to("player_page.php");
			} else {
				$_SESSION["errors"] .= "<li class='errorItem'></li>";
				redirect_to("player_page.php?add_video=true");
			}
		} else {
			$_SESSION["errors"] .= "<li class='errorItem'></li>";
			redirect_to("player_page.php?add_video=true");
		}
	} else {
		$_SESSION["errors"] .= "<li class='errorItem'>No form was submitted. Please try again</li>";
		redirect_to("player_page.php?add_video=true");
	}
?>