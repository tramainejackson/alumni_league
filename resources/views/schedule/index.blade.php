@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md mt-3">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_schedule.index', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->season . ' ' . $activeSeason->year }}</a>
					@endforeach
				@else
				@endif
			</div>
			<div class="col-12 col-md-8">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				@if($seasonScheduleWeeks->get()->isNotEmpty())
					@foreach($seasonScheduleWeeks->get() as $showWeekInfo)
						@php $seasonWeekGames = $showSeason->games()->getWeekGames($showWeekInfo->season_week)->get() @endphp
						<div class='leagues_schedule text-center mb-5'>
							<table id='week_{{ $showWeekInfo->season_week }}_schedule' class='weekly_schedule table'>
								<thead>
									<tr class="indigo darken-2 white-text">
										<th class="text-center" colspan="6">
											<h2 class="h2-responsive position-relative my-3">
												<span>Week {{ $showWeekInfo->season_week }} Games</span>
												<a href="{{ request()->query() == null ? route('league_schedule.edit', ['league_schedule' => $showWeekInfo->season_week]) : route('league_schedule.edit', ['league_schedule' => $showWeekInfo->season_week, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm btn-rounded position-absolute right white black-text">Edit Week</a>
											</h2>
										</th>
									</tr>
									<tr class="indigo darken-3 white-text">
										<th class="text-center" colspan="3">Match-Up</th>
										<th>Time</th>
										<th>Date</th>
										<th></th>
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
													<td>{{ $game->away_team }}
														@if($game->result->winning_team_id == $game->away_team_id)
															@if($game->result->forfeit == 'Y')
																<span class="badge badge-pill green darken-2 ml-3">Winner</span>
															@else
																<span class="badge badge-pill green darken-2 ml-3">{{ $game->result->away_team_score }}</span>
															@endif
														@else
															@if($game->result->forfeit == 'Y')
																<span class="badge badge-pill red darken-2 ml-3">Forfeit</span>
															@else
																<span class="badge badge-pill red darken-2 ml-3">{{ $game->result->away_team_score }}</span>
															@endif
														@endif
													</td>
													<td>vs</td>
													<td>{{ $game->home_team }}
														@if($game->result->winning_team_id == $game->home_team_id)
															@if($game->result->forfeit == 'Y')
																<span class="badge badge-pill green darken-2 ml-3">Winner</span>
															@else
																<span class="badge badge-pill green darken-2 ml-3">{{ $game->result->home_team_score }}</span>
															@endif
														@else
															@if($game->result->forfeit == 'Y')
																<span class="badge badge-pill red darken-2 ml-3">Forfeit</span>
															@else
																<span class="badge badge-pill red darken-2 ml-3">{{ $game->result->home_team_score }}</span>
															@endif
														@endif
													</td>
												@else
													<td>{{ $game->away_team }}</td>
													<td>vs</td>
													<td>{{ $game->home_team }}</td>
												@endif
												
												<td>{{ $game->game_time() }}</td>
												<td>{{ $game->game_date() }}</td>
												<td><button class="btn btn-primary btn-rounded btn-sm my-0" type="button">Edit Game</button></td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div>
					@endforeach
				@else
					<div class="text-center">
						<p class="">There is no schedule for the selected season</p>
					</div>
				@endif
			</div>
			<div class="col-md mt-3 text-right">
				<a href="{{ request()->query() == null ? route('league_schedule.create') : route('league_schedule.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Week</a>
				<a href="#" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button" data-target="#add_new_game_modal" data-toggle="modal">Add New Game</a>
			</div>
		</div>
		<div class="modal fade" id="add_new_game_modal" tabindex="-1" role="dialog" aria-labelledby="addNewGameModal" aria-hidden="true" data-backdrop="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="">Add New Game</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- Create Form -->
						{!! Form::open(['action' => ['LeagueScheduleController@add_game'], 'method' => 'POST']) !!}
							<div class="md-form">
								<select class="mdb-select" name="season_week">
									<option value="" disabled selected>Choose a week</option>
									@foreach($seasonScheduleWeeks->get() as $week)
										<option value="{{ $week->season_week }}">Week {{ $week->season_week }}</option>
									@endforeach
								</select>
								<label for="">Select A Week</label>
							</div>
							<div class="row">
								<div class="col">
									<div class="md-form">
										<select class="mdb-select" name="away_team">
											<option value="" disabled selected>Choose your option</option>
											@foreach($showSeason->league_teams as $away_team)
												<option value="{{ $away_team->id }}">{{ $away_team->team_name }}</option>
											@endforeach
										</select>
										<label for="away_team">Away Team</label>
									</div>
								</div>
								<div class="col">
									<div class="md-form">
										<select class="mdb-select" name="home_team">
											<option value="" disabled selected>Choose your option</option>
											@foreach($showSeason->league_teams as $home_team)
												<option value="{{ $home_team->id }}">{{ $home_team->team_name }}</option>
											@endforeach
										</select>
										<label for="home_team">Home Team</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="md-form">
										<input type="text" name="date_picker" id="input_gamedate" class="form-control datetimepicker" value="{{ old('game_date') }}" placeholder="Selected Date" />
										<label for="input_gamedate">Game Date</label>
									</div>
								</div>
								<div class="col">
									<div class="md-form">
										<input type="text" name="game_time" id="input_starttime" class="form-control timepicker" value="{{ old('game_time') }}" placeholder="Selected time" />
										<label for="input_starttime">Game Time</label>
									</div>
								</div>
							</div>
							<div class="md-form">
								<button class="btn blue lighten-1" type="submit">Add Game</button>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection