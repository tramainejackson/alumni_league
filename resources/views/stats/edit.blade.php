@extends('layouts.app')

@section('content')
	@include('include.functions')
	
	<div class="container-fluid bgrd3" id="leaguesProfileContainer">
		<div class="row">
			<div class="col-12 mt-3">
				@foreach($seasonScheduleWeeks as $edit_week)
					<a href="{{ request()->query() == null ? route('league_stats.edit_week', ['week' => $edit_week->season_week]) : route('league_stats.edit_week', ['week' => $edit_week->season_week, 'season' => request()->query('season')]) }}" class="btn btn-rounded mdb-color darken-3 white-text">Week {{ $loop->iteration }} Stats</a>
				@endforeach

				@if(isset($allStarGame) && $allStarGame != null)
					<a href="{{ request()->query() == null ? route('league_stats.all_star_game', ['game' => $allStarGame->id]) : route('league_stats.all_star_game', ['game' => $allStarGame->id, 'season' => request()->query('season')]) }}" class="btn btn-rounded mdb-color darken-3 white-text mw-100">All Star Game Stats</a>
				@endif
			</div>

			<div class="col-12">

				@if(!isset($allStarGame))
					<div class="text-center coolText1">
						<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
					</div>
					<div class="text-center">
						<h3 class="h3-responsive">Week Stats</h3>
					</div>

					@if($weekGames->count() > 0)
						{!! Form::open(['action' => ['LeagueStatController@update', 'week' => $week], 'method' => 'PATCH']) !!}
							@foreach($weekGames as $game)
								<!--Card-->
								<div class="card mb-4">
									<!--Card content-->
									<div class="card-body">
										<!--Title-->
										<div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
											<div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
												<h2 class="card-title h2-responsive my-2 text-underline">Game {{ $loop->iteration }}</h2>
												<button class="btn btn-sm btn-rounded orange darken-1 clearStatsBtn" type="button">Clear Game Stats</button>
											</div>

											<div class="d-flex flex-column align-items-center">
												<div class="btn-group mb-2" role="group" aria-label="Game Time and Date">
													<button class="btn btn-outline-mdb-color" type="button"><i class="fas fa-calendar mr-2" aria-hidden="true"></i>{{ $game->game_date() }}</button>
													<button class="btn btn-outline-mdb-color" type="button"><i class="fas fa-clock mr-2" aria-hidden="true"></i>{{ $game->game_time() }}</button>
												</div>
												<div class="btn-group" role="group" aria-label="Game Time and Date">
													<button class="btn btn-outline-mdb-color" type="button"><span class="blue-grey border px-2 py-1 rounded-circle white-text d-block d-md-inline">{{ $game->result ? $game->result->away_team_score != null ? $game->result->away_team_score : '0' : '' }}</span>&nbsp;{{ $game->away_team }}</button>
													<button class="btn btn-outline-mdb-color" type="button"><span class="blue-grey border px-2 py-1 rounded-circle white-text d-block d-md-inline">{{ $game->result ? $game->result->home_team_score != null ? $game->result->home_team_score : '0' : '' }}</span>&nbsp;{{ $game->home_team }}</button>
												</div>
											</div>
										</div>

										@if($game->player_stats->isNotEmpty())

											<!-- Edit Form -->
											<div class="my-2">
												<div class="row">
													<div class="col-12 table-wrapper mb-3">
														<table class="table table-striped table-sm table-responsive-sm team_players_stats_table">
															<thead>
																<tr class="blue darken-3 white-text text-center">
																	<th class="text-nowrap">{{ $game->away_team_obj->team_name }}</th>
																	<th>Points</th>
																	<th>3's</th>
																	<th>FT's</th>
																	<th>Assists</th>
																	<th>Rebounds</th>
																	<th>Steals</th>
																	<th>Blocks</th>
																	<th>POTW</th>
																</tr>
															</thead>
															<tbody>
																@foreach($game->away_team_obj->players as $away_player)
																	@php $playerStat = $away_player->stats->where('league_schedule_id', $game->id)->first(); @endphp

																	<tr>
																		<td class="text-center text-nowrap">{{ '#' . $away_player->jersey_num . ' ' . $away_player->player_name }}</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Pts</span>
																				</div>
																				<input type="number" name="edit_points[]" class="form-control" value="{{ $playerStat->points }}" placeholder="Enter Points" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">3s</span>
																				</div>
																				<input type="number" name="edit_threes[]" class="form-control" value="{{ $playerStat->threes_made }}" placeholder="Enter Total 3's" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">FTs</span>
																				</div>
																				<input type="number" name="edit_fts[]" class="form-control" value="{{ $playerStat->ft_made }}" placeholder="Enter Total FT's" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Ast</span>
																				</div>
																				<input type="number" name="edit_assists[]" class="form-control" value="{{ $playerStat->assist }}" placeholder="Enter Assists" min="0" step="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Rebs</span>
																				</div>

																				<input type="number" name="edit_rebounds[]" class="form-control" value="{{ $playerStat->rebounds }}" placeholder="Enter Rebounds" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Stls</span>
																				</div>

																				<input type="number" name="edit_steals[]" class="form-control" value="{{ $playerStat->steals }}" placeholder="Enter Steals" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Blks</span>
																				</div>

																				<input type="number" name="edit_blocks[]" class="form-control" value="{{ $playerStat->blocks }}" placeholder="Enter Blocks" min="0" />
																			</div>
																		</td>
																		<td class="align-bottom text-center text-nowrap">
																			<div class="form-check" id="">
																				<input type="checkbox" name="potw" class="form-check-input filled-in" value="potw_{{ $away_player->id }}" id="potw_{{ $away_player->id }}"{{ $playerStat->potw == 'Y' ? ' checked' : '' }} />
																				<label class="form-check-label" for="potw_{{ $away_player->id }}"></label>
																			</div>
																		</td>
																	</tr>
																@endforeach
															</tbody>
														</table>
													</div>
													<div class="col-12 table-wrapper">
														<table class="table table-striped table-sm table-responsive-sm team_players_stats_table">
															<thead>
																<tr class="blue-grey white-text text-center">
																	<th class="text-nowrap">{{ $game->home_team_obj->team_name }}</th>
																	<th>Points</th>
																	<th>3's</th>
																	<th>FT's</th>
																	<th>Assists</th>
																	<th>Rebounds</th>
																	<th>Steals</th>
																	<th>Blocks</th>
																	<th>POTW</th>
																</tr>
															</thead>
															<tbody>
																@foreach($game->home_team_obj->players as $home_player)
																	@php $playerStat = $home_player->stats->where('league_schedule_id', $game->id)->first(); @endphp

																	<tr>
																		<td class="text-center text-nowrap">{{ '#' . $home_player->jersey_num . ' ' . $home_player->player_name }}</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Pts</span>
																				</div>
																				<input type="number" name="edit_points[]" class="form-control" value="{{ $playerStat->points }}" placeholder="Enter Game Points" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">3s</span>
																				</div>
																				<input type="number" name="edit_threes[]" class="form-control" value="{{ $playerStat->threes_made }}" placeholder="Enter Total 3's" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">FTs</span>
																				</div>
																				<input type="number" name="edit_fts[]" class="form-control" value="{{ $playerStat->ft_made }}" placeholder="Enter Total FT's" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Ast</span>
																				</div>
																				<input type="number" name="edit_assists[]" class="form-control" value="{{ $playerStat->assist }}" placeholder="Enter Game Assists" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Rebs</span>
																				</div>

																				<input type="number" name="edit_rebounds[]" class="form-control" value="{{ $playerStat->rebounds }}" placeholder="Enter Game Rebounds" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Stls</span>
																				</div>

																				<input type="number" name="edit_steals[]" class="form-control" value="{{ $playerStat->steals }}" placeholder="Enter Game Steals" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Blks</span>
																				</div>

																				<input type="number" name="edit_blocks[]" class="form-control" value="{{ $playerStat->blocks }}" placeholder="Enter Game Total Blocks" min="0" />
																			</div>
																		</td>
																		<td class="align-bottom text-center text-nowrap">
																			<div class="form-check" id="">
																				<input type="checkbox" name="potw" class="form-check-input filled-in" value="potw_{{ $home_player->id }}" id="potw_{{ $home_player->id }}"{{ $playerStat->potw == 'Y' ? ' checked' : '' }} />
																				<label class="form-check-label" for="potw_{{ $home_player->id }}"></label>
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
													<div class="col-12 table-wrapper mb-4 mb-lg-0">
														<table class="table table-striped table-sm table-fixed">
															<thead>
																<tr class="blue darken-3 white-text text-center">
																	<th>{{ $game->away_team_obj->team_name }}</th>
																	<th>Points</th>
																	<th>3'</th>
																	<th>FT's</th>
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
																				<input type="number" name="points[]" class="form-control" value="" placeholder="Enter Points" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">3s</span>
																				</div>
																				<input type="number" name="threes[]" class="form-control" value="" placeholder="Enter Total 3's" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">FTs</span>
																				</div>
																				<input type="number" name="fts[]" class="form-control" value="" placeholder="Enter Total FT's" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Ast</span>
																				</div>
																				<input type="number" name="assists[]" class="form-control" value="" placeholder="Enter Assists" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Rebs</span>
																				</div>

																				<input type="number" name="rebounds[]" class="form-control" value="" placeholder="Enter Rebounds" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Stls</span>
																				</div>

																				<input type="number" name="steals[]" class="form-control" value="" placeholder="Enter Steals" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Blks</span>
																				</div>

																				<input type="number" name="blocks[]" class="form-control" value="" placeholder="Enter Blocks" min="0" />
																			</div>
																		</td>
																	</tr>
																@endforeach
															</tbody>
														</table>
													</div>
													<div class="col-12 table-wrapper">
														<table class="table table-striped table-sm table-fixed">
															<thead>
																<tr class="blue-grey white-text text-center">
																	<th>{{ $game->home_team_obj->team_name }}</th>
																	<th>Points</th>
																	<th>3's</th>
																	<th>FT's</th>
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
																				<input type="number" name="points[]" class="form-control" value="" placeholder="Enter Game Points" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">3s</span>
																				</div>
																				<input type="number" name="threes[]" class="form-control" value="" placeholder="Enter Total 3's" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">FTs</span>
																				</div>
																				<input type="number" name="fts[]" class="form-control" value="" placeholder="Enter Total FT's" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Ast</span>
																				</div>
																				<input type="number" name="assists[]" class="form-control" value="" placeholder="Enter Game Assists" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Rebs</span>
																				</div>

																				<input type="number" name="rebounds[]" class="form-control" value="" placeholder="Enter Game Rebounds" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Stls</span>
																				</div>

																				<input type="number" name="steals[]" class="form-control" value="" placeholder="Enter Game Steals" min="0" />
																			</div>
																		</td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-prepend">
																					<span class="input-group-text">Blks</span>
																				</div>

																				<input type="number" name="blocks[]" class="form-control" value="" placeholder="Enter Game Total Blocks" min="0" />
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
								<button class="btn btn-lg blue lighten-1 white-text" type="submit">Update Week Games</button>
							</div>
						{!! Form::close() !!}
					@else
						<div class="my-5 text-center">
							<h2 class="h2-responsive red-text coolText4"><i class="fa fa-warning" aria-hidden="true"></i>&nbsp;There is no week {{ $week }} on the schedule. Click below to add another week to the schedule.&nbsp;<i class="fa fa-warning" aria-hidden="true"></i></h2>
							<a href="{{ request()->query() == null ? route('league_schedule.create') : route('league_schedule.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text">Add Week</a>
						</div>
					@endif
				@else
					<div class="text-center coolText1">
						<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
					</div>
					<div class="text-center">
						<h3 class="h3-responsive">All-Star Stats</h3>
					</div>

					{!! Form::open(['action' => ['LeagueStatController@update', 'week' => 2], 'method' => 'PATCH']) !!}

						<!--Card-->
						<div class="card mb-4">
							<!--Card content-->
							<div class="card-body">
								<!--Title-->
								<div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
									<div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
										<h2 class="card-title h2-responsive my-2 text-underline">All Star Game</h2>
										<button class="btn btn-sm btn-rounded orange darken-1 clearStatsBtn" type="button">Clear Game Stats</button>
									</div>

									<div class="d-flex flex-column align-items-center">
										<div class="btn-group mb-2" role="group" aria-label="Game Time and Date">
											<button class="btn btn-outline-mdb-color" type="button"><i class="fas fa-calendar mr-2" aria-hidden="true"></i>{{ $seasonASG->game_date() }}</button>
											<button class="btn btn-outline-mdb-color" type="button"><i class="fas fa-clock mr-2" aria-hidden="true"></i>{{ $seasonASG->game_time() }}</button>
										</div>
										<div class="btn-group" role="group" aria-label="Game Time and Date">
											<button class="btn btn-outline-mdb-color" type="button"><span class="blue-grey border px-2 py-1 rounded-circle white-text d-block d-md-inline">{{ $seasonASG->result ? $seasonASG->result->away_team_score != null ? $seasonASG->result->away_team_score : '0' : '' }}</span>&nbsp;{{ $seasonASG->away_team }}</button>
											<button class="btn btn-outline-mdb-color" type="button"><span class="blue-grey border px-2 py-1 rounded-circle white-text d-block d-md-inline">{{ $seasonASG->result ? $seasonASG->result->home_team_score != null ? $seasonASG->result->home_team_score : '0' : '' }}</span>&nbsp;{{ $seasonASG->home_team }}</button>
										</div>
									</div>
								</div>

							@if($seasonASG->player_stats->isNotEmpty())
								<!-- Edit Form -->
								<div class="my-2">
									<div class="row">
										<div class="col-12 table-wrapper mb-3">
											<table class="table table-striped table-sm table-responsive-sm team_players_stats_table">
												<thead>
												<tr class="blue darken-3 white-text text-center">
													<th class="text-nowrap">{{ $seasonASG->away_team_obj->team_name }}</th>
													<th>Points</th>
													<th>3's</th>
													<th>FT's</th>
													<th>Assists</th>
													<th>Rebounds</th>
													<th>Steals</th>
													<th>Blocks</th>
													<th>POTW</th>
												</tr>
												</thead>
												<tbody>
												@foreach($seasonASG->away_team_obj->players as $away_player)
													@php $playerStat = $away_player->stats->where('league_schedule_id', $seasonASG->id)->first(); @endphp

													<tr>
														<td class="text-center text-nowrap">{{ '#' . $away_player->jersey_num . ' ' . $away_player->player_name }}</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Pts</span>
																</div>
																<input type="number" name="edit_points[]" class="form-control" value="{{ $playerStat->points }}" placeholder="Enter Points" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">3s</span>
																</div>
																<input type="number" name="edit_threes[]" class="form-control" value="{{ $playerStat->threes_made }}" placeholder="Enter Total 3's" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">FTs</span>
																</div>
																<input type="number" name="edit_fts[]" class="form-control" value="{{ $playerStat->ft_made }}" placeholder="Enter Total FT's" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Ast</span>
																</div>
																<input type="number" name="edit_assists[]" class="form-control" value="{{ $playerStat->assist }}" placeholder="Enter Assists" min="0" step="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Rebs</span>
																</div>

																<input type="number" name="edit_rebounds[]" class="form-control" value="{{ $playerStat->rebounds }}" placeholder="Enter Rebounds" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Stls</span>
																</div>

																<input type="number" name="edit_steals[]" class="form-control" value="{{ $playerStat->steals }}" placeholder="Enter Steals" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Blks</span>
																</div>

																<input type="number" name="edit_blocks[]" class="form-control" value="{{ $playerStat->blocks }}" placeholder="Enter Blocks" min="0" />
															</div>
														</td>
														<td class="align-bottom text-center text-nowrap">
															<div class="form-check" id="">
																<input type="checkbox" name="potw" class="form-check-input filled-in" value="potw_{{ $away_player->id }}" id="potw_{{ $away_player->id }}"{{ $playerStat->potw == 'Y' ? ' checked' : '' }} />
																<label class="form-check-label" for="potw_{{ $away_player->id }}"></label>
															</div>
														</td>
													</tr>
												@endforeach
												</tbody>
											</table>
										</div>
										<div class="col-12 table-wrapper">
											<table class="table table-striped table-sm table-responsive-sm team_players_stats_table">
												<thead>
												<tr class="blue-grey white-text text-center">
													<th class="text-nowrap">{{ $seasonASG->home_team_obj->team_name }}</th>
													<th>Points</th>
													<th>3's</th>
													<th>FT's</th>
													<th>Assists</th>
													<th>Rebounds</th>
													<th>Steals</th>
													<th>Blocks</th>
													<th>POTW</th>
												</tr>
												</thead>
												<tbody>
												@foreach($seasonASG->home_team_obj->players as $home_player)
													@php $playerStat = $home_player->stats->where('league_schedule_id', $seasonASG->id)->first(); @endphp
													<tr>
														<td class="text-center text-nowrap">{{ '#' . $home_player->jersey_num . ' ' . $home_player->player_name }}</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Pts</span>
																</div>
																<input type="number" name="edit_points[]" class="form-control" value="{{ $playerStat->points }}" placeholder="Enter Game Points" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">3s</span>
																</div>
																<input type="number" name="edit_threes[]" class="form-control" value="{{ $playerStat->threes_made }}" placeholder="Enter Total 3's" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">FTs</span>
																</div>
																<input type="number" name="edit_fts[]" class="form-control" value="{{ $playerStat->ft_made }}" placeholder="Enter Total FT's" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Ast</span>
																</div>
																<input type="number" name="edit_assists[]" class="form-control" value="{{ $playerStat->assist }}" placeholder="Enter Game Assists" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Rebs</span>
																</div>

																<input type="number" name="edit_rebounds[]" class="form-control" value="{{ $playerStat->rebounds }}" placeholder="Enter Game Rebounds" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Stls</span>
																</div>

																<input type="number" name="edit_steals[]" class="form-control" value="{{ $playerStat->steals }}" placeholder="Enter Game Steals" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Blks</span>
																</div>

																<input type="number" name="edit_blocks[]" class="form-control" value="{{ $playerStat->blocks }}" placeholder="Enter Game Total Blocks" min="0" />
															</div>
														</td>
														<td class="align-bottom text-center text-nowrap">
															<div class="form-check" id="">
																<input type="checkbox" name="potw" class="form-check-input filled-in" value="potw_{{ $home_player->id }}" id="potw_{{ $home_player->id }}"{{ $playerStat->potw == 'Y' ? ' checked' : '' }} />
																<label class="form-check-label" for="potw_{{ $home_player->id }}"></label>
															</div>
														</td>
													</tr>
												@endforeach
												</tbody>
											</table>
										</div>
									</div>
									<input type="number" name="edit_game_id[]" class="hidden" value="{{ $seasonASG->id }}" hidden />
								</div>

							@else

								<!-- Edit Form -->
								<div class="my-2">
									<div class="row">
										<div class="col-12 table-wrapper mb-4 mb-lg-0">
											<table class="table table-striped table-sm table-fixed">
												<thead>
												<tr class="blue darken-3 white-text text-center">
													<th>{{ $seasonASG->away_team_obj->team_name }}</th>
													<th>Points</th>
													<th>3'</th>
													<th>FT's</th>
													<th>Assists</th>
													<th>Rebounds</th>
													<th>Steals</th>
													<th>Blocks</th>
												</tr>
												</thead>
												<tbody>
												@foreach($seasonASG->away_team_obj->players as $away_player)
													<tr>
														<td class="text-center">{{ '#' . $away_player->jersey_num . ' ' . $away_player->player_name }}</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Pts</span>
																</div>
																<input type="number" name="points[]" class="form-control" value="" placeholder="Enter Points" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">3s</span>
																</div>
																<input type="number" name="threes[]" class="form-control" value="" placeholder="Enter Total 3's" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">FTs</span>
																</div>
																<input type="number" name="fts[]" class="form-control" value="" placeholder="Enter Total FT's" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Ast</span>
																</div>
																<input type="number" name="assists[]" class="form-control" value="" placeholder="Enter Assists" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Rebs</span>
																</div>

																<input type="number" name="rebounds[]" class="form-control" value="" placeholder="Enter Rebounds" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Stls</span>
																</div>

																<input type="number" name="steals[]" class="form-control" value="" placeholder="Enter Steals" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Blks</span>
																</div>

																<input type="number" name="blocks[]" class="form-control" value="" placeholder="Enter Blocks" min="0" />
															</div>
														</td>
													</tr>
												@endforeach
												</tbody>
											</table>
										</div>
										<div class="col-12 table-wrapper">
											<table class="table table-striped table-sm table-fixed">
												<thead>
												<tr class="blue-grey white-text text-center">
													<th>{{ $seasonASG->home_team_obj->team_name }}</th>
													<th>Points</th>
													<th>3's</th>
													<th>FT's</th>
													<th>Assists</th>
													<th>Rebounds</th>
													<th>Steals</th>
													<th>Blocks</th>
												</tr>
												</thead>
												<tbody>
												@foreach($seasonASG->home_team_obj->players as $home_player)
													<tr>
														<td class="text-center">{{ '#' . $home_player->jersey_num . ' ' . $home_player->player_name }}</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Pts</span>
																</div>
																<input type="number" name="points[]" class="form-control" value="" placeholder="Enter Game Points" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">3s</span>
																</div>
																<input type="number" name="threes[]" class="form-control" value="" placeholder="Enter Total 3's" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">FTs</span>
																</div>
																<input type="number" name="fts[]" class="form-control" value="" placeholder="Enter Total FT's" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Ast</span>
																</div>
																<input type="number" name="assists[]" class="form-control" value="" placeholder="Enter Game Assists" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Rebs</span>
																</div>

																<input type="number" name="rebounds[]" class="form-control" value="" placeholder="Enter Game Rebounds" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Stls</span>
																</div>

																<input type="number" name="steals[]" class="form-control" value="" placeholder="Enter Game Steals" min="0" />
															</div>
														</td>
														<td>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">Blks</span>
																</div>

																<input type="number" name="blocks[]" class="form-control" value="" placeholder="Enter Game Total Blocks" min="0" />
															</div>
														</td>
													</tr>
												@endforeach
												</tbody>
											</table>
										</div>
									</div>
									<input type="number" name="game_id[]" class="hidden" value="{{ $seasonASG->id }}" hidden />
								</div>
							@endif
						</div>
						<!--/.Card-->

						<div class="md-form">
							<button class="btn btn-lg blue lighten-1 white-text" type="submit">Update Week Games</button>
						</div>

					{!! Form::close() !!}
				@endif
			</div>
		</div>
	</div>

	<!-- Footer -->
	@include('layouts.footer')
	<!-- Footer -->
@endsection