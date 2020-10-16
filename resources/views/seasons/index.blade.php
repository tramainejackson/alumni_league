@extends('layouts.app')

@section('additional_scripts')
	<script type="text/javascript">
        if(window.location.href.indexOf("new_season") > 0) {
            setTimeout(function() {
                $('#newSeasonForm').modal('show');
            }, 500);
        }
	</script>
@endsection

@section('content')
	@if(Auth::check())
		@include('include.functions')

		<div class="container-fluid bgrd3">
			<div class="row align-items-stretch{{ $showSeason->league_profile ? '': ' view' }}">
				<!--Column will include buttons for creating a new season-->
				<div class="col py-3" id="">
					<div class="row">
						<div class="col">
							<button class="btn btn-lg btn-rounded blue white-text" type="button" data-toggle="modal" data-target="#newSeasonForm">New Season</button>

							@if($activeSeasons->isNotEmpty())
								@foreach($activeSeasons as $activeSeason)
									<a href="{{ route('league_seasons.index', ['season' => $activeSeason->id]) }}" class="btn btn-lg btn-rounded deep-orange white-text d-block{{ $activeSeason->id == $showSeason->id ? ' lighten-2' : '' }}" type="button">{{ $activeSeason->name }}</a>
								@endforeach
							@else
							@endif
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-7 pb-3{{ $showSeason->league_profile ? '': ' d-flex align-items-center justify-content-center' }}">

					@if($showSeason->completed == 'N')
						<!-- Show league season info -->
						@if($showSeason->paid == 'Y')
							<div class="text-center coolText1 d-flex align-items-center justify-content-center seasonName">
								<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
							</div>

							<!--Card-->
							<div class="card">
								<!--Card content-->
								<div class="card-body">
									<!-- League season info -->
									<div class="">

										<form action="{{ action('LeagueSeasonController@update', [$showSeason->league_profile->id, 'season' => $showSeason->id, 'year' => $showSeason->year]) }}" method="POST" class="" enctype="multipart/form-data">

											{{ method_field('PATCH') }}
											{{ csrf_field() }}

											<div class="updateLeagueForm">

												<div class="row">
													<div class="col-12 col-md" id="">
														<div class="md-form">
															<input type="text" name="name" class="form-control" id="leagues_season_name" placeholder="Name" value="{{ $showSeason->name }}" />

															<label for="name">Name</label>
														</div>
													</div>

													<div class="col-12 col-md" id="">
														<div class="md-form">
															<input type="text" name="leagues_address" class="form-control" id="leagues_address" placeholder="Address" value="{{ $showSeason->address }}" />

															<label for="leagues_address">Address</label>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md">
														<div class="md-form input-group">
															<div class="input-group-prepend">
																<span class="input-group-text md-addon"><i class="fas fa-dollar-sign"></i></span>
															</div>

															<input type="number" name="leagues_fee" class="form-control" id="league_fee" value="{{ $showSeason->league_fee }}"  step="0.01" placeholder="League Entry Fee" />

															<div class="input-group-prepend">
																<span class="input-group-text">Per Team</span>
															</div>

															<label for="leagues_fee">Entry Fee</label>
														</div>
													</div>

													<div class="col-12 col-md">
														<div class="md-form input-group mb-5">
															<div class="input-group-prepend">
																<span class="input-group-text md-addon"><i class="fas fa-dollar-sign" aria-hidden="true"></i></span>
															</div>

															<input type="number" class="form-control" class="form-control" name="ref_fee" id="ref_fee" value="{{ $showSeason->ref_fee }}" step="0.01" placeholder="Ref Fee" />

															<div class="input-group-prepend">
																<span class="input-group-text">Per Game</span>
															</div>

															<label for="ref_fee">Ref Fee</label>
														</div>
													</div>
												</div>

												<div class="row">

													<div class="col-12 col-md">
														<select class="mdb-select md-form" name="age_group">
															<option value="blank" disabled>Select An Age Option</option>
															@foreach($ageGroups as $ageGroup)
																<option value="{{ $ageGroup }}"{{ $ageGroup == $showSeason->age_group ? ' selected' : ''  }}>{{ ucwords(str_ireplace('_', ' ', $ageGroup)) }}</option>
															@endforeach
														</select>

														<label data-error="wrong" data-success="right" for="age_group" class="text-primary mdb-main-label">Age Group</label>
													</div>

													<div class="col-12 col-md">
														<select class="mdb-select md-form" name="comp_group">
															<option value="blank" disabled>Select A Competition Option</option>
															@foreach($compGroups as $compGroup)
																<option value="{{ $compGroup }}"{{ $compGroup == $showSeason->comp_group ? ' selected' : ''  }}>{{ ucwords(str_ireplace('_', ' ', $compGroup)) }}</option>
															@endforeach
														</select>

														<label for="comp_group" class="text-primary mdb-main-label">Competition Group</label>
													</div>

												</div>

												<div class="form-row">
													<div class="form-group col-12">
														<label for="standings_type" class="d-block form-control-label">Standings Type</label>

														<div class="d-block d-sm-inline">
															<button type="button" class="btn w-auto automaticStandings automatic{{ $showSeason->standings_type == 'automatic' ? ' active btn-success' : ' btn-blue-grey' }}">
																<input type="checkbox" name="standings_type" value="automatic" {{ $showSeason->standings_type == 'automatic' ? 'checked' : '' }} hidden />Automatic
															</button>
														</div>
														<div class="d-block d-sm-inline">
															<button type="button" class="btn w-auto manualStandings manual{{ $showSeason->standings_type == 'manual' ? ' active btn-success' : ' btn-blue-grey' }}">
																<input type="checkbox" name="standings_type" value="manual" {{ $showSeason->standings_type == 'manual' ? 'checked' : '' }} hidden />Manual
															</button>
														</div>
														<span class="{{ $showSeason->standings_type == 'automatic' ? 'd-block d-sm-inline' : 'd-none' }}">
															<button type="button" class="btn w-auto btn-blue gsBtn">Generate Standings</button>
														</span>
													</div>
												</div>

												<div class="form-row">
													<div class="form-group col-12">
														<label for="schedule_type" class="d-block form-control-label">Scheduling Type</label>

														<div class="d-block d-sm-inline">
															<button type="button" class="btn w-auto automaticSchedule automatic{{ $showSeason->schedule_type == 'automatic' ? ' active btn-success' : ' btn-blue-grey' }}">
																<input type="checkbox" name="schedule_type" value="automatic" {{ $showSeason->schedule_type == 'automatic' ? 'checked' : '' }} hidden />Automatic
															</button>
														</div>
														<div class="d-block d-sm-inline">
															<button type="button" class="btn w-auto manualSchedule manual{{ $showSeason->schedule_type == 'manual' ? ' active btn-success' : ' btn-blue-grey' }}">
																<input type="checkbox" name="schedule_type" value="manual" {{ $showSeason->schedule_type == 'manual' ? 'checked' : '' }} hidden />Manual
															</button>
														</div>
														<span class="{{ $showSeason->standings_type == 'automatic' ? 'd-block d-sm-inline' : 'd-none' }}">
															<button type="button" class="btn w-auto btn-blue gsBtn">Generate Schedule</button>
														</span>
													</div>
												</div>

												<div class="form-row justify-content-around align-items-center">
													<div class="form-group text-center">
														<label for="conferences" class="d-block form-control-label">Conferences</label>

														<div class="btn-group">
															<button type="button" class="btn activeYes{{ $showSeason->has_conferences == 'Y' ? ' active btn-success' : ' btn-blue-grey' }}" style="line-height:1.5">
																<input type="checkbox" name="conferences" value="Y" {{ $showSeason->has_conferences == 'Y' ? 'checked' : '' }} hidden />Yes
															</button>
															<button type="button" class="btn activeNo{{ $showSeason->has_conferences == 'N' ? ' active btn-success' : ' btn-blue-grey' }}" style="line-height:1.5">
																<input type="checkbox" name="conferences" value="N" {{ $showSeason->has_conferences == 'N' ? 'checked' : '' }} hidden />No
															</button>
														</div>
													</div>

													<div class="form-group text-center">
														<label for="divisions" class="d-block form-control-label">Divisions</label>

														<div class="btn-group">
															<button type="button" class="btn activeYes{{ $showSeason->has_divisions == 'Y' ? ' active btn-success' : ' btn-blue-grey' }}" style="line-height:1.5">
																<input type="checkbox" name="divisions" value="Y" {{ $showSeason->has_divisions == 'Y' ? 'checked' : '' }} hidden />Yes
															</button>
															<button type="button" class="btn activeNo{{ $showSeason->has_divisions == 'N' ? ' active btn-success' : ' btn-blue-grey' }}" style="line-height:1.5">
																<input type="checkbox" name="divisions" value="N" {{ $showSeason->has_divisions == 'N' ? 'checked' : '' }} hidden />No
															</button>
														</div>
													</div>
												</div>

												{{-- Add Divider--}}
												<div class="divider-long" id=""></div>

												@if($showSeason->has_conferences == 'Y')
													<div class="text-center" id="">
														<h2>Conference Names</h2>
													</div>

													<div class="row">
														@foreach($showSeasonConferences as $conference)
															<div class="col-12 col-md" id="">
																<div class="md-form">
																	<input type="text" name="conference_name[]" class="form-control" id="conference_name" placeholder="Name" value="{{ $conference->conference_name }}" />

																	<label for="conference_name">Conference {{ $loop->iteration }} Name</label>
																</div>
															</div>
														@endforeach
													</div>

													{{-- Add Divider--}}
													<div class="divider-long" id=""></div>
												@endif

												@if($showSeason->has_divisions == 'Y')
													<div class="text-center" id="">
														<h2>Division Names</h2>
													</div>

													<div class="row">
														@foreach($showSeasonDivisions as $division)
															<div class="col-12 col-md" id="">
																<div class="md-form">
																	<input type="text" name="division_name[]" class="form-control" id="division_name" placeholder="Name" value="{{ $division->division_name }}" />

																	<label for="division_name">Division {{ $loop->iteration }} Name</label>
																</div>
															</div>
														@endforeach
													</div>

													{{-- Add Divider--}}
													<div class="divider-long" id=""></div>
												@endif

												<div class="d-flex justify-content-around align-items-center">
													<button type="submit" class="btn btn-lg white-text green" id="">Update League</button>
													<button type="button" class="btn btn-lg white-text cyan darken-2" id="" data-toggle="modal" data-target="#start_playoffs">Start Playoffs</button>
												</div>
											</div>
										</form>
									</div>
									<!--./ League season info /.-->
								</div>
							</div>
							<!--/.Card-->
						@else
							<div class="coolText4 py-3 px-5">
								<h1 class="h1-responsive text-justify">Welcome to ToTheRec Leagues home page. Here you will be able to see your schedule, stats, and information for the selected season at a glance.<br/><br/>It doesn't look like you have any active seasons going for your league right now. Let'e get started by creating a new season. Click <a href="#" class="" type="button" data-toggle="modal" data-target="#newSeasonForm">here</a> to create a new season.</h1>
							</div>
						@endif
					@else
						<div class="coolText4 py-3 px-lg-5">
							<h1 class="h1-responsive text-justify">It doesn't look like you have any active seasons going for your league right now. Let'e get started by creating a new season. Click <a href="#" class="" type="button" data-toggle="modal" data-target="#newSeasonForm">here</a> to create a new season.<br/><br/>You can always see past seasons by selecting the links under the completed season section to the right</h1>
						</div>
					@endif
				</div>

				<!--Column will include seasons (archieved and current)-->
				<div class="col py-3 d-none d-lg-block">
					<!--Show completed season if any available-->
					<h2 class="text-center h2-responsive">Completed Seasons</h2>

					@if($completedSeasons->isNotEmpty())
						@foreach($completedSeasons as $completedSeason)
							<div class="text-center">
								<a href="{{ route('archives', ['season' => $completedSeason->id]) }}" class="btn btn-rounded btn-lg purple darken-2 d-block">{{ ucfirst($completedSeason->name) }}</a>
							</div>
						@endforeach
					@else
						<div class="text-center">
							<h4 class="h4-responsive">You do not currently have any completed season in the archives</h4>
						</div>
					@endif
				</div>
			</div>

			@if($showSeason->paid == 'Y')

				<div class="row">
					<!-- League season schedule snap shot -->
					<div class="col-12 col-lg-8 col-xl-8 mx-auto my-5">
						<div class="my-5 d-flex align-items-center justify-content-center flex-column">
							<div class="d-flex w-100 justify-content-center align-items-center flex-column flex-lg-row">
								<h1 class="h1-responsive">Upcoming Schedule</h1>
								<a href="{{ request()->query() == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">Full Schedule</a>
							</div>

							<div class="container-fluid" id="season_schedule_snap">
								<div class="row">
									@if($showSeasonSchedule->isNotEmpty())
										@foreach($showSeasonSchedule as $upcomingGame)
											<div class="card col-12 col-md-6 col-lg-4 col-lg-3 my-2">
												<h3 class="h3-responsive text-center p-4 blue-grey white-text">Week&nbsp;{{ $upcomingGame->season_week }}</h3>
												<div class="card-body text-center">
													<p class="">{{ $upcomingGame->home_team }}</p>
													<p class="">vs</p>
													<p class="">{{ $upcomingGame->away_team }}</p>
												</div>
												<div class="card-footer px-1 d-flex align-items-center justify-content-around">
													<span class="mx-2"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;{{ $upcomingGame->game_time() }}</span>
													<span class="mx-2"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;{{ $upcomingGame->game_date() }}</span>
												</div>
											</div>
										@endforeach
									@else
										<div class="col text-center">
											<h3 class="h3-responsive">No upcoming games within the next week on this seasons schedule</h3>
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
					<!--./ League season schedule snap shot /.-->

					<!-- League season teams snap shot -->
					<div class="col-8 mx-auto my-5">
						<div class="d-flex w-100 justify-content-center align-items-center flex-column flex-lg-row">
							<h1 class="h1-responsive">Teams</h1>
							<a href="{{ request()->query() == null ? route('league_teams.index') : route('league_teams.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">All Teams</a>
						</div>
						<div id="season_teams_snap" class="my-5 d-flex align-items-center justify-content-around mb-4 mb-lg-0 flex-column flex-lg-row">
							@if($showSeasonTeams->isNotEmpty())

								<button class="btn btn-lg deep-purple white-text">Total Teams:&nbsp;<span class="badge badge-pill blue-grey">{{ $showSeasonTeams->count() }}</span></button>

								<button class="btn btn-lg deep-purple white-text">Total Players:&nbsp;<span class="badge badge-pill blue-grey">{{ $showSeasonPlayers->count() }}</span></button>

								<button class="btn btn-lg deep-purple white-text">Unpaid Teams:&nbsp;<span class="badge badge-pill blue-grey">{{ $showSeasonUnpaidTeams->count() }}</span></button>

							@else

								<h3 class="h3-responsive">No teams showing for this season</h3>

							@endif
						</div>
					</div>
					<!--./ League season teams snap shot /.-->

					<!-- League season stats snap shot -->
					<div class="col-8 mx-auto my-5">
						<div class="d-flex w-100 justify-content-center align-items-center flex-column flex-lg-row">
							<h1 class="h1-responsive">Stats</h1>
							<a href="{{ request()->query() == null ? route('league_stats.index') : route('league_stats.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">All Stats</a>
						</div>
						<div id="season_stats_snap" class="my-5 row">
							<!-- Season stat leaders by category -->
						@if($showSeasonStat->isNotEmpty())
							<!-- Get the scoring leaders -->
								<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
									<table class="table white-text">
										<thead>
										<tr>
											<th>Team</th>
											<th>Player</th>
											<th>PPG</th>
										</tr>
										</thead>
										<tbody>
										@foreach($showSeason->stats()->scoringLeaders(5)->get() as $playerStat)
											<tr class="white-text">
												<td>{{ $playerStat->player->team_name }}</td>
												<td>{{ $playerStat->player->player_name }}</td>
												<td>{{ $playerStat->PPG != null ? $playerStat->PPG : 'N/A' }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>

								<!-- Get the rebounding leaders -->
								<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
									<table class="table white-text">
										<thead>
										<tr>
											<th>Team</th>
											<th>Player</th>
											<th>RPG</th>
										</tr>
										</thead>
										<tbody>
										@foreach($showSeason->stats()->reboundingLeaders(5)->get() as $playerStat)
											<tr class="white-text">
												<td>{{ $playerStat->player->team_name }}</td>
												<td>{{ $playerStat->player->player_name }}</td>
												<td>{{ $playerStat->RPG != null ? $playerStat->RPG : 'N/A' }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>

								<!-- Get the assisting leaders -->
								<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
									<table class="table white-text">
										<thead>
										<tr>
											<th>Team</th>
											<th>Player</th>
											<th>APG</th>
										</tr>
										</thead>
										<tbody>
										@foreach($showSeason->stats()->assistingLeaders(5)->get() as $playerStat)
											<tr class="white-text">
												<td>{{ $playerStat->player->team_name }}</td>
												<td>{{ $playerStat->player->player_name }}</td>
												<td>{{ $playerStat->APG != null ? $playerStat->APG : 'N/A' }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>

								<!-- Get the stealing leaders -->
								<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
									<table class="table white-text">
										<thead>
										<tr>
											<th>Team</th>
											<th>Player</th>
											<th>SPG</th>
										</tr>
										</thead>
										<tbody>
										@foreach($showSeason->stats()->stealingLeaders(5)->get() as $playerStat)
											<tr class="white-text">
												<td>{{ $playerStat->player->team_name }}</td>
												<td>{{ $playerStat->player->player_name }}</td>
												<td>{{ $playerStat->SPG != null ? $playerStat->SPG : 'N/A' }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>

								<!-- Get the blocking leaders -->
								<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
									<table class="table white-text">
										<thead>
										<tr>
											<th>Team</th>
											<th>Player</th>
											<th>BPG</th>
										</tr>
										</thead>
										<tbody>
										@foreach($showSeason->stats()->blockingLeaders(5)->get() as $playerBlocks)
											<tr class="white-text">
												<td>{{ $playerBlocks->player->team_name }}</td>
												<td>{{ $playerBlocks->player->player_name }}</td>
												<td>{{ $playerBlocks->BPG != null ? $playerBlocks->BPG : 'N/A' }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							@else
								<h3 class="text-center h3-responsive col">There are no stats added for this league yet</h3>
							@endif
						</div>
					</div>
					<!--./ League season stats snap shot /.-->
				</div>
			@else
			@endif

			{{-- Include Modals--}}
			@include('modals.new_season_modal')
			@include('modals.complete_season_modal')

		</div>
	@else
		<div class="container-fluid bgrd3">

			<div class="row view">

				@if($showSeason->paid == 'Y')

					<div class="row">
						<!-- League season schedule snap shot -->
						<div class="col-12 mx-auto py-2">
							<h2 class="display-3 text-center">Active Season(s)</h2>

							@if($activeSeasons->isNotEmpty())
								@foreach($activeSeasons as $activeSeason)
									<a href="{{ route('league_seasons.index', ['season' => $activeSeason->id]) }}" class="btn btn-lg btn-rounded deep-orange white-text{{ $activeSeason->id == $showSeason->id ? ' lighten-2' : '' }}" type="button">{{ $activeSeason->name }}</a>
								@endforeach
							@else
							@endif
						</div>

						<div class="col-12 col-lg-8 col-xl-8 mx-auto my-5">
							<div class="text-center p-4 card rgba-deep-orange-light white-text" id="">
								<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
							</div>
							<div class="my-5 d-flex align-items-center justify-content-center flex-column">
								<div class="d-flex w-100 justify-content-center align-items-center flex-column flex-lg-row">
									<h1 class="h1-responsive">Upcoming Schedule</h1>
									<a href="{{ request()->query() == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">Full Schedule</a>
								</div>

								<div class="container-fluid" id="season_schedule_snap">
									<div class="row">
										@if($showSeasonSchedule->isNotEmpty())
											@foreach($showSeasonSchedule as $upcomingGame)
												<div class="card col-12 col-md-6 col-lg-4 col-lg-3 my-2">
													<h3 class="h3-responsive text-center p-4 blue-grey white-text">Week&nbsp;{{ $upcomingGame->season_week }}</h3>
													<div class="card-body text-center">
														<p class="">{{ $upcomingGame->home_team }}</p>
														<p class="">vs</p>
														<p class="">{{ $upcomingGame->away_team }}</p>
													</div>
													<div class="card-footer px-1 d-flex align-items-center justify-content-around">
														<span class="mx-2"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;{{ $upcomingGame->game_time() }}</span>
														<span class="mx-2"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;{{ $upcomingGame->game_date() }}</span>
													</div>
												</div>
											@endforeach
										@else
											<div class="col text-center">
												<h3 class="h3-responsive">No upcoming games within the next week on this seasons schedule</h3>
											</div>
										@endif
									</div>
								</div>
							</div>
						</div>
						<!--./ League season schedule snap shot /.-->

						<!-- Divider /.-->
						<div class="divider-short" id=""></div>
						<!--./ Divider /.-->

						<!-- League season teams snap shot -->
						<div class="col-8 mx-auto my-5">
							<div class="d-flex w-100 justify-content-center align-items-center flex-column flex-lg-row">
								<h1 class="h1-responsive">Teams</h1>
								<a href="{{ request()->query() == null ? route('league_teams.index') : route('league_teams.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">All Teams</a>
							</div>
							<div id="season_teams_snap" class="my-5 d-flex align-items-center justify-content-around mb-4 mb-lg-0 flex-column flex-lg-row">
								@if($showSeasonTeams->isNotEmpty())

									<button class="btn btn-lg deep-purple white-text">Total Teams:&nbsp;<span class="badge badge-pill blue-grey">{{ $showSeasonTeams->count() }}</span></button>

									<button class="btn btn-lg deep-purple white-text">Total Players:&nbsp;<span class="badge badge-pill blue-grey">{{ $showSeasonPlayers->count() }}</span></button>

								@else

									<h3 class="h3-responsive">No teams showing for this season</h3>

								@endif
							</div>
						</div>
						<!--./ League season teams snap shot /.-->

						<!-- Divider /.-->
						<div class="divider-short" id=""></div>
						<!--./ Divider /.-->

						<!-- League season stats snap shot -->
						<div class="col-8 mx-auto my-5">
							<div class="d-flex w-100 justify-content-center align-items-center flex-column flex-lg-row">
								<h1 class="h1-responsive">Stats</h1>
								<a href="{{ request()->query() == null ? route('league_stats.index') : route('league_stats.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">All Stats</a>
							</div>
							<div id="season_stats_snap" class="my-5 row">
								<!-- Season stat leaders by category -->
							@if($showSeasonStat->isNotEmpty())
								<!-- Get the scoring leaders -->
									<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
										<table class="table white-text">
											<thead>
											<tr>
												<th>Team</th>
												<th>Player</th>
												<th>PPG</th>
											</tr>
											</thead>
											<tbody>
											@foreach($showSeason->stats()->scoringLeaders(5)->get() as $playerStat)
												<tr class="white-text">
													<td>{{ $playerStat->player->team_name }}</td>
													<td>{{ $playerStat->player->player_name }}</td>
													<td>{{ $playerStat->PPG != null ? $playerStat->PPG : 'N/A' }}</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>

									<!-- Get the rebounding leaders -->
									<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
										<table class="table white-text">
											<thead>
											<tr>
												<th>Team</th>
												<th>Player</th>
												<th>RPG</th>
											</tr>
											</thead>
											<tbody>
											@foreach($showSeason->stats()->reboundingLeaders(5)->get() as $playerStat)
												<tr class="white-text">
													<td>{{ $playerStat->player->team_name }}</td>
													<td>{{ $playerStat->player->player_name }}</td>
													<td>{{ $playerStat->RPG != null ? $playerStat->RPG : 'N/A' }}</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>

									<!-- Get the assisting leaders -->
									<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
										<table class="table white-text">
											<thead>
											<tr>
												<th>Team</th>
												<th>Player</th>
												<th>APG</th>
											</tr>
											</thead>
											<tbody>
											@foreach($showSeason->stats()->assistingLeaders(5)->get() as $playerStat)
												<tr class="white-text">
													<td>{{ $playerStat->player->team_name }}</td>
													<td>{{ $playerStat->player->player_name }}</td>
													<td>{{ $playerStat->APG != null ? $playerStat->APG : 'N/A' }}</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>

									<!-- Get the stealing leaders -->
									<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
										<table class="table white-text">
											<thead>
											<tr>
												<th>Team</th>
												<th>Player</th>
												<th>SPG</th>
											</tr>
											</thead>
											<tbody>
											@foreach($showSeason->stats()->stealingLeaders(5)->get() as $playerStat)
												<tr class="white-text">
													<td>{{ $playerStat->player->team_name }}</td>
													<td>{{ $playerStat->player->player_name }}</td>
													<td>{{ $playerStat->SPG != null ? $playerStat->SPG : 'N/A' }}</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>

									<!-- Get the blocking leaders -->
									<div class="blue-gradient col-12 col-md-7 col-lg-5 m-1 table-wrapper mx-auto">
										<table class="table white-text">
											<thead>
											<tr>
												<th>Team</th>
												<th>Player</th>
												<th>BPG</th>
											</tr>
											</thead>
											<tbody>
											@foreach($showSeason->stats()->blockingLeaders(5)->get() as $playerBlocks)
												<tr class="white-text">
													<td>{{ $playerBlocks->player->team_name }}</td>
													<td>{{ $playerBlocks->player->player_name }}</td>
													<td>{{ $playerBlocks->BPG != null ? $playerBlocks->BPG : 'N/A' }}</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
								@else
									<h3 class="text-center h3-responsive col">There are no stats added for this league yet</h3>
								@endif
							</div>
						</div>
						<!--./ League season stats snap shot /.-->
					</div>
				@else
				@endif

				@if($completedSeasons->isNotEmpty())
					<div class="divider-long" id=""></div>

					<div class="row" id="completed_seasons">
						<div class="col-12">
							<h2 class="display-2">Completed Seasons</h2>
						</div>
					</div>
				@endif
			</div>
		</div>
	@endif
@endsection