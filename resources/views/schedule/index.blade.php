@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">

		<div class="row" id="">
			@if(Auth::check() && Auth::user()->type == 'admin')
				<div class="col col-lg-10 mx-auto my-3">
					{{--Authourization Only--}}
					@if(!isset($allComplete))
						@if($showSeason->league_teams->isNotEmpty())
							<a class="btn mx-auto mx-0 mw-100 btn-rounded mdb-color darken-3 white-text" type="button" href="{{ request()->query() == null ? route('league_schedule.create') : route('league_schedule.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}">Add New Week</a>
						@endif

						@if($seasonScheduleWeeks->get()->isNotEmpty())
							<a href="#" class="btn mx-auto mx-0 mw-100 btn-rounded mdb-color darken-3 white-text" type="button" data-target="#add_new_game_modal" data-toggle="modal">Add New Game</a>
						@endif
					@endif
				</div>
			@endif
		</div>

		<div class="row view">

			<div class="col-12 col-lg-10 pt-3 d-flex justify-content-center flex-column mx-auto">
				<div class="text-center p-4 card rgba-deep-orange-light white-text mb-3" id="">
					<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
				</div>

				@if(!isset($allComplete))

					@if($seasonScheduleWeeks->get()->isNotEmpty())
						@foreach($seasonScheduleWeeks->get() as $showWeekInfo)
							@php $seasonWeekGames = $showSeason->games()->getWeekGames($showWeekInfo->season_week)->get() @endphp

							<div class='leagues_schedule text-center table-wrapper mb-5'>
								<table id='week_{{ $showWeekInfo->season_week }}_schedule' class='weekly_schedule table text-nowrap'>
									<thead>
										<tr class="indigo darken-2 white-text">
											<th class="text-center" colspan="6">
												<h2 class="h2-responsive position-relative my-3">
                                                    <div class="" id="">
                                                        <span>Week {{ $loop->iteration }} Games</span>

                                                        @if(Auth::check() && Auth::user()->type == 'admin')
                                                            {{--Authourization Only--}}
                                                            <a href="{{ request()->query() == null ? route('league_schedule.edit', ['league_schedule' => $showWeekInfo->season_week]) : route('league_schedule.edit', ['league_schedule' => $showWeekInfo->season_week, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm btn-rounded position-absolute right white black-text">Edit Week</a>
                                                        @endif
                                                    </div>

                                                    @if($seasonWeekGames->isNotEmpty())
                                                        @foreach($seasonWeekGames as $getPOTW)
                                                            @foreach($getPOTW->player_stats as $POTW)
                                                                @if($POTW->potw == "Y")
                                                                    <h4 class="h4-responsive">Player Of The Week : {{ $POTW->player->player_name }} ({{ $POTW->player->league_team->team_name }})</h4>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endif
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

													<td class="gameTimeData text-nowrap">{{ $game->game_time !== null ? $game->game_time() : 'TBD' }}</td>
													<td class="gameDateData text-nowrap">{{ $game->game_date !== null ? $game->game_date() : 'TBD' }}</td>
													<td>

														@if(Auth::check() && (Auth::user()->type == 'statistician' || Auth::user()->type == 'admin'))
															{{--Authourization Only--}}
															<button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button>
														@else
															<a class="btn btn-primary btn-rounded btn-sm my-0 w-100 editGameBtn" href="{{ route('league_stats.show', ['game' => $game->id, 'season' => $showSeason->id]) }}">View Stats</a>
														@endif

													</td>
													<td class="gameIDData" hidden>{{ $game->id }}</td>
												</tr>
											@endforeach
										@endif
									</tbody>
								</table>
							</div>
						@endforeach
					@else
						@if(Auth::check())
							<div class="text-center">
								<h1 class="h1-responsive coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;There is no schedule for the selected season. Once you have your teams added you will be able to create a new schedule&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h1>
							</div>
						@else
							<div class="text-center">
								<h1 class="h1-responsive coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;There is no schedule for the selected season yet.<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h1>
							</div>
						@endif
					@endif
				@else
					<div class="coolText4 py-3 px-5">
						<h1 class="h1-responsive text-justify">It doesn't look like you have any active seasons going for your league right now. Let'e get started by creating a new season. Click <a href="/home?new_season" class="">here</a> to create a new season</h1>
					</div>
				@endif

				@if($seasonASG != null)
					<div class='leagues_schedule text-center table-wrapper mb-5'>
						<table id='asg_week_schedule' class='weekly_schedule table text-nowrap'>
							<thead>
							<tr class="indigo darken-2 white-text">
								<th class="text-center" colspan="6">
									<h2 class="h2-responsive position-relative my-3">
										<div class="" id="">
											<span>All-Star Game</span>
										</div>
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
							<tr>
								@if($seasonASG->result != null)
									<td class="awayTeamData text-nowrap"><span class="awayTeamNameData">{{ $seasonASG->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $seasonASG->away_team_obj->id }}</span>
										@if($seasonASG->result->winning_team_id == $seasonASG->away_team_id)
											@if($seasonASG->result->forfeit == 'Y')
												<span class="badge badge-pill green darken-2 ml-3 forfeitData awayTeamScoreData">Winner</span>
											@else
												<span class="badge badge-pill green darken-2 ml-3 awayTeamScoreData">{{ $seasonASG->result->away_team_score }}</span>
											@endif
										@else
											@if($seasonASG->result->forfeit == 'Y')
												<span class="badge badge-pill red darken-2 ml-3 awayTeamScoreData forfeitData">Forfeit</span>
											@else
												<span class="badge badge-pill red darken-2 ml-3 awayTeamScoreData">{{ $seasonASG->result->away_team_score }}</span>
											@endif
										@endif
									</td>
									<td>vs</td>
									<td class="homeTeamData text-nowrap"><span class="homeTeamNameData">{{ $seasonASG->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $seasonASG->home_team_obj->id }}</span>
										@if($seasonASG->result->winning_team_id == $seasonASG->home_team_id)
											@if($seasonASG->result->forfeit == 'Y')
												<span class="badge badge-pill green darken-2 ml-3 forfeitData homeTeamScoreData">Winner</span>
											@else
												<span class="badge badge-pill green darken-2 ml-3 homeTeamScoreData">{{ $seasonASG->result->home_team_score }}</span>
											@endif
										@else
											@if($seasonASG->result->forfeit == 'Y')
												<span class="badge badge-pill red darken-2 ml-3 homeTeamScoreData forfeitData">Forfeit</span>
											@else
												<span class="badge badge-pill red darken-2 ml-3 homeTeamScoreData">{{ $seasonASG->result->home_team_score }}</span>
											@endif
										@endif
									</td>
								@else
									<td class="awayTeamData text-nowrap"><span class="awayTeamNameData">{{ $seasonASG->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $seasonASG->away_team_obj->id }}</span></td>
									<td>vs</td>
									<td class="homeTeamData text-nowrap"><span class="homeTeamNameData">{{ $seasonASG->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $seasonASG->home_team_obj->id }}</span></td>
								@endif

								<td class="gameTimeData text-nowrap">{{ $seasonASG->game_time !== null ? $seasonASG->game_time() : 'TBD' }}</td>
								<td class="gameDateData text-nowrap">{{ $seasonASG->game_date !== null ? $seasonASG->game_date() : 'TBD' }}</td>
								<td>

									@if(Auth::check() && (Auth::user()->type == 'statistician' || Auth::user()->type == 'admin'))
										{{--Authourization Only--}}
										<button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button>
									@else
										<a class="btn btn-primary btn-rounded btn-sm my-0 w-100 editGameBtn" href="{{ route('league_stats.show', ['game' => $seasonASG->id, 'season' => $showSeason->id]) }}">View Stats</a>
									@endif

								</td>
								<td class="gameIDData" hidden>{{ $seasonASG->id }}</td>
							</tr>
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>


		@include('modals.edit_game')
		@include('modals.add_new_game')
	</div>

	<!-- Footer -->
	@include('content_parts.footer')
	<!-- Footer -->
@endsection