@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md mt-3">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_teams.index', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->season . ' ' . $activeSeason->year }}</a>
					@endforeach
				@else
				@endif
			</div>
			<div class="col-12 col-md-8">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				
				@if($seasonTeams->isNotEmpty())
					<div class="row">
						@foreach($seasonTeams as $team)
							@php $teamCaptain = $team->players()->captain(); @endphp

							<div class="col-6">
								<div class="card card-cascade wider my-4">
									<!-- Card image -->
									<div class="view overlay">
										<img class="card-img-top" src="{{ $team->team_picture != null ? $team->sm_photo() : $defaultImg }}" alt="Card image cap">
										<a href="#!">
											<div class="mask rgba-white-slight"></div>
										</a>
									</div>
									
									<!-- Card content -->
									<div class="card-body text-center position-relative">
										<!-- Title -->
										<h1 class="card-title h1-responsive font-weight-bold">{{ $team->team_name }}</h1>
										<!-- Team Captain Info -->
										<div class="d-flex flex-column align-items-center">
											<h3 class="border-bottom card-title h3-responsive mb-2 px-5">Captain Info</h3>
											<div class="d-flex flex-column align-items-center justify-content-center">
												<p class="m-0">
													<label class="">Name:&nbsp;</label>
													<span>{{ $teamCaptain->isNotEmpty() ? $teamCaptain->first()->player_name : 'N/A' }}</span>
												</p>
												<p class="m-0">
													<label class="">Email:&nbsp;</label>
													<span>{{ $teamCaptain->isNotEmpty() ? $teamCaptain->first()->email != null ? $teamCaptain->first()->email : 'No email address' : 'No email address' }}</span>
												</p>
												<p class="m-0">
													<label class="">Phone:&nbsp;</label>
													<span>{{ $teamCaptain->isNotEmpty() ? $teamCaptain->first()->phone != null ? $teamCaptain->first()->phone : 'No email address' : 'No email address' }}</span>
												</p>
											</div>
											<div class="">
												<a href="{{ request()->query() == null ? route('league_teams.edit', ['league_team' => $team->id]) : route('league_teams.edit', ['league_team' => $team->id, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg blue lighten-1">Edit Team</a>
											</div>
										</div>
										<div class="feesButton">
											@if($team->fee_paid == 'N')
												<button class="btn orange darken-2" type="button">Fees Due</button>
											@else
												<button class="btn green darken-1" type="button">Fees Paid</button>
											@endif
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				@else
					<div class="">
						<h3 class="h3-responsive text-center">There are no teams added for this season yet</h3>
					</div>
				@endif
			</div>

			<div class="col-md mt-3">
				<a href="{{ request()->query() == null ? route('league_teams.create') : route('league_teams.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Team</a>
			</div>
		</div>
	</div>
@endsection