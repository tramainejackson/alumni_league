@extends('layouts.app')

@section('content')

	<div class="container-fluid bgrd3 pb-5">

		@if($showSeason->is_playoffs == 'Y')
			<div class="row z-depth-3">
				<div class="col-12 playoffTimeHeader" id=""></div>
			</div>
		@endif

		<div class="row{{ $showSeason->league_profile && $checkStats ? '': ' view' }}">

			<div class="col-12 col-lg-10 order-lg-2 order-xl-1 mx-auto">
				<div class="col-12 col-lg-8 pt-3 mx-auto coolText1">
					<div class="text-center p-4 card rgba-deep-orange-light white-text my-3" id="">
						<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
					</div>
				</div>

				@if($week_games->count() > 1)

					<div class="my-4 pb-3" id="" style="display: flex; flex-wrap: nowrap; overflow-x: auto;">

						<h4 class="h4 h4-responsive d-inline-block col-2 text-wrap" style="flex: 0 0 auto;">{{ $weekCheck }}</h4>

						@foreach($week_games as $week_game)

							@if($week_game->id != $gameID)

								@if($week_game->result !== null)

									<div class="d-inline-block col-4 py-1 border border-primary rounded-pill rgba-stylish-light mr-3 align-self-center" id="" style="flex: 0 0 auto;">
										<a href="{{ route('league_stats.show', [$week_game->id, 'season' => $showSeason->id]) }}">

											<div class="container-fluid" id="">
												<div class="row" id="">
													<div class="col-12" id="">
														<p class="m-0 p-0 font-small">Final</p>
													</div>
													<div class="col-12 d-flex align-items-center justify-content-between" id="">
														<p class="m-0 p-0 font-small">{{ $week_game->home_team }}</p>
														<p class="m-0 p-0 font-small">{{ $week_game->result->home_team_score }}</p>
													</div>
													<div class="col-12 d-flex align-items-center justify-content-between" id="">
														<p class="m-0 p-0 font-small">{{ $week_game->away_team }}</p>
														<p class="m-0 p-0 font-small">{{ $week_game->result->away_team_score }}</p>
													</div>
												</div>
											</div>
										</a>
									</div>
								@else
									<div class="d-inline-block col-4 py-1 border border-primary rounded-pill rgba-stylish-light mr-3 align-self-center" id="" style="flex: 0 0 auto;">
										<a href="{{ route('league_stats.show', [$week_game->id]) }}">

											<div class="container-fluid" id="">
												<div class="row" id="">
													<div class="col-12" id="">
														<p class="m-0 p-0 font-small">TBD</p>
													</div>
													<div class="col-12 d-flex align-items-center justify-content-between" id="">
														<p class="m-0 p-0 font-small">{{ $week_game->home_team }}</p>
														<p class="m-0 p-0 font-small">TBD</p>
													</div>
													<div class="col-12 d-flex align-items-center justify-content-between" id="">
														<p class="m-0 p-0 font-small">{{ $week_game->away_team }}</p>
														<p class="m-0 p-0 font-small">TBD</p>
													</div>
												</div>
											</div>
										</a>
									</div>
								@endif
							@endif
						@endforeach
					</div>
				@endif

				@if($game_results->forfeit == 'N')

					<div class="row mt-3 mb-5 flex-column flex-md-row" id="">
						<div class="away_team_score col-12 col-md-5 d-flex align-items-center justify-content-around" id="">
							<h2 class="h2-responsive">{{ $away_team->team_name }}</h2>

							<img src="{{ $away_team->sm_photo() }}" class="rounded-circle img-thumbnail img-fluid" height="50px" width="50px" />

							<h2 class="{{ $game_results->winning_team_id == $away_team->id ? 'green-text' : '' }}">{{ $game_results->away_team_score != null ? $game_results->away_team_score : '0' }}</h2>
						</div>

						<div class="col-12 col-md-2 text-center" id=""><h4 class="h4-responsive my-2">Game Result</h4></div>

						<div class="home_team_score col-12 col-md-5 d-flex align-items-center justify-content-around" id="">
							<h2 class="{{ $game_results->winning_team_id == $home_team->id ? 'green-text' : '' }} order-last order-md-0">{{ $game_results->home_team_score != null ? $game_results->home_team_score : '0' }}</h2>

							<img src="{{ $home_team->sm_photo() }}" class="rounded-circle img-thumbnail img-fluid" height="50px" width="50px" />

							<h2 class="h2-responsive order-first order-md-2">{{ $home_team->team_name }}</h2>
						</div>
					</div>

					<div class="" id="">
						@if($game->season_week == null)
							@if($game->playin_game == 'Y')
								<h2 class="h2-responsive text-center">Playoff Play-In Game</h2>
							@elseif($game->all_star_game == 'Y')
								<h2 class="h2-responsive text-center">ALL-STAR GAME</h2>
							@else
								@if($game->round == $playoffSettings->total_rounds)
									<h2 class="h2-responsive text-center">Championship Game</h2>
								@else
									<h2 class="h2-responsive text-center">Playoff Round {{ $game->round }}</h2>
								@endif
							@endif
						@else
							<h2 class="h2-responsive text-center">Week {{ $game->season_week }}</h2>
						@endif
					</div>

					<div class="row" id="">
						<div class="col-12 col-md-6 away_team_stats" id="">
							<div class="showGameStats col-12 col-md my-1 mx-auto table-wrapper" id="">
								<table class="table white-text" id="show_away_team_stats">
									<thead>
										<tr class="leagueLeadersCategoryFR">
											<th></th>
											<th>Points</th>
											<th>Rebounds</th>
											<th>Assist</th>
											<th>Blocks</th>
											<th>Steals</th>
										</tr>
									</thead>
									<tbody>
										@foreach($away_team->players as $away_team_player)
											@php $player_game_stats = $game->player_stats->where('league_player_id', $away_team_player->id)->first(); @endphp

											@if($player_game_stats != null)
												<tr data-toggle="modal" data-target="#player_card" class="text-center{{ $player_game_stats->potw == 'Y' ? ' red' : '' }}">
													<td class='playerNameTD'>#{{ $away_team_player->jersey_num . ' ' . $away_team_player->player_name }}</td>
													<td class='playerStatTD'>{{ $player_game_stats->points != null ? $player_game_stats->points : 0 }}</td>
													<td class='playerStatTD'>{{ $player_game_stats->rebounds != null ? $player_game_stats->rebounds : 0 }}</td>
													<td class='playerStatTD'>{{ $player_game_stats->assists != null ? $player_game_stats->assists : 0 }}</td>
													<td class='playerStatTD'>{{ $player_game_stats->blocks != null ? $player_game_stats->blocks : 0 }}</td>
													<td class='playerStatTD'>{{ $player_game_stats->steals != null ? $player_game_stats->steals : 0 }}</td>
													<td class='totalPointsTD text-center' hidden>{{ $away_team_player->TPTS == null ? 0 : $away_team_player->TPTS }}</td>
													<td class='pointsPGTD text-center' hidden>{{ $away_team_player->PPG == null ? 0 : $away_team_player->PPG }}</td>
													<td class='totalThreesTD' hidden>{{ $away_team_player->TTHR == null ? 0 : $away_team_player->TTHR }}</td>
													<td class='threesPGTD' hidden>{{ $away_team_player->TPG == null ? 0 : $away_team_player->TPG }}</td>
													<td class='totalFTTD' hidden>{{ $away_team_player->TFTS == null ? 0 : $away_team_player->TFTS }}</td>
													<td class='freeThrowsPGTD' hidden>{{ $away_team_player->FTPG == null ? 0 : $away_team_player->FTPG }}</td>
													<td class='totalAssTD' hidden>{{ $away_team_player->TASS == null ? 0 : $away_team_player->TASS }}</td>
													<td class='assistPGTD' hidden>{{ $away_team_player->APG == null ? 0 : $away_team_player->APG }}</td>
													<td class='totalRebTD' hidden>{{ $away_team_player->TRBD == null ? 0 : $away_team_player->TRBD }}</td>
													<td class='rebPGTD' hidden>{{ $away_team_player->RPG == null ? 0 : $away_team_player->RPG }}</td>
													<td class='totalStealsTD' hidden>{{ $away_team_player->TSTL == null ? 0 : $away_team_player->TSTL }}</td>
													<td class='stealsPGTD' hidden>{{ $away_team_player->SPG == null ? 0 : $away_team_player->SPG }}</td>
													<td class='totalBlocksTD' hidden>{{ $away_team_player->TBLK == null ? 0 : $away_team_player->TBLK }}</td>
													<td class='blocksPGTD' hidden>{{ $away_team_player->BPG == null ? 0 : $away_team_player->BPG }}</td>
													<td class='teamNameTD' hidden>{{ $away_team_player->team_name }}</td>
													<td class='allStarTD' hidden>{{ $away_team_player->all_star }}</td>
												</tr>
											@endif
										@endforeach
									</tbody>
								</table>
							</div>
						</div>

						<div class="col-12 col-md-6 home_team_stats" id="">
							<div class="showGameStats col-12 col-md my-1 mx-auto table-wrapper" id="">
								<table class="table white-text" id="show_home_team_stats">
									<thead>
										<tr class="">
											<th></th>
											<th>Points</th>
											<th>Rebounds</th>
											<th>Assist</th>
											<th>Blocks</th>
											<th>Steals</th>
										</tr>
									</thead>
									<tbody>
										@foreach($home_team->players as $home_team_player)
											@php $player_game_stats = $game->player_stats->where('league_player_id', $home_team_player->id)->first(); @endphp

											@if($player_game_stats != null)
												<tr data-toggle="modal" data-target="#player_card">
													<td class='playerNameTD'>#{{ $home_team_player->jersey_num . ' ' . $home_team_player->player_name }}</td>
													<td class='playerStatTD'>{{ $player_game_stats->points != null ? $player_game_stats->points : 0 }}</td>
													<td class='playerStatTD'>{{ $player_game_stats->rebounds != null ? $player_game_stats->rebounds : 0 }}</td>
													<td class='playerStatTD'>{{ $player_game_stats->assists != null ? $player_game_stats->assists : 0 }}</td>
													<td class='playerStatTD'>{{ $player_game_stats->blocks != null ? $player_game_stats->blocks : 0 }}</td>
													<td class='playerStatTD'>{{ $player_game_stats->steals != null ? $player_game_stats->steals : 0 }}</td>
													<td class='totalPointsTD text-center' hidden>{{ $home_team_player->TPTS == null ? 0 : $home_team_player->TPTS }}</td>
													<td class='pointsPGTD text-center' hidden>{{ $home_team_player->PPG == null ? 0 : $home_team_player->PPG }}</td>
													<td class='totalThreesTD' hidden>{{ $home_team_player->TTHR == null ? 0 : $home_team_player->TTHR }}</td>
													<td class='threesPGTD' hidden>{{ $home_team_player->TPG == null ? 0 : $home_team_player->TPG }}</td>
													<td class='totalFTTD' hidden>{{ $home_team_player->TFTS == null ? 0 : $home_team_player->TFTS }}</td>
													<td class='freeThrowsPGTD' hidden>{{ $home_team_player->FTPG == null ? 0 : $home_team_player->FTPG }}</td>
													<td class='totalAssTD' hidden>{{ $home_team_player->TASS == null ? 0 : $home_team_player->TASS }}</td>
													<td class='assistPGTD' hidden>{{ $home_team_player->APG == null ? 0 : $home_team_player->APG }}</td>
													<td class='totalRebTD' hidden>{{ $home_team_player->TRBD == null ? 0 : $home_team_player->TRBD }}</td>
													<td class='rebPGTD' hidden>{{ $home_team_player->RPG == null ? 0 : $home_team_player->RPG }}</td>
													<td class='totalStealsTD' hidden>{{ $home_team_player->TSTL == null ? 0 : $home_team_player->TSTL }}</td>
													<td class='stealsPGTD' hidden>{{ $home_team_player->SPG == null ? 0 : $home_team_player->SPG }}</td>
													<td class='totalBlocksTD' hidden>{{ $home_team_player->TBLK == null ? 0 : $home_team_player->TBLK }}</td>
													<td class='blocksPGTD' hidden>{{ $home_team_player->BPG == null ? 0 : $home_team_player->BPG }}</td>
													<td class='teamNameTD' hidden>{{ $home_team_player->team_name }}</td>
													<td class='allStarTD' hidden>{{ $home_team_player->all_star }}</td>
												</tr>
											@endif
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				@else

					<div class="row mt-3 mb-5 flex-column flex-md-row" id="">
						<div class="away_team_score col-12 col-md-5 d-flex align-items-center justify-content-around" id="">
							<h2 class="h2-responsive">{{ $away_team->team_name }}</h2>

							<img src="{{ $away_team->sm_photo() }}" class="rounded-circle img-thumbnail img-fluid" height="50px" width="50px" />

							<h2 class="{{ $game_results->winning_team_id == $away_team->id ? 'green-text' : '' }}">{{ $game_results->away_team_score != null ? $game_results->away_team_score : '0' }}</h2>
						</div>

						<div class="col-2 text-center" id=""><h4 class="h4-responsive my-2">Game Result</h4></div>

						<div class="home_team_score col-12 col-md-5 d-flex align-items-center justify-content-around" id="">
							<h2 class="{{ $game_results->winning_team_id == $home_team->id ? 'green-text' : '' }}">{{ $game_results->home_team_score != null ? $game_results->home_team_score : '0' }}</h2>

							<img src="{{ $home_team->sm_photo() }}" class="rounded-circle img-thumbnail img-fluid" height="50px" width="50px" />

							<h2 class="h2-responsive">{{ $home_team->team_name }}</h2>
						</div>
					</div>

					<div class="" id="">
						@if($game->season_week == null)
							@if($game->playin_game == 'Y')
								<h2 class="h2-responsive text-center">Playoff Play-In Game</h2>
							@elseif($game->all_star_game == 'Y')
								<h2 class="h2-responsive text-center">ALL-STAR GAME</h2>
							@else
								@if($game->round == $playoffSettings->total_rounds)
									<h2 class="h2-responsive text-center">Championship Game</h2>
								@else
									<h2 class="h2-responsive text-center">Playoff Round {{ $game->round }}</h2>
								@endif
							@endif
						@else
							<h2 class="h2-responsive text-center">Week {{ $game->season_week }}</h2>
						@endif
					</div>

					<div class="" id="">
						<div class="card z-depth-3 rgba-white-strong py-3" id="">
							<h2 class="text-center display-4 coolText4">There Aren't Any Stats Recorded For This Game. This Game Was A Forfeit</h2>
						</div>
					</div>
				@endif
			</div>
		</div>

		@include('modals.player_card')

	</div>

	<!-- Footer -->
	@include('layouts.footer')
	<!-- Footer -->
@endsection