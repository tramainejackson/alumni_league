@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd1">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md mt-3">
				<h2 class="h2-responsive text-underline">Check List</h2>
				<p class="text-justify font-small">*Make Sure All Games Have Teams, Date, and Time Selected*</p>
				<p class="text-justify font-small">*Forfeited Games Will Not Have Team Scores*</p>
			</div>
			<div class="col-12 col-md-8">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
					<h1 class="display-4 coolText4">It's Playoff Time</h1>
				</div>
				<div class="my-4 d-flex align-items-center justify-content-center">
					<h2 class="h2-responsive text-center m-2">Edit Round {{ $round }} Games</h2>
				</div>

				{!! Form::open(['action' => ['LeagueScheduleController@update_playoff_week', 'season' => $showSeason->id], 'class' => 'updateplayoffsForm', 'method' => 'POST']) !!}
					<input type="text" name="round_id" class="hidden" value="{{ $round }}" hidden />
					@foreach($weekGames as $game)
						<!--Card-->
						<div class="card mb-4">
							<!--Card content-->
							<div class="card-body">
								<!--Title-->
								<div class="d-flex align-items-center justify-content-between">
									<div class="d-flex align-items-center justify-content-center">
										<h2 class="card-title h2-responsive my-2 text-underline">Game {{ $loop->iteration}}</h2>
										<h4 class="ml-5 my-2">{{ $game->home_seed . ' vs ' . $game->away_seed }}</h4>
									</div>
									
									<!-- Forfeit Toggle -->
									<div class="d-flex flex-column align-items-center">
										<p class="m-0">Forfeit</p>
										<div class="">
											<button class="btn btn-sm awayForfeitBtn{{ $game->result ? $game->result->forfeit == 'Y' && $game->result->losing_team_id == $game->away_team_id ? ' red' : ' stylish-color-dark' : ' stylish-color-dark' }}" type="button">{{ $game->away_team }} Forfeit
												<input type="checkbox" name="away_forfeit[]" class="hidden" value="{{ $game->id }}" hidden{{ $game->result ? $game->result->forfeit == 'Y' && $game->result->losing_team_id == $game->away_team_id ? ' checked' : '' : '' }} />
											</button>
											<button class="btn btn-sm homeForfeitBtn{{ $game->result ? $game->result->forfeit == 'Y' && $game->result->losing_team_id == $game->home_team_id ? ' red' : ' stylish-color-dark' : ' stylish-color-dark' }}" type="button">{{ $game->home_team }} Forfeit
												<input type="checkbox" name="home_forfeit[]" class="hidden" value="{{ $game->id }}" hidden{{ $game->result ? $game->result->forfeit == 'Y' && $game->result->losing_team_id == $game->home_team_id ? ' checked' : '' : '' }} />
											</button>
										</div>
									</div>
								</div>
								<!-- Create Form -->
								<div class="my-2">
									<div class="row">
										<div class="col">
											<div class="md-form">
												<select class="mdb-select" name="away_team[]">
													<option value="" disabled selected>Choose your option</option>
													@foreach($showSeason->league_teams as $away_team)
														<option value="{{ $away_team->id }}"{{ $game->away_team_id == $away_team->id ? 'selected' : '' }}>{{ $away_team->team_name }}</option>
													@endforeach
												</select>
												<label for="away_team">Away Team</label>
											</div>
										</div>
										<div class="col">
											<div class="md-form">
												<select class="mdb-select" name="home_team[]">
													<option value="" disabled selected>Choose your option</option>
													@foreach($showSeason->league_teams as $home_team)
														<option value="{{ $home_team->id }}"{{ $game->home_team_id == $home_team->id ? 'selected' : '' }}>{{ $home_team->team_name }}</option>
													@endforeach
												</select>
												<label for="home_team">Home Team</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<div class="md-form input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">Away Team Score</span>
												</div>
												
												<input type="number" name="away_score[]" id="" class="form-control" value="{{ $game->result ? $game->result->away_team_score : '' }}" placeholder="Enter Away Score" min="0" max="200" />
											</div>
										</div>
										<div class="col">
											<div class="md-form input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">Home Team Score</span>
												</div>
												
												<input type="number" name="home_score[]" id="" class="form-control" value="{{ $game->result ? $game->result->home_team_score : '' }}" placeholder="Enter Home Score" min="0" max="200" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<div class="md-form input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">Game Date</span>
												</div>
												
												<input type="text" name="date_picker[]" id="input_gamedate" class="form-control datetimepicker" value="{{ $game->game_date == null ? '' : $game->game_date() }}" placeholder="Selected Date" />
											</div>
										</div>
										<div class="col">
											<div class="md-form input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">Game Time</span>
												</div>
												
												<input type="text" name="game_time[]" id="input_starttime" class="form-control timepicker" value="{{ $game->game_time == null ? '' : $game->game_time() }}" placeholder="Selected time" />
											</div>
										</div>
										
										<input type="number" name="game_id[]" class="hidden" value="{{ $game->id }}" hidden />
									</div>
								</div>
							</div>
						</div>
						<!--/.Card-->
					@endforeach
					
					<!-- Hidden card for new games -->
					<!--Card-->
					<div class="card mb-4 newGameRow hidden" hidden>
						<!--Card content-->
						<div class="card-body">
							<!--Title-->
							<h2 class="card-title h2-responsive my-2 text-underline">New Game</h2>
							<!-- Create Form -->
							<div class="my-2">
								<div class="row">
									<div class="col">
										<div class="md-form">
											<select class="" name="new_away_team[]" disabled>
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
											<select class="" name="new_home_team[]" disabled>
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
										<div class="md-form input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Home Team Score</span>
											</div>
											
											<input type="number" name="new_away_score[]" class="form-control" value="" placeholder="Enter Away Score" min="0" max="200" disabled />
										</div>
									</div>
									<div class="col">
										<div class="md-form input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Away Team Score</span>
											</div>
											
											<input type="number" name="new_home_score[]" class="form-control" value="" placeholder="Enter Home Score" min="0" max="200" disabled />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="md-form input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Game Date</span>
											</div>
											
											<input type="text" name="new_date_picker[]" class="form-control datetimepicker" value="" placeholder="Selected Date" disabled />
										</div>
									</div>
									<div class="col">
										<div class="md-form input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Game Time</span>
											</div>
											
											<input type="text" name="new_game_time[]" class="form-control timepicker" value="" placeholder="Selected time" disabled />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/.Card-->
					<div class="md-form">
						<button class="btn btn-lg blue lighten-1 text-white" type="submit">Update Playoff Games</button>
					</div>
				{!! Form::close() !!}
			</div>
			<div class="col-md text-right mt-3">
				<a href="{{ request()->query() == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">All Games</a>
			</div>
			
			<div class="removeModals">
				<!-- Remove Week Modal -->
				<div class="modal fade" id="remove_week" tabindex="-1" role="dialog" aria-labelledby="removeWeek" aria-hidden="true" data-backdrop="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h2 class="h2-responsive">Remove Week</h2>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								{!! Form::open(['action' => ['LeagueScheduleController@delete_week', $weekGames->first()->season_week], 'method' => 'DELETE']) !!}
									<h3 class="h3-responsive">Removing this week will delete all of the games from the calendar and any player stats for the games.<br/><br/>Are you sure you want to delete this whole week?</h3>
									
									<div class="d-flex align-items-center justify-content-between">
										<button class="btn btn-success" type="submit">Confirm</button>
										<button class="btn btn-warning" data-dismiss="modal"type="submit">Cancel</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
				
				<!-- Remove Game Modal -->
				<div class="modal fade" id="remove_game" tabindex="-1" role="dialog" aria-labelledby="removeGame" aria-hidden="true" data-backdrop="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h2 class="h2-responsive">Remove Game</h2>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								
									<p class="">Show all games scheduled for week and if resulted or not</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection