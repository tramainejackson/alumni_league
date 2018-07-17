@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col col-lg-3 mt-3 d-none d-lg-block">
				<h2 class="h2-responsive text-underline">Check List</h2>
				<p class="text-justify font-small">*Make Sure All Games Have Teams, Date, and Time Selected*</p>
				<p class="text-justify font-small">*Forfeited Games Will Not Have Team Scores*</p>
			</div>
			<div class="col-12 col-lg-6">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
				</div>
				<div class="mt-4 mb-2 d-flex flex-column flex-lg-row align-items-center justify-content-center">
					<button class="btn btn-rounded btn-sm green darken-1 white-text mx-4 order-1 order-lg-0" id="edit_page_add_game" type="button"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add Game</button>
					
					<h2 class="h2-responsive text-center m-2">Edit Week</h2>
					
					<button class="btn btn-rounded btn-sm red darken-1 white-text mx-4 order-2" id="edit_page_remove_week" type="button" data-toggle="modal" data-target="#remove_week"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;Remove Week</button>					
				</div>
				<div class="text-center mb-4">
					<a href="{{ request()->query() == null ? route('league_stat.edit_week', ['week' => $weekGames->first()->season_week]) : route('league_stat.edit_week', ['week' => $weekGames->first()->season_week, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-rounded cyan darken-1" type="button">Edit Week Stats</a>
				</div>

				{!! Form::open(['action' => ['LeagueScheduleController@update_week', $weekGames->first()->season_week], 'class' => 'updateWeekForm', 'name' => 'edit_week_form', 'method' => 'PATCH']) !!}
					@if($weekGames->count() > 0)
						@foreach($weekGames as $game)
							<!--Card-->
							<div class="card mb-4">
								<!--Card content-->
								<div class="card-body">
									<!--Title-->
									<div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
										<div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
											<h2 class="card-title h2-responsive my-2 text-underline">Game {{ $loop->iteration}}</h2>
											<a href="{{ request()->query() == null ? route('league_schedule.show', ['league_schedule' => $game->id]) : route('league_schedule.show', ['league_schedule' => $game->id, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm btn-rounded orange darken-1" type="button">Remove Game</a>
										</div>
										
										<!-- Forfeit Toggle -->
										<div class="d-flex flex-column align-items-center">
											<p class="m-0">Forfeit</p>
											<div class="">
												<button class="btn btn-sm d-block w-100 awayForfeitBtn{{ $game->result ? $game->result->forfeit == 'Y' && $game->result->losing_team_id == $game->away_team_id ? ' red' : ' stylish-color-dark' : ' stylish-color-dark' }}" type="button">{{ $game->away_team }} Forfeit
													<input type="checkbox" name="away_forfeit[]" class="hidden" value="{{ $game->id }}" hidden{{ $game->result ? $game->result->forfeit == 'Y' && $game->result->losing_team_id == $game->away_team_id ? ' checked' : '' : '' }} />
												</button>
												<button class="btn btn-sm d-block w-100 homeForfeitBtn{{ $game->result ? $game->result->forfeit == 'Y' && $game->result->losing_team_id == $game->home_team_id ? ' red' : ' stylish-color-dark' : ' stylish-color-dark' }}" type="button">{{ $game->home_team }} Forfeit
													<input type="checkbox" name="home_forfeit[]" class="hidden" value="{{ $game->id }}" hidden{{ $game->result ? $game->result->forfeit == 'Y' && $game->result->losing_team_id == $game->home_team_id ? ' checked' : '' : '' }} />
												</button>
											</div>
										</div>
									</div>
									<!-- Create Form -->
									<div class="my-2">
										<div class="row">
											<div class="col-12 col-md">
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
											<div class="col-12 col-md">
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
													
													<input type="text" name="date_picker[]" id="input_gamedate" class="form-control datetimepicker" value="{{ $game->game_date() }}" placeholder="Selected Date" />
												</div>
											</div>
											<div class="col">
												<div class="md-form input-group">
													<div class="input-group-prepend">
														<span class="input-group-text">Game Time</span>
													</div>
													
													<input type="text" name="game_time[]" id="input_starttime" class="form-control timepicker" value="{{ $game->game_time() }}" placeholder="Selected time" />
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
										<div class="col-12 col-md">
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
										<div class="col-12 col-md">
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
							<button class="btn btn-lg blue lighten-1" type="submit">Update Week Games</button>
						</div>
					@else
						<div class="my-5 text-center">
							<h2 class="h2-responsive red-text coolText4"><i class="fa fa-warning" aria-hidden="true"></i>&nbsp;You do not have any teams added to this season. Please add some teams before creating a schedule&nbsp;<i class="fa fa-warning" aria-hidden="true"></i></h2>
							<a href="{{ request()->query() == null ? route('league_teams.create') : route('league_teams.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text">Add Teams</a>
						</div>
					@endif
				{!! Form::close() !!}
			</div>
			<div class="col col-lg-3 mt-3 text-center text-xl-right order-first order-lg-0">
				<a href="{{ request()->query() == null ? route('league_schedule.create') : route('league_schedule.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text d-lg-block" type="button">Add New Week</a>
				
				<a href="{{ request()->query() == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text d-lg-block" type="button">All Games</a>
				
				<div class="table-wrapper">
					<table class="table table-hover table-striped mt-3 d-none d-lg-table">
						<tbody>
							@foreach($showSeason->games()->getScheduleWeeks()->get() as $week)
							@php $gamesCount = $showSeason->games()->getWeekGames($week->season_week)->get()->count(); @endphp
								<tr class="{{ $week->season_week == $thisWeek ? 'white-text blue' : '' }}">
									<td class="text-center">
										<span class="w-100 d-block font-weight-bold text-underline">Week {{ $loop->iteration }}</span>
										<span class="">{{ $gamesCount }} games scheduled</span>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
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