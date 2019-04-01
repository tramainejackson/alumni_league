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
	@include('include.functions')
	
	<div class="container-fluid bgrd3">
		<div class="row align-items-stretch{{ $showSeason->league_profile ? '': ' view' }}">
			<!--Column will include buttons for creating a new season-->
			<div class="col py-3" id="">
				<div class="row">
					<div class="col">
						<button class="btn btn-lg btn-rounded blue white-text" type="button" data-toggle="modal" data-target="#newSeasonForm">New Season</button>
					</div>
					@if($activeSeasons->isNotEmpty())
						<div class="col d-none d-lg-block">
							@foreach($activeSeasons as $activeSeason)
								<a href="{{ route('home', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text d-block{{ $activeSeason->id == $showSeason->id ? ' lighten-2' : '' }}" type="button">{{ $activeSeason->name }}</a>
							@endforeach
						</div>
					@else
					@endif
				</div>
			</div>

			<div class="col-12 col-lg-7 pb-3{{ $showSeason->league_profile ? '': ' d-flex align-items-center justify-content-center' }}">
				@if(!isset($allComplete))
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
									{!! Form::open(['action' => ['LeagueSeasonController@update', $showSeason->league_profile->id, 'season' => $showSeason->id, 'year' => $showSeason->year], 'method' => 'PATCH', 'files' => true]) !!}
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
														@foreach($ageGroups as $ageGroup)
															<option value="{{ $ageGroup }}"{{ $ageGroup == $showSeason->age_group ? ' selected' : ''  }}>{{ ucwords(str_ireplace('_', ' ', $ageGroup)) }}</option>
														@endforeach
													</select>

													<label data-error="wrong" data-success="right" for="age_group" class="text-primary">Age Group</label>
												</div>

												<div class="col-12 col-md">
													<select class="mdb-select md-form" name="comp_group">
														<option value="blank" disabled>Select blah blah</option>
														@foreach($compGroups as $compGroup)
															<option value="{{ $compGroup }}"{{ $compGroup == $showSeason->comp_group ? ' selected' : ''  }}>{{ ucwords(str_ireplace('_', ' ', $compGroup)) }}</option>
														@endforeach
													</select>

													<label for="comp_group" class="text-primary">Competition Group</label>
												</div>

											</div>
											
											<div class="md-form">
												<button type="submit" class="btn btn-lg white-text green m-0" id="">Update League</button>
												<button type="button" class="btn btn-lg white-text cyan darken-2" id="" data-toggle="modal" data-target="#start_playoffs">Start Playoffs</button>
											</div>
										</div>
									{!! Form::close() !!}
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
											<h3 class="h3-responsive text-center p-4 blue-grey">Week&nbsp;{{ $upcomingGame->season_week }}</h3>
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
						<h1 class="h1-responsive">Quick Teams</h1>
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
						<h1 class="h1-responsive">Quick Stats</h1>
						<a href="{{ request()->query() == null ? route('league_stat.index') : route('league_stat.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient fullCatLink">All Stats</a>
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
		
		<!--New Season Modal-->
		<div class="modal fade" id="newSeasonForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					{!! Form::open(['action' => 'LeagueSeasonController@store', 'method' => 'POST', 'name' => 'newSeasonForm']) !!}
						<div class="modal-header text-center">
							<h4 class="modal-title w-100 font-weight-bold">New Season</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body mx-3">
							<form name="newSeasonForm" class="">
								<div class="newSeasonInfo animated">
									<div class="row">
										<div class="col-12">
											<div class="md-form">
												<input type="text" class="form-control" id="season_name" value="{{ old('name') }}" placeholder="Add A Name For This Season" name="name" required />

												<label data-error="wrong" data-success="right" for="season" class="blue-text">Season</label>
											</div>
										</div>
										<div class="col-12 col-lg">
											<select class="mdb-select md-form" name="season" required>
												<option value="" disabled selected>Choose A Season</option>
												<option value="winter">Winter</option>
												<option value="spring">Spring</option>
												<option value="summer">Summer</option>
												<option value="fall">Fall</option>
											</select>

											<label data-error="wrong" data-success="right" for="season" class="blue-text">Season</label>
										</div>
										<div class="col-12 col-lg">
											<select class="mdb-select md-form" name="year" required>
												<option value="" disabled selected>Choose A Year</option>
												<option value="2018">2018</option>
												<option value="2019">2019</option>
												<option value="2020">2020</option>
												<option value="2021">2021</option>
											</select>

											<label data-error="wrong" data-success="right" for="season" class="blue-text">Year</label>
										</div>
									</div>
									
									<div class="row">
										<div class="col-12 col-lg">
											<div class="md-form input-group">
												<div class="input-group-prepend">
													<span class="input-group-text md-addon"><i class="fas fa-dollar-sign" aria-hidden="true"></i></span>
												</div>

												<input type="number" name="league_fee" class="form-control" id="league_fee" value="{{ $showSeason->league_profile ? $showSeason->league_profile->leagues_fee == null ? '0.00' : $showSeason->leagues_fee == null ? '0.00' : $showSeason->leagues_fee : '0.00' }}" step="0.01" placeholder="League Entry Fee" required />
												
												<input type="number" name="league_id" class="hidden" value="{{ $showSeason->league_profile ? $showSeason->league_profile->id : $showSeason->id }}" hidden />
												
												<div class="input-group-prepend">
													<span class="input-group-text">Per Team</span>
												</div>
												
												<label for="leagues_fee">Entry Fee</label>
											</div>
										</div>

										<div class="col-12 col-lg">
											<div class="md-form input-group">
												<div class="input-group-prepend">
													<span class="input-group-text md-addon"><i class="fas fa-dollar-sign" aria-hidden="true"></i></span>
												</div>
												
												<input type="number" class="form-control" class="form-control" name="ref_fee" id="ref_fee" value="{{ $showSeason->league_profile ? $showSeason->league_profile->ref_fee == null ? '0.00' : $showSeason->ref_fee == null ? '0.00' : $showSeason->ref_fee : '0.00' }}" step="0.01" placeholder="League Referee Fee" required />
												
												<div class="input-group-prepend">
													<span class="input-group-text">Per Game</span>
												</div>
												
												<label for="ref_fee">Ref Fee</label>
											</div>
										</div>
									</div>

									<div class="row" id="">

										<div class="col-12">
											<select class="mdb-select md-form" name="age_group">
												@if(head($ageGroups) == '' || head($ageGroups) == null)
													<option value="blank" selected disabled>You do not have any age groups selected to choose from</option>
												@else
													@foreach($ageGroups as $ageGroup)
														<option value="{{ $ageGroup }}">{{ ucwords(str_ireplace('_', ' ', $ageGroup)) }}</option>
													@endforeach
												@endif
											</select>

											<label data-error="wrong" data-success="right" for="age_group" class="blue-text">Age Group</label>
										</div>

										<div class="col-12">
											<select class="mdb-select md-form" name="comp_group">
												@if(head($ageGroups) == '' || head($ageGroups) == null)
													<option value="blank" selected disabled>You do not have any competition groups selected to choose from</option>
												@else
													@foreach($compGroups as $compGroup)
														<option value="{{ $compGroup }}">{{ ucwords(str_ireplace('_', ' ', $compGroup)) }}</option>
													@endforeach
												@endif
											</select>

											<label data-error="wrong" data-success="right" for="comp_group" class="blue-text">Competition Group</label>
										</div>

										<div class="col-12" id="">
											<div class="md-form">
												<input type="text" name="location" class="form-control" value="{{ old('location') ? old('location') : $showSeason->league_profile ? $showSeason->league_profile->address : $showSeason->address }}" />

												<label data-error="wrong" data-success="right" for="age_group">Games Location</label>
											</div>
										</div>
									</div>
								</div>

								<div class="payPalCheckout coolText4 animated hidden">
									<div class="row mb-3">
										<div class="col-12">
											<h3 class="h3-responsive">To continue, select the PayPal checkout button. Each season is $100 and includes all features throughout the whole season. Your will be redirected to your new season once payment is accepted.</h3>
										</div>
									</div>
									<div class="row">
										<div class="col-12 text-center">
											<h4 class="h4-responsive">New Season For	
												<span class="payPalCheckoutSeason"></span>
											</h4>
										</div>
										<div class="col-6">
											<p class="text-underline mb-0">Season Name</p>
											<p class="payPalCheckoutSeasonName"></p>
										</div>
										<div class="col-6">
											<p class="text-underline mb-0">Season Location</p>
											<p class="payPalCheckoutSeasonLocation"></p>
										</div>
										<div class="col-6">
											<p class="text-underline mb-0">Season Levels</p>
											<p class="payPalCheckoutSeasonLevel"></p>
										</div>
										<div class="col-6">
											<p class="text-underline mb-0">Season Cost</p>
											<p class="payPalCheckoutSeasonCost"></p>
										</div>
									</div>
								</div>
							</form>
						</div>
						

						<div class="modal-footer d-flex justify-content-center">
							<button type="button" class="btn btn-deep-orange addSeasonBtn animated">Add Season</button>
							
							<div class="payPalCheckoutBtn animated hidden">
								<script src="https://www.paypalobjects.com/api/checkout.js"></script>

								<div id="paypal-button"></div>

								<script>
									paypal.Button.render({

										env: 'sandbox', // sandbox | production

										style: {
											size: 'medium',
											color: 'blue',
											shape: 'pill',
											label: 'checkout',
											tagline: 'true'
										},
										
										client: {
											sandbox:    'AZri7zmZvEDIt-EyO1A1kfvDzygfGcuOjVdowBT1pqqmuZFDhkKq9HG2HSMlkzo5ibNUBFf3-3GsuiGu',
											production: 'AS7p39CJ_I30Af236rVzKtkoq2LzJw5ZMJnFwcuPOXUVWwehJ7OJscCl43jknJB_sdjBqNVbTUYexfIN'
										},

										payment: function(data, actions) {
											return actions.payment.create({
												payment: {
													transactions: [{
														amount: { 
															total: '100.00', 
															currency: 'USD' 
														}
													}]
												}
											});
										},

										// Wait for the payment to be authorized by the customer

										onAuthorize: function(data, actions) {
										  return actions.payment.execute()
											.then(function () {
												$.ajax({
												  method: "POST",
												  url: "league_season",
												  data: $('form[name="newSeasonForm"]').serialize()
												})
												
												.fail(function() {	
													alert("Fail");
												})
												
												.done(function(data) {
													var returnData = data;

													toastr.success(returnData[1], 'Successful');
													
													setTimeout(function() {
														window.open('/home?season=' + returnData[0] + '&year=' + $('.newSeasonInfo select[name="year"]').val(), '_self');
													}, 2000);
												});
											});
										},
										
										onCancel: function (data, actions) {
											// Show a cancel page or return to cart
											alert("Cancel");
										},

										onError: function (err) {
											// Show an error page here, when an error occurs
											alert("Error");
										}
										
									}, '#paypal-button');

								</script>
							</div>								
						</div>
						
					{!! Form::close() !!}
				</div>
			</div>
		</div>
		
		<!-- Complete season and start playoffs modal -->
		<div class="modal fade" id="start_playoffs" tabindex="-1" role="dialog" aria-labelledby="startPlayoffs" aria-hidden="true" data-backdrop="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="">Start Playoffs</h1>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="red-text">**Starting the playoffs will complete your season for you and generate a playoff schedule based on the current standings. This cannot be reversed once accepted**</p>
						
						<h2 class="h2-responsive my-5">Are you sure you want to start this seasons playoffs?</h2>
						
						<div class="d-flex align-items-center justify-content-between">
							<button class="btn btn-lg green" type="button" onclick="event.preventDefault(); document.getElementById('create_playoff_form').submit();">Yes</button>
								{!! Form::open(['action' => ['LeagueSeasonController@create_playoffs', 'season' => $showSeason->id, 'year' => $showSeason->year], 'id' => 'create_playoff_form', 'method' => 'POST']) !!}
								{!! Form::close() !!}
							<button class="btn btn-lg btn-warning" type="button" data-dismiss="modal" aria-label="Close">No</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		@if(session()->has('testdrive'))
			@if(session()->get('testdrive') == 'true')

				<!-- Test Drive Tutorial Modal -->
				<div id="test_drive_tutorial" class="container position-fixed white rounded z-depth-2 w-25 p-3 animated bounceInDown" style="top:10px; right:10px;">
					<div class="row" id="">
						<div class="col">
							<h4 class="w-100" id="">ToTheRec Leagues Test Drive</h4>
						</div>
						<div class="col-12">
							<p>Thanks for taking a test drive. We\'ll walk you through everything that you need to know about hosting your own league and multiple seasons with ToTheRec</p>
							<div class="d-flex align-items-center justify-content-between">
								<button class="btn btn-outline-amber nextBtn step1">Next</button>
								<button class="btn btn-outline-red removeTestDrive" data-dismiss="modal" aria-label="Close">Cancel</button>
							</div>
						</div>
					</div>
				</div>

			@endif
		@endif
	</div>
@endsection
