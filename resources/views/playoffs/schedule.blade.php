@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd1">

		@if($showSeason->is_playoffs == 'Y')
			<div class="row z-depth-3">
				<div class="col-12 playoffTimeHeader" id=""></div>
			</div>
		@endif

		<div class="row">
			<div class="col-12 col-lg-10 mx-auto py-4">
				<div class="text-center coolText1">
					<h1 class="display-3 mb-4">{{ ucfirst($showSeason->name) }}</h1>

					<div class="col-12 mt-3 text-center">
						@if($showSeason->champion_id != null)
							@php $championTeam = App\LeagueTeam::find($showSeason->champion_id); @endphp
							<div class="container-fluid">
								<div class="row">
									<div class="col">
										<h1 class="">Champion</h1>
										<h2 class="">{{ $championTeam->team_name }}</h2>
									</div>
								</div>
							</div>
						@endif
					</div>
				</div>

				@if($playInGames->get()->isNotEmpty() && $playoffSettings->playin_games_complete == 'N')
					<div class="col-12 pb-0 mb-0">
						<p class="text-center pb-0 mb-0" style="background: radial-gradient(rgba(255, 255, 255, 1), rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0));"><i class="fas fa-star"></i>&nbsp;Once playin games complete, tournament bracket will be posted&nbsp;<i class="fas fa-star"></i></p>
					</div>
				@endif

				<div class="col-12 text-center">
					<p class="" style="background: radial-gradient(rgba(255, 255, 255, 1), rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0));"><i class="fas fa-star"></i>&nbsp;Single game elimination for every round&nbsp;<i class="fas fa-star"></i></p>
				</div>

				@if($nonPlayInGames->get()->isNotEmpty())
					<!-- Playoff Round Games -->
					@foreach($playoffRounds as $round)
						<div class='leagues_schedule text-center mb-5 table-wrapper'>
							<table id='week_schedule' class='weekly_schedule table'>
								<thead>
									<tr class="indigo darken-2 white-text">
										<th class="text-center" colspan="6">
											<h2 class="h2-responsive position-relative my-3">
												<span>{{ $round->round == $playoffSettings->total_rounds ? 'Championship Game' : 'Round ' . $round->round . ' Games' }}</span>

												@if(Auth::check() && Auth::user()->type == 'admin')
													{{--Authourization Only--}}
													<a href="{{ request()->query() == null ? route('edit_round', ['round' => $round->round]) : route('edit_round', ['round' => $round->round, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm btn-rounded position-absolute right white black-text">Edit Week</a>
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
									@foreach($showSeason->games()->roundGames($round->round)->get() as $game)
										<tr>
											@if($game->result)
												<td class="awayTeamData"><span class="awayTeamNameData">{{ $game->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $game->away_team_obj->id }}</span>
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
												<td class="homeTeamData"><span class="homeTeamNameData">{{ $game->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $game->home_team_obj->id }}</span>
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
												<td class="awayTeamData"><span class="awayTeamNameData">{{ $game->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $game->away_team_obj->id }}</span></td>
												<td>vs</td>
												<td class="homeTeamData"><span class="homeTeamNameData">{{ $game->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $game->home_team_obj->id }}</span></td>
											@endif
											
											<td class="gameTimeData">{{ $game->game_time == null ? 'TBD' : $game->game_time() }}</td>
											<td class="gameDateData">{{ $game->game_date == null ? 'TBD' : $game->game_date() }}</td>
											<td class="gameIDData" hidden>{{ $game->id }}</td>

											@if(Auth::check() && (Auth::user()->type == 'statistician' || Auth::user()->type == 'admin'))
												{{--Authourization Only--}}
												<td><button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button></td>
											@else
												<td><a class="btn btn-primary btn-rounded btn-sm my-0 w-100 editGameBtn" href="{{ route('league_stats.show', ['game' => $game->id, 'round' => $game->round, 'season' => $showSeason]) }}">View Stats</a></td>
											@endif
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endforeach
				@endif
			
				@if($playInGames->get()->isNotEmpty())
					<!-- Playin Games -->
					<div class='leagues_schedule text-center mb-5 table-wrapper'>
						<table id='week_schedule' class='weekly_schedule table'>
							<thead>
								<tr class="indigo darken-2 white-text">
									<th class="text-center" colspan="6">
										<h2 class="h2-responsive position-relative my-3">
											<span>Playoff Playin Games</span>

											@if(Auth::check() && Auth::user()->type == 'admin')
												{{--Authourization Only--}}
												<a href="{{ request()->query() == null ? route('edit_playins') : route('edit_playins', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm btn-rounded position-absolute right white black-text">Edit Week</a>
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
								@foreach($playInGames->get() as $game)
									<tr>
										@if($game->result)
											<td class="awayTeamData"><span class="awayTeamNameData">{{ $game->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $game->away_team_obj->id }}</span>
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
											<td class="homeTeamData"><span class="homeTeamNameData">{{ $game->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $game->home_team_obj->id }}</span>
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
											<td class="awayTeamData"><span class="awayTeamNameData">{{ $game->away_team }}</span><span class="awayTeamIDData hidden" hidden>{{ $game->away_team_obj->id }}</span></td>
											<td>vs</td>
											<td class="homeTeamData"><span class="homeTeamNameData">{{ $game->home_team }}</span><span class="homeTeamIDData hidden" hidden>{{ $game->home_team_obj->id }}</span></td>
										@endif
										
										<td class="gameTimeData">{{ $game->game_time == null ? 'TBD' : $game->game_time() }}</td>
										<td class="gameDateData">{{ $game->game_date == null ? 'TBD' : $game->game_date() }}</td>
										<td class="gameIDData" hidden>{{ $game->id }}</td>

										@if(Auth::check() && (Auth::user()->type == 'statistician' || Auth::user()->type == 'admin'))
											{{--Authourization Only--}}
											<td><button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button></td>
										@else
											<td><a class="btn btn-primary btn-rounded btn-sm my-0 w-100 editGameBtn" href="{{ route('league_stats.show', ['game' => $game->id, 'season' => $showSeason]) }}">View Stats</a></td>
										@endif
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif

				@if($seasonScheduleWeeks->get()->isNotEmpty())
					@foreach($seasonScheduleWeeks->get() as $showWeekInfo)
						@php $seasonWeekGames = $showSeason->games()->getWeekGames($showWeekInfo->season_week)->get() @endphp

						<div class='leagues_schedule text-center table-wrapper mb-5'>
							<table id='week_{{ $showWeekInfo->season_week }}_schedule' class='weekly_schedule table'>
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

											<td class="gameTimeData text-nowrap">{{ $game->game_time == null ? 'TBD' : $game->game_time() }}</td>
											<td class="gameDateData text-nowrap">{{ $game->game_date == null ? 'TBD' : $game->game_date() }}</td>
											<td>

												@if(Auth::check() && (Auth::user()->type == 'statistician' || Auth::user()->type == 'admin'))
													{{--Authourization Only--}}
													<button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button>
												@else
													<a class="btn btn-primary btn-rounded btn-sm my-0 w-100 editGameBtn" href="{{ route('league_stats.show', ['game' => $game->id, 'season' => $showSeason]) }}">View Stats</a>
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
				@endif

				@if($seasonASG != null)
					<div class='leagues_schedule text-center table-wrapper mb-5'>
						<table id='asg_week_schedule' class='weekly_schedule table'>
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

								<td class="gameTimeData text-nowrap">{{ $seasonASG->game_time !== null ? $seasonASG->game_time() : 'TBD'}}</td>
								<td class="gameDateData text-nowrap">{{ $seasonASG->game_date !== null ? $seasonASG->game_date() : 'TBD'}}</td>
								<td>

									@if(Auth::check() && (Auth::user()->type == 'statistician' || Auth::user()->type == 'admin'))
										{{--Authourization Only--}}
										<button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button>
									@else
										<a class="btn btn-primary btn-rounded btn-sm my-0 w-100 editGameBtn" href="{{ route('league_stats.show', ['game' => $seasonASG->id, 'season' => $showSeason]) }}">View Stats</a>
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
		@include('modals.edit_playoff_game')

	</div>

	<!-- Footer -->
	@include('layouts.footer')
	<!-- Footer -->
@endsection