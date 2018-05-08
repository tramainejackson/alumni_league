@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md mt-3">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_teams.create', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->season . ' ' . $activeSeason->year }}</a>
					@endforeach
				@else
				@endif
			</div>
			<div class="col-12 col-md-8">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				
				<!--Card-->
				<div class="card card-cascade mb-4 reverse wider">
					<!--Card image-->
					<div class="view">
						<img src="/images/commissioner.jpg" class="img-fluid" alt="photo">
					</div>
					<!--Card content-->
					<div class="card-body">
						<!--Title-->
						<h2 class="card-title h2-responsive text-center">Create New Team</h2>
						<!-- Create Form -->
						{!! Form::open(['action' => ['LeagueTeamController@store'], 'method' => 'POST']) !!}
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
			<div class="col-md mt-3">
				<a href="{{ route('league_teams.create') }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Team</a>
			</div>
		</div>
	</div>
@endsection