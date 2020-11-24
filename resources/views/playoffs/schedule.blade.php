@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd1">
		<div class="row">
			<div class="col-12 col-lg-10 mx-auto py-4">
				<div class="text-center coolText1">
					<h1 class="display-3 mb-4">{{ ucfirst($showSeason->name) }}</h1>
					<h1 class="display-4 coolText4 mb-3">It's Playoff Time</h1>
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
												<a href="{{ request()->query() == null ? route('edit_round', ['round' => $round->round]) : route('edit_round', ['round' => $round->round, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm btn-rounded position-absolute right white black-text">Edit Week</a>
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
											<td><button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button></td>
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
											<a href="{{ request()->query() == null ? route('edit_playins') : route('edit_playins', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm btn-rounded position-absolute right white black-text">Edit Week</a>
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
										<td><button class="btn btn-primary btn-rounded btn-sm my-0 editGameBtn" type="button" data-target="#edit_game_modal" data-toggle="modal">Edit Game</button></td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
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
		
		<!-- Edit game modal -->
		<div class="modal fade" id="edit_game_modal" tabindex="-1" role="dialog" aria-labelledby="editGameModal" aria-hidden="true" data-backdrop="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="h2-responsive">Edit Game</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						{!! Form::open(['action' => ['LeagueScheduleController@update_game'], 'method' => 'PATCH']) !!}
							<!--Card-->
							<div class="card mb-4">
								<!--Card content-->
								<div class="card-body">
									<!--Title-->
									<div class="d-flex align-items-center justify-content-between">
										<div class="d-flex align-items-center justify-content-center">
											<h4 class="card-title h4-responsive my-2">Changing this games teams will remove any stats that have been added</h4>
										</div>
										
										<!-- Forfeit Toggle -->
										<div class="d-flex flex-column align-items-center">
											<p class="m-0">Forfeit</p>
											<div class="">
												<button class="btn btn-sm stylish-color-dark awayForfeitBtn d-block" type="button"><span class="awayForfeitBtnTeamName"></span>
													<input type="checkbox" name="away_forfeit" class="hidden" value="" hidden />
												</button>
												<button class="btn btn-sm stylish-color-dark homeForfeitBtn d-block" type="button"><span class="homeForfeitBtnTeamName"></span>
													<input type="checkbox" name="home_forfeit" class="hidden" value="" hidden />
												</button>
											</div>
										</div>
									</div>
									
									<!-- Edit Form -->
									<div class="my-2">
										<div class="row">
											<div class="col">
												<div class="md-form">
													<select class="mdb-select" name="edit_away_team">
														<option value="" disabled>Choose your option</option>
														@foreach($showSeason->league_teams as $away_team)
															<option value="{{ $away_team->id }}">{{ $away_team->team_name }}</option>
														@endforeach
													</select>
													<label for="edit_away_team">Away Team</label>
												</div>
											</div>
											<div class="col">
												<div class="md-form">
													<select class="mdb-select" name="edit_home_team">
														<option value="" disabled>Choose your option</option>
														@foreach($showSeason->league_teams as $home_team)
															<option value="{{ $home_team->id }}">{{ $home_team->team_name }}</option>
														@endforeach
													</select>
													<label for="edit_home_team">Home Team</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div class="md-form input-group">
													<div class="input-group-prepend">
														<span class="input-group-text">Away Score</span>
													</div>
													
													<input type="number" name="edit_away_score" id="" class="form-control" value="" placeholder="Enter Away Score" min="0" max="200" />
												</div>
											</div>
											<div class="col">
												<div class="md-form input-group">
													<div class="input-group-prepend">
														<span class="input-group-text">Home Score</span>
													</div>
													
													<input type="number" name="edit_home_score" id="" class="form-control" value="" placeholder="Enter Home Score" min="0" max="200" />
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div class="md-form input-group">
													<div class="input-group-prepend">
														<span class="input-group-text">Game Date</span>
													</div>
													
													<input type="text" name="edit_date_picker" id="input_gamedate" class="form-control datetimepicker" value="" placeholder="Selected Date" />
												</div>
											</div>
											<div class="col">
												<div class="md-form input-group">
													<div class="input-group-prepend">
														<span class="input-group-text">Game Time</span>
													</div>
													
													<input type="text" name="edit_game_time" id="input_starttime" class="form-control timepicker" value="" placeholder="Selected time" />
												</div>
											</div>
											
											<input type="number" name="edit_game_id" class="hidden" value="" hidden />
										</div>
										<div class="md-form">
											<button class="btn blue white-text darken-2" type="submit">Update Game</button>
										</div>
									</div>
								</div>
							</div>
							<!--/.Card-->
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection