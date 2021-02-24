@extends('layouts.app')

@section('scripts')
	<script type="text/javascript">
        if(window.location.href.indexOf("new_season") > 0) {
            setTimeout(function() {
                $('#newSeasonForm').modal('show');
            }, 500);
        }
	</script>
@endsection

@section('content')

	@if(Auth::check() && Auth::user()->type == 'admin')
		@include('include.functions')

		<div class="container-fluid bgrd3">

			@if($showSeason->is_playoffs == 'Y')
				<div class="row z-depth-3">
					<div class="col-12 playoffTimeHeader" id=""></div>
				</div>
			@endif

			{{--<div class="row align-items-stretch{{ $showSeason->league_profile ? '': ' view' }}">--}}
				{{--<!--Column will include buttons for creating a new season-->--}}
				{{--<div class="col-2 py-3" id="">--}}
					{{--<div class="row">--}}
						{{--<div class="col">--}}
							{{--<button class="btn btn-lg btn-rounded blue white-text" type="button" data-toggle="modal" data-target="#newSeasonForm">New Season</button>--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}
			{{--</div>--}}

			<div class="row" id="">
				<div class="col-12 col-lg-10 py-3 mx-auto">

					@if($showSeason->completed == 'N')
						<!-- Show league season info -->
						@if($showSeason->paid == 'Y')
							<div class="text-center coolText1">
								<div class="text-center p-4 card rgba-deep-orange-light white-text mb-3" id="">
									<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
								</div>
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
															<input type="text" name="leagues_address" class="form-control" id="leagues_address" placeholder="Address" value="{{ $showSeason->location }}" />

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

												{{--<div class="form-row">--}}
													{{--<div class="form-group col-12">--}}
														{{--<label for="standings_type" class="d-block form-control-label">Standings Type</label>--}}

														{{--<div class="d-block d-sm-inline">--}}
															{{--<button type="button" class="btn w-auto automaticStandings automatic{{ $showSeason->standings_type == 'automatic' ? ' active btn-success' : ' btn-blue-grey' }}">--}}
																{{--<input type="checkbox" name="standings_type" value="automatic" {{ $showSeason->standings_type == 'automatic' ? 'checked' : '' }} hidden />Automatic--}}
															{{--</button>--}}
														{{--</div>--}}
														{{--<div class="d-block d-sm-inline">--}}
															{{--<button type="button" class="btn w-auto manualStandings manual{{ $showSeason->standings_type == 'manual' ? ' active btn-success' : ' btn-blue-grey' }}">--}}
																{{--<input type="checkbox" name="standings_type" value="manual" {{ $showSeason->standings_type == 'manual' ? 'checked' : '' }} hidden />Manual--}}
															{{--</button>--}}
														{{--</div>--}}
														{{--<span class="{{ $showSeason->standings_type == 'automatic' ? 'd-block d-sm-inline' : 'd-none' }}">--}}
															{{--<button type="button" class="btn w-auto btn-blue gsBtn">Generate Standings</button>--}}
														{{--</span>--}}
													{{--</div>--}}
												{{--</div>--}}

												{{--<div class="form-row">--}}
													{{--<div class="form-group col-12">--}}
														{{--<label for="schedule_type" class="d-block form-control-label">Scheduling Type</label>--}}

														{{--<div class="d-block d-sm-inline">--}}
															{{--<button type="button" class="btn w-auto automaticSchedule automatic{{ $showSeason->schedule_type == 'automatic' ? ' active btn-success' : ' btn-blue-grey' }}">--}}
																{{--<input type="checkbox" name="schedule_type" value="automatic" {{ $showSeason->schedule_type == 'automatic' ? 'checked' : '' }} hidden />Automatic--}}
															{{--</button>--}}
														{{--</div>--}}
														{{--<div class="d-block d-sm-inline">--}}
															{{--<button type="button" class="btn w-auto manualSchedule manual{{ $showSeason->schedule_type == 'manual' ? ' active btn-success' : ' btn-blue-grey' }}">--}}
																{{--<input type="checkbox" name="schedule_type" value="manual" {{ $showSeason->schedule_type == 'manual' ? 'checked' : '' }} hidden />Manual--}}
															{{--</button>--}}
														{{--</div>--}}
														{{--<span class="{{ $showSeason->standings_type == 'automatic' ? 'd-block d-sm-inline' : 'd-none' }}">--}}
															{{--<button type="button" class="btn w-auto btn-blue gsBtn">Generate Schedule</button>--}}
														{{--</span>--}}
													{{--</div>--}}
												{{--</div>--}}

												<div class="form-row justify-content-around align-items-center">
													<div class="form-group text-center">
														<label for="conferences" class="d-block form-control-label">Conferences</label>

														<div class="btn-group">
															<button type="button" class="btn activeYes{{ $showSeason->has_conferences == 'Y' ? ' active btn-success' : ' btn-blue-grey' }}" onclick="showOrRemoveConferences();" style="line-height:1.5">
																<input type="checkbox" name="conferences" value="Y" {{ $showSeason->has_conferences == 'Y' ? 'checked' : '' }} hidden />Yes
															</button>
															<button type="button" class="btn activeNo{{ $showSeason->has_conferences == 'N' ? ' active btn-success' : ' btn-blue-grey' }}" onclick="showOrRemoveConferences();" style="line-height:1.5">
																<input type="checkbox" name="conferences" value="N" {{ $showSeason->has_conferences == 'N' ? 'checked' : '' }} hidden />No
															</button>
														</div>
													</div>

													<div class="form-group text-center">
														<label for="divisions" class="d-block form-control-label">Divisions</label>

														<div class="btn-group">
															<button type="button" class="btn activeYes{{ $showSeason->has_divisions == 'Y' ? ' active btn-success' : ' btn-blue-grey' }}" onclick="showOrRemoveDivisions();" style="line-height:1.5">
																<input type="checkbox" name="divisions" value="Y" {{ $showSeason->has_divisions == 'Y' ? 'checked' : '' }} hidden />Yes
															</button>
															<button type="button" class="btn activeNo{{ $showSeason->has_divisions == 'N' ? ' active btn-success' : ' btn-blue-grey' }}" onclick="showOrRemoveDivisions();" style="line-height:1.5">
																<input type="checkbox" name="divisions" value="N" {{ $showSeason->has_divisions == 'N' ? 'checked' : '' }} hidden />No
															</button>
														</div>
													</div>
												</div>

												<div class="conferenceToggle {{ $showSeason->has_conferences == 'Y' ? '' : 'd-none bounceInLeft' }}" id="">
													{{-- Add Divider--}}
													<div class="divider-long" id=""></div>

													<div class="text-center" id="">
														<h2>Conference Names</h2>
													</div>

													<div class="row align-items-center d-flex justify-content-center">
														@foreach($showSeasonConferences as $conference)
															<div class="col-10 col-sm-5" id="">
																<div class="md-form">
																	<input type="text" name="conference_name[]" class="form-control" id="conference_name" placeholder="Name" value="{{ $conference->conference_name }}" />

																	<label for="conference_name">Conference {{ $loop->iteration }} Name</label>
																</div>
															</div>
														@endforeach
													</div>
												</div>


												{{--@if($showSeason->has_conferences == 'Y')--}}
													{{--<div class="text-center" id="">--}}
														{{--<h2>Conference Names</h2>--}}
													{{--</div>--}}

													{{--<div class="row">--}}
														{{--@foreach($showSeasonConferences as $conference)--}}
															{{--<div class="col-12 col-md" id="">--}}
																{{--<div class="md-form">--}}
																	{{--<input type="text" name="conference_name[]" class="form-control" id="conference_name" placeholder="Name" value="{{ $conference->conference_name }}" />--}}

																	{{--<label for="conference_name">Conference {{ $loop->iteration }} Name</label>--}}
																{{--</div>--}}
															{{--</div>--}}
														{{--@endforeach--}}
													{{--</div>--}}

													{{-- Add Divider--}}
													{{--<div class="divider-long" id=""></div>--}}
												{{--@endif--}}

												<div class="divisionToggle {{ $showSeason->has_divisions == 'Y' ? '' : 'd-none bounceInLeft' }}" id="">
													{{-- Add Divider--}}
													<div class="divider-long" id=""></div>

													<div class="text-center" id="">
														<h2>Division Names</h2>
													</div>

													<div class="row row-cols-2 align-items-center justify-content-center">
														@foreach($showSeasonDivisions as $division)
															<div class="col-10 col-sm-5" id="">
																<div class="md-form">
																	<input type="text" name="division_name[]" class="form-control" id="division_name" placeholder="Name" value="{{ $division->division_name }}" />

																	<label for="division_name">Division {{ $loop->iteration }} Name</label>
																</div>
															</div>
														@endforeach
													</div>
												</div>

												<div class="updateLeagueInputs rgba-white-strong px-5 py-3 rounded" id="">
													<div class="d-flex flex-column flex-md-row align-items-center justify-content-center" id="">
														<h2 class="h2-responsive text-underline mx-auto">League Rules</h2>

														<button class="btn btn-floating green addRuleBtn" type="button">
															<i class="fa fa-plus-circle" aria-hidden="true"></i>
														</button>
													</div>
													<div class="" id="">
														<div class="table-wrapper">
															<table class="table table-hover table-striped" id="league_rules_table">
																<thead>
																<tr>
																	<th class="text-nowrap">League Rule Description</th>
																	<th></th>
																	<th></th>
																</tr>
																</thead>
																<tbody>

																@if($leagueRules->isNotEmpty())
																	@foreach($leagueRules as $leagueRule)
																		<tr class="">
																			<td class="" colspan="2">
																				<input type="text" name="rule[]" class="form-control" value="{{ $leagueRule->rule }}" placeholder="Enter Rule Description" />
																			</td>

																			<td class="">
																				<button data-target="#delete_rule" data-toggle="modal" type="button" class="btn btn-sm red darken-1 white-text rounded w-100 deleteRuleBtn">Remove</button>
																				<input type="text" class="hidden" value="{{ $leagueRule->id }}" hidden />
																			</td>
																		</tr>
																	@endforeach
																@else
																	<tr class="">
																		<th colspan="3" class="text-center">You currently do not have any rules added for this season.</th>
																	</tr>
																@endif

																<tr class="hidden" hidden>
																	<td class="hidden">
																		<input type="number" name="season_id" class="form-control" value="{{ $showSeason->id }}" />
																	</td>
																</tr>

																<tr class="newRuleRow hidden" hidden>
																	<td class="" colspan="2">
																		<input type="text" name="new_rule[]" class="form-control" value="" placeholder="Enter Rule Description" disabled />
																	</td>
																	<td class="">
																		<button class="btn btn-sm orange lighten-1 w-100 my-0 removeNewRuleRow hidden" type="button">Hide</button>
																	</td>
																</tr>
																</tbody>
															</table>
														</div>

													</div>
												</div>

												@if($showSeason->league_players()->allStars()->count() > 0)
													<div class="card mx-5 my-4 rgba-light-blue-strong text-white" id="">
														<div class="card-body" id="">
															<div class="" id="">
																<h2 class="h2-responsive text-underline text-center">All Star Game</h2>
															</div>

															@if($allStarGame == null)
																<div class="" id="">
																	<h3 class="h3 text-center">Current All Star Selection Count: {{ $showSeason->league_players()->allStars()->count() }}</h3>
																</div>

																<div class="text-center" id="">
																	<button class="btn peach-gradient" type='button' id="" data-toggle="modal" data-target="#create_all_star_team">Create All Star Game</button>
																</div>
															@else
																<div class="" id="">
																	<table id='' class='table-light table'>
																		<thead>
																			<tr class="indigo darken-3 white-text">
																				<th class="text-center" colspan="3">Match-Up</th>
																				<th>Time</th>
																				<th>Date</th>
																				<th></th>
																			</tr>
																		</thead>

																		<tbody>
																			<tr>
																				@if($allStarGame->result)
																					<td class="awayTeamData text-nowrap"><span class="awayTeamNameData">{{ $allStarGame->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $allStarGame->away_team_obj->id }}</span>
																						@if($allStarGame->result->winning_team_id == $allStarGame->away_team_id)
																							@if($allStarGame->result->forfeit == 'Y')
																								<span class="badge badge-pill green darken-2 ml-3 forfeitData awayTeamScoreData">Winner</span>
																							@else
																								<span class="badge badge-pill green darken-2 ml-3 awayTeamScoreData">{{ $allStarGame->result->away_team_score }}</span>
																							@endif
																						@else
																							@if($allStarGame->result->forfeit == 'Y')
																								<span class="badge badge-pill red darken-2 ml-3 awayTeamScoreData forfeitData">Forfeit</span>
																							@else
																								<span class="badge badge-pill red darken-2 ml-3 awayTeamScoreData">{{ $allStarGame->result->away_team_score }}</span>
																							@endif
																						@endif
																					</td>
																					<td>vs</td>
																					<td class="homeTeamData text-nowrap"><span class="homeTeamNameData">{{ $allStarGame->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $allStarGame->home_team_obj->id }}</span>
																						@if($allStarGame->result->winning_team_id == $allStarGame->home_team_id)
																							@if($allStarGame->result->forfeit == 'Y')
																								<span class="badge badge-pill green darken-2 ml-3 forfeitData homeTeamScoreData">Winner</span>
																							@else
																								<span class="badge badge-pill green darken-2 ml-3 homeTeamScoreData">{{ $allStarGame->result->home_team_score }}</span>
																							@endif
																						@else
																							@if($allStarGame->result->forfeit == 'Y')
																								<span class="badge badge-pill red darken-2 ml-3 homeTeamScoreData forfeitData">Forfeit</span>
																							@else
																								<span class="badge badge-pill red darken-2 ml-3 homeTeamScoreData">{{ $allStarGame->result->home_team_score }}</span>
																							@endif
																						@endif
																					</td>
																				@else
																					<td class="awayTeamData text-nowrap"><span class="awayTeamNameData">{{ $allStarGame->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $allStarGame->away_team_obj->id }}</span></td>
																					<td>vs</td>
																					<td class="homeTeamData text-nowrap"><span class="homeTeamNameData">{{ $allStarGame->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $allStarGame->home_team_obj->id }}</span></td>
																				@endif

																				<td class="gameTimeData text-nowrap">{{ $allStarGame->game_time != null ? $allStarGame->game_time() : 'TBD' }}</td>
																				<td class="gameDateData text-nowrap">{{ $allStarGame->game_date != null ? $allStarGame->game_date() : 'TBD' }}</td>
																				<td>

																					@if(Auth::check() && (Auth::user()->type == 'statistician' || Auth::user()->type == 'admin'))
																						{{--Authourization Only--}}
																						<button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button>
																					@else
																						<a class="btn btn-primary btn-rounded btn-sm my-0 w-100 editGameBtn" href="{{ route('league_stats.show', ['game' => $allStarGame->id]) }}">View Stats</a>
																					@endif

																				</td>
																				<td class="gameIDData" hidden>{{ $allStarGame->id }}</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															@endif
														</div>
													</div>
												@endif

												<div class="d-flex justify-content-around align-items-center flex-column flex-md-row">
													<button type="submit" class="btn btn-lg white-text green" id="">Update League</button>

													@if($showSeason->is_playoffs == 'N' && $allGames->isNotEmpty())
														<button type="button" class="btn btn-lg white-text cyan darken-2" id="" data-toggle="modal" data-target="#start_playoffs">Start Playoffs</button>
													@endif
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
											<div class="col-12 col-md-6 col-lg-4 col-lg-3 my-2">
												<div class="card">
													<h3 class="h3-responsive text-center p-4 blue-grey white-text">{{ $upcomingGame->season_week == null ? $upcomingGame->all_star_game == 'Y' ? 'All-Star Game' : 'Round ' . $upcomingGame->round : 'Week ' . $upcomingGame->season_week }}</h3>
													<div class="card-body text-center">
														<p class=""><a href="{{ route('league_teams.show', ['league_team' => $upcomingGame->home_team_id, 'season' => $showSeason->id]) }}">{{ $upcomingGame->home_team }}</a></p>
														<p class="">vs</p>
														<p class=""><a href="{{ route('league_teams.show', ['league_team' => $upcomingGame->away_team_id, 'season' => $showSeason->id]) }}">{{ $upcomingGame->away_team }}</a></p>
													</div>
													<div class="card-footer px-1 d-flex align-items-center justify-content-around">
														<span class="mx-2"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;{{ $upcomingGame->game_time != null ? $upcomingGame->game_time() : 'TBD' }}</span>
														<span class="mx-2"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;{{ $upcomingGame->game_date != null ? $upcomingGame->game_date() : 'TBD' }}</span>
													</div>
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
								<div class="blue-gradient col-12 col-lg-5 m-1 table-wrapper mx-auto">
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
								<div class="blue-gradient col-12 col-lg-5 m-1 table-wrapper mx-auto">
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
								<div class="blue-gradient col-12 col-lg-5 m-1 table-wrapper mx-auto">
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
								<div class="blue-gradient col-12 col-lg-5 m-1 table-wrapper mx-auto">
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
								<div class="blue-gradient col-12 col-lg-5 m-1 table-wrapper mx-auto">
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
			{{--@include('modals.new_season_modal')--}}
			@include('modals.complete_season_modal')
			@include('modals.delete_rule')

			@if($showSeason->league_players()->allStars()->count() > 0)
				@include('modals.create_all_star_game')
			@endif

			@if($allStarGame != null)
				@include('modals.edit_game')
			@endif

		</div>
	@else
		<div class="container-fluid bgrd3">

			@if($showSeason->paid == 'Y')

				@if($showSeason->is_playoffs == 'Y')
					<div class="row z-depth-3">
						<div class="col-12 playoffTimeHeader" id=""></div>
					</div>
				@endif

				<div class="row view">

					<div class="row">
						<!-- League season schedule snap shot -->
						<div class="col-10 col-lg-8 col-xl-8 mx-auto my-5">
							<div class="text-center p-4 card rgba-deep-orange-light white-text" id="">
								<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
							</div>

							<div class="my-5 d-flex align-items-center justify-content-center flex-column">
								<div class="d-flex w-100 justify-content-center align-items-center flex-column flex-lg-row">
									<h1 class="h1 h1-responsive text-center">Upcoming Schedule</h1>
									<a href="{{ request()->query() == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">Full Schedule</a>
								</div>

								<div class="container-fluid" id="season_schedule_snap">
									<div class="row">
										@if($showSeasonSchedule->isNotEmpty())
											@foreach($showSeasonSchedule as $upcomingGame)
												<div class="col-12 col-md-6 col-lg-4 col-lg-3 my-2">
													<div class="card">
														<h3 class="h3-responsive text-center p-4 blue-grey white-text">{{ $upcomingGame->season_week == null ? $upcomingGame->round == null ? 'Play-In Game' : 'Round ' . $upcomingGame->round : 'Week ' . $upcomingGame->season_week }}</h3>
														<div class="card-body text-center">
															<p class=""><a href="{{ route('league_teams.show', ['league_team' => $upcomingGame->home_team_id, 'season' => $showSeason->id]) }}">{{ $upcomingGame->home_team }}</a></p>
															<p class="">vs</p>
															<p class=""><a href="{{ route('league_teams.show', ['league_team' => $upcomingGame->away_team_id, 'season' => $showSeason->id]) }}">{{ $upcomingGame->away_team }}</a></p>
														</div>
														<div class="card-footer px-1 d-flex align-items-center justify-content-around">
															<span class="mx-2"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;{{ $upcomingGame->game_time != null ? $upcomingGame->game_time() : 'TBD' }}</span>
															<span class="mx-2"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;{{ $upcomingGame->game_date != null ? $upcomingGame->game_date() : 'TBD' }}</span>
														</div>
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
								<h1 class="h1-responsive">Stats Leaders</h1>
								<a href="{{ request()->query() == null ? route('league_stats.index') : route('league_stats.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">All Stats</a>
							</div>
							<div id="season_stats_snap" class="my-5 row">
								<!-- Season stat leaders by category -->
							@if($showSeasonStat->isNotEmpty())
								<!-- Get the scoring leaders -->
									<div class="blue-gradient col-12 col-lg-5 m-1 table-wrapper mx-auto">
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
									<div class="blue-gradient col-12 col-lg-5 m-1 table-wrapper mx-auto">
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
									<div class="blue-gradient col-12 col-lg-5 m-1 table-wrapper mx-auto">
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
									<div class="blue-gradient col-12 col-lg-5 m-1 table-wrapper mx-auto">
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
									<div class="blue-gradient col-12 col-lg-5 m-1 table-wrapper mx-auto">
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

						@if($leagueRules->isNotEmpty())
							<!-- Divider /.-->
							<div class="divider-short" id=""></div>
							<!--./ Divider /.-->
						@endif

						@if($leagueRules->isNotEmpty())
							<div class="col-8 mx-auto my-5" id="">
								<!-- League Rules snap shot -->
								<table id="" class="table table-warning table-bordered table-striped leagueRulesTable" cellspacing="0" style="display: none">
									<thead>
									<tr>
										<th class="th text-center">Rule Description<i class="" aria-hidden="true"></i></th>
									</tr>
									</thead>

									<tbody>
										@foreach($leagueRules as $leagueRule)
											<tr>
												<td>{{ $leagueRule->rule }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>

								<div class="text-center" id="">
									<button class='btn btn-lg btn-deep-purple seeLeagueRules' type='button' onclick="showLeagueRules();">See League Rules</button>
									<button class='btn btn-lg btn-outline-blue-grey closeLeagueRules' type='button' onclick="hideLeagueRules();" style="display: none">Close League Rules</button>
								</div>
								<!--./ League Rules snap shot /.-->
							</div>
						@endif
					</div>
				</div>
			@else
			@endif
		</div>
	@endif

    <!-- Footer -->
    @include('content_parts.footer')
    <!-- Footer -->
@endsection