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
							<h2 class="h2-responsive">Week {{ $showWeekInfo->season_week }} Games</h2>
							<table id='week_{{ $showWeekInfo->season_week }}_schedule' class='weekly_schedule table'>
								<thead>
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
												<td>{{ $game->away_team }}</td>
												<td>vs</td>
												<td>{{ $game->home_team }}</td>
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
						<p class="">There are no stats for the selected season</p>
					</div>
				@endif
			</div>
			<div class="col-md mt-3">
				<a href="{{ route('league_schedule.create') }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Week</a>
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