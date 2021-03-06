@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">

		@if($showSeason->is_playoffs == 'Y')
			<div class="row z-depth-3">
				<div class="col-12 playoffTimeHeader" id=""></div>
			</div>
		@endif

		<div class="row">

			<div class="col-12 my-3">
				@if(Auth::check() && (Auth::user()->type == 'statistician' || Auth::user()->type == 'admin'))
					{{--Authourization Only--}}
                    @if($seasonScheduleWeeks->isNotEmpty())
                        @foreach($seasonScheduleWeeks as $week)
                            <a href="{{ request()->query() == null ? route('league_stats.edit_week', ['week' => $week->season_week]) : route('league_stats.edit_week', ['week' => $week->season_week, 'season' => request()->query('season')]) }}" class="btn btn-rounded mdb-color darken-3 white-text mw-100">Week {{ $loop->iteration }} Stats</a>
                        @endforeach
                    @endif

                    @if($showSeason->is_playoffs == 'Y')
						@foreach($playoffRounds as $round)
							<a href="{{ request()->query() == null ? route('league_stats.edit_round', ['round' => $round->round]) : route('league_stats.edit_round', ['round' => $round->round, 'season' => request()->query('season')]) }}" class="btn btn-rounded mdb-color darken-3 white-text mw-100">{{ $round->round != $playoffSettings->total_rounds ? 'Round ' . $round->round  . ' Stats' : 'Championship Game Stats'}}</a>
						@endforeach
					@endif

					@if($allStarGame != null)
						<a href="{{ request()->query() == null ? route('league_stats.all_star_game', ['game' => $allStarGame->id]) : route('league_stats.all_star_game', ['game' => $allStarGame->id, 'season' => request()->query('season')]) }}" class="btn btn-rounded mdb-color darken-3 white-text mw-100">All Star Game Stats</a>
					@endif
				@else
                    @if($seasonScheduleWeeks->isNotEmpty())
                        @foreach($seasonScheduleWeeks as $week)
                            <a href="{{ request()->query() == null ? route('league_stats.show', ['week' => $week->season_week]) : route('league_stats.show', ['week' => $week->season_week, 'season' => request()->query('season')]) }}" class="btn btn-rounded mdb-color darken-3 white-text mw-100">Week {{ $loop->iteration }} Stats</a>
                        @endforeach
                    @endif

                    @if($showSeason->is_playoffs == 'Y')
                        @foreach($playoffRounds as $round)
                            <a href="{{ request()->query() == null ? route('league_stats.show', ['round' => $round->round]) : route('league_stats.show', [$round->round, 'round' => $round->round, 'season' => request()->query('season')]) }}" class="btn btn-rounded mdb-color darken-3 white-text mw-100">{{ $round->round != $playoffSettings->total_rounds ? 'Round ' . $round->round  . ' Stats' : 'Championship Game Stats'}}</a>
                        @endforeach
                    @endif

                    @if($allStarGame != null)
                        <a href="{{ request()->query() == null ? route('league_stats.all_star_game', ['game' => $allStarGame->id]) : route('league_stats.all_star_game', ['game' => $allStarGame->id, 'season' => request()->query('season')]) }}" class="btn btn-rounded mdb-color darken-3 white-text mw-100">All Star Game Stats</a>
                    @endif
				@endif
			</div>
		</div>

		<div class="row view">

			<div class="pt-3 col-12 col-lg-8 mx-auto{{ $checkStats ? '' : ' d-flex justify-content-center flex-column' }}">
				<div class="text-center coolText1">
					<div class="text-center p-4 card rgba-deep-orange-light white-text mb-3" id="">
						<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
					</div>
				</div>

				@if($checkStats)

					<div id="league_stat_categories" class="d-flex flex-column flex-md-row align-items-center justify-content-around">
						<button type="button" class="btn statCategoryBtn gray activeBtn w-100" id="league_leaders_btn">League Leaders</button>
						<button type="button" class="btn statCategoryBtn gray w-100" id="player_stats_btn">Player Stats</button>
						<button type="button" class="btn statCategoryBtn gray w-100" id="team_stats_btn">Team Stats</button>
					</div>

					<div id="league_stats" class="container-fluid mb-4">

						<div id="league_leaders" class="row">

							<div class="leagueLeadersCategory col-12 col-md my-1 mx-auto table-wrapper" id="league_leaders_points">
								<table class="table white-text text-nowrap" id="points_category">
									<thead>
										<tr class="leagueLeadersCategoryFR">
											<th></th>
											<th>Total Points</th>
											<th>PPG</th>
										</tr>
									</thead>
									<tbody>
										@foreach($showSeason->stats()->scoringLeaders(5)->get() as $scoringLeader)
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
												<td class='allStarTD' hidden>{{ $scoringLeader->player->all_star }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>

							<div class="leagueLeadersCategory col-12 col-md mx-auto my-1 table-wrapper" id="league_leaders_assist">
								<table class="table white-text text-nowrap" id="assist_category">
									<thead>
										<tr class="leagueLeadersCategoryFR">
											<th></th>
											<th>Total Assists</th>
											<th>APG</th>
										</tr>
									</thead>
									<tbody>
										@foreach($showSeason->stats()->assistingLeaders(5)->get() as $assistLeader)
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
												<td class='allStarTD' hidden>{{ $assistLeader->player->all_star }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>

							<div class="leagueLeadersCategory col-12 col-md mx-auto my-1 table-wrapper" id="league_leaders_rebounds">
								<table class="table white-text text-nowrap" id="rebounds_category">
									<thead>
										<tr class="leagueLeadersCategoryFR">
											<th></th>
											<th>Total Rebounds</th>
											<th>RPG</th>
										</tr>
									</thead>
									<tbody>
										@foreach($showSeason->stats()->reboundingLeaders(5)->get() as $reboundsLeader)
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
												<td class='allStarTD' hidden>{{ $reboundsLeader->player->all_star }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>

							<div class="leagueLeadersCategory col-12 col-md mx-auto my-1 table-wrapper" id="league_leaders_steals">
								<table class="table white-text text-nowrap" id="steals_category">
									<thead>
										<tr class="leagueLeadersCategoryFR">
											<th></th>
											<th>Total Steals</th>
											<th>SPG</th>
										</tr>
									</thead>
									<tbody>
										@foreach($showSeason->stats()->stealingLeaders(5)->get() as $stealsLeader)
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
												<td class='allStarTD' hidden>{{ $stealsLeader->player->all_star }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>

							<div class="leagueLeadersCategory col-12 col-md mx-auto my-1 table-wrapper" id="league_leaders_blocks">
								<table class="table white-text text-nowrap" id="blocks_category">
									<thead>
										<tr class="leagueLeadersCategoryFR">
											<th></th>
											<th>Total Blocks</th>
											<th>BPG</th>
										</tr>
									</thead>
									<tbody>
										@foreach($showSeason->stats()->blockingLeaders(5)->get() as $blocksLeader)
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
												<td class='allStarTD' hidden>{{ $blocksLeader->player->all_star }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>

						</div>

						<div class="hidden table-wrapper" id="player_stats" style="display:none !important; max-height: initial;">
							<table class="table table-bordered text-nowrap" id="player_stats_table">
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
											<td class='allStarTD' hidden>{{ $showPlayer->player->all_star }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>

						<div class="hidden table-wrapper" id="team_stats" style="display:none !important; max-height: initial;">
							<table class="table table-bordered text-nowrap" id="team_stats_table">
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
					@if(Auth::check())
						<div class="text-center">
							<h1 class="h1-responsive coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;There are no stats added for this season yet. Once you have games, teams and players added, you will be able to add their stats to the games&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h1>
						</div>
					@else
						<div class="text-center">
							<h1 class="h1-responsive coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;There are no stats added for this season yet.<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h1>
						</div>
					@endif

				@endif
			</div>
		</div>
		
		<!-- Modal Cards -->
		@include('modals.player_card')
		@include('modals.team_card')
	</div>

	<!-- Footer -->
	@include('content_parts.footer')
	<!-- Footer -->
@endsection