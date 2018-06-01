@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col col-md-3 mt-3 text-left d-none d-md-block">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_teams.create', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->name }}</a>
					@endforeach
				@else
				@endif
			</div>
			<div class="col-12 col-md-5 mx-auto">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
					<h3 class="h-responsive">Total Teams: {{ $totalTeams }}</h3>
				</div>
				
				<!--Card-->
				<div class="card card-cascade mb-4 reverse wider">
					<!--Card image-->
					<div class="view">
						<img src="{{ $defaultImg }}" class="img-fluid mx-auto" alt="photo">
					</div>
					<!--Card content-->
					<div class="card-body">
						<!--Title-->
						<h2 class="card-title h2-responsive text-center">Create New Team</h2>
						<!-- Create Form -->
						{!! Form::open(['action' => ['LeagueTeamController@store', 'season' => $showSeason->id, 'year' => $showSeason->year], 'method' => 'POST']) !!}
							<div class="md-form">
								<input type="text" name="team_name" class="form-control" value="{{ old('team_name') }}" />
								<label for="team_name">Team Name</label>
							</div>
							
							@if($errors->has('team_name'))
								<div class="md-form-errors red-text">
									<p class=""><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;{{ $errors->first('team_name') }}</p>
								</div>
							@endif
							
							<div class="input-form">
								<label for="fee_paid" class="d-block">League Fee Paid</label>
								<div class="">
									<button class="btn inputSwitchToggle green active" type="button">Yes
										<input type="checkbox" name="fee_paid" class="hidden" value="Y" checked hidden />
									</button>
									
									<button class="btn inputSwitchToggle grey" type="button">No
										<input type="checkbox" name="fee_paid" class="hidden" value="N" hidden />
									</button>
								</div>
							</div>
							<div class="md-form text-center">
								<button type="submit" class="btn blue lighten-1">Create Team</button>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
				<!--/.Card-->
			</div>
			<div class="col col-md-3 mt-3 text-center text-md-right order-first order-md-0">
				<a href="{{ request()->query() == null ? route('league_teams.index') : route('league_teams.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">All Teams</a>
			</div>
		</div>
	</div>
@endsection