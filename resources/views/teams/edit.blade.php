@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md mt-3"></div>
			<div class="col-12 col-md-8">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				
				<!--Card-->
				<div class="card card-cascade mb-4 reverse wider">
					<!--Card image-->
					<div class="view">
						<img src="/images/commissioner.jpg" class="img-fluid" alt="photo">
					</div>
					<!--Card content-->
					<div class="card-body">
						<!--Title-->
						<h2 class="card-title h2-responsive text-center">{{ $league_team->team_name }}</h2>
						
						<!-- Create Form -->
						{!! Form::open(['action' => ['LeagueTeamController@update', $league_team->id], 'method' => 'PATCH']) !!}
							<!-- Team Info -->
							<div class="">
								<div class="md-form">
									<input type="text" name="team_name" class="form-control" value="{{ $league_team->team_name }}" />
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
										<button class="btn inputSwitchToggle{{ $league_team->fee_paid == 'Y' ? ' green active' : ' grey' }}" type="button">Yes
											<input type="checkbox" name="fee_paid" class="hidden" value="Y"{{ $league_team->fee_paid == 'Y' ? ' checked' : '' }} hidden />
										</button>
										
										<button class="btn inputSwitchToggle{{ $league_team->fee_paid == 'N' ? ' green active' : ' grey' }}" type="button">No
											<input type="checkbox" name="fee_paid" class="hidden" value="N"{{ $league_team->fee_paid == 'N' ? ' checked' : '' }} hidden />
										</button>
									</div>
								</div>
							</div>
							
							<!-- Team Players Info -->
							<div class="mt-4 position-relative">
								<div class="d-flex align-items-center justify-content-center">
									<h3 class="text-center my-0 mx-auto">{{ $league_team->team_name }} Players</h3>
									<button class="btn btn-floating green position-absolute right addPlayerBtn" type="button">
										<i class="fa fa-plus-circle" aria-hidden="true"></i>
									</button>
								</div>
								<table class="table table-hover table-striped" id="team_players_table">
									<thead>
										<tr>
											<th>Captain</th>
											<th>Jersey Num.</th>
											<th>Player Name</th>
											<th>Email Address</th>
											<th>Phone</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@if($league_team->players->isNotEmpty())
											@foreach($league_team->players as $player)
												<tr class="">
													<td class="">
														<input type="checkbox" name="team_captain" class="filled-in" value="captain_{{ $player->id }}" id="captain_{{ $player->id }}"{{ $player->team_captain == 'Y' ? ' checked' : '' }} />
														<label for="captain_{{ $player->id }}" class="label-table"></label>
													</td>
													<td class="">
														<input type="number" name="jersey_num[]" class="form-control" value="{{ $player->jersey_num }}" placeholder="Enter Jersey #" />
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
													<td class="">
														<a href="#" class="btn btn-sm red darken-1 white-text rounded w-100">Remove</a>
													</td>
												</tr>
											@endforeach
										@else
											<tr class="">
												<th colspan="5" class="text-center">No Players Added for this team yes</th>
											</tr>
										@endif
										<tr class="newPlayerRow hidden" hidden>
											<td class="text-center">&nbsp;</td>
											<td class="">
												<input type="number" name="new_jers_num" class="form-control" value="" placeholder="Enter Jersey #" disabled />
											</td>
											<td class="">
												<input type="text" name="new_player_name" class="form-control" value="" placeholder="Enter Player Name" disabled />
											</td>
											<td class="">
												<input type="text" name="new_player_email[]" class="form-control" value="" placeholder="Enter Player Email" disabled />
											</td>
											<td class="">
												<input type="text" name="new_player_phone" class="form-control" value="" placeholder="Enter Player Phone" disabled />
											</td>
											<td class="">
												<button class="btn btn-sm orange lighten-1 w-100 my-0 removeNewPlayerRow hidden" type="button">Hide</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="md-form">
								<button class="btn blue lighten-1" type="submit">Update Team Information</button>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
				<!--/.Card-->
			</div>
			<div class="col-md mt-3">
				<a href="{{ route('league_teams.create') }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Team</a>
			</div>
		</div>
	</div>
@endsection