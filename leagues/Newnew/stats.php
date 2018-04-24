<?php require_once	("../../include/initialize2.php"); ?>
<?php require_once("../../include/leagues_header.php"); ?>
<body>
	<div class="leagues_page_div container-fluid">
		<?php include("leagues_menu.php"); ?>
		<div id="card_overlay"></div>
		<div id="player_card">
			<div id="player_card_content">
				<div class="playerCardHeader">
					<span class="closeCard">X</span><h2 class="jerseyNumPlayerCard"></h2><h2 class="playerNamePlayerCard"></h2>
				</div>
				<div class="playerCardStats"> 
					<ul>
						<li class="playerCardStatsLI"><b>Team Name:</b> <span class="teamNameVal"></span></li>
						<li class="playerCardStatsLI"><b>Points:</b> <span class="perGamePointsVal"></span></li>
						<li class="playerCardStatsLI"><b>Assist:</b> <span class="perGameAssistVal"></span></li>
						<li class="playerCardStatsLI"><b>Rebounds:</b> <span class="perGameReboundsVal"></span></li>
						<li class="playerCardStatsLI"><b>Steals:</b> <span class="perGameStealsVal"></span></li>
						<li class="playerCardStatsLI"><b>Blocks:</b> <span class="perGameBlocksVal"></span></li>
					</ul>
				</div>	
			</div>
		</div>
		<div id="team_card">
			<div id="team_card_content">
				<div class="teamCardHeader">
					<span class="closeCard">X</span>
					<div id="bgrdBlur"></div>
				</div>
				<div class="teamCardStats"> 
					<ul>
						<li class="teamCardStatsLI"><b>Team:</b> <span class="teamNameTeamCard"></span></li>
						<li class="teamCardStatsLI"><b>Record:</b> <span class="teamWinsVal"></span> - <span class="teamLossesVal"></span></li>
						<li class="teamCardStatsLI"><b>Points:</b> <span class="totalTeamPointsVal"></span></li>
						<li class="teamCardStatsLI"><b>Assist:</b> <span class="perGameTeamAssistVal"></span></li>
						<li class="teamCardStatsLI"><b>Rebounds:</b> <span class="perGameTeamReboundsVal"></span></li>
						<li class="teamCardStatsLI"><b>Steals:</b> <span class="perGameTeamStealsVal"></span></li>
						<li class="teamCardStatsLI"><b>Blocks:</b> <span class="perGameTeamBlocksVal"></span></li>
						<li class="teamCardStatsLI"><b>Points P/G:</b> <span class="perGameTeamPointsVal"></span></li>
						<li class="teamCardStatsLI"><b>Assist P/G:</b> <span class="totalTeamAssistVal"></span></li>
						<li class="teamCardStatsLI"><b>Rebounds P/G:</b> <span class="totalTeamReboundsVal"></span></li>
						<li class="teamCardStatsLI"><b>Steals P/G:</b> <span class="totalTeamStealsVal"></span></li>
						<li class="teamCardStatsLI"><b>Blocks P/G:</b> <span class="totalTeamBlocksVal"></span></li>
					</ul>
				</div>
			</div>
		</div>
		<h1>League Header or Banner</h1>
		<div id="league_stat_categories">
			<button class="statCategoryBtn activeBtn" id="league_leaders_btn">League Leaders</button>
			<button class="statCategoryBtn" id="player_stats_btn">Player Stats</button>
			<button class="statCategoryBtn" id="team_stats_btn">Team Stats</button>
		</div>
		<div id="league_stats">
			<?php if(!isset($_GET["players"]) && !isset($_GET["teams"])) { ?>
				<div id="league_leaders">
					<div class="leagueLeadersCategory" id="league_leaders_points">
						<?php $scoringLeaders = League_Stats::get_scoring_leaders(); ?>
						<table id="points_category">
							<tr class="leagueLeadersCategoryFR">
								<th></th>
								<th>Total Points</th>
								<th>Points Per Game</th>
							</tr>
							<?php foreach($scoringLeaders as $scoringLeader) { ?>
								<tr>
									<td class='playerNameTD'><?php echo $scoringLeader->player_name; ?></td>
									<td class='totalPointsTD'><?php echo $scoringLeader->points; ?></td>
									<td class='pointsPGTD'><?php echo $scoringLeader->PPG; ?></td>
									<td class='totalThreesTD' hidden><?php echo $scoringLeader->threes_made; ?></td>
									<td class='threesPGTD' hidden><?php echo $scoringLeader->TPG; ?></td>
									<td class='totalFTTD' hidden><?php echo $scoringLeader->ft_made; ?></td>
									<td class='freeThrowsPGTD' hidden><?php echo $scoringLeader->FTPG; ?></td>
									<td class='totalAssTD' hidden><?php echo $scoringLeader->assist; ?></td>
									<td class='assistPGTD' hidden><?php echo $scoringLeader->APG; ?></td>
									<td class='totalRebTD' hidden><?php echo $scoringLeader->rebounds; ?></td>
									<td class='rebPGTD' hidden><?php echo $scoringLeader->RPG; ?></td>
									<td class='totalStealsTD' hidden><?php echo $scoringLeader->steals; ?></td>
									<td class='stealsPGTD' hidden><?php echo $scoringLeader->SPG; ?></td>
									<td class='totalBlocksTD' hidden><?php echo $scoringLeader->blocks; ?></td>
									<td class='blocksPGTD' hidden><?php echo $scoringLeader->BPG; ?></td>
									<td class='teamNameTD' hidden><?php echo $scoringLeader->team_name; ?></td>
									<td class='jerseyNumTD' hidden># <?php echo $scoringLeader->jersey_num; ?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
					<div class="leagueLeadersCategory" id="league_leaders_assist">
						<?php $assistLeaders = League_Stats::get_assist_leaders(); ?>
						<table id="assist_category">
							<tr class="leagueLeadersCategoryFR">
								<th></th>
								<th>Total Assists</th>
								<th>Assist Per Game</th>
							</tr>
							<?php foreach($assistLeaders as $assistLeader) { ?>
								<tr>	
									<td class='playerNameTD'><?php echo $assistLeader->player_name; ?></td>
									<td class='totalPointsTD' hidden><?php echo $assistLeader->points; ?></td>
									<td class='pointsPGTD' hidden><?php echo $assistLeader->PPG; ?></td>
									<td class='totalThreesTD' hidden><?php echo $assistLeader->threes_made; ?></td>
									<td class='threesPGTD' hidden><?php echo $assistLeader->TPG; ?></td>
									<td class='totalFTTD' hidden><?php echo $assistLeader->ft_made; ?></td>
									<td class='freeThrowsPGTD' hidden><?php echo $assistLeader->FTPG; ?></td>
									<td class='totalAssTD'><?php echo $assistLeader->assist; ?></td>
									<td class='assistPGTD'><?php echo $assistLeader->APG; ?></td>
									<td class='totalRebTD' hidden><?php echo $assistLeader->rebounds; ?></td>
									<td class='rebPGTD' hidden><?php echo $assistLeader->RPG; ?></td>
									<td class='totalStealsTD' hidden><?php echo $assistLeader->steals; ?></td>
									<td class='stealsPGTD' hidden><?php echo $assistLeader->SPG; ?></td>
									<td class='totalBlocksTD' hidden><?php echo $assistLeader->blocks; ?></td>
									<td class='blocksPGTD' hidden><?php echo $assistLeader->BPG; ?></td>
									<td class='teamNameTD' hidden><?php echo $assistLeader->team_name; ?></td>
									<td class='jerseyNumTD' hidden>#&nbsp;<?php echo $assistLeader->jersey_num; ?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
					<div class="leagueLeadersCategory" id="league_leaders_rebounds">
						<?php $reboundsLeaders = League_Stats::get_rebounds_leaders(); ?>
						<table id="rebounds_category">
							<tr class="leagueLeadersCategoryFR">
								<th></th>
								<th>Total Rebounds</th>
								<th>Rebounds Per Game</th>
							</tr>
							<?php foreach($reboundsLeaders as $reboundsLeader) { ?>
								<tr>
									<td class='playerNameTD'><?php echo $reboundsLeader->player_name; ?></td>
									<td class='totalPointsTD' hidden><?php echo $reboundsLeader->points; ?></td>
									<td class='pointsPGTD' hidden><?php echo $reboundsLeader->PPG; ?></td>
									<td class='totalThreesTD' hidden><?php echo $reboundsLeader->threes_made; ?></td>
									<td class='threesPGTD' hidden><?php echo $reboundsLeader->TPG; ?></td>
									<td class='totalFTTD' hidden><?php echo $reboundsLeader->ft_made; ?></td>
									<td class='freeThrowsPGTD' hidden><?php echo $reboundsLeader->FTPG; ?></td>
									<td class='totalAssTD' hidden><?php echo $reboundsLeader->assist; ?></td>
									<td class='assistPGTD' hidden><?php echo $reboundsLeader->APG; ?></td>
									<td class='totalRebTD'><?php echo $reboundsLeader->rebounds; ?></td>
									<td class='rebPGTD'><?php echo $reboundsLeader->RPG; ?></td>
									<td class='totalStealsTD' hidden><?php echo $reboundsLeader->steals; ?></td>
									<td class='stealsPGTD' hidden><?php echo $reboundsLeader->SPG; ?></td>
									<td class='totalBlocksTD' hidden><?php echo $reboundsLeader->blocks; ?></td>
									<td class='blocksPGTD' hidden><?php echo $reboundsLeader->BPG; ?></td>
									<td class='teamNameTD' hidden><?php echo $reboundsLeader->team_name; ?></td>
									<td class='jerseyNumTD' hidden>#&nbsp;<?php echo $reboundsLeader->jersey_num; ?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
					<div class="leagueLeadersCategory" id="league_leaders_steals">
						<?php $stealsLeaders = League_Stats::get_steals_leaders(); ?>
						<table id="steals_category">
							<tr class="leagueLeadersCategoryFR">
								<th></th>
								<th>Total Steals</th>
								<th>Steals Per Game</th>
							</tr>
							<?php foreach($stealsLeaders as $stealsLeader) { ?>
								<tr>
									<td class='playerNameTD'><?php echo $stealsLeader->player_name; ?></td>
									<td class='totalPointsTD' hidden><?php echo $stealsLeader->points; ?></td>
									<td class='pointsPGTD' hidden><?php echo $stealsLeader->PPG; ?></td>
									<td class='totalThreesTD' hidden><?php echo $stealsLeader->threes_made; ?></td>
									<td class='threesPGTD' hidden><?php echo $stealsLeader->TPG; ?></td>
									<td class='totalFTTD' hidden><?php echo $stealsLeader->ft_made; ?></td>
									<td class='freeThrowsPGTD' hidden><?php echo $stealsLeader->FTPG; ?></td>
									<td class='totalAssTD' hidden><?php echo $stealsLeader->assist; ?></td>
									<td class='assistPGTD' hidden><?php echo $stealsLeader->APG; ?></td>
									<td class='totalRebTD' hidden><?php echo $stealsLeader->rebounds; ?></td>
									<td class='rebPGTD' hidden><?php echo $stealsLeader->RPG; ?></td>
									<td class='totalStealsTD'><?php echo $stealsLeader->steals; ?></td>
									<td class='stealsPGTD'><?php echo $stealsLeader->SPG; ?></td>
									<td class='totalBlocksTD' hidden><?php echo $stealsLeader->blocks; ?></td>
									<td class='blocksPGTD' hidden><?php echo $stealsLeader->BPG; ?></td>
									<td class='teamNameTD' hidden><?php echo $stealsLeader->team_name; ?></td>
									<td class='jerseyNumTD' hidden>#&nbsp;<?php echo $stealsLeader->jersey_num; ?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
					<div class="leagueLeadersCategory" id="league_leaders_blocks">
						<?php $blocksLeaders = League_Stats::get_blocks_leaders(); ?>
						<table id="blocks_category">
							<tr class="leagueLeadersCategoryFR">
								<th></th>
								<th>Total Blocks</th>
								<th>Blocks Per Game</th>
							</tr>
							<?php foreach($blocksLeaders as $blocksLeader) { ?>
								<tr>
									<td class='playerNameTD'><?php echo $blocksLeader->player_name; ?></td>
									<td class='totalPointsTD' hidden><?php echo $blocksLeader->points; ?></td>
									<td class='pointsPGTD' hidden><?php echo $blocksLeader->PPG; ?></td>
									<td class='totalThreesTD' hidden><?php echo $blocksLeader->threes_made; ?></td>
									<td class='threesPGTD' hidden><?php echo $blocksLeader->TPG; ?></td>
									<td class='totalFTTD' hidden><?php echo $blocksLeader->ft_made; ?></td>
									<td class='freeThrowsPGTD' hidden><?php echo $blocksLeader->FTPG; ?></td>
									<td class='totalAssTD' hidden><?php echo $blocksLeader->assist; ?></td>
									<td class='assistPGTD' hidden><?php echo $blocksLeader->APG; ?></td>
									<td class='totalRebTD' hidden><?php echo $blocksLeader->rebounds; ?></td>
									<td class='rebPGTD' hidden><?php echo $blocksLeader->RPG; ?></td>
									<td class='totalStealsTD' hidden><?php echo $blocksLeader->steals; ?></td>
									<td class='stealsPGTD' hidden><?php echo $blocksLeader->SPG; ?></td>
									<td class='totalBlocksTD'><?php echo $blocksLeader->blocks; ?></td>
									<td class='blocksPGTD'><?php echo $blocksLeader->BPG; ?></td>
									<td class='teamNameTD' hidden><?php echo $blocksLeader->team_name; ?></td>
									<td class='jerseyNumTD' hidden>#@nbsp;<?php echo $blocksLeader->jersey_num; ?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			<?php } elseif(isset($_GET["players"])) { ?>
				<div id="player_stats">
					<?php $allPlayers = League_Stats::get_all_players_stats(); ?>
					<table id="player_stats_table">
						<tr>
							<th></th>
							<th>Total Points</th><th>Points p/g</th>
							<th>3's</th><th>3's p/g</th>
							<th>FT</th><th>FT's p/g</th>
							<th>Assists</th><th>Assists p/g</th>
							<th>Rebounds</th><th>Rebounds p/g</th>
							<th>Steals</th><th>Steals p/g</th>
							<th>Blocks</th><th>Blocks p/g</th>
						</tr>
						<?php foreach($allPlayers as $showPlayer) { ?>
							<tr>
								<td class='playerNameTD'><?php echo $showPlayer->player_name; ?></td>
								<td class='totalPointsTD'><?php echo $showPlayer->points; ?></td>
								<td class='pointsPGTD'><?php echo $showPlayer->PPG; ?></td>
								<td class='totalThreesTD'><?php echo $showPlayer->threes_made; ?></td>
								<td class='threesPGTD'><?php echo $showPlayer->TPG; ?></td>
								<td class='totalFTTD'><?php echo $showPlayer->ft_made; ?></td>
								<td class='freeThrowsPGTD'><?php echo $showPlayer->FTPG; ?></td>
								<td class='totalAssTD'><?php echo $showPlayer->assist; ?></td>
								<td class='assistPGTD'><?php echo $showPlayer->APG; ?></td>
								<td class='totalRebTD'><?php echo $showPlayer->rebounds; ?></td>
								<td class='rebPGTD'><?php echo $showPlayer->RPG; ?></td>
								<td class='totalStealsTD'><?php echo $showPlayer->steals; ?></td>
								<td class='stealsPGTD'><?php echo $showPlayer->SPG; ?></td>
								<td class='totalBlocksTD'><?php echo $showPlayer->blocks; ?></td>
								<td class='blocksPGTD'><?php echo $showPlayer->BPG; ?></td>
								<td class='teamNameTD' hidden><?php echo $showPlayer->team_name; ?></td>
								<td class='jerseyNumTD' hidden>#&nbsp;<?php echo $showPlayer->jersey_num; ?></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			<?php } elseif(isset($_GET["teams"])) { ?>
				<div id="team_stats">
					<?php $allTeams = League_Stats::get_all_teams_stats(); ?>
					<table id="team_stats_table">
						<tr>
							<th></th>
							<th>Total Points</th><th>Points p/g</th>
							<th>3's</th><th>3's p/g</th>
							<th>FT</th><th>FT's p/g</th>
							<th>Assists</th><th>Assists p/g</th>
							<th>Rebounds</th><th>Rebounds p/g</th>
							<th>Steals</th><th>Steals p/g</th>
							<th>Blocks</th><th>Blocks p/g</th>
						</tr>
						<?php foreach($allTeams as $showTeam) { ?>
							<tr>
								<td class='teamNameTD'><?php echo $showTeam->team_name; ?></td>
								<td class='totalPointsTD'><?php echo $showTeam->TPTS; ?></td>
								<td class='pointsPGTD'><?php echo $showTeam->PPG; ?></td>
								<td class='totalThreesTD'><?php echo $showTeam->TTHR; ?></td>
								<td class='threesPGTD'><?php echo $showTeam->TPG; ?></td>
								<td class='totalFTTD'><?php echo $showTeam->TFTS; ?></td>
								<td class='freeThrowsPGTD'><?php echo $showTeam->FTPG; ?></td>
								<td class='totalAssTD'><?php echo $showTeam->TASS; ?></td>
								<td class='assistPGTD'><?php echo $showTeam->APG; ?></td>
								<td class='totalRebTD'><?php echo $showTeam->TRBD; ?></td>
								<td class='rebPGTD'><?php echo $showTeam->RPG; ?></td>
								<td class='totalStealsTD'><?php echo $showTeam->TSTL; ?></td>
								<td class='stealsPGTD'><?php echo $showTeam->SPG; ?></td>
								<td class='totalBlocksTD'><?php echo $showTeam->TBLK; ?></td>
								<td class='blocksPGTD'><?php echo $showTeam->BPG; ?></td>
								<td class='totalWinsTD' hidden><?php echo $showTeam->team_wins; ?></td>
								<td class='totalLossesTD' hidden><?php echo $showTeam->team_losses; ?></td>
								<td class='totalGamesTD' hidden><?php echo $showTeam->team_games; ?></td>
								<td class='teamPicture' hidden><?php echo $showTeam->team_picture; ?></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php require_once("../../include/leagues_footer.php"); ?>
</body>
</html>