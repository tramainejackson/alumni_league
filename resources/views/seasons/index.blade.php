@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">

		<div class="row view">

			@if($showSeason->paid == 'Y')

				<div class="row">
					<!-- League season schedule snap shot -->
					<div class="col-12 col-lg-8 col-xl-8 mx-auto py-2">
						<h2 class="display-2 text-center">Current Season</h2>
						<h2 class="display-4 text-center font-italic">Name: {{ $showSeason->name }}</h2>
					</div>

					<div class="col-12 col-lg-8 col-xl-8 mx-auto my-5">
						<div class="my-5 d-flex align-items-center justify-content-center flex-column">
							<div class="d-flex w-100 justify-content-center align-items-center flex-column flex-lg-row">
								<h1 class="h1-responsive">Upcoming Schedule</h1>
								<a href="{{ request()->query() == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">Full Schedule</a>
							</div>

							<div class="container-fluid" id="season_schedule_snap">
								<div class="row">
									@if($showSeasonSchedule->isNotEmpty())
										@foreach($showSeasonSchedule as $upcomingGame)
											<div class="card col-12 col-md-6 col-lg-4 col-lg-3 my-2">
												<h3 class="h3-responsive text-center p-4 blue-grey white-text">Week&nbsp;{{ $upcomingGame->season_week }}</h3>
												<div class="card-body text-center">
													<p class="">{{ $upcomingGame->home_team }}</p>
													<p class="">vs</p>
													<p class="">{{ $upcomingGame->away_team }}</p>
												</div>
												<div class="card-footer px-1 d-flex align-items-center justify-content-around">
													<span class="mx-2"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;{{ $upcomingGame->game_time() }}</span>
													<span class="mx-2"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;{{ $upcomingGame->game_date() }}</span>
												</div>
											</div>
										@endforeach
									@else
										<div class="col text-center">
											<h3 class="h3-responsive">No upcoming games within the next week on this seasons schedule</h3>
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
					<!--./ League season schedule snap shot /.-->

					<!-- Divider /.-->
					<div class="divider-short" id=""></div>
					<!--./ Divider /.-->

					<!-- League season teams snap shot -->
					<div class="col-8 mx-auto my-5">
						<div class="d-flex w-100 justify-content-center align-items-center flex-column flex-lg-row">
							<h1 class="h1-responsive">Quick Teams</h1>
							<a href="{{ request()->query() == null ? route('league_teams.index') : route('league_teams.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">All Teams</a>
						</div>
						<div id="season_teams_snap" class="my-5 d-flex align-items-center justify-content-around mb-4 mb-lg-0 flex-column flex-lg-row">
							@if($showSeasonTeams->isNotEmpty())

								<button class="btn btn-lg deep-purple white-text">Total Teams:&nbsp;<span class="badge badge-pill blue-grey">{{ $showSeasonTeams->count() }}</span></button>

								<button class="btn btn-lg deep-purple white-text">Total Players:&nbsp;<span class="badge badge-pill blue-grey">{{ $showSeasonPlayers->count() }}</span></button>

							@else

								<h3 class="h3-responsive">No teams showing for this season</h3>

							@endif
						</div>
					</div>
					<!--./ League season teams snap shot /.-->

					<!-- Divider /.-->
					<div class="divider-short" id=""></div>
					<!--./ Divider /.-->

					<!-- League season stats snap shot -->
					<div class="col-8 mx-auto my-5">
						<div class="d-flex w-100 justify-content-center align-items-center flex-column flex-lg-row">
							<h1 class="h1-responsive">Quick Stats</h1>
							<a href="{{ request()->query() == null ? route('league_stat.index') : route('league_stat.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">All Stats</a>
						</div>
						<div id="season_stats_snap" class="my-5 row">
							<!-- Season stat leaders by category -->
						@if($showSeasonStat->isNotEmpty())
							<!-- Get the scoring leaders -->
								<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
									<table class="table white-text">
										<thead>
										<tr>
											<th>Team</th>
											<th>Player</th>
											<th>PPG</th>
										</tr>
										</thead>
										<tbody>
										@foreach($showSeason->stats()->scoringLeaders(5)->get() as $playerStat)
											<tr class="white-text">
												<td>{{ $playerStat->player->team_name }}</td>
												<td>{{ $playerStat->player->player_name }}</td>
												<td>{{ $playerStat->PPG != null ? $playerStat->PPG : 'N/A' }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>

								<!-- Get the rebounding leaders -->
								<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
									<table class="table white-text">
										<thead>
										<tr>
											<th>Team</th>
											<th>Player</th>
											<th>RPG</th>
										</tr>
										</thead>
										<tbody>
										@foreach($showSeason->stats()->reboundingLeaders(5)->get() as $playerStat)
											<tr class="white-text">
												<td>{{ $playerStat->player->team_name }}</td>
												<td>{{ $playerStat->player->player_name }}</td>
												<td>{{ $playerStat->RPG != null ? $playerStat->RPG : 'N/A' }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>

								<!-- Get the assisting leaders -->
								<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
									<table class="table white-text">
										<thead>
										<tr>
											<th>Team</th>
											<th>Player</th>
											<th>APG</th>
										</tr>
										</thead>
										<tbody>
										@foreach($showSeason->stats()->assistingLeaders(5)->get() as $playerStat)
											<tr class="white-text">
												<td>{{ $playerStat->player->team_name }}</td>
												<td>{{ $playerStat->player->player_name }}</td>
												<td>{{ $playerStat->APG != null ? $playerStat->APG : 'N/A' }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>

								<!-- Get the stealing leaders -->
								<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
									<table class="table white-text">
										<thead>
										<tr>
											<th>Team</th>
											<th>Player</th>
											<th>SPG</th>
										</tr>
										</thead>
										<tbody>
										@foreach($showSeason->stats()->stealingLeaders(5)->get() as $playerStat)
											<tr class="white-text">
												<td>{{ $playerStat->player->team_name }}</td>
												<td>{{ $playerStat->player->player_name }}</td>
												<td>{{ $playerStat->SPG != null ? $playerStat->SPG : 'N/A' }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>

								<!-- Get the blocking leaders -->
								<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
									<table class="table white-text">
										<thead>
										<tr>
											<th>Team</th>
											<th>Player</th>
											<th>BPG</th>
										</tr>
										</thead>
										<tbody>
										@foreach($showSeason->stats()->blockingLeaders(5)->get() as $playerBlocks)
											<tr class="white-text">
												<td>{{ $playerBlocks->player->team_name }}</td>
												<td>{{ $playerBlocks->player->player_name }}</td>
												<td>{{ $playerBlocks->BPG != null ? $playerBlocks->BPG : 'N/A' }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							@else
								<h3 class="text-center h3-responsive col">There are no stats added for this league yet</h3>
							@endif
						</div>
					</div>
					<!--./ League season stats snap shot /.-->
				</div>
			@else
			@endif
				@if($completedSeasons->isNotEmpty())
					<div class="divider-long" id=""></div>

					<div class="" id="completed_seasons">
						<h2 class="display-2">Completed Seasons</h2>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection