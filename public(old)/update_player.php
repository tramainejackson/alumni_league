<?php require_once("../include/initialize.php"); ?>	
<?php
	if(isset($_POST["submit"])) {
		// echo "<pre>";
		// print_r($_FILES);
		// echo "</pre>";
		$playerObj = Player_Profile::find_by_id($session->player);
		$updatePlayer = checkPlayerUpdate($_POST["firstname"], $_POST["lastname"], $_POST["nickname"], $_POST["email"], $_POST["highschool"], 
			$_POST["college"], $_POST["height"], $_POST["weight"], $_POST["rec_name"], $_POST["day_name"], $_POST["time_name"], $_POST["time_of_day"]);
		if($updatePlayer != false) {
			$playerObj->firstname = $updatePlayer[0];
			$playerObj->lastname = $updatePlayer[1];
			$playerObj->nickname = $updatePlayer[2];
			$playerObj->email = $updatePlayer[3];
			$playerObj->player_playground = $updatePlayer[8];
			$playerObj->highschool = $updatePlayer[4];
			$playerObj->college = $updatePlayer[5];
			$playerObj->height = $updatePlayer[6];
			$playerObj->weight = $updatePlayer[7];
			$playerObj->dob = $_POST["dob"];
			$playerObj->show_email = $_POST["show_email"];
			$playerObj->picture = DatabaseObject::checkNewPicture($_FILES["file"]);
			$playerObj->set_id($playerObj->get_player_id());
			
			if($playerObj->ttr_player == "Y") {
				// Seperate each league option
				$playerLeaguesInfo = explode(";", $playerObj->ttr_player_info);
				
				// Loop through each league option
				foreach($playerLeaguesInfo as $getLeaguesInfo) {
					$sepInfo = explode("_", $getLeaguesInfo);
					
					// If $sepInfo[2] is set that means that the league was declined 
					// by the player and we will skip it
					if(!isset($sepInfo[2])) {
						if($sepInfo[0] != "") {
							echo"<pre>";
							print_r($sepInfo);
							echo"</pre>";
							$leaguesID = str_ireplace("League", "", $sepInfo[0]);
							$leaguesPlayerID = str_ireplace("Player", "", $sepInfo[1]);
							$linkedPlayer = !isset($sepInfo[2]) ? League_Player::get_ttr_player_by_id($leaguesID, $leaguesPlayerID) : "";
							$linkedPlayerStat = !isset($sepInfo[2]) ? League_Stats::get_ttr_player_by_id($leaguesID, $leaguesPlayerID) : "";
							$linkedPlayerTeam = !isset($sepInfo[2]) ? League_Team::get_team_by_id($leaguesID, $linkedPlayer->get_leagues_teams_id()) : "";
							
							$linkedPlayer->player_name = $playerObj->full_name();
							$linkedPlayer->ttr_player_picture = $playerObj->picture;
							$linkedPlayer->id = $playerObj->get_player_id();
							
							if($linkedPlayer->save()) {
								if(!empty($linkedPlayerStat)) {
									if(is_array($linkedPlayerStat)) {
										foreach($linkedPlayerStat as $playerLeagueStat) {
											$playerLeagueStat->ttr_player = isset($_POST["addPlayerLeague"]) ? "Y" : "D";
											$playerLeagueStat->player_name = isset($_POST["addPlayerLeague"]) ? $playerObj->full_name() : "";
											$playerLeagueStat->ttr_player_picture = isset($_POST["addPlayerLeague"]) ? $playerObj->picture : "NULL";
											$playerLeagueStat->set_ttr_players_id(isset($_POST["addPlayerLeague"]) ? $playerObj->get_player_id() : "NULL");
											$playerLeagueStat->id = $playerLeagueStat->get_league_stat_id();
											
											if($playerLeagueStat->save()) {
												
											}
										}
									} elseif(is_object($playerLeagueStats)) {
										$playerLeagueStat = $playerLeagueStats;
										$playerLeagueStat->ttr_player = isset($_POST["addPlayerLeague"]) ? "Y" : "D";
										$playerLeagueStat->player_name = isset($_POST["addPlayerLeague"]) ? $playerObj->full_name() : "";
										$playerLeagueStat->ttr_player_picture = isset($_POST["addPlayerLeague"]) ? $playerObj->picture : "NULL";
										$playerLeagueStat->set_ttr_players_id(isset($_POST["addPlayerLeague"]) ? $playerObj->get_player_id() : "NULL");
										$playerLeagueStat->id = $playerLeagueStat->get_league_stat_id();
										
										if($playerLeagueStat->save()) {
											
										}
									}
								} else {
									
								}
							}
						}
					}
				}
			}
			
			if($playerObj->save()) {
				$session->message("<li class='okItem'>User update was successfull</li>");
				redirect_to("player_page.php");
			} else {
				$session->error("<li class='errorItem'>Unable to update profile. Please try again</li>");
				redirect_to("player_page.php");
			}
		} else {
			$session->error("<li class='errorItem'>Unable to update profile. Please try again</li>");
			redirect_to("player_page.php");
		}
	} elseif(isset($_POST["addPlayerLeague"]) || isset($_POST["declinePlayerLeague"])) {
		$playerObj = Player_Profile::find_by_id($session->player);

		$leagueID = isset($_POST["addPlayerLeague"]) ? $_POST["addPlayerLeague"] : $_POST["declinePlayerLeague"];
		
		$playerLeague = League_Player::get_player_by_email($leagueID, $playerObj->email);
		$playerLeagueStats = League_Stats::get_player_by_id($leagueID, $playerLeague->get_leagues_players_id());
		$currentLeagueInfo = $playerObj->ttr_player_info;
		$playerObj->ttr_player = "Y";
		$playerObj->set_id($playerObj->get_player_id());
		$playerLeague->ttr_player = isset($_POST["addPlayerLeague"]) ? "Y" : "D";
		$playerLeague->player_name = isset($_POST["addPlayerLeague"]) ? $playerObj->full_name() : "";
		$playerLeague->ttr_player_picture = isset($_POST["addPlayerLeague"]) ? $playerObj->picture : "NULL";
		$playerLeague->set_ttr_players_id(isset($_POST["addPlayerLeague"]) ? $playerObj->get_player_id() : "NULL");
		$playerLeague->id = $playerLeague->get_leagues_players_id();
		
		if(!substr_count($currentLeagueInfo, "_Player" . $playerLeague->get_leagues_players_id()) > 0) {
			if(isset($_POST["addPlayerLeague"])) {
				$playerObj->ttr_player_info = $currentLeagueInfo . "League" . $leagueID . "_Player" . $playerLeague->get_leagues_players_id() . ";";
			} elseif($_POST["declinePlayerLeague"]) {
				$playerObj->ttr_player_info = $currentLeagueInfo . "Decline_League" . $leagueID . "_Player" . $playerLeague->get_leagues_players_id() . ";";
			}
		}
		
		if($playerObj->save()) {
			if($playerLeague->save()) {
				if(!empty($playerLeagueStats)) {
					if(is_array($playerLeagueStats)) {
						foreach($playerLeagueStats as $playerLeagueStat) {
							$playerLeagueStat->ttr_player = isset($_POST["addPlayerLeague"]) ? "Y" : "D";
							$playerLeagueStat->player_name = isset($_POST["addPlayerLeague"]) ? $playerObj->full_name() : "";
							$playerLeagueStat->ttr_player_picture = isset($_POST["addPlayerLeague"]) ? $playerObj->picture : "NULL";
							$playerLeagueStat->set_ttr_players_id(isset($_POST["addPlayerLeague"]) ? $playerObj->get_player_id() : "NULL");
							$playerLeagueStat->id = $playerLeagueStat->get_league_stat_id();
							
							if($playerLeagueStat->save()) {
								
							}
						}
					} elseif(is_object($playerLeagueStats)) {
						$playerLeagueStat = $playerLeagueStats;
						$playerLeagueStat->ttr_player = isset($_POST["addPlayerLeague"]) ? "Y" : "D";
						$playerLeagueStat->player_name = isset($_POST["addPlayerLeague"]) ? $playerObj->full_name() : "";
						$playerLeagueStat->ttr_player_picture = isset($_POST["addPlayerLeague"]) ? $playerObj->picture : "NULL";
						$playerLeagueStat->set_ttr_players_id(isset($_POST["addPlayerLeague"]) ? $playerObj->get_player_id() : "NULL");
						$playerLeagueStat->id = $playerLeagueStat->get_league_stat_id();
						
						if($playerLeagueStat->save()) {
							
						}
					}
				} else {
					
				}
				echo "<li class='okItem'>User update was successfull</li>";
			}
		} else {
			echo "<li class='errorItem'>Unable to update profile. Please try again</li>";
		}
	} else {
		$session->error("<li class='errorItem'>Form unable to be submitted. Please try again</li>");
		redirect_to("player_page.php");
	}
?>	