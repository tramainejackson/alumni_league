<?php require_once("../include/initialize.php"); ?>
<?php require_once("../include/header.php"); ?>
<body>
	<div id="backgroundImageP"></div>
	<div class="container-fluid" id="playerProfileContainer">
		<h2 id="player_page_header" class="page_header">ToTheRec Players</h2>
		<div class="alphabetClass">
			<?php $showLetter = find_alphabet(); ?>
			<?php for($i=0; $i < count($showLetter); $i++) { ?>
				<?php $getPlayersWithLastName = Player_Profile::get_player_profiles_by_letter(strtolower($showLetter[$i])); ?>
				<?php if(!empty($getPlayersWithLastName)) { ?>
					<div class="hasPlayers">
						<a href="players.php?filter=<?php echo strtolower($showLetter[$i]); ?>"><?php echo $showLetter[$i]; ?></a>
					</div>
				<?php } else { ?>
					<div class="noPlayers">
						<a href="#"><?php echo $showLetter[$i]; ?></a>
					</div>
				<?php } ?>	
			<?php } ?>
		</div>
		<?php if(isset($_GET["player"])) { ?>
			<?php $showProfile = Player_Profile::find_player_by_id($_GET["num"]); ?>
			<div class="playerDisplay">
				<div class="search_box">
					<input class="player_search" name="search" type="search" placeholder="Search Player"/>				
					<a class="addFilter" href="#">Search</a>
				</div>
				<div class="playerPageInfo" id="player_demographics">
					<div class="playerPagePic">
						<img id="playerPic" class="playerPic_class" src="../uploads/<?php echo $showProfile->picture; ?>">
					</div>
					<div class="playerPageBioHeader">
						<h2 id="contact_header"><?php echo $showProfile->nickname != "" ? $showProfile->firstname. " \"".$showProfile->nickname."\" " .$showProfile->lastname : $showProfile->full_name();; ?></h2>
						<h3 id="contact_header2" class=""><?php echo $showProfile->height != "" ? "<span>Height: " . $showProfile->height . "</span>" : ""; ?><?php echo $showProfile->weight > 0 ? "<span>Weight: " . $showProfile->weight . " lbs.</span>" : ""; ?></h3>
					</div>
					<div class="playerPageBio">
						<table>
								<tr>
									<td><b>High School:</b></td>
									<td><?php echo $showProfile->highschool != "" ? $showProfile->highschool : "No HS Entered"; ?></td>
								</tr>
								<tr>
									<td><b>College:</b></td>
									<td><?php echo $showProfile->college != "" ? $showProfile->college : "No College Entered"; ?></td>
								</tr>
								<tr>
									<td><b>Age:</b></td>
									<td><?php echo $showProfile->dob != 0 ? $showProfile->get_player_age() : "No DOB Entered"; ?></td>
								</tr>
								<?php if($showProfile->show_email == "Y") { ?>
									<tr>
										<td><b>Email:</b></td>
										<td><?php echo $showProfile->email != "" ? $showProfile->email : "No Email Address Entered"; ?></td>
									</tr>
								<?php } ?>
						</table>
					</div>
				</div>
				<?php if($showProfile->ttr_player == "Y") { ?>
					<?php $playerLeaguesInfo = explode(";", $showProfile->ttr_player_info); ?>
					<div class="playerLeagues">
						<?php foreach($playerLeaguesInfo as $getLeaguesInfo) { ?>
							<?php if(!empty($getLeaguesInfo)) { ?>
								<?php $sepInfo = explode("_", $getLeaguesInfo); ?>
								<?php $leaguesID = str_ireplace("League", "", $sepInfo[0]); ?>
								<?php $leaguesPlayerID = str_ireplace("Player", "", $sepInfo[1]); ?>
								<?php $linkedLeague = !isset($sepInfo[2]) ? League_Profile::get_league_by_id($leaguesID) : ""; ?>
								<?php $linkedPlayer = !isset($sepInfo[2]) ? League_Player::get_ttr_player_by_id($leaguesID, $leaguesPlayerID) : ""; ?>
								<?php $linkedPlayerTeam = !isset($sepInfo[2]) ? League_Team::get_team_by_id($leaguesID, $linkedPlayer->get_leagues_teams_id()) : ""; ?>

								<?php // '$sepInfo[2]' indicates that a league was declined ?>
								<?php if(!isset($sepInfo[2])) { ?>
									<div class="playerProfileLeaguesInfo">
										<h2 class="">Leagues I'm Playing In</h2>
										<div class="">
											<a href="#collapse_<?php echo str_ireplace(" ", "", strtolower($linkedLeague->leagues_name)); ?>" class="indProfileLeaguesLink" data-toggle="collapse"><b>League:</b> <?php echo $linkedLeague->leagues_name; ?></a>
										</div>
										<div id="collapse_<?php echo str_ireplace(" ", "", strtolower($linkedLeague->leagues_name)); ?>" class="collapse">
											<?php $getStandings = League_Standings::get_league_standings($linkedPlayer->get_league_id()); ?>
											<div id="view_standings" class="playerProfileLeaguesTeamStandings">
												<table id="view_standings_table">
													<caption>Standings</caption>
													<tr>
														<th>Team Name</th>
														<th>Wins</th>
														<th>Losses</th>
														<th>Forfeits</th>
														<th>Win Perc.</th>
														<th>Total Points</th>
													</tr>
													<?php if(empty($getStandings)) { ?>
														<tr>
															<td colspan='5'>No standings to display yet.</td>
														</tr>
													<?php } else { ?>
														<?php if(is_array($getStandings)) { ?>
															<?php foreach($getStandings as $showStanding) { ?>
																<tr class="<?php echo $showStanding->get_team_id() == $linkedPlayer->get_leagues_teams_id() ? "linkStandingsTeam" : ""; ?>">
																	<td><?php echo $showStanding->team_name; ?></td>
																	<td><?php echo $showStanding->team_wins != null ? $showStanding->team_wins : 0; ?></td>
																	<td><?php echo $showStanding->team_losses != null ? $showStanding->team_losses : 0; ?></td>
																	<td><?php echo $showStanding->team_forfeits != null ? $showStanding->team_forfeits : 0; ?></td>
																	<td><?php echo $showStanding->winPERC != null ? $showStanding->winPERC : "0.00"; ?></td>
																	<td><?php echo $showStanding->team_points != null ? $showStanding->team_points : "TBD"; ?></td>
																</tr>
															<?php } ?>
														<?php } elseif(is_object($getStandings)) { ?>
															<?php $showStanding = $getStandings; ?>
															<tr class="<?php echo $showStanding->get_team_id() == $linkedPlayer->get_leagues_teams_id() ? "linkStandingsTeam" : ""; ?>">
																<td><?php echo $showStanding->team_name; ?></td>
																<td><?php echo $showStanding->team_wins != null ? $showStanding->team_wins : 0; ?></td>
																<td><?php echo $showStanding->team_losses != null ? $showStanding->team_losses : 0; ?></td>
																<td><?php echo $showStanding->team_forfeits != null ? $showStanding->team_forfeits : 0; ?></td>
																<td><?php echo $showStanding->winPERC != null ? $showStanding->winPERC : "0.00"; ?></td>
																<td><?php echo $showStanding->team_points != null ? $showStanding->team_points : "TBD"; ?></td>
															</tr>
														<?php } ?>
													<?php } ?>
												</table>
											</div>
											<div class="playerProfileLeaguesTeamStats">
												<?php $getStats = League_Stats::get_player_stats_by_id($leaguesID, $leaguesPlayerID); ?>
												<?php if(!empty($getStats)) { ?>
													<table id="view_stats_table">
														<caption class="">#<?php echo $getStats->jersey_num; ?> Stats</caption>
														<tr>
															<th>PPG</th>
															<th>APG</th>
															<th>RPG</th>
															<th>SPG</th>
															<th>BPG</th>
															<th>PTS</th>
															<th>3's</th>
															<th>AST</th>
															<th>RBD</th>
															<th>STL</th>
															<th>BLK</th>
														</tr>
														<tr>
															<td><?php echo $getStats->PPG != null ? $getStats->PPG : "0.00"; ?></td>
															<td><?php echo $getStats->APG != null ? $getStats->APG : "0.00"; ?></td>
															<td><?php echo $getStats->RPG != null ? $getStats->RPG : "0.00"; ?></td>
															<td><?php echo $getStats->SPG != null ? $getStats->SPG : "0.00"; ?></td>
															<td><?php echo $getStats->BPG != null ? $getStats->BPG : "0.00"; ?></td>
															<td><?php echo $getStats->TPTS != null ? $getStats->TPTS : "0"; ?></td>
															<td><?php echo $getStats->TTHR != null ? $getStats->TTHR : "0"; ?></td>
															<td><?php echo $getStats->TASS != null ? $getStats->TASS : "0"; ?></td>
															<td><?php echo $getStats->TRBD != null ? $getStats->TRBD : "0"; ?></td>
															<td><?php echo $getStats->TSTL != null ? $getStats->TSTL : "0"; ?></td>
															<td><?php echo $getStats->TBLK != null ? $getStats->TBLK : "0"; ?></td>
														</tr>
													</table>
												<?php } else { ?>
													<ul class="">
														<li class="">No player stats added</li>
													</ul>
												<?php } ?>
											</div>
											<div class="playerProfileLeaguesLink">
												<a href="<?php echo $linkedLeague->ttr_league_site ?>" class="" target="_blank">Go To League Site</a>
											</div>
										</div>
									</div>
								<?php } else { ?>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					</div>
				<?php } ?>
				<?php if($showProfile->player_playground != NULL || $showProfile->player_playground != "") { ?>
					<div class="playerPlaygrounds">
						<?php $playgrounds = explode("; ", $showProfile->player_playground); ?>
						<h2 class="">Here's where I catch my best games</h2>
						<ol class="">
							<?php for($ii=0; $ii < count($playgrounds); $ii++) { ?>
								<?php $counter = $ii + 1; ?>
								<li class=""><?php echo $counter . ". " . str_ireplace("_", " ", $playgrounds[$ii]); ?></li>
							<?php } ?>
						</ol>
					</div>
				<?php } ?>
				<div class="playerPageVideos" id="player_videos">
					<?php $getPlayerVideos = Video::find_player_videos_by_id($_GET["num"]); ?>
					<?php if(!empty($getPlayerVideos)) { ?>
						<?php if(is_array($getPlayerVideos)) { ?>
							<div class="">
								<h2 class="playerPageVideosHeader">Highlights</h2>
								<?php foreach($getPlayerVideos as $showVideo) { ?>
									<div class="playerPageVideo ">
										<h2>Uploaded: <?php $date = date_create($showVideo->upload_date); echo date_format($date, "m/d/y"); ?><span class="myVideoID" hidden><?php echo $showVideo->get_upload_id(); ?></span></h2>
										<video class="currentVideo">
											<source src="<?php echo $showVideo->get_filename(); ?>" type="video/mp4">
											<source src="<?php echo $showVideo->get_filename(); ?>" type="video/ogg">
											Your browser does not support the video tag.
										</video>
									</div>
								<?php } ?>
							</div>
						<?php } elseif(is_object($getPlayerVideos)) { ?>
							<div class="">
								<h2 class="playerPageVideosHeader">Highlights</h2>
								<?php $showVideo = $getPlayerVideos; ?>
								<div class="playerPageVideo ">
									<h2>Uploaded: <?php $date = date_create($showVideo->upload_date); echo date_format($date, "m/d/y"); ?><span class="myVideoID" hidden><?php echo $showVideo->get_upload_id(); ?></span></h2>
									<video class="currentVideo">
										<source src="<?php echo $showVideo->get_filename(); ?>" type="video/mp4">
										<source src="<?php echo $showVideo->get_filename(); ?>" type="video/ogg">
										Your browser does not support the video tag.
									</video>
								</div>
							</div>
						<?php } ?>
					<?php } else { ?>
						<div class="">
							<h2 class="playerPageVideosNone">This Player Hasn't Decided To Showcase Their Skills Yet. No Highlights To Show</h2>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } elseif(isset($_GET["filter"])) { ?>
			<div class="search_box">
				<input class="player_search" name="search" type="search" placeholder="Search Player"/>				
				<a class="addFilter" href="#">Search</a>
				<a class="removeFilter" href="players.php">Remove Filter</a>
			</div>
			<?php $player = Player_Profile::get_player_profiles_by_letter($_GET["filter"]); ?>
			<?php if(is_object($player)) { ?>
				<?php $showPlayer = $player; ?>
					<div class="playersPage">
						<div class="playerPicture">
							<div style="background-image:url(../uploads/<?php echo $showPlayer->picture; ?>)" class=""></div>
						</div>
						<div class="playerNameHeader">
							<div class="">
								<h2 class="">
									<?php $nickname = $showPlayer->nickname != "" ? "\"".$showPlayer->nickname."\"" : " "; ?>
									<?php echo $nickname;?>
								</h2>
							</div>
							<div class="">
								<h2 class="">
									<?php echo $showPlayer->firstname . " " .  $showPlayer->lastname;?>
								</h2>
							</div>
						</div>
						<div class="playerBio">
							<ul>
								<?php $checkVideoCount = Player_Profile::find_player_videos_by_id($showPlayer->get_player_id()); ?>
								<?php $bio  = $showPlayer->height != "" ? "<li class='playerBioItem'><span class='label'>Height:</span><span class='labelContent'>".$showPlayer->height."</span></li>" : ""; ?>
								<?php $bio .= $showPlayer->weight > 0 ? "<li class='playerBioItem'><span class='label'>Weight:</span><span class='labelContent'>".$showPlayer->weight."</span></li>" : ""; ?>
								<?php $bio .= $showPlayer->highschool != "" ? "<li class='playerBioItem' title='".$showPlayer->highschool."'><span class='label'>HS:</span><span class='labelContent'>".$showPlayer->highschool."</span></li>" : ""; ?>
								<?php $bio .= $showPlayer->college != "" ? "<li class='playerBioItem' title='".$showPlayer->college."'><span class='label'>College:</span><span class='labelContent'>".$showPlayer->college."</span></li>" : ""; ?>
								<?php $bio .= !empty($checkVideoCount) ? "<li class='playerBioItem'><span class='label'>Highlights:</span><span class='labelContent'>".count($checkVideoCount)."</span></li>" : ""; ?>
								<?php echo $bio; ?>
							</ul>
						</div>
						<div class="playerFooter">
							<a href="players.php?player=<?php echo $showPlayer->firstname."_".$showPlayer->lastname."&num=".$showPlayer->get_player_id(); ?>">Go To Profile</a>						
						</div>
					</div>
			<?php } else { ?>
				<?php foreach($player as $showPlayer) { ?>
					<div class="playersPage">
						<div class="playerPicture">
							<div style="background-image:url(../uploads/<?php echo $showPlayer->picture; ?>)" class=""></div>
						</div>
						<div class="playerNameHeader">
							<div class="">
								<h2 class="">
									<?php $nickname = $showPlayer->nickname != "" ? "\"".$showPlayer->nickname."\"" : " "; ?>
									<?php echo $nickname;?>
								</h2>
							</div>
							<div class="">
								<h2 class="">
									<?php echo $showPlayer->firstname . " " .  $showPlayer->lastname;?>
								</h2>
							</div>
						</div>
						<div class="playerBio">
							<ul>
								<?php $checkVideoCount = mysqli_num_rows(find_player_videos_by_id($showPlayer->get_player_id())); ?>
								<?php $bio  = $showPlayer->height != "" ? "<li class='playerBioItem'><span class='label'>Height:</span><span class='labelContent'>".$showPlayer->height."</span></li>" : ""; ?>
								<?php $bio .= $showPlayer->weight > 0 ? "<li class='playerBioItem'><span class='label'>Weight:</span><span class='labelContent'>".$showPlayer->weight."</span></li>" : ""; ?>
								<?php $bio .= $showPlayer->highschool != "" ? "<li class='playerBioItem' title='".$showPlayer->highschool."'><span class='label'>HS:</span><span class='labelContent'>".$showPlayer->highschool."</span></li>" : ""; ?>
								<?php $bio .= $showPlayer->college != "" ? "<li class='playerBioItem' title='".$showPlayer->college."'><span class='label'>College:</span><span class='labelContent'>".$showPlayer->college."</span></li>" : ""; ?>
								<?php $bio .= $checkVideoCount > 0 ? "<li class='playerBioItem'><span class='label'>Highlights:</span><span class='labelContent'>".count($checkVideoCount)."</span></li>" : ""; ?>
								<?php echo $bio; ?>
							</ul>
						</div>
						<div class="playerFooter">
							<a href="players.php?player=<?php echo $showPlayer->firstname."_".$showPlayer->lastname."&num=".$showPlayer->player_id; ?>">Go To Profile</a>						
						</div>
					</div>
				<?php } ?>
			<?php } ?>
		<?php } elseif(isset($_GET["filter_search"])) { ?>
			<div class="search_box">
				<input class="player_search" name="search" type="search" placeholder="Search Player" value="<?php echo isset($_GET["filter_search"]) ? $_GET["filter_search"] : ""; ?>"/>				
				<a class="addFilter" href="#">Search</a>
				<a class="removeFilter" href="players.php">Remove Filter</a>
			</div>
			<?php $player = Player_Profile::get_players_by_search($_GET["filter_search"]); ?>
			<?php if(!empty($player)) { ?>
				<?php if(is_object($player)) { ?>
					<?php $showPlayer = $player; ?>
					<div class="playersPage">
						<div class="playerPicture">
							<div style="background-image:url(../uploads/<?php echo $showPlayer->picture; ?>)" class=""></div>
						</div>
						<div class="playerNameHeader">
							<div class="">
								<h2 class="">
									<?php $nickname = $showPlayer->nickname != "" ? "\"".$showPlayer->nickname."\"" : " "; ?>
									<?php echo $nickname;?>
								</h2>
							</div>
							<div class="">
								<h2 class="">
									<?php echo $showPlayer->firstname . " " .  $showPlayer->lastname;?>
								</h2>
							</div>
						</div>
						<div class="playerBio">
							<ul>
								<?php $checkVideoCount = Video::find_player_videos_by_id($showPlayer->get_player_id()); ?>
								<?php $bio  = $showPlayer->height != "" ? "<li class='playerBioItem'><span class='label'>Height:</span><span class='labelContent'>".$showPlayer->height."</span></li>" : ""; ?>
								<?php $bio .= $showPlayer->weight > 0 ? "<li class='playerBioItem'><span class='label'>Weight:</span><span class='labelContent'>".$showPlayer->weight."</span></li>" : ""; ?>
								<?php $bio .= $showPlayer->highschool != "" ? "<li class='playerBioItem' title='".$showPlayer->highschool."'><span class='label'>HS:</span><span class='labelContent'>".$showPlayer->highschool."</span></li>" : ""; ?>
								<?php $bio .= $showPlayer->college != "" ? "<li class='playerBioItem' title='".$showPlayer->college."'><span class='label'>College:</span><span class='labelContent'>".$showPlayer->college."</span></li>" : ""; ?>
								<?php $bio .= !empty($checkVideoCount) ? "<li class='playerBioItem'><span class='label'>Highlights:</span><span class='labelContent'>".count($checkVideoCount)."</span></li>" : ""; ?>
								<?php echo $bio; ?>
							</ul>
						</div>
						<div class="playerFooter">
							<a href="players.php?player=<?php echo $showPlayer->firstname."_".$showPlayer->lastname."&num=".$showPlayer->get_player_id(); ?>">Go To Profile</a>						
						</div>
					</div>
				<?php } elseif(is_array($player)) { ?>
					<?php foreach($player as $showPlayer) { ?>
						<div class="playersPage">
							<div class="playerPicture">
								<div style="background-image:url(../uploads/<?php echo $showPlayer->picture; ?>)" class=""></div>
							</div>
							<div class="playerNameHeader">
								<div class="">
									<h2 class="">
										<?php $nickname = $showPlayer->nickname != "" ? "\"".$showPlayer->nickname."\"" : " "; ?>
										<?php echo $nickname;?>
									</h2>
								</div>
								<div class="">
									<h2 class="">
										<?php echo $showPlayer->firstname . " " .  $showPlayer->lastname;?>
									</h2>
								</div>
							</div>
							<div class="playerBio">
								<ul>
									<?php $checkVideoCount = Video::find_player_videos_by_id($showPlayer->get_player_id()); ?>
									<?php $bio  = $showPlayer->height != "" ? "<li class='playerBioItem'><span class='label'>Height:</span><span class='labelContent'>".$showPlayer->height."</span></li>" : ""; ?>
									<?php $bio .= $showPlayer->weight > 0 ? "<li class='playerBioItem'><span class='label'>Weight:</span><span class='labelContent'>".$showPlayer->weight."</span></li>" : ""; ?>
									<?php $bio .= $showPlayer->highschool != "" ? "<li class='playerBioItem' title='".$showPlayer->highschool."'><span class='label'>HS:</span><span class='labelContent'>".$showPlayer->highschool."</span></li>" : ""; ?>
									<?php $bio .= $showPlayer->college != "" ? "<li class='playerBioItem' title='".$showPlayer->college."'><span class='label'>College:</span><span class='labelContent'>".$showPlayer->college."</span></li>" : ""; ?>
									<?php $bio .= !empty($checkVideoCount) ? "<li class='playerBioItem'><span class='label'>Highlights:</span><span class='labelContent'>".count($checkVideoCount)."</span></li>" : ""; ?>
									<?php echo $bio; ?>
								</ul>
							</div>
							<div class="playerFooter">
								<a href="players.php?player=<?php echo $showPlayer->firstname."_".$showPlayer->lastname."&num=".$showPlayer->get_player_id(); ?>">Go To Profile</a>						
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			<?php } else { ?>
				<div id="noVideos_message">
					<p class="">No players meet the search critera for "<?php echo $_GET["filter_search"]; ?>"</p>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div class="search_box">
				<input class="player_search" name="search" type="search" placeholder="Search Player"/>				
				<a class="addFilter" href="#">Search</a>
			</div>
			<?php $recentPlayers = Player_Profile::find_recent_added_players(); ?>
			<?php foreach($recentPlayers as $showPlayer) { ?>
				<div class="playersPage">
					<div class="playerPicture">
						<div style="background-image:url(../uploads/<?php echo $showPlayer->picture; ?>)" class=""></div>
					</div>
					<div class="playerNameHeader">
						<div class="">
							<h2 class="">
								<?php $nickname = $showPlayer->nickname != "" ? "\"".$showPlayer->nickname."\"" : " "; ?>
								<?php echo $nickname;?>
							</h2>
						</div>
						<div class="">
							<h2 class="">
								<?php echo $showPlayer->firstname . " " .  $showPlayer->lastname;?>
							</h2>
						</div>
					</div>
					<div class="playerBio">
						<ul>
							<?php $checkVideoCount = Player_Profile::find_player_videos_by_id($showPlayer->get_player_id()); ?>
							<?php $bio  = $showPlayer->height != "" ? "<li class='playerBioItem'><span class='label'>Height:</span><span class='labelContent'>".$showPlayer->height."</span></li>" : ""; ?>
							<?php $bio .= $showPlayer->weight > 0 ? "<li class='playerBioItem'><span class='label'>Weight:</span><span class='labelContent'>".$showPlayer->weight."</span></li>" : ""; ?>
							<?php $bio .= $showPlayer->highschool != "" ? "<li class='playerBioItem' title='".$showPlayer->highschool."'><span class='label'>HS:</span><span class='labelContent'>".$showPlayer->highschool."</span></li>" : ""; ?>
							<?php $bio .= $showPlayer->college != "" ? "<li class='playerBioItem' title='".$showPlayer->college."'><span class='label'>College:</span><span class='labelContent'>".$showPlayer->college."</span></li>" : ""; ?>
							<?php $bio .= !empty($checkVideoCount) ? "<li class='playerBioItem'><span class='label'>Highlights:</span><span class='labelContent'>".count($checkVideoCount)."</span></li>" : ""; ?>
							<?php echo $bio; ?>
						</ul>
					</div>
					<div class="playerFooter">
						<a href="players.php?player=<?php echo $showPlayer->firstname."_".$showPlayer->lastname."&num=".$showPlayer->get_player_id(); ?>">Go To Profile</a>						
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
	<?php require_once("../include/footer.php"); ?>
</body>
</html>