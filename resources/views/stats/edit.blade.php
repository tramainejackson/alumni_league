@extends('layouts.app')

@section('content')
	@include('include.functions')
	
	<div class="container-fluid" id="leaguesProfileContainer">
		<div class="row">
			<div class="col-12 mt-3">
				@foreach($seasonScheduleWeeks as $edit_week)
					<a href="{{ request()->query() == null ? route('league_stat.edit_week', ['week' => $edit_week->season_week]) : route('league_stat.edit_week', ['week' => $edit_week->season_week, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-rounded mdb-color darken-3 white-text{{ $edit_week->season_week == $week ? ' disabled' : '' }}"{{ $edit_week->season_week == $week ? ' disabled' : '' }}>Week {{ $edit_week->season_week }} Stats</a>
				@endforeach
			</div>
			<div class="col-12">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				<div class="text-center">
					<h3 class="h3-responsive">Week {{ $week }} Stats</h3>
				</div>
				
				@if($weekGames->count() > 0)
					@foreach($weekGames as $game)
					{{ dd($game->home_team) }}
						<!--Card-->
						<div class="card mb-4">
							<!--Card content-->
							<div class="card-body">
								<!--Title-->
								<div class="d-flex align-items-center justify-content-between">
									<div class="d-flex align-items-center justify-content-center">
										<h2 class="card-title h2-responsive my-2 text-underline">Game {{ $loop->iteration}}</h2>
										<button class="btn btn-sm btn-rounded orange darken-1" type="button" data-toggle="modal" data-target="#remove_game">Remove Game</button>
									</div>
									
									<div class="d-flex flex-column align-items-center">
										<div class="btn-group mb-2" role="group" aria-label="Game Time and Date">
											<button class="btn btn-outline-mdb-color" type="button"><i class="fa fa-calendar mr-2" aria-hidden="true"></i>{{ $game->game_date() }}</button>
											<button class="btn btn-outline-mdb-color" type="button"><i class="fa fa-clock-o mr-2" aria-hidden="true"></i>{{ $game->game_time() }}</button>
										</div>
										<div class="btn-group" role="group" aria-label="Game Time and Date">
											<button class="btn btn-outline-mdb-color" type="button">{{ $game->result ? $game->result->away_team_score : '' }} Away Score</button>
											<button class="btn btn-outline-mdb-color" type="button">{{ $game->result ? $game->result->home_team_score : '' }} Home Score</button>
										</div>
									</div>
								</div>
								
								<!-- Edit Form -->
								{!! Form::open(['action' => ['LeagueStatController@update', 'week' => $week], 'method' => 'PATCH']) !!}
									<div class="my-2">
										<div class="row">
											<div class="col-12">
												<table class="table">
													<thead>
														<tr>
															<th>Away Team</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>{{ $away_team->team_name }}<td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="col-12">
												<table class="table">
													<thead>
														<tr>
															<th>Home Team</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>{{ $home_team->team_name }}<td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<input type="number" name="game_id[]" class="hidden" value="{{ $game->id }}" hidden />
									</div>
								{!! Form::close() !!}
							</div>
						</div>
						<!--/.Card-->
					@endforeach

					<div class="md-form">
						<button class="btn btn-lg blue lighten-1" type="submit">Update Week Games</button>
					</div>
				@else
					<div class="my-5 text-center">
						<h2 class="h2-responsive red-text coolText4"><i class="fa fa-warning" aria-hidden="true"></i>&nbsp;You do not have any teams added to this season. Please add some teams before creating a schedule&nbsp;<i class="fa fa-warning" aria-hidden="true"></i></h2>
						<a href="{{ request()->query() == null ? route('league_teams.create') : route('league_teams.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text">Add Teams</a>
					</div>
				@endif					
			</div>
		</div>
	</div>
@endsection