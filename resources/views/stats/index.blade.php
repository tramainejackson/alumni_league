@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md mt-3">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_stat.index', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->season . ' ' . $activeSeason->year }}</a>
					@endforeach
				@else
				@endif
			</div>
			<div class="col-12 col-md-8">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				<div id="league_stat_categories" class="d-flex align-items-center justify-content-around">
					<button type="button" class="btn statCategoryBtn activeBtn" id="league_leaders_btn">League Leaders</button>
					<button type="button" class="btn statCategoryBtn" id="player_stats_btn">Player Stats</button>
					<button type="button" class="btn statCategoryBtn" id="team_stats_btn">Team Stats</button>
				</div>
				<div id="league_stats">
					<div id="league_leaders">
						<div class="leagueLeadersCategory" id="league_leaders_points">
							<table class="table table-responsive-sm" id="points_category">
								<thead>
									<tr class="leagueLeadersCategoryFR">
										<th></th>
										<th>Total Points</th>
										<th>Points Per Game</th>
									</tr>
								</thead>
								<tbody>
									@foreach($showSeason->stats()->scoringLeaders(5)->get() as $scoringLeader)
										<tr>
											<td class='playerNameTD'>{{ $scoringLeader->player_name }}</td>
											<td class='totalPointsTD'>{{ $scoringLeader->TPTS }}</td>
											<td class='pointsPGTD'>{{ $scoringLeader->PPG }}</td>
											<td class='totalThreesTD' hidden>{{ $scoringLeader->TTHR }}</td>
											<td class='threesPGTD' hidden>{{ $scoringLeader->TPG }}</td>
											<td class='totalFTTD' hidden>{{ $scoringLeader->TFTS }}</td>
											<td class='freeThrowsPGTD' hidden>{{ $scoringLeader->FTPG }}</td>
											<td class='totalAssTD' hidden>{{ $scoringLeader->TASS }}</td>
											<td class='assistPGTD' hidden>{{ $scoringLeader->APG }}</td>
											<td class='totalRebTD' hidden>{{ $scoringLeader->TRBD }}</td>
											<td class='rebPGTD' hidden>{{ $scoringLeader->RPG }}</td>
											<td class='totalStealsTD' hidden>{{ $scoringLeader->TSTL }}</td>
											<td class='stealsPGTD' hidden>{{ $scoringLeader->SPG }}</td>
											<td class='totalBlocksTD' hidden>{{ $scoringLeader->TBLK }}</td>
											<td class='blocksPGTD' hidden>{{ $scoringLeader->BPG }}</td>
											<td class='teamNameTD' hidden>{{ $scoringLeader->team_name }}</td>
											<td class='jerseyNumTD' hidden># {{ $scoringLeader->jersey_num }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="leagueLeadersCategory" id="league_leaders_assist">
							<table class="table table-responsive-sm" id="assist_category">
								<thead>
									<tr class="leagueLeadersCategoryFR">
										<th></th>
										<th>Total Assists</th>
										<th>Assist Per Game</th>
									</tr>
								</thead>
								<tbody>
									@foreach($showSeason->stats()->assistingLeaders(5)->get() as $assistLeader)
										<tr>
											<td class='playerNameTD'>{{ $assistLeader->player_name }}</td>
											<td class='totalPointsTD' hidden>{{ $assistLeader->TPTS }}</td>
											<td class='pointsPGTD' hidden>{{ $assistLeader->PPG }}</td>
											<td class='totalThreesTD' hidden>{{ $assistLeader->TTHR }}</td>
											<td class='threesPGTD' hidden>{{ $assistLeader->TPG }}</td>
											<td class='totalFTTD' hidden>{{ $assistLeader->TFTS }}</td>
											<td class='freeThrowsPGTD' hidden>{{ $assistLeader->FTPG }}</td>
											<td class='totalAssTD'>{{ $assistLeader->TASS }}</td>
											<td class='assistPGTD'>{{ $assistLeader->APG }}</td>
											<td class='totalRebTD' hidden>{{ $assistLeader->TRBD }}</td>
											<td class='rebPGTD' hidden>{{ $assistLeader->RPG }}</td>
											<td class='totalStealsTD' hidden>{{ $assistLeader->TSTL }}</td>
											<td class='stealsPGTD' hidden>{{ $assistLeader->SPG }}</td>
											<td class='totalBlocksTD' hidden>{{ $assistLeader->TBLK }}</td>
											<td class='blocksPGTD' hidden>{{ $assistLeader->BPG }}</td>
											<td class='teamNameTD' hidden>{{ $assistLeader->team_name }}</td>
											<td class='jerseyNumTD' hidden>#&nbsp;{{ $assistLeader->jersey_num }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="leagueLeadersCategory" id="league_leaders_rebounds">
							<table class="table table-responsive-sm" id="rebounds_category">
								<thead>
									<tr class="leagueLeadersCategoryFR">
										<th></th>
										<th>Total Rebounds</th>
										<th>Rebounds Per Game</th>
									</tr>
								</thead>
								<tbody>
									@foreach($showSeason->stats()->reboundingLeaders(5)->get() as $reboundsLeader)
										<tr>
											<td class='playerNameTD'>{{ $reboundsLeader->player_name }}</td>
											<td class='totalPointsTD' hidden>{{ $reboundsLeader->TPTS }}</td>
											<td class='pointsPGTD' hidden>{{ $reboundsLeader->PPG }}</td>
											<td class='totalThreesTD' hidden>{{ $reboundsLeader->TTHR }}</td>
											<td class='threesPGTD' hidden>{{ $reboundsLeader->TPG }}</td>
											<td class='totalFTTD' hidden>{{ $reboundsLeader->TFTS }}</td>
											<td class='freeThrowsPGTD' hidden>{{ $reboundsLeader->FTPG }}</td>
											<td class='totalAssTD' hidden>{{ $reboundsLeader->TASS }}</td>
											<td class='assistPGTD' hidden>{{ $reboundsLeader->APG }}</td>
											<td class='totalRebTD'>{{ $reboundsLeader->TRBD }}</td>
											<td class='rebPGTD'>{{ $reboundsLeader->RPG }}</td>
											<td class='totalStealsTD' hidden>{{ $reboundsLeader->TSTL }}</td>
											<td class='stealsPGTD' hidden>{{ $reboundsLeader->SPG }}</td>
											<td class='totalBlocksTD' hidden>{{ $reboundsLeader->TBLK }}</td>
											<td class='blocksPGTD' hidden>{{ $reboundsLeader->BPG }}</td>
											<td class='teamNameTD' hidden>{{ $reboundsLeader->team_name }}</td>
											<td class='jerseyNumTD' hidden>#&nbsp;{{ $reboundsLeader->jersey_num }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="leagueLeadersCategory" id="league_leaders_steals">
							<table class="table table-responsive-sm" id="steals_category">
								<thead>
									<tr class="leagueLeadersCategoryFR">
										<th></th>
										<th>Total Steals</th>
										<th>Steals Per Game</th>
									</tr>
								</thead>
								<tbody>
									@foreach($showSeason->stats()->stealingLeaders(5)->get() as $stealsLeader)
										<tr>
											<td class='playerNameTD'>{{ $stealsLeader->player_name }}</td>
											<td class='totalPointsTD' hidden>{{ $stealsLeader->TPTS }}</td>
											<td class='pointsPGTD' hidden>{{ $stealsLeader->PPG }}</td>
											<td class='totalThreesTD' hidden>{{ $stealsLeader->TTHR }}</td>
											<td class='threesPGTD' hidden>{{ $stealsLeader->TPG }}</td>
											<td class='totalFTTD' hidden>{{ $stealsLeader->TFTS }}</td>
											<td class='freeThrowsPGTD' hidden>{{ $stealsLeader->FTPG }}</td>
											<td class='totalAssTD' hidden>{{ $stealsLeader->TASS }}</td>
											<td class='assistPGTD' hidden>{{ $stealsLeader->APG }}</td>
											<td class='totalRebTD' hidden>{{ $stealsLeader->TRBD }}</td>
											<td class='rebPGTD' hidden>{{ $stealsLeader->RPG }}</td>
											<td class='totalStealsTD'>{{ $stealsLeader->TSTL }}</td>
											<td class='stealsPGTD'>{{ $stealsLeader->SPG }}</td>
											<td class='totalBlocksTD' hidden>{{ $stealsLeader->TBLK }}</td>
											<td class='blocksPGTD' hidden>{{ $stealsLeader->BPG }}</td>
											<td class='teamNameTD' hidden>{{ $stealsLeader->team_name }}</td>
											<td class='jerseyNumTD' hidden>#&nbsp;{{ $stealsLeader->jersey_num }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="leagueLeadersCategory" id="league_leaders_blocks">
							<table class="table table-responsive-sm" id="blocks_category">
								<thead>
									<tr class="leagueLeadersCategoryFR">
										<th></th>
										<th>Total Blocks</th>
										<th>Blocks Per Game</th>
									</tr>
								</thead>
								<tbody>
									@foreach($showSeason->stats()->blockingLeaders(5)->get() as $blocksLeader)
										<tr>
											<td class='playerNameTD'>{{ $blocksLeader->player_name }}</td>
											<td class='totalPointsTD' hidden>{{ $blocksLeader->TPTS }}</td>
											<td class='pointsPGTD' hidden>{{ $blocksLeader->PPG }}</td>
											<td class='totalThreesTD' hidden>{{ $blocksLeader->TTHR }}</td>
											<td class='threesPGTD' hidden>{{ $blocksLeader->TPG }}</td>
											<td class='totalFTTD' hidden>{{ $blocksLeader->TFTS }}</td>
											<td class='freeThrowsPGTD' hidden>{{ $blocksLeader->FTPG }}</td>
											<td class='totalAssTD' hidden>{{ $blocksLeader->TASS }}</td>
											<td class='assistPGTD' hidden>{{ $blocksLeader->APG }}</td>
											<td class='totalRebTD' hidden>{{ $blocksLeader->TRBD }}</td>
											<td class='rebPGTD' hidden>{{ $blocksLeader->RPG }}</td>
											<td class='totalStealsTD' hidden>{{ $blocksLeader->TSTL }}</td>
											<td class='stealsPGTD' hidden>{{ $blocksLeader->SPG }}</td>
											<td class='totalBlocksTD'>{{ $blocksLeader->TBLK }}</td>
											<td class='blocksPGTD'>{{ $blocksLeader->BPG }}</td>
											<td class='teamNameTD' hidden>{{ $blocksLeader->team_name }}</td>
											<td class='jerseyNumTD' hidden>#@nbsp;{{ $blocksLeader->jersey_num }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>

					<div class="hidden" id="player_stats">
						<table class="table table-responsive-sm" id="player_stats_table">
							<thead>
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
							</thead>
							<tbody>
								@foreach($allPlayers->get() as $showPlayer)
									<tr>
										<td class='playerNameTD'>{{ $showPlayer->player_name }}</td>
										<td class='totalPointsTD'>{{ $showPlayer->TPTS }}</td>
										<td class='pointsPGTD'>{{ $showPlayer->PPG }}</td>
										<td class='totalThreesTD'>{{ $showPlayer->TTHR }}</td>
										<td class='threesPGTD'>{{ $showPlayer->TPG }}</td>
										<td class='totalFTTD'>{{ $showPlayer->TFTS }}</td>
										<td class='freeThrowsPGTD'>{{ $showPlayer->FTPG }}</td>
										<td class='totalAssTD'>{{ $showPlayer->TASS }}</td>
										<td class='assistPGTD'>{{ $showPlayer->APG }}</td>
										<td class='totalRebTD'>{{ $showPlayer->TRBD }}</td>
										<td class='rebPGTD'>{{ $showPlayer->RPG }}</td>
										<td class='totalStealsTD'>{{ $showPlayer->TSTL }}</td>
										<td class='stealsPGTD'>{{ $showPlayer->SPG }}</td>
										<td class='totalBlocksTD'>{{ $showPlayer->TBLK }}</td>
										<td class='blocksPGTD'>{{ $showPlayer->BPG }}</td>
										<td class='teamNameTD' hidden>{{ $showPlayer->team_name }}</td>
										<td class='jerseyNumTD' hidden>#&nbsp;{{ $showPlayer->jersey_num }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div class="hidden" id="team_stats">
						<table class="table table-responsive-sm" id="team_stats_table">
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
							@foreach($allTeams->get() as $showTeam)
								<tr>
									<td class='teamNameTD'>{{ $showTeam->team_name }}</td>
									<td class='totalPointsTD'>{{ $showTeam->TPTS }}</td>
									<td class='pointsPGTD'>{{ $showTeam->PPG }}</td>
									<td class='totalThreesTD'>{{ $showTeam->TTHR }}</td>
									<td class='threesPGTD'>{{ $showTeam->TPG }}</td>
									<td class='totalFTTD'>{{ $showTeam->TFTS }}</td>
									<td class='freeThrowsPGTD'>{{ $showTeam->FTPG }}</td>
									<td class='totalAssTD'>{{ $showTeam->TASS }}</td>
									<td class='assistPGTD'>{{ $showTeam->APG }}</td>
									<td class='totalRebTD'>{{ $showTeam->TRBD }}</td>
									<td class='rebPGTD'>{{ $showTeam->RPG }}</td>
									<td class='totalStealsTD'>{{ $showTeam->TSTL }}</td>
									<td class='stealsPGTD'>{{ $showTeam->SPG }}</td>
									<td class='totalBlocksTD'>{{ $showTeam->TBLK }}</td>
									<td class='blocksPGTD'>{{ $showTeam->BPG }}</td>
									<td class='totalWinsTD' hidden>{{ $showTeam->team_wins }}</td>
									<td class='totalLossesTD' hidden>{{ $showTeam->team_losses }}</td>
									<td class='totalGamesTD' hidden>{{ $showTeam->team_games }}</td>
									<td class='teamPicture' hidden>{{ $showTeam->team_picture }}</td>
								</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
			<div class="col-md mt-3"></div>
		</div>
		<div class="row">
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
		</div>
	</div>
@endsection