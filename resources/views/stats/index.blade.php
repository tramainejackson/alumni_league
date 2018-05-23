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
										<tr data-toggle="modal" data-target="#player_card">
											<td class='playerNameTD'>#{{ $scoringLeader->player->jersey_num . ' ' . $scoringLeader->player->player_name }}</td>
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
											<td class='teamNameTD' hidden>{{ $scoringLeader->player->team_name }}</td>
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
										<tr data-toggle="modal" data-target="#player_card">
											<td class='playerNameTD'>#{{ $assistLeader->player->jersey_num . ' ' . $assistLeader->player->player_name }}</td>
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
											<td class='teamNameTD' hidden>{{ $assistLeader->player->team_name }}</td>
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
										<tr data-toggle="modal" data-target="#player_card">
											<td class='playerNameTD'>#{{ $reboundsLeader->player->jersey_num . ' ' . $reboundsLeader->player->player_name }}</td>
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
											<td class='teamNameTD' hidden>{{ $reboundsLeader->player->team_name }}</td>
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
										<tr data-toggle="modal" data-target="#player_card">
											<td class='playerNameTD'>#{{ $stealsLeader->player->jersey_num . '  ' . $stealsLeader->player->player_name }}</td>
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
											<td class='teamNameTD' hidden>{{ $stealsLeader->player->team_name }}</td>
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
										<tr data-toggle="modal" data-target="#player_card">
											<td class='playerNameTD'>#{{ $blocksLeader->player->jersey_num . ' ' . $blocksLeader->player->player_name }}</td>
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
											<td class='teamNameTD' hidden>{{ $blocksLeader->player->team_name }}</td>
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
									<th>Total Points</th>
									<th>PPG</th>
									<th>3's</th>
									<th>3's PG</th>
									<th>FT</th>
									<th>FTPG</th>
									<th>Assists</th>
									<th>APG</th>
									<th>Rebounds</th>
									<th>RPG</th>
									<th>Steals</th>
									<th>SPG</th>
									<th>Blocks</th>
									<th>BPG</th>
								</tr>
							</thead>
							<tbody>
								@foreach($allPlayers->get() as $showPlayer)
									<tr data-toggle="modal" data-target="#player_card">
										<td class='playerNameTD'>#{{ $showPlayer->player->jersey_num . ' ' . $showPlayer->player->player_name }}</td>
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
										<td class='teamNameTD' hidden>{{ $showPlayer->player->team_name }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div class="hidden" id="team_stats">
						<table class="table table-responsive-sm" id="team_stats_table">
							<thead>
								<tr>
									<th></th>
									<th>Total Points</th>
									<th>PPG&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Points Per Game Are Calculated From The Game Results"></i></th>
									<th>3's PG&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="3's Per Game Are Calculated From The Player Stats"></i></th>
									<th>FT's PG&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Free Throws Per Game Are Calculated From The Player Stats"></i></th>
									<th>APG&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Assist Per Game Are Calculated From The Player Stats"></i></th>
									<th>RPG&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Rebounds Per Game Are Calculated From The Player Stats"></i></th>
									<th>SPG&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Steals Per Game Are Calculated From The Player Stats"></i></th>
									<th>BPG&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Blocks Per Game Are Calculated From The Player Stats"></i></th>
								</tr>
							</thead>
							<tbody>
								@foreach($allTeams->get() as $showTeam)
									<tr data-toggle="modal" data-target="#team_card">
										<td class='teamNameTD'>{{ $showTeam->team_name }}</td>
										<td class='totalPointsTD'>{{ $showTeam->TPTS }}</td>
										<td class='pointsPGTD'>{{ $showTeam->PPG }}</td>
										<td class='threesPGTD'>{{ $showTeam->TPG }}</td>
										<td class='freeThrowsPGTD'>{{ $showTeam->FTPG }}</td>
										<td class='assistPGTD'>{{ $showTeam->APG }}</td>
										<td class='rebPGTD'>{{ $showTeam->RPG }}</td>
										<td class='stealsPGTD'>{{ $showTeam->SPG }}</td>
										<td class='blocksPGTD'>{{ $showTeam->BPG }}</td>
										<td class='totalThreesTD' hidden>{{ $showTeam->TTHR }}</td>
										<td class='totalFTTD' hidden>{{ $showTeam->TFTS }}</td>
										<td class='totalAssTD' hidden>{{ $showTeam->TASS }}</td>
										<td class='totalRebTD' hidden>{{ $showTeam->TRBD }}</td>
										<td class='totalStealsTD' hidden>{{ $showTeam->TSTL }}</td>
										<td class='totalBlocksTD' hidden>{{ $showTeam->TBLK }}</td>
										<td class='totalWinsTD' hidden>{{ $showTeam->team_wins }}</td>
										<td class='totalLossesTD' hidden>{{ $showTeam->team_losses }}</td>
										<td class='totalGamesTD' hidden>{{ $showTeam->team_games }}</td>
										<td class='teamPicture' hidden>{{ $showTeam->team_picture != null ? $showTeam->team_picture : $defaultImg }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md mt-3">
				@foreach($seasonScheduleWeeks as $week)
					<a href="{{ request()->query() == null ? route('league_stat.edit_week', ['week' => $week->season_week]) : route('league_stat.edit_week', ['week' => $week->season_week, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text">Week {{ $loop->iteration }} Stats</a>
				@endforeach
			</div>
		</div>
		
		<!-- Modal Cards -->
		<div class="">
			<!-- Player Card -->
			<div class="modal fade" id="player_card" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<!--Card-->
						<div class="card black white-text">
							<!--Card image-->
							<div class="view playerCardHeader gradient-card-header blue-gradient">
								<div class="card-header-title">
									<h2 class="playerNamePlayerCard"></h2>
								
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>
							<!--Card content-->
							<div class="card-body black white-text text-center playerCardStats container-fluid">
								<div class="row">
									<div class="col-4 playerCardStatsLI">
										<b>Team Name:</b> <span class="teamNameVal"></span>
									</div>
									<div class="col-4 playerCardStatsLI">
										<b>Points:</b> <span class="perGamePointsVal"></span>
									</div>
									<div class="col-4 playerCardStatsLI">
										<b>Assist:</b> <span class="perGameAssistVal"></span>
									</div>
									<div class="col-4 playerCardStatsLI">
										<b>Rebounds:</b> <span class="perGameReboundsVal"></span>
									</div>
									<div class="col-4 playerCardStatsLI">
										<b>Steals:</b> <span class="perGameStealsVal"></span>
									</div>
									<div class="col-4 playerCardStatsLI">
										<b>Blocks:</b> <span class="perGameBlocksVal"></span>
									</div>
								</div>
							</div>
						</div>
						<!--/.Card-->
					</div>
				</div>
			</div>
			
			<!-- Team Card -->
			<div class="modal fade" id="team_card" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content"  id="team_card_content">
						<!--Card-->
						<div class="card black white-text">
							<!--Card image-->
							<div class="view teamCardHeader">
								<img src="" class="img-fluid" alt="photo">
								<a href="#">
									<div class="mask rgba-white-slight">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
								</a>
							</div>
							<!--Card content-->
							<div class="card-body text-center">
								<div class="modal-body teamCardStats container-fluid">
									<div class="row">
										<div class="col-4 teamCardStatsLI">
											<b>Team:&nbsp;</b><span class="teamNameTeamCard"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>Record:</b> <span class="teamWinsVal"></span> - <span class="teamLossesVal"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>Points:</b> <span class="totalTeamPointsVal"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>Assist:</b> <span class="perGameTeamAssistVal"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>Rebounds:</b> <span class="perGameTeamReboundsVal"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>Steals:</b> <span class="perGameTeamStealsVal"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>Blocks:</b> <span class="perGameTeamBlocksVal"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>PPG:</b> <span class="perGameTeamPointsVal"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>APG:</b> <span class="totalTeamAssistVal"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>RPG:</b> <span class="totalTeamReboundsVal"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>SPG:</b> <span class="totalTeamStealsVal"></span>
										</div>
										<div class="col-4 teamCardStatsLI">
											<b>BPG:</b> <span class="totalTeamBlocksVal"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--/.Card-->
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection