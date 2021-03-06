@extends('layouts.app')

@section('title', 'The Alumni League Teams')

@section('content')

	<div class="container-fluid bgrd3">

		<div class="row">

			<div class="col-12 mt-3 text-center">
				@if(Auth::check() && Auth::user()->type == 'admin')
					<div class="text-center d-inline-block" id="">
						<a href="{{ request()->query() == null ? route('league_teams.create') : route('league_teams.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Team</a>
					</div>
					<div class="text-center d-inline-block" id="">
						<a href="{{ request()->query() == null ? route('league_teams.index') : route('league_teams.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">All Teams</a>
					</div>
				@endif
			</div>

			<div class="col-12 col-xl-8 mx-auto">
				<div class="text-center coolText1">
					<div class="text-center p-4 card rgba-deep-orange-light white-text my-3" id="">
						<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
					</div>
				</div>
				
				<!--Card-->
				<div class="card card-cascade mb-4 reverse wider">
					<!--Card image-->
					<div class="view">
						<img src="{{ asset($league_team->lg_photo()) }}" class="img-fluid mx-auto" alt="photo" style="max-width: 75%;">
					</div>

					<!--Card content-->
					<div class="card-body rgba-white-strong rounded z-depth-1-half">
						<!--Title-->
						<h2 class="card-title h2-responsive text-center">{{ $league_team->team_name }}</h2>
						
						<!-- Create Form -->
						{!! Form::open(['action' => ['LeagueTeamController@update', $league_team->id], 'id' => 'update_team_form', 'method' => 'PATCH', 'files' => true]) !!}

							<!-- Team Info -->
							<div class="">
								<div class="row">
									<div class="col-12 col-md">
										<div class="md-form">
											<input type="text" name="team_name" class="form-control" value="{{ $league_team->team_name }}" />
											<label for="team_name">Team Name</label>
										</div>
										
										@if($errors->has('team_name'))
											<div class="md-form-errors red-text">
												<p class=""><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;{{ $errors->first('team_name') }}</p>
											</div>
										@endif
									</div>
									<div class="col-12 col-md order-first order-md-0 p-0">
										<div class="md-form">
											<div class="file-field">
												<div class="btn btn-primary btn-sm float-left">
													<span>Choose file</span>
													<input type="file" name="team_photo" />
												</div>
												<div class="file-path-wrapper">
													<input class="file-path validate" type="text" placeholder="Change Team Picture" />
												</div>
											</div>
										</div>
										
										@if($errors->has('team_photo'))
											<div class="md-form-errors red-text">
												<p class=""><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;{{ $errors->first('team_photo') }}</p>
											</div>
										@endif
									</div>
								</div>

								<div class="form-row">

									@if($league_team->is_all_star_team == 'N')
										@if(Auth::check() && Auth::user()->type == 'admin')
											@if($showSeason->has_conferences == 'Y')
												@if($showSeason->conferences->isNotEmpty())
													<div class="col-12 col-md">
														<select class="mdb-select md-form" name="conference">

															<option value="blank" selected disabled>Select A Conference</option>

															@foreach($conferences as $conference)
																<option value="{{ $conference->id }}"{{ $league_team->league_conference_id == $conference->id ? ' selected' : ''  }}>{{ ucwords(str_ireplace('_', ' ', $conference->conference_name)) }}</option>
															@endforeach
														</select>

														<label data-error="wrong" data-success="right" for="conference" class="text-primary mdb-main-label">Conference</label>
													</div>
												@endif
											@endif

											@if($showSeason->has_divisions == 'Y')
												@if($showSeason->conferences->isNotEmpty())
													<div class="col-12 col-md">
														<select class="mdb-select md-form" name="division">

															<option value="blank" selected disabled>Select A Division</option>

															@foreach($divisions as $division)
																<option value="{{ $division->id }}"{{ $league_team->league_division_id == $division->id ? ' selected' : ''  }}>{{ ucwords(str_ireplace('_', ' ', $division->division_name)) }}</option>
															@endforeach
														</select>

														<label for="comp_group" class="text-primary mdb-main-label">Division</label>
													</div>
												@endif
											@endif
										@endif
									@endif

								</div>

								@if(Auth::check() && Auth::user()->type == 'admin')
									<div class="form-row align-items-center justify-content-between justify-content-md-around">
										@if($league_team->is_all_star_team == 'N')
											<div class="input-form">
												<label for="fee_paid" class="d-block">League Fee Paid</label>

												<div class="d-flex">
													<button class="btn inputSwitchToggle{{ $league_team->fee_paid == 'Y' ? ' green active' : ' grey' }}" type="button">Yes
														<input type="checkbox" name="fee_paid" class="hidden" value="Y"{{ $league_team->fee_paid == 'Y' ? ' checked' : '' }} hidden />
													</button>

													<button class="btn inputSwitchToggle{{ $league_team->fee_paid == 'N' ? ' green active' : ' grey' }}" type="button">No
														<input type="checkbox" name="fee_paid" class="hidden" value="N"{{ $league_team->fee_paid == 'N' ? ' checked' : '' }} hidden />
													</button>
												</div>
											</div>
										@endif

										<div class="input-form">
											<label for="all_star_team" class="d-block">Is This An All-Star Team?</label>

											<div class="d-flex">
												<button class="btn inputSwitchToggle{{ $league_team->is_all_star_team == 'Y' ? ' green active' : ' grey' }}" type="button">Yes
													<input type="checkbox" name="all_star_team" class="hidden" value="Y"{{ $league_team->is_all_star_team == 'Y' ? ' checked' : '' }} hidden />
												</button>

												<button class="btn inputSwitchToggle{{ $league_team->is_all_star_team == 'N' ? ' green active' : ' grey' }}" type="button">No
													<input type="checkbox" name="all_star_team" class="hidden" value="N"{{ $league_team->is_all_star_team == 'N' ? ' checked' : '' }} hidden />
												</button>
											</div>
										</div>
									</div>
								@endif
							</div>


							@if(Auth::check() && Auth::user()->type == 'admin')
								<div class="divider-long my-5"></div>
							@endif

							<!-- Team Players Info -->
							<div class="mt-4 position-relative">
								<div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
									<h3 class="text-center my-0 mx-auto">{{ $league_team->team_name }} Players</h3>

									@if($league_team->is_all_star_team == 'N')
										<button class="btn btn-floating green addPlayerBtn" type="button">
											<i class="fa fa-plus-circle" aria-hidden="true"></i>
										</button>
									@endif
								</div>
								<div class="table-wrapper">
									<table class="table table-hover table-striped" id="team_players_table">
										<thead>
											<tr>
												@if($league_team->is_all_star_team == 'N')
													<th>Captain</th>
													<th class="text-nowrap">Jersey Num.</th>
													<th class="text-nowrap">Player Name</th>
													<th class="text-nowrap">Email Address</th>
													<th class="text-nowrap">Phone</th>
													<th class="text-nowrap">All-Star</th>
													<th></th>
												@else
													<th>Jersey Num.</th>
													<th class="text-nowrap">Player Name</th>
												@endif
											</tr>
										</thead>
										<tbody>
											@if($league_team->players->isNotEmpty())
												@foreach($league_team->players as $player)
													<tr class="">
														@if($league_team->is_all_star_team == 'N')
															<td class="align-bottom">
																<div class="form-check" id="">
																	<input type="checkbox" name="team_captain" class="form-check-input filled-in" value="captain_{{ $player->id }}" id="captain_{{ $player->id }}"{{ $player->team_captain == 'Y' ? ' checked' : '' }} />
																	<label class="form-check-label" for="captain_{{ $player->id }}"></label>
																</div>
															</td>
															<td class="">
																<input type="number" name="jersey_num[]" class="form-control" value="{{ $player->jersey_num }}" placeholder="Enter Jersey #" min="0" step="1" />
															</td>
															<td class="">
																<input type="text" name="player_name[]" class="form-control" value="{{ $player->player_name }}" placeholder="Enter Player Name" />
															</td>
															<td class="">
																<input type="text" name="player_email[]" class="form-control" value="{{ $player->email }}" placeholder="Enter Player Email" />
															</td>
															<td class="">
																<input type="text" name="player_phone[]" class="form-control" value="{{ $player->phone }}" placeholder="Enter Player Phone" />
															</td>

															@if(Auth::check() && Auth::user()->type == 'admin')
																<td class="align-bottom">
																	<div class="form-check" id="">
																		<input type="checkbox" name="all_star[]" class="form-check-input filled-in" value="all_star_{{ $player->id }}" id="all_star_{{ $player->id }}"{{ $player->all_star == 'Y' ? ' checked' : '' }} />
																		<label class="form-check-label" for="all_star_{{ $player->id }}"></label>
																	</div>
																</td>
															@endif

															<td class="">
																<button data-target="#delete_player" data-toggle="modal" type="button" class="btn btn-sm red darken-1 white-text rounded w-100 deletePlayerBtn">Remove</button>
																<input type="text" class="hidden" value="{{ $player->id }}" hidden />
															</td>
														@else
															<td class="">
																<input type="number" name="jersey_num[]" class="form-control" value="{{ $player->jersey_num }}" placeholder="Enter Jersey #" min="0" step="1" />
															</td>
															<td class="">
																<input type="text" name="player_name[]" class="form-control" value="{{ $player->player_name }}" placeholder="Enter Player Name" />
															</td>
														@endif
													</tr>
												@endforeach
											@else
												@if($league_team->is_all_star_team == 'N')
													<tr class="">
														<th colspan="6" class="text-center">No Players Added for this team yet</th>
													</tr>
												@else
													<tr class="">
														<th colspan="2" class="text-center">No Players Added for this team yet. All Star Team Players Are Added Automatically</th>
													</tr>
												@endif
											@endif

											<tr class="newPlayerRow hidden" hidden>
												<td class="text-center">&nbsp;</td>
												<td class="">
													<input type="number" name="new_jers_num[]" class="form-control" value="" placeholder="Enter Jersey #" min="0" step="1" disabled />
												</td>
												<td class="">
													<input type="text" name="new_player_name[]" class="form-control" value="" placeholder="Enter Player Name" disabled />
												</td>
												<td class="">
													<input type="text" name="new_player_email[]" class="form-control" value="" placeholder="Enter Player Email" disabled />
												</td>
												<td class="">
													<input type="text" name="new_player_phone[]" class="form-control" value="" placeholder="Enter Player Phone" disabled />
												</td>
												<td class="">
													<button class="btn btn-sm orange lighten-1 w-100 my-0 removeNewPlayerRow hidden" type="button">Hide</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="md-form">
								<button class="btn blue lighten-1 white-text" type="submit">Update Team Information</button>

								@if(Auth::check() && Auth::user()->type == 'admin')
									<button class="btn red darken-1 white-text" type="button" data-toggle="modal" data-target="#delete_team">Delete Team</button>
								@endif
							</div>
						{!! Form::close() !!}
					</div>
				</div>
				<!--/.Card-->
			</div>
		</div>

		<div class="row">
			@if(Auth::check() && Auth::user()->type == 'admin')
				@include('modals.delete_team')
				@include('modals.delete_player')
			@endif
		</div>
	</div>

	<!-- Footer -->
	@include('content_parts.footer')
	<!-- Footer -->
@endsection