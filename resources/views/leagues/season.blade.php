@extends('layouts.app')

@section('content')
	@include('include.functions')
	
	<div class="container-fluid bgrd4">
		<div class="row py-3">
			<div class="col-3">
				<div class="text-center">
					@if($season->completed == "Y")
						<button class="btn btn-block orange darken-1 my-1">Season Completed</button>
					@elseif($season->completed == "N")
						<button class="btn btn-block green darken-1 my-1">Season Active</button>
					@endif
					
					<img src="{{ $league->picture !== null ? asset($league->picture) : $defaultImg }}" class="img-fluid z-depth-1 rounded-circle" />
					
					<div class="my-2">
						<h2 class="h2-responsive white-text">League: <a class="text-underline" href="{{ route('league_profile.show', ['league' => str_ireplace(" ", "", strtolower($league->name))]) }}">{{ ucwords($league->name) }}</a></h2>
						
						<h3 class="h3-responsive white-text">Season Name: {{ ucwords($season->name) }}</h3>
					</div>
				</div>
				
				<ul class="nav md-pills pills-primary flex-column" role="tablist">
					<li class="nav-item">
						<a class="nav-link active white-text" data-toggle="tab" href="#season_standings" role="tab">Standings</a>
					</li>
					<li class="nav-item">
						<a class="nav-link white-text" data-toggle="tab" href="#season_stats" role="tab">Stats</a>
					</li>
					<li class="nav-item">
						<a class="nav-link white-text" data-toggle="tab" href="#season_schedule" role="tab">Schedule</a>
					</li>
					<li class="nav-item">
						<a class="nav-link white-text" data-toggle="tab" href="#season_teams" role="tab">Teams</a>
					</li>
					<li class="nav-item">
						<a class="nav-link white-text" data-toggle="tab" href="#season_pictures" role="tab">Pictures</a>
					</li>
				</ul>
			</div>
			
			<div class="col-9 mx-auto">
				<!-- Tab panels -->
				<div class="tab-content vertical">
					<!--Standings Panel-->
					<div class="tab-pane fade in show active" id="season_standings" role="tabpanel">
					
						@if($standings != null && $standings->isNotEmpty())
							<div id="league_standings">
								<table id="league_standings_table" class="table text-center table-striped table-responsive-sm table-hover table-secondary black-text rounded">
									<thead>
										<tr>
											<th class="font-weight-bold">Team Name</th>
											<th class="font-weight-bold">Wins</th>
											<th class="font-weight-bold">Losses</th>
											<th class="font-weight-bold">Forfeits</th>
											<th class="font-weight-bold">Win/Loss Pct.</th>
										</tr>
									</thead>
									<tbody>
										@foreach($standings as $showStandings)
											<tr>
												<td>{{ $showStandings->team_name }}</td>
												<td>{{ $showStandings->team_wins == null ? '0' : $showStandings->team_wins }}</td>
												<td>{{ $showStandings->team_losses == null ? '0' : $showStandings->team_losses }}</td>
												<td>{{ $showStandings->team_forfeits == null ? '0' : $showStandings->team_forfeits }}</td>
												<td>{{ $showStandings->winPERC == null ? '0.00' : $showStandings->winPERC }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						@else
							<div class="view d-flex align-items-center justify-content-center">
								<div class="rgba-amber-strong p-3 rounded z-depth-2">
									<h2 class="h2-responsive coolText4 text-center">There are no standings for this season yet</h2>
								</div>
							</div>
						@endif
					</div>
					<!--/.Standings Panel-->

					<!--Stats Panel-->
					<div class="tab-pane fade" id="season_stats" role="tabpanel">

						@if($stats)
							<div id="league_stat_categories" class="d-flex flex-column flex-md-row align-items-center justify-content-around">
								<button type="button" class="btn statCategoryBtn gray activeBtn w-100" id="league_leaders_btn">League Leaders</button>
								<button type="button" class="btn statCategoryBtn gray w-100" id="player_stats_btn">Player Stats</button>
								<button type="button" class="btn statCategoryBtn gray w-100" id="team_stats_btn">Team Stats</button>
							</div>
							<div id="league_stats" class="container-fluid">
								<div id="league_leaders" class="row">
									<div class="leagueLeadersCategory col-12 col-md mx-auto" id="league_leaders_points">
										<table class="table table-responsive-sm" id="points_category">
											<thead>
												<tr class="leagueLeadersCategoryFR">
													<th></th>
													<th>Total Points</th>
													<th>PPG</th>
												</tr>
											</thead>
											<tbody>
												@foreach($season->stats()->scoringLeaders(5)->get() as $scoringLeader)
													<tr data-toggle="modal" data-target="#player_card">
														<td class='playerNameTD'>#{{ $scoringLeader->player->jersey_num . ' ' . $scoringLeader->player->player_name }}</td>
														<td class='totalPointsTD text-center'>{{ $scoringLeader->TPTS == null ? 0 : $scoringLeader->TPTS }}</td>
														<td class='pointsPGTD text-center'>{{ $scoringLeader->PPG == null ? 0 : $scoringLeader->PPG }}</td>
														<td class='totalThreesTD' hidden>{{ $scoringLeader->TTHR == null ? 0 : $scoringLeader->TTHR }}</td>
														<td class='threesPGTD' hidden>{{ $scoringLeader->TPG == null ? 0 : $scoringLeader->TPG }}</td>
														<td class='totalFTTD' hidden>{{ $scoringLeader->TFTS == null ? 0 : $scoringLeader->TFTS }}</td>
														<td class='freeThrowsPGTD' hidden>{{ $scoringLeader->FTPG == null ? 0 : $scoringLeader->FTPG }}</td>
														<td class='totalAssTD' hidden>{{ $scoringLeader->TASS == null ? 0 : $scoringLeader->TASS }}</td>
														<td class='assistPGTD' hidden>{{ $scoringLeader->APG == null ? 0 : $scoringLeader->APG }}</td>
														<td class='totalRebTD' hidden>{{ $scoringLeader->TRBD == null ? 0 : $scoringLeader->TRBD }}</td>
														<td class='rebPGTD' hidden>{{ $scoringLeader->RPG == null ? 0 : $scoringLeader->RPG }}</td>
														<td class='totalStealsTD' hidden>{{ $scoringLeader->TSTL == null ? 0 : $scoringLeader->TSTL }}</td>
														<td class='stealsPGTD' hidden>{{ $scoringLeader->SPG == null ? 0 : $scoringLeader->SPG }}</td>
														<td class='totalBlocksTD' hidden>{{ $scoringLeader->TBLK == null ? 0 : $scoringLeader->TBLK }}</td>
														<td class='blocksPGTD' hidden>{{ $scoringLeader->BPG == null ? 0 : $scoringLeader->BPG }}</td>
														<td class='teamNameTD' hidden>{{ $scoringLeader->player->team_name }}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
									<div class="leagueLeadersCategory col-12 col-md mx-auto" id="league_leaders_assist">
										<table class="table table-responsive-sm" id="assist_category">
											<thead>
												<tr class="leagueLeadersCategoryFR">
													<th></th>
													<th>Total Assists</th>
													<th>APG</th>
												</tr>
											</thead>
											<tbody>
												@foreach($season->stats()->assistingLeaders(5)->get() as $assistLeader)
													<tr data-toggle="modal" data-target="#player_card">
														<td class='playerNameTD'>#{{ $assistLeader->player->jersey_num . ' ' . $assistLeader->player->player_name }}</td>
														<td class='totalPointsTD' hidden>{{ $assistLeader->TPTS == null ? 0 : $assistLeader->TPTS }}</td>
														<td class='pointsPGTD' hidden>{{ $assistLeader->PPG == null ? 0 : $assistLeader->PPG }}</td>
														<td class='totalThreesTD' hidden>{{ $assistLeader->TTHR == null ? 0 : $assistLeader->TTHR }}</td>
														<td class='threesPGTD' hidden>{{ $assistLeader->TPG == null ? 0 : $assistLeader->TPG }}</td>
														<td class='totalFTTD' hidden>{{ $assistLeader->TFTS == null ? 0 : $assistLeader->TFTS }}</td>
														<td class='freeThrowsPGTD' hidden>{{ $assistLeader->FTPG == null ? 0 : $assistLeader->FTPG }}</td>
														<td class='totalAssTD text-center'>{{ $assistLeader->TASS == null ? 0 : $assistLeader->TASS }}</td>
														<td class='assistPGTD text-center'>{{ $assistLeader->APG == null ? 0 : $assistLeader->APG }}</td>
														<td class='totalRebTD' hidden>{{ $assistLeader->TRBD == null ? 0 : $assistLeader->TRBD }}</td>
														<td class='rebPGTD' hidden>{{ $assistLeader->RPG == null ? 0 : $assistLeader->RPG }}</td>
														<td class='totalStealsTD' hidden>{{ $assistLeader->TSTL == null ? 0 : $assistLeader->TSTL }}</td>
														<td class='stealsPGTD' hidden>{{ $assistLeader->SPG == null ? 0 : $assistLeader->SPG }}</td>
														<td class='totalBlocksTD' hidden>{{ $assistLeader->TBLK == null ? 0 : $assistLeader->TBLK }}</td>
														<td class='blocksPGTD' hidden>{{ $assistLeader->BPG == null ? 0 : $assistLeader->BPG }}</td>
														<td class='teamNameTD' hidden>{{ $assistLeader->player->team_name }}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
									<div class="leagueLeadersCategory col-12 col-md mx-auto" id="league_leaders_rebounds">
										<table class="table table-responsive-sm" id="rebounds_category">
											<thead>
												<tr class="leagueLeadersCategoryFR">
													<th></th>
													<th>Total Rebounds</th>
													<th>RPG</th>
												</tr>
											</thead>
											<tbody>
												@foreach($season->stats()->reboundingLeaders(5)->get() as $reboundsLeader)
													<tr data-toggle="modal" data-target="#player_card">
														<td class='playerNameTD'>#{{ $reboundsLeader->player->jersey_num . ' ' . $reboundsLeader->player->player_name }}</td>
														<td class='totalPointsTD' hidden>{{ $reboundsLeader->TPTS == null ? 0 : $reboundsLeader->TPTS }}</td>
														<td class='pointsPGTD' hidden>{{ $reboundsLeader->PPG == null ? 0 : $reboundsLeader->PPG }}</td>
														<td class='totalThreesTD' hidden>{{ $reboundsLeader->TTHR == null ? 0 : $reboundsLeader->TTHR }}</td>
														<td class='threesPGTD' hidden>{{ $reboundsLeader->TPG == null ? 0 : $reboundsLeader->TPG }}</td>
														<td class='totalFTTD' hidden>{{ $reboundsLeader->TFTS == null ? 0 : $reboundsLeader->TFTS }}</td>
														<td class='freeThrowsPGTD' hidden>{{ $reboundsLeader->FTPG == null ? 0 : $reboundsLeader->FTPG }}</td>
														<td class='totalAssTD' hidden>{{ $reboundsLeader->TASS == null ? 0 : $reboundsLeader->TASS }}</td>
														<td class='assistPGTD' hidden>{{ $reboundsLeader->APG == null ? 0 : $reboundsLeader->APG }}</td>
														<td class='totalRebTD text-center'>{{ $reboundsLeader->TRBD == null ? 0 : $reboundsLeader->TRBD }}</td>
														<td class='rebPGTD text-center'>{{ $reboundsLeader->RPG == null ? 0 : $reboundsLeader->RPG }}</td>
														<td class='totalStealsTD' hidden>{{ $reboundsLeader->TSTL == null ? 0 : $reboundsLeader->TSTL }}</td>
														<td class='stealsPGTD' hidden>{{ $reboundsLeader->SPG == null ? 0 : $reboundsLeader->SPG }}</td>
														<td class='totalBlocksTD' hidden>{{ $reboundsLeader->TBLK == null ? 0 : $reboundsLeader->TBLK }}</td>
														<td class='blocksPGTD' hidden>{{ $reboundsLeader->BPG == null ? 0 : $reboundsLeader->BPG }}</td>
														<td class='teamNameTD' hidden>{{ $reboundsLeader->player->team_name }}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
									<div class="leagueLeadersCategory col-12 col-md mx-auto" id="league_leaders_steals">
										<table class="table table-responsive-sm" id="steals_category">
											<thead>
												<tr class="leagueLeadersCategoryFR">
													<th></th>
													<th>Total Steals</th>
													<th>SPG</th>
												</tr>
											</thead>
											<tbody>
												@foreach($season->stats()->stealingLeaders(5)->get() as $stealsLeader)
													<tr data-toggle="modal" data-target="#player_card">
														<td class='playerNameTD'>#{{ $stealsLeader->player->jersey_num . '  ' . $stealsLeader->player->player_name }}</td>
														<td class='totalPointsTD' hidden>{{ $stealsLeader->TPTS == null ? 0 : $stealsLeader->TPTS }}</td>
														<td class='pointsPGTD' hidden>{{ $stealsLeader->PPG == null ? 0 : $stealsLeader->PPG }}</td>
														<td class='totalThreesTD' hidden>{{ $stealsLeader->TTHR == null ? 0 : $stealsLeader->TTHR }}</td>
														<td class='threesPGTD' hidden>{{ $stealsLeader->TPG == null ? 0 : $stealsLeader->TPG }}</td>
														<td class='totalFTTD' hidden>{{ $stealsLeader->TFTS == null ? 0 : $stealsLeader->TFTS }}</td>
														<td class='freeThrowsPGTD' hidden>{{ $stealsLeader->FTPG == null ? 0 : $stealsLeader->FTPG }}</td>
														<td class='totalAssTD' hidden>{{ $stealsLeader->TASS == null ? 0 : $stealsLeader->TASS }}</td>
														<td class='assistPGTD' hidden>{{ $stealsLeader->APG == null ? 0 : $stealsLeader->APG }}</td>
														<td class='totalRebTD' hidden>{{ $stealsLeader->TRBD == null ? 0 : $stealsLeader->TRBD }}</td>
														<td class='rebPGTD' hidden>{{ $stealsLeader->RPG == null ? 0 : $stealsLeader->RPG }}</td>
														<td class='totalStealsTD text-center'>{{ $stealsLeader->TSTL == null ? 0 : $stealsLeader->TSTL }}</td>
														<td class='stealsPGTD text-center'>{{ $stealsLeader->SPG == null ? 0 : $stealsLeader->SPG }}</td>
														<td class='totalBlocksTD' hidden>{{ $stealsLeader->TBLK == null ? 0 : $stealsLeader->TBLK }}</td>
														<td class='blocksPGTD' hidden>{{ $stealsLeader->BPG == null ? 0 : $stealsLeader->BPG }}</td>
														<td class='teamNameTD' hidden>{{ $stealsLeader->player->team_name }}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
									<div class="leagueLeadersCategory col-12 col-md mx-auto" id="league_leaders_blocks">
										<table class="table table-responsive-sm" id="blocks_category">
											<thead>
												<tr class="leagueLeadersCategoryFR">
													<th></th>
													<th>Total Blocks</th>
													<th>BPG</th>
												</tr>
											</thead>
											<tbody>
												@foreach($season->stats()->blockingLeaders(5)->get() as $blocksLeader)
													<tr data-toggle="modal" data-target="#player_card">
														<td class='playerNameTD'>#{{ $blocksLeader->player->jersey_num . ' ' . $blocksLeader->player->player_name }}</td>
														<td class='totalPointsTD' hidden>{{ $blocksLeader->TPTS == null ? 0 : $blocksLeader->TPTS }}</td>
														<td class='pointsPGTD' hidden>{{ $blocksLeader->PPG == null ? 0 : $blocksLeader->PPG }}</td>
														<td class='totalThreesTD' hidden>{{ $blocksLeader->TTHR == null ? 0 : $blocksLeader->TTHR }}</td>
														<td class='threesPGTD' hidden>{{ $blocksLeader->TPG == null ? 0 : $blocksLeader->TPG }}</td>
														<td class='totalFTTD' hidden>{{ $blocksLeader->TFTS == null ? 0 : $blocksLeader->TFTS }}</td>
														<td class='freeThrowsPGTD' hidden>{{ $blocksLeader->FTPG == null ? 0 : $blocksLeader->FTPG }}</td>
														<td class='totalAssTD' hidden>{{ $blocksLeader->TASS == null ? 0 : $blocksLeader->TASS }}</td>
														<td class='assistPGTD' hidden>{{ $blocksLeader->APG == null ? 0 : $blocksLeader->APG }}</td>
														<td class='totalRebTD' hidden>{{ $blocksLeader->TRBD == null ? 0 : $blocksLeader->TRBD }}</td>
														<td class='rebPGTD' hidden>{{ $blocksLeader->RPG == null ? 0 : $blocksLeader->RPG }}</td>
														<td class='totalStealsTD' hidden>{{ $blocksLeader->TST == null ? 0 : $blocksLeader->TSTL }}</td>
														<td class='stealsPGTD' hidden>{{ $blocksLeader->SPG == null ? 0 : $blocksLeader->SPG }}</td>
														<td class='totalBlocksTD text-center'>{{ $blocksLeader->TBLK == null ? 0 : $blocksLeader->TBLK }}</td>
														<td class='blocksPGTD text-center'>{{ $blocksLeader->BPG == null ? 0 : $blocksLeader->BPG }}</td>
														<td class='teamNameTD' hidden>{{ $blocksLeader->player->team_name }}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								<div class="hidden table-wrapper" id="player_stats" style="display:none !important; max-height: initial;">
									<table class="table" id="player_stats_table">
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
												<tr data-toggle="modal" data-target="#player_card" class="text-center">
													<td class='playerNameTD'>#{{ $showPlayer->player->jersey_num . ' ' . $showPlayer->player->player_name }}</td>
													<td class='totalPointsTD'>{{ $showPlayer->TPTS == null ? 0 : $showPlayer->TPTS }}</td>
													<td class='pointsPGTD'>{{ $showPlayer->PPG == null ? 0 : $showPlayer->PPG }}</td>
													<td class='totalThreesTD'>{{ $showPlayer->TTHR == null ? 0 : $showPlayer->TTHR }}</td>
													<td class='threesPGTD'>{{ $showPlayer->TPG == null ? 0 : $showPlayer->TPG }}</td>
													<td class='totalFTTD'>{{ $showPlayer->TFTS == null ? 0 : $showPlayer->TFTS }}</td>
													<td class='freeThrowsPGTD'>{{ $showPlayer->FTPG == null ? 0 : $showPlayer->FTPG }}</td>
													<td class='totalAssTD'>{{ $showPlayer->TASS == null ? 0 : $showPlayer->TASS }}</td>
													<td class='assistPGTD'>{{ $showPlayer->APG == null ? 0 : $showPlayer->APG }}</td>
													<td class='totalRebTD'>{{ $showPlayer->TRBD == null ? 0 : $showPlayer->TRBD }}</td>
													<td class='rebPGTD'>{{ $showPlayer->RPG == null ? 0 : $showPlayer->RPG }}</td>
													<td class='totalStealsTD'>{{ $showPlayer->TSTL == null ? 0 : $showPlayer->TSTL }}</td>
													<td class='stealsPGTD'>{{ $showPlayer->SPG == null ? 0 : $showPlayer->SPG }}</td>
													<td class='totalBlocksTD'>{{ $showPlayer->TBLK == null ? 0 : $showPlayer->TBLK }}</td>
													<td class='blocksPGTD'>{{ $showPlayer->BPG == null ? 0 : $showPlayer->BPG }}</td>
													<td class='teamNameTD' hidden>{{ $showPlayer->player->team_name }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>

								<div class="hidden table-wrapper" id="team_stats" style="display:none !important; max-height: initial;">
									<table class="table" id="team_stats_table">
										<thead>
											<tr class='text-center'>
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
												<tr data-toggle="modal" data-target="#team_card" class='text-center'>
													<td class='teamNameTD'>{{ $showTeam->team_name }}</td>
													<td class='totalPointsTD'>{{ $showTeam->TPTS  == null ? 0 : $showTeam->TPTS }}</td>
													<td class='pointsPGTD'>{{ $showTeam->PPG  == null ? 0.00 : $showTeam->PPG }}</td>
													<td class='threesPGTD'>{{ $showTeam->TPG  == null ? 0.00 : $showTeam->TPG }}</td>
													<td class='freeThrowsPGTD'>{{ $showTeam->FTPG  == null ? 0.00 : $showTeam->FTPG }}</td>
													<td class='assistPGTD'>{{ $showTeam->APG  == null ? 0.00 : $showTeam->APG }}</td>
													<td class='rebPGTD'>{{ $showTeam->RPG  == null ? 0.00 : $showTeam->RPG }}</td>
													<td class='stealsPGTD'>{{ $showTeam->SPG  == null ? 0.00 : $showTeam->SPG }}</td>
													<td class='blocksPGTD'>{{ $showTeam->BPG  == null ? 0.00 : $showTeam->BPG }}</td>
													<td class='totalThreesTD' hidden>{{ $showTeam->TTHR  == null ? 0 : $showTeam->TTHR }}</td>
													<td class='totalFTTD' hidden>{{ $showTeam->TFTS  == null ? 0 : $showTeam->TFTS }}</td>
													<td class='totalAssTD' hidden>{{ $showTeam->TASS  == null ? 0 : $showTeam->TASS }}</td>
													<td class='totalRebTD' hidden>{{ $showTeam->TRBD  == null ? 0 : $showTeam->TRBD }}</td>
													<td class='totalStealsTD' hidden>{{ $showTeam->TSTL  == null ? 0 : $showTeam->TSTL }}</td>
													<td class='totalBlocksTD' hidden>{{ $showTeam->TBLK  == null ? 0 : $showTeam->TBLK }}</td>
													<td class='totalWinsTD' hidden>{{ $showTeam->team_wins  == null ? 0 : $showTeam->team_wins }}</td>
													<td class='totalLossesTD' hidden>{{ $showTeam->team_losses  == null ? 0 : $showTeam->team_losses }}</td>
													<td class='totalGamesTD' hidden>{{ $showTeam->team_games  == null ? 0 : $showTeam->team_games }}</td>
													<td class='teamPicture' hidden>{{ $showTeam->team_picture != null ? $showTeam->team_picture : $defaultImg }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						@else
							<div class="view d-flex align-items-center justify-content-center">
								<div class="rgba-amber-strong p-3 rounded z-depth-2">
									<h1 class="h1-responsive coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;There are no stats added for this season yet&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h1>
								</div>
							</div>
						@endif

					</div>
					<!--/.Stats Panel-->
					
					<!--Schedule Panel-->
					<div class="tab-pane fade" id="season_schedule" role="tabpanel">
						@if($season->is_playoffs == 'Y')
							@if($nonPlayInGames->get()->isNotEmpty())
								<!-- Playoff Round Games -->
								@foreach($playoffRounds as $round)
									<div class='leagues_schedule text-center mb-5 table-wrapper'>
										<table id='week_schedule' class='weekly_schedule table'>
											<thead>
												<tr class="indigo darken-2 white-text">
													<th class="text-center" colspan="6">
														<h2 class="h2-responsive position-relative my-3">
															<span>{{ $round->round == $playoffSettings->total_rounds ? 'Championship Game' : 'Round ' . $round->round . ' Games' }}</span>
														</h2>
													</th>
												</tr>
												<tr class="indigo darken-3 white-text">
													<th class="text-center" colspan="3">Match-Up</th>
													<th>Time</th>
													<th>Date</th>
												</tr>
											</thead>
											<tbody>
												@foreach($season->games()->roundGames($round->round)->get() as $game)
													<tr>
														@if($game->result)
															<td class="awayTeamData"><span class="awayTeamNameData">{{ $game->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $game->away_team_obj->id }}</span>
																@if($game->result->winning_team_id == $game->away_team_id)
																	@if($game->result->forfeit == 'Y')
																		<span class="badge badge-pill green darken-2 ml-3 forfeitData awayTeamScoreData">Winner</span>
																	@else
																		<span class="badge badge-pill green darken-2 ml-3 awayTeamScoreData">{{ $game->result->away_team_score }}</span>
																	@endif
																@else
																	@if($game->result->forfeit == 'Y')
																		<span class="badge badge-pill red darken-2 ml-3 awayTeamScoreData forfeitData">Forfeit</span>
																	@else
																		<span class="badge badge-pill red darken-2 ml-3 awayTeamScoreData">{{ $game->result->away_team_score }}</span>
																	@endif
																@endif
															</td>
															<td>vs</td>
															<td class="homeTeamData"><span class="homeTeamNameData">{{ $game->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $game->home_team_obj->id }}</span>
																@if($game->result->winning_team_id == $game->home_team_id)
																	@if($game->result->forfeit == 'Y')
																		<span class="badge badge-pill green darken-2 ml-3 forfeitData homeTeamScoreData">Winner</span>
																	@else
																		<span class="badge badge-pill green darken-2 ml-3 homeTeamScoreData">{{ $game->result->home_team_score }}</span>
																	@endif
																@else
																	@if($game->result->forfeit == 'Y')
																		<span class="badge badge-pill red darken-2 ml-3 homeTeamScoreData forfeitData">Forfeit</span>
																	@else
																		<span class="badge badge-pill red darken-2 ml-3 homeTeamScoreData">{{ $game->result->home_team_score }}</span>
																	@endif
																@endif
															</td>
														@else
															<td class="awayTeamData"><span class="awayTeamNameData">{{ $game->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $game->away_team_obj->id }}</span></td>
															<td>vs</td>
															<td class="homeTeamData"><span class="homeTeamNameData">{{ $game->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $game->home_team_obj->id }}</span></td>
														@endif
														
														<td class="gameTimeData">{{ $game->game_time == null ? 'N/A' : $game->game_time() }}</td>
														<td class="gameDateData">{{ $game->game_date == null ? 'N/A' : $game->game_date() }}</td>
														<td class="gameIDData" hidden>{{ $game->id }}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								@endforeach
							@endif
						
							@if($playInGames->get()->isNotEmpty())
								<!-- Playin Games -->
								<div class='leagues_schedule text-center mb-5 table-wrapper'>
									<table id='week_schedule' class='weekly_schedule table'>
										<thead>
											<tr class="indigo darken-2 white-text">
												<th class="text-center" colspan="6">
													<h2 class="h2-responsive position-relative my-3">
														<span>Playoff Playin Games</span>
													</h2>
												</th>
											</tr>
											<tr class="indigo darken-3 white-text">
												<th class="text-center" colspan="3">Match-Up</th>
												<th>Time</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody>
											@foreach($playInGames->get() as $game)
												<tr>
													@if($game->result)
														<td class="awayTeamData"><span class="awayTeamNameData">{{ $game->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $game->away_team_obj->id }}</span>
															@if($game->result->winning_team_id == $game->away_team_id)
																@if($game->result->forfeit == 'Y')
																	<span class="badge badge-pill green darken-2 ml-3 forfeitData awayTeamScoreData">Winner</span>
																@else
																	<span class="badge badge-pill green darken-2 ml-3 awayTeamScoreData">{{ $game->result->away_team_score }}</span>
																@endif
															@else
																@if($game->result->forfeit == 'Y')
																	<span class="badge badge-pill red darken-2 ml-3 awayTeamScoreData forfeitData">Forfeit</span>
																@else
																	<span class="badge badge-pill red darken-2 ml-3 awayTeamScoreData">{{ $game->result->away_team_score }}</span>
																@endif
															@endif
														</td>
														<td>vs</td>
														<td class="homeTeamData"><span class="homeTeamNameData">{{ $game->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $game->home_team_obj->id }}</span>
															@if($game->result->winning_team_id == $game->home_team_id)
																@if($game->result->forfeit == 'Y')
																	<span class="badge badge-pill green darken-2 ml-3 forfeitData homeTeamScoreData">Winner</span>
																@else
																	<span class="badge badge-pill green darken-2 ml-3 homeTeamScoreData">{{ $game->result->home_team_score }}</span>
																@endif
															@else
																@if($game->result->forfeit == 'Y')
																	<span class="badge badge-pill red darken-2 ml-3 homeTeamScoreData forfeitData">Forfeit</span>
																@else
																	<span class="badge badge-pill red darken-2 ml-3 homeTeamScoreData">{{ $game->result->home_team_score }}</span>
																@endif
															@endif
														</td>
													@else
														<td class="awayTeamData"><span class="awayTeamNameData">{{ $game->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $game->away_team_obj->id }}</span></td>
														<td>vs</td>
														<td class="homeTeamData"><span class="homeTeamNameData">{{ $game->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $game->home_team_obj->id }}</span></td>
													@endif
													
													<td class="gameTimeData">{{ $game->game_time == null ? 'N/A' : $game->game_time() }}</td>
													<td class="gameDateData">{{ $game->game_date == null ? 'N/A' : $game->game_date() }}</td>
													<td class="gameIDData" hidden>{{ $game->id }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							@endif
						@endif

						@if($schedule->get()->isNotEmpty())
							@foreach($schedule->orderBy('season_week', 'desc')->get() as $showWeekInfo)
								@php $seasonWeekGames = $season->games()->getWeekGames($showWeekInfo->season_week)->get() @endphp
								<div class='leagues_schedule text-center table-wrapper mb-5'>
									<table id='week_{{ $showWeekInfo->season_week }}_schedule' class='weekly_schedule table'>
										<thead>
											<tr class="indigo darken-2 white-text">
												<th class="text-center" colspan="6">
													<h2 class="h2-responsive position-relative my-3">
														<span>Week {{ $loop->iteration }} Games</span>
													</h2>
												</th>
											</tr>
											<tr class="indigo darken-3 white-text">
												<th class="text-center" colspan="3">Match-Up</th>
												<th>Time</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody>
											@if($seasonWeekGames->isEmpty())
												<tr>
													<th colspan="6" class="">NO GAMES SCHEDULED FOR THIS WEEK</th>
												</tr>
											@else
												@foreach($seasonWeekGames as $game)
													<tr>
														@if($game->result)
															<td class="awayTeamData text-nowrap"><span class="awayTeamNameData">{{ $game->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $game->away_team_obj->id }}</span>
																@if($game->result->winning_team_id == $game->away_team_id)
																	@if($game->result->forfeit == 'Y')
																		<span class="badge badge-pill green darken-2 ml-3 forfeitData awayTeamScoreData">Winner</span>
																	@else
																		<span class="badge badge-pill green darken-2 ml-3 awayTeamScoreData">{{ $game->result->away_team_score }}</span>
																	@endif
																@else
																	@if($game->result->forfeit == 'Y')
																		<span class="badge badge-pill red darken-2 ml-3 awayTeamScoreData forfeitData">Forfeit</span>
																	@else
																		<span class="badge badge-pill red darken-2 ml-3 awayTeamScoreData">{{ $game->result->away_team_score }}</span>
																	@endif
																@endif
															</td>
															<td>vs</td>
															<td class="homeTeamData text-nowrap"><span class="homeTeamNameData">{{ $game->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $game->home_team_obj->id }}</span>
																@if($game->result->winning_team_id == $game->home_team_id)
																	@if($game->result->forfeit == 'Y')
																		<span class="badge badge-pill green darken-2 ml-3 forfeitData homeTeamScoreData">Winner</span>
																	@else
																		<span class="badge badge-pill green darken-2 ml-3 homeTeamScoreData">{{ $game->result->home_team_score }}</span>
																	@endif
																@else
																	@if($game->result->forfeit == 'Y')
																		<span class="badge badge-pill red darken-2 ml-3 homeTeamScoreData forfeitData">Forfeit</span>
																	@else
																		<span class="badge badge-pill red darken-2 ml-3 homeTeamScoreData">{{ $game->result->home_team_score }}</span>
																	@endif
																@endif
															</td>
														@else
															<td class="awayTeamData text-nowrap"><span class="awayTeamNameData">{{ $game->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $game->away_team_obj->id }}</span></td>
															<td>vs</td>
															<td class="homeTeamData text-nowrap"><span class="homeTeamNameData">{{ $game->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $game->home_team_obj->id }}</span></td>
														@endif
														
														<td class="gameTimeData text-nowrap">{{ $game->game_time() }}</td>
														<td class="gameDateData text-nowrap">{{ $game->game_date() }}</td>
														<td class="gameIDData" hidden>{{ $game->id }}</td>
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
							@endforeach
						@else
							<div class="view d-flex align-items-center justify-content-center">
								<div class="rgba-amber-strong p-3 rounded z-depth-2">
									<h2 class="coolText4 h2-responsive">The is no schedule added for this season yet</h2>
								</div>
							</div>
						@endif
					</div>
					<!--/.Schedule Panel-->
					
					<!--Teams Panel-->
					<div class="tab-pane fade" id="season_teams" role="tabpanel">

						@if($teams->isNotEmpty())
							<div class="row">
								@foreach($teams as $team)
									<div class="col-12 col-xl-6">
										<div class="card card-cascade wider my-4">
											<!-- Card image -->
											<div class="view overlay">
												<img class="card-img-top" src="{{ $team->team_picture != null ? $team->sm_photo() : $defaultImg }}" alt="Card image cap">
												<a href="#!">
													<div class="mask rgba-white-slight"></div>
												</a>
											</div>
											
											<!-- Card content -->
											<div class="card-body text-center position-relative border rounded-bottom z-depth-2">
												<!-- Title -->
												<h1 class="card-title h1-responsive font-weight-bold w-75 mx-auto">{{ $team->team_name }}</h1>
												
												<!-- Team Players Info -->
												<div class="">
													<h3 class="h3-responsive text-underline">Players</h3>
													@if($team->players->isNotEmpty())
														@foreach($team->players as $player)
															<div class="d-flex align-items-center justify-content-center">
																<p class="pr-2">#{{ $player->jersey_num }}</p>
																<p class="">{{ $player->player_name }}</p>
															</div>
														@endforeach
													@else
														<h4 class="h4-responsive coolText4">No Players Added For This Team Yet</h4>
													@endif
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@else
							<div class="view d-flex align-items-center justify-content-center">
								<div class="rgba-amber-strong p-3 rounded z-depth-2">
									<h2 class="h2-responsive coolText4 text-center">There are no teams added for this season yet</h2>
								</div>
							</div>
						@endif

					</div>
					<!--/.Teams Panel-->
					
					<!--Pictures Panel-->
					<div class="tab-pane fade" id="season_pictures" role="tabpanel">
					
						@if($pictures->isNotEmpty())
							<div class="row">
								<div class="col-12">
									<div id="mdb-lightbox-ui"></div>

									<div class="mdb-lightbox">
										@foreach($pictures as $picture)
											<figure class="col-4">
												<a href="{{ $picture->sm_photo() }}" class="" data-size="1600x1067">
													<img alt="picture" src="{{ $picture->sm_photo() }}" class="img-fluid" />
												</a>
											</figure>
										@endforeach
									</div>
								</div>
							</div>
						@else
							<div class="view d-flex align-items-center justify-content-center">
								<div class="rgba-amber-strong p-3 rounded z-depth-2">
									<h2 class="h2-responsive coolText4 text-center">There are no pictures for this season yet</h2>
								</div>
							</div>
						@endif
					</div>
					<!--/.Pictures Panel-->
				</div>
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