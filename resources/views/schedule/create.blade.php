@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">
		<div class="row">

			<div class="col-10 py-4 mt-4 mx-auto">
				<a href="{{ request()->query() == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text d-lg-block position-absolute allGamesBtn" type="button" style="">All Games</a>

				<div class="container-fluid" id="">
					<div class="row" id="">
						@foreach($showSeason->games()->getScheduleWeeks()->get() as $week)
							@php $gamesCount = $showSeason->games()->getWeekGames($week->season_week)->get()->count(); @endphp
							<div class="d-none d-lg-block col-2">
								<h3 class="">Week {{ $loop->iteration }}</h3>
								<p class="">{{ $gamesCount }} games scheduled</p>
							</div>
						@endforeach
					</div>
				</div>
			</div>

			<div class="col-12 col-lg-10 mx-auto">
				<div class="text-center p-4 card rgba-deep-orange-light white-text" id="">
					<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
				</div>
				<div class="my-4">
					<h2 class="h2-responsive text-center">Create New Week</h2>
					<h4 class="h4-responsive text-center coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;You currently have {{ $weekCount->count() > 0 ? $weekCount->count() : '0' }} weeks showing. This will add week {{ ($weekCount->count() + 1) }} to the schedule&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h4>
				</div>
				
				{!! Form::open(['action' => ['LeagueScheduleController@add_week', 'season' => $showSeason->id], 'name' =>'new_week_form', 'method' => 'POST']) !!}
					@if($showSeason->league_teams->count() > 0)
						@for($i=1; $i <= round($showSeason->league_teams->count() / 2); $i++)
							<!--Card-->
							<div class="card mb-4">
								<!--Title-->
								<h2 class="card-title h2-responsive text-center my-2">Game {{ $i }} for week {{ ($weekCount->count() + 1) }}</h2>
								<!--Card content-->
								<div class="card-body">
									<!-- Create Form -->
									<div class="my-2">
										<div class="row">
											<div class="col-12 col-lg">
												<div class="">
													<select class="mdb-select md-form" name="away_team[]">
														<option value="" disabled selected>Choose your option</option>
														@foreach($showSeason->league_teams as $away_team)
															<option value="{{ $away_team->id }}">{{ $away_team->team_name }}</option>
														@endforeach
													</select>
													
													<label for="away_team" class="mdb-main-label">Away Team</label>
												</div>
											</div>
											<div class="col-12 col-lg">
												<div class="">
													<select class="mdb-select md-form" name="home_team[]">
														<option value="" disabled selected>Choose your option</option>
														@foreach($showSeason->league_teams as $home_team)
															<option value="{{ $home_team->id }}">{{ $home_team->team_name }}</option>
														@endforeach
													</select>
													
													<label for="home_team" class="mdb-main-label">Home Team</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-lg">
												<div class="md-form">
													<input type="text" name="date_picker[]" id="input_gamedate" class="form-control datetimepicker" value="{{ old('game_date') }}" placeholder="Selected Date" />
													
													<label for="input_gamedate">Game Date</label>
												</div>
											</div>
											<div class="col-12 col-lg">
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
							<button class="btn blue lighten-1 white-text" type="submit">Add Week</button>
						</div>
					@else
						<div class="my-5 text-center">
							<h2 class="h2-responsive red-text coolText4"><i class="fa fa-warning" aria-hidden="true"></i>&nbsp;You do not have any teams added to this season. Please add some teams before creating a schedule&nbsp;<i class="fa fa-warning" aria-hidden="true"></i></h2>
							
							<a href="{{ request()->query() == null ? route('league_teams.create') : route('league_teams.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text d-block">Add Teams</a>
						</div>
					@endif
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection