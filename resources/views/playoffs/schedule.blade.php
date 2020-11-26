@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd1">
		<div class="row">
			<div class="col-12 col-lg-10 mx-auto py-4">
				<div class="text-center coolText1">
					<h1 class="display-3 mb-4">{{ ucfirst($showSeason->name) }}</h1>
					<h1 class="display-4 coolText4 mb-3">It's Playoff Time</h1>

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
											
											<td class="gameTimeData">{{ $game->game_time == null ? 'N/A' : $game->game_time() }}</td>
											<td class="gameDateData">{{ $game->game_date == null ? 'N/A' : $game->game_date() }}</td>
											<td class="gameIDData" hidden>{{ $game->id }}</td>

											@if(Auth::check() && (Auth::user()->type == 'statistician' || Auth::user()->type == 'admin'))
												{{--Authourization Only--}}
												<td><button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button></td>
											@else
												<td><a class="btn btn-primary btn-rounded btn-sm my-0 w-100 editGameBtn" href="{{ route('league_stats.show', ['game' => $game->id]) }}">View Stats</a></td>
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
										
										<td class="gameTimeData">{{ $game->game_time == null ? 'N/A' : $game->game_time() }}</td>
										<td class="gameDateData">{{ $game->game_date == null ? 'N/A' : $game->game_date() }}</td>
										<td class="gameIDData" hidden>{{ $game->id }}</td>

										@if(Auth::check() && (Auth::user()->type == 'statistician' || Auth::user()->type == 'admin'))
											{{--Authourization Only--}}
											<td><button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button></td>
										@else
											<td><a class="btn btn-primary btn-rounded btn-sm my-0 w-100 editGameBtn" href="{{ route('league_stats.show', ['game' => $game->id]) }}">View Stats</a></td>
										@endif
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>

		@include('modals.edit_playoff_game')
	</div>
@endsection