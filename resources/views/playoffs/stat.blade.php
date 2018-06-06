@extends('layouts.app')

@section('content')
	@include('include.functions')
	
	<div class="container-fluid" id="leaguesProfileContainer">
		<div class="row">
			<div class="col-12 mt-3">
				@foreach($playoffRounds as $edit_round)
					<a href="{{ request()->query() == null ? route('league_stat.edit_round', ['round' => $edit_round->round]) : route('league_stat.edit_round', ['round' => $edit_round->round, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-rounded mdb-color darken-3 white-text{{ $edit_round->round == $round ? ' disabled' : '' }}"{{ $edit_round->round == $round ? ' disabled' : '' }}>{{ $edit_round->round != $playoffRounds->count() ? 'Round ' . $edit_round->round  . ' Stats' : 'Championship Game Stats'}}</a>
				@endforeach
			</div>
			<div class="col-12">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				<div class="text-center">
					<h3 class="h3-responsive">{{ $round != $playoffRounds->count() ? 'Round ' . $round  . ' Stats' : 'Championship Game Stats'}}</h3>
				</div>
				
				@if($roundGames->count() > 0)
					{!! Form::open(['action' => ['LeagueStatController@update', 'round' => $round], 'method' => 'PATCH']) !!}
						@foreach($roundGames as $game)
							<!--Card-->
							<div class="card mb-4">
								<!--Card content-->
								<div class="card-body">
									<!--Title-->
									<div class="d-flex align-items-center justify-content-between">
										<div class="d-flex align-items-center justify-content-center">
											<h2 class="card-title h2-responsive my-2 text-underline">Game {{ $loop->iteration }}</h2>
											<button class="btn btn-sm btn-rounded orange darken-1 clearStatsBtn" type="button">Clear Game Stats</button>
										</div>
										
										<div class="d-flex flex-column align-items-center">
											<div class="btn-group mb-2" role="group" aria-label="Game Time and Date">
												<button class="btn btn-outline-mdb-color" type="button"><i class="fa fa-calendar mr-2" aria-hidden="true"></i>{{ $game->game_date() }}</button>
												<button class="btn btn-outline-mdb-color" type="button"><i class="fa fa-clock-o mr-2" aria-hidden="true"></i>{{ $game->game_time() }}</button>
											</div>
											<div class="btn-group" role="group" aria-label="Game Time and Date">
												<button class="btn btn-outline-mdb-color" type="button"><span class="blue-grey border px-2 py-1 rounded-circle white-text">{{ $game->result ? $game->result->away_team_score != null ? $game->result->away_team_score : '0' : '' }}</span>&nbsp;{{ $game->away_team }}</button>
												<button class="btn btn-outline-mdb-color" type="button"><span class="blue-grey border px-2 py-1 rounded-circle white-text">{{ $game->result ? $game->result->home_team_score != null ? $game->result->home_team_score : '0' : '' }}</span>&nbsp;{{ $game->home_team }}</button>
											</div>
										</div>
									</div>
										
									@if($game->player_stats->isNotEmpty())
										<!-- Edit Form -->
										<div class="my-2">
											<div class="row">
												<div class="col-12">
													<table class="table table-striped table-sm table-fixed">
														<thead>
															<tr class="blue darken-3 white-text text-center">
																<th>{{ $game->away_team_obj->team_name }}</th>
																<th>Points</th>
																<th>Assists</th>
																<th>Rebounds</th>
																<th>Steals</th>
																<th>Blocks</th>
															</tr>
														</thead>
														<tbody>
															@foreach($game->away_team_obj->players as $away_player)
																@php $playerStat = $away_player->stats->where('league_schedule_id', $game->id)->first(); @endphp
																<tr>
																	<td class="text-center">{{ '#' . $away_player->jersey_num . ' ' . $away_player->player_name }}</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Pts</span>
																			</div>
																			<input type="number" name="edit_points[]" class="form-control" value="{{ $playerStat->points }}" placeholder="Enter Points" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Ast</span>
																			</div>
																			<input type="number" name="edit_assists[]" class="form-control" value="{{ $playerStat->assist }}" placeholder="Enter Assists" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Rebs</span>
																			</div>
																			
																			<input type="number" name="edit_rebounds[]" class="form-control" value="{{ $playerStat->rebounds }}" placeholder="Enter Rebounds" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Stls</span>
																			</div>
																			
																			<input type="number" name="edit_steals[]" class="form-control" value="{{ $playerStat->steals }}" placeholder="Enter Steals" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Blks</span>
																			</div>
																			
																			<input type="number" name="edit_blocks[]" class="form-control" value="{{ $playerStat->blocks }}" placeholder="Enter Blocks" />
																		</div>
																	</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												</div>
												<div class="col-12">
													<table class="table table-striped table-sm table-fixed">
														<thead>
															<tr class="blue-grey white-text text-center">
																<th>{{ $game->home_team_obj->team_name }}</th>
																<th>Points</th>
																<th>Assists</th>
																<th>Rebounds</th>
																<th>Steals</th>
																<th>Blocks</th>
															</tr>
														</thead>
														<tbody>
															@foreach($game->home_team_obj->players as $home_player)
																@php $playerStat = $home_player->stats->where('league_schedule_id', $game->id)->first(); @endphp
																<tr>
																	<td class="text-center">{{ '#' . $home_player->jersey_num . ' ' . $home_player->player_name }}</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Pts</span>
																			</div>
																			<input type="number" name="edit_points[]" class="form-control" value="{{ $playerStat->points }}" placeholder="Enter Game Points" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Ast</span>
																			</div>
																			<input type="number" name="edit_assists[]" class="form-control" value="{{ $playerStat->assist }}" placeholder="Enter Game Assists" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Rebs</span>
																			</div>
																			
																			<input type="number" name="edit_rebounds[]" class="form-control" value="{{ $playerStat->rebounds }}" placeholder="Enter Game Rebounds" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Stls</span>
																			</div>
																			
																			<input type="number" name="edit_steals[]" class="form-control" value="{{ $playerStat->steals }}" placeholder="Enter Game Steals" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Blks</span>
																			</div>
																			
																			<input type="number" name="edit_blocks[]" class="form-control" value="{{ $playerStat->blocks }}" placeholder="Enter Game Total Blocks" />
																		</div>
																	</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												</div>
											</div>
											<input type="number" name="edit_game_id[]" class="hidden" value="{{ $game->id }}" hidden />
										</div>
										
									@else
									
										<!-- Edit Form -->
										<div class="my-2">
											<div class="row">
												<div class="col-12">
													<table class="table table-striped table-sm table-fixed">
														<thead>
															<tr class="blue darken-3 white-text text-center">
																<th>{{ $game->away_team_obj->team_name }}</th>
																<th>Points</th>
																<th>Assists</th>
																<th>Rebounds</th>
																<th>Steals</th>
																<th>Blocks</th>
															</tr>
														</thead>
														<tbody>
															@foreach($game->away_team_obj->players as $away_player)
																<tr>
																	<td class="text-center">{{ '#' . $away_player->jersey_num . ' ' . $away_player->player_name }}</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Pts</span>
																			</div>
																			<input type="number" name="points[]" class="form-control" value="" placeholder="Enter Points" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Ast</span>
																			</div>
																			<input type="number" name="assists[]" class="form-control" value="" placeholder="Enter Assists" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Rebs</span>
																			</div>
																			
																			<input type="number" name="rebounds[]" class="form-control" value="" placeholder="Enter Rebounds" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Stls</span>
																			</div>
																			
																			<input type="number" name="steals[]" class="form-control" value="" placeholder="Enter Steals" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Blks</span>
																			</div>
																			
																			<input type="number" name="blocks[]" class="form-control" value="" placeholder="Enter Blocks" />
																		</div>
																	</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												</div>
												<div class="col-12">
													<table class="table table-striped table-sm table-fixed">
														<thead>
															<tr class="blue-grey white-text text-center">
																<th>{{ $game->home_team_obj->team_name }}</th>
																<th>Points</th>
																<th>Assists</th>
																<th>Rebounds</th>
																<th>Steals</th>
																<th>Blocks</th>
															</tr>
														</thead>
														<tbody>
															@foreach($game->home_team_obj->players as $home_player)
																<tr>
																	<td class="text-center">{{ '#' . $home_player->jersey_num . ' ' . $home_player->player_name }}</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Pts</span>
																			</div>
																			<input type="number" name="points[]" class="form-control" value="" placeholder="Enter Game Points" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Ast</span>
																			</div>
																			<input type="number" name="assists[]" class="form-control" value="" placeholder="Enter Game Assists" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Rebs</span>
																			</div>
																			
																			<input type="number" name="rebounds[]" class="form-control" value="" placeholder="Enter Game Rebounds" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Stls</span>
																			</div>
																			
																			<input type="number" name="steals[]" class="form-control" value="" placeholder="Enter Game Steals" />
																		</div>
																	</td>
																	<td>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text">Blks</span>
																			</div>
																			
																			<input type="number" name="blocks[]" class="form-control" value="" placeholder="Enter Game Total Blocks" />
																		</div>
																	</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												</div>
											</div>
											<input type="number" name="game_id[]" class="hidden" value="{{ $game->id }}" hidden />
										</div>
									@endif
								</div>
							</div>
							<!--/.Card-->
						@endforeach
						
						<div class="md-form">
							<button class="btn btn-lg blue lighten-1" type="submit">Update round Games</button>
						</div>
					{!! Form::close() !!}
				@else
					<div class="my-5 text-center">
						<h2 class="h2-responsive red-text coolText4"><i class="fa fa-warning" aria-hidden="true"></i>&nbsp;There is no round {{ $round }} on the schedule. Click below to add another round to the schedule.&nbsp;<i class="fa fa-warning" aria-hidden="true"></i></h2>
						<a href="{{ request()->query() == null ? route('league_schedule.create') : route('league_schedule.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text">Add round</a>
					</div>
				@endif					
			</div>
		</div>
	</div>
@endsection