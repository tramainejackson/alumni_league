@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">

		<div class="row" id="">
			@if(Auth::check() && Auth::user()->type == 'admin')
				{{--Authourization Only--}}
				<div class="col col-lg-10 mx-auto my-3">
					@if(!isset($allComplete))
						<a class="btn btn-rounded mdb-color darken-3 white-text" type="button" href="{{ request()->query() == null ? route('league_teams.create') : route('league_teams.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}">Add New Team</a>
					@else
					@endif
				</div>
			@endif
		</div>

		<div class="row view pt-3">
			<div class="col-12 col-lg-10 mx-auto{{ $seasonTeams->isNotEmpty() ? '' : ' d-flex align-items-center justify-content-center flex-column' }}">
				<div class="text-center coolText1">
					<div class="text-center p-4 card rgba-deep-orange-light white-text my-3" id="">
						<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
					</div>

					@if($showSeason->is_playoffs == 'Y')
						<h1 class="display-4 coolText4">It's Playoff Time</h1>
					@endif
				</div>

				@if(!isset($allComplete))

					@if(Auth::check())

						{{--Authourization Only--}}
						@if($seasonTeams->isNotEmpty())

							<div class="row">
								@foreach($seasonTeams as $team)

									@php $teamCaptain = $team->players()->captain(); @endphp

									<div class="col-12 col-xl-6">
										<div class="card card-cascade wider my-4">
											<!-- Card image -->
											<div class="view overlay">
												<img class="card-img-top" src="{{ $team->team_picture != null ? $team->sm_photo() : $defaultImg }}" alt="Card image cap">
												<a href="#!">
													<div class="mask rgba-white-slight"></div>
												</a>
											</div>

											<!-- Card content -->
											<div class="card-body text-center position-relative border z-depth-1-half rgba-white-strong">
												<!-- Title -->
												<h1 class="card-title h1-responsive font-weight-bold mx-auto">{{ $team->team_name }}</h1>
												<!-- Team Captain Info -->
												<div class="d-flex flex-column align-items-center">
													<h3 class="border-bottom card-title h3-responsive mb-2 px-5">Captain Info</h3>
													<div class="d-flex flex-column align-items-center justify-content-center">
														<p class="m-0">
															<label class="">Name:&nbsp;</label>
															<span>{{ $teamCaptain->isNotEmpty() ? $teamCaptain->first()->player_name : 'N/A' }}</span>
														</p>

														<p class="m-0">
															<label class="">Phone:&nbsp;</label>
															<span>{{ $teamCaptain->isNotEmpty() ? $teamCaptain->first()->phone != null ? $teamCaptain->first()->phone : 'No Phone Number' : 'No Phone Number' }}</span>
														</p>
													</div>

													@if($team->league_conference_id != null || $team->league_division_id != null)
														<div class="divider-short"></div>
													@endif

													@if($team->league_conference_id != null)
														<p class="m-0">
															<label class="">Conference:&nbsp;</label>
															<span>{{ $team->conference->conference_name }}</span>
														</p>
													@endif

													@if($team->league_division_id != null)
														<p class="m-0">
															<label class="">Division:&nbsp;</label>
															<span>{{ $team->division->division_name }}</span>
														</p>
													@endif

													@if(Auth::check() && (Auth::user()->type == 'admin') || array_search($team->id, $userTeamsIDs) !== false)
														{{--Authourization Only--}}
														<div class="">
															<a href="{{ request()->query() == null ? route('league_teams.edit', ['league_team' => $team->id]) : route('league_teams.edit', ['league_team' => $team->id, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg deep-orange lighten-1 white-text">Edit Team</a>
														</div>
													@else
														<div class="">
															<a href="{{ request()->query() == null ? route('league_teams.show', ['league_team' => $team->id]) : route('league_teams.show', ['league_team' => $team->id, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg blue lighten-1 white-text">View Team</a>
														</div>
													@endif
												</div>

												@if(Auth::check() && Auth::user()->type == 'admin')
													{{--Authourization Only--}}
													<div class="feesButton">
														@if($team->fee_paid == 'N')
															<button class="btn orange darken-2 white-text" type="button">Fees Due</button>
														@else
															<button class="btn green darken-1 white-text" type="button">Fees Paid</button>
														@endif
													</div>
												@endif
											</div>
										</div>
									</div>
								@endforeach
							</div>

						@else

							<div class="{{ $showSeason->league_profile && $seasonTeams->isEmpty() ? '' : 'col-12 col-lg-8 d-flex align-items-center justify-content-center flex-column' }}">

								<div class="text-center coolText1">
									<h1 class="h1-responsive text-center coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;There are no teams added for this season yet&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h1>
								</div>

								<!--Card-->
								<div class="card card-cascade mb-4 reverse wider">
									<!--Card image-->
									<div class="view">
										<img src="{{ $defaultImg }}" class="img-fluid mx-auto" alt="photo">
									</div>
									<!--Card content-->
									<div class="card-body text-center position-relative border z-depth-1-half rgba-white-strong">
										<!--Title-->
										<h2 class="card-title h2-responsive text-center">Create New Team</h2>

										<!-- Create Form -->
										<form action="{{ action('LeagueTeamController@store', ['season' => $showSeason->id, 'year' => $showSeason->year]) }}" method="POST" class="" enctype="multipart/form-data">

											{{ csrf_field() }}

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
										</form>
									</div>
								</div>
								<!--/.Card-->
							</div>
						@endif

					@else

						@if($seasonTeams->isNotEmpty())

							<div class="row">
								@foreach($seasonTeams as $team)
									@php $teamCaptain = $team->players()->captain(); @endphp

									@if($team->is_all_star_team == 'Y')

										@if($showSeason->is_playoffs == 'Y')

											<div class="col-12 col-xl-6">
												<div class="card card-cascade wider my-4">
													<!-- Card image -->
													<div class="view overlay">
														<img class="card-img-top" src="{{ $team->team_picture != null ? $team->sm_photo() : $defaultImg }}" alt="Card image cap">
														<a href="#!">
															<div class="mask rgba-white-slight"></div>
														</a>
													</div>

													<!-- Card content -->
													<div class="card-body text-center position-relative border z-depth-1-half rgba-white-strong">
														<!-- Title -->
														<h1 class="card-title h1-responsive font-weight-bold mx-auto">{{ $team->team_name }}</h1>
														<!-- Team Captain Info -->
														<div class="d-flex flex-column align-items-center">
															<h3 class="border-bottom card-title h3-responsive mb-2 px-5">Captain Info</h3>
															<div class="d-flex flex-column align-items-center justify-content-center">
																<p class="m-0">
																	<label class="">Name:&nbsp;</label>
																	<span>{{ $teamCaptain->isNotEmpty() ? $teamCaptain->first()->player_name : 'N/A' }}</span>
																</p>

																<p class="m-0">
																	<label class="">Phone:&nbsp;</label>
																	<span>{{ $teamCaptain->isNotEmpty() ? $teamCaptain->first()->phone != null ? $teamCaptain->first()->phone : 'No Phone Number' : 'No Phone Number' }}</span>
																</p>
															</div>

															@if($team->league_conference_id != null || $team->league_division_id != null)
																<div class="divider-short"></div>
															@endif

															@if($team->league_conference_id != null)
																<p class="m-0">
																	<label class="">Conference:&nbsp;</label>
																	<span>{{ $team->conference->conference_name }}</span>
																</p>
															@endif

															@if($team->league_division_id != null)
																<p class="m-0">
																	<label class="">Division:&nbsp;</label>
																	<span>{{ $team->division->division_name }}</span>
																</p>
															@endif

															<div class="">
																<a href="{{ request()->query() == null ? route('league_teams.show', ['league_team' => $team->id]) : route('league_teams.show', ['league_team' => $team->id, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg blue lighten-1 white-text">View Team</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										@endif
									@else
										<div class="col-12 col-xl-6">
											<div class="card card-cascade wider my-4">
												<!-- Card image -->
												<div class="view overlay">
													<img class="card-img-top" src="{{ $team->team_picture != null ? $team->sm_photo() : $defaultImg }}" alt="Card image cap">
													<a href="#!">
														<div class="mask rgba-white-slight"></div>
													</a>
												</div>

												<!-- Card content -->
												<div class="card-body text-center position-relative border z-depth-1-half rgba-white-strong">
													<!-- Title -->
													<h1 class="card-title h1-responsive font-weight-bold mx-auto">{{ $team->team_name }}</h1>
													<!-- Team Captain Info -->
													<div class="d-flex flex-column align-items-center">
														<h3 class="border-bottom card-title h3-responsive mb-2 px-5">Captain Info</h3>
														<div class="d-flex flex-column align-items-center justify-content-center">
															<p class="m-0">
																<label class="">Name:&nbsp;</label>
																<span>{{ $teamCaptain->isNotEmpty() ? $teamCaptain->first()->player_name : 'N/A' }}</span>
															</p>

															<p class="m-0">
																<label class="">Phone:&nbsp;</label>
																<span>{{ $teamCaptain->isNotEmpty() ? $teamCaptain->first()->phone != null ? $teamCaptain->first()->phone : 'No Phone Number' : 'No Phone Number' }}</span>
															</p>
														</div>

														@if($team->league_conference_id != null || $team->league_division_id != null)
															<div class="divider-short"></div>
														@endif

														@if($team->league_conference_id != null)
															<p class="m-0">
																<label class="">Conference:&nbsp;</label>
																<span>{{ $team->conference->conference_name }}</span>
															</p>
														@endif

														@if($team->league_division_id != null)
															<p class="m-0">
																<label class="">Division:&nbsp;</label>
																<span>{{ $team->division->division_name }}</span>
															</p>
														@endif

														<div class="">
															<a href="{{ request()->query() == null ? route('league_teams.show', ['league_team' => $team->id]) : route('league_teams.show', ['league_team' => $team->id, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg blue lighten-1 white-text">View Team</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									@endif
								@endforeach
							</div>
						@endif
					@endif
				@else
					<div class="coolText4 py-3 px-5">
						<h1 class="h1-responsive text-justify">It doesn't look like you have any active seasons going for your league right now. Let'e get started by creating a new season. Click <a href="/home?new_season">here</a> to create a new season.</h1>
					</div>
				@endif
			</div>
		</div>
	</div>

	<!-- Footer -->
	@include('layouts.footer')
	<!-- Footer -->
@endsection