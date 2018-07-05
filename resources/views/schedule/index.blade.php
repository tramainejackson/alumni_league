@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col col-lg d-none d-lg-block mt-3">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_schedule.index', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->name }}</a>
					@endforeach
				@else
				@endif
			</div>
			<div class="col-12 col-lg-7">
				@if(!isset($allComplete))
					<div class="text-center coolText1">
						<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
					</div>
					
					@if($seasonScheduleWeeks->get()->isNotEmpty())
						@foreach($seasonScheduleWeeks->get() as $showWeekInfo)
							@php $seasonWeekGames = $showSeason->games()->getWeekGames($showWeekInfo->season_week)->get() @endphp
							<div class='leagues_schedule text-center table-wrapper mb-5'>
								<table id='week_{{ $showWeekInfo->season_week }}_schedule' class='weekly_schedule table'>
									<thead>
										<tr class="indigo darken-2 white-text">
											<th class="text-center" colspan="6">
												<h2 class="h2-responsive position-relative my-3">
													<span>Week {{ $loop->iteration }} Games</span>
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
													<td><button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button></td>
												</tr>
											@endforeach
										@endif
									</tbody>
								</table>
							</div>
						@endforeach
					@else
						<div class="text-center">
							<h1 class="h1-responsive coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;There is no schedule for the selected season&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h1>
						</div>
					@endif
				@else
					<div class="coolText4 py-3 px-5">
						<h1 class="h1-responsive text-justify">It doesn't look like you have any active seasons going for your league right now. Let'e get started by creating a new season. Click <a href="/home?new_season" class="">here</a> to create a new season</h1>
					</div>
				@endif
			</div>
			
			<div class="col-md col-lg mt-3 text-center text-lg-right order-first order-lg-0">
				@if(!isset($allComplete))
					<a href="{{ request()->query() == null ? route('league_schedule.create') : route('league_schedule.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Week</a>
				
					<a href="#" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button" data-target="#add_new_game_modal" data-toggle="modal">Add New Game</a>
				@endif
			</div>
		</div>
		
		@if(!isset($allComplete))
			<!-- Edit game modal -->
			<div class="modal fade" id="edit_game_modal" tabindex="-1" role="dialog" aria-labelledby="editGameModal" aria-hidden="true" data-backdrop="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="h2-responsive">Edit Game</h2>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							{!! Form::open(['action' => ['LeagueScheduleController@update_game'], 'method' => 'PATCH']) !!}
								<!--Card-->
								<div class="card mb-4">
									<!--Card content-->
									<div class="card-body">
										<!--Title-->
										<div class="d-flex flex-column flex-lg-row align-items-center justify-content-between">
											<div class="d-flex align-items-center justify-content-center">
												<h4 class="card-title h4-responsive my-2">Changing this games teams will remove any stats that have been added</h4>
											</div>
											
											<!-- Forfeit Toggle -->
											<div class="d-flex flex-column align-items-center">
												<p class="m-0">Forfeit</p>
												<div class="">
													<button class="btn btn-sm stylish-color-dark awayForfeitBtn d-block" type="button"><span class="awayForfeitBtnTeamName"></span>
														<input type="checkbox" name="away_forfeit" class="hidden" value="" hidden />
													</button>
													<button class="btn btn-sm stylish-color-dark homeForfeitBtn d-block" type="button"><span class="homeForfeitBtnTeamName"></span>
														<input type="checkbox" name="home_forfeit" class="hidden" value="" hidden />
													</button>
												</div>
											</div>
										</div>
										
										<!-- Edit Form -->
										<div class="my-2">
											<div class="row">
												<div class="col-12 col-lg">
													<div class="md-form">
														<select class="mdb-select" name="edit_away_team">
															<option value="" disabled>Choose your option</option>
															@foreach($showSeason->league_teams as $away_team)
																<option value="{{ $away_team->id }}">{{ $away_team->team_name }}</option>
															@endforeach
														</select>
														<label for="edit_away_team">Away Team</label>
													</div>
												</div>
												<div class="col-12 col-lg">
													<div class="md-form">
														<select class="mdb-select" name="edit_home_team">
															<option value="" disabled>Choose your option</option>
															@foreach($showSeason->league_teams as $home_team)
																<option value="{{ $home_team->id }}">{{ $home_team->team_name }}</option>
															@endforeach
														</select>
														<label for="edit_home_team">Home Team</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col">
													<div class="md-form input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">Away Score</span>
														</div>
														
														<input type="number" name="edit_away_score" id="" class="form-control" value="" placeholder="Enter Away Score" min="0" max="200" />
													</div>
												</div>
												<div class="col">
													<div class="md-form input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">Home Score</span>
														</div>
														
														<input type="number" name="edit_home_score" id="" class="form-control" value="" placeholder="Enter Home Score" min="0" max="200" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col">
													<div class="md-form input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">Game Date</span>
														</div>
														
														<input type="text" name="edit_date_picker" id="input_gamedate" class="form-control datetimepicker" value="" placeholder="Selected Date" />
													</div>
												</div>
												<div class="col">
													<div class="md-form input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">Game Time</span>
														</div>
														
														<input type="text" name="edit_game_time" id="input_starttime" class="form-control timepicker" value="" placeholder="Selected time" />
													</div>
												</div>
												
												<input type="number" name="edit_game_id" class="hidden" value="" hidden />
											</div>
											<div class="md-form">
												<button class="btn blue white-text darken-2" type="submit">Update Game</button>
											</div>
										</div>
									</div>
								</div>
								<!--/.Card-->
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
			
			<!-- Add new game modal -->
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
									<div class="col-12 col-lg">
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
									<div class="col-12 col-lg">
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
									<div class="col-12 col-lg">
										<div class="md-form">
											<input type="text" name="date_picker" id="input_gamedate" class="form-control datetimepicker" value="{{ old('game_date') }}" placeholder="Selected Date" />
											<label for="input_gamedate">Game Date</label>
										</div>
									</div>
									<div class="col-12 col-lg">
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
		@endif
	</div>
@endsection