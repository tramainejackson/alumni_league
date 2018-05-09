@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md mt-3">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_schedule.create', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->season . ' ' . $activeSeason->year }}</a>
					@endforeach
				@else
				@endif
			</div>
			<div class="col-12 col-md-8">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				<div class="my-4">
					<h2 class="h2-responsive text-center">Create New Week</h2>
					<h4 class="h4-responsive text-center coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;You currently have {{ $weekCount }} weeks showing. This will add week {{ ($weekCount + 1) }} to the schedule&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h4>
				</div>
				
				{!! Form::open(['action' => ['LeagueScheduleController@add_week'], 'method' => 'POST']) !!}
					@for($i=1; $i <= round($showSeason->league_teams->count() / 2); $i++)
						<!--Card-->
						<div class="card mb-4">
							<!--Title-->
							<h2 class="card-title h2-responsive text-center my-2">Game {{ $i }} for week {{ ($weekCount + 1) }}</h2>
							<!--Card content-->
							<div class="card-body">
								<!-- Create Form -->
								<div class="my-2">
									<div class="row">
										<div class="col">
											<div class="md-form">
												<select class="mdb-select" name="away_team[]">
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
												<select class="mdb-select" name="home_team[]">
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
												<input type="text" name="date_picker[]" id="input_gamedate" class="form-control datetimepicker" value="{{ old('game_date') }}" placeholder="Selected Date" />
												<label for="input_gamedate">Game Date</label>
											</div>
										</div>
										<div class="col">
											<div class="md-form">
												<input type="text" name="game_time[]" id="input_starttime" class="form-control timepicker" value="{{ old('game_time') }}" placeholder="Selected time" />
												<label for="input_starttime">Game Time</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--/.Card-->
					@endfor
					<div class="md-form">
						<button class="btn blue lighten-1" type="submit">Add Week</button>
					</div>
				{!! Form::close() !!}
			</div>
			<div class="col-md mt-3">
				@foreach($showSeason->games()->getScheduleWeeks()->get() as $week)
					@php $gamesCount = $showSeason->games()->getWeekGames($week->season_week)->get()->count(); @endphp
					<div class="">
						<h3 class="">Week {{ $week->season_week }}</h3>	
						<p class="">{{ $gamesCount }} games scheduled</p>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection