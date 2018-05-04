@extends('layouts.app')

@section('content')
	@include('include.functions')
	
	<div class="container-fluid">
		<div class="row align-items-stretch">
			<!--Column will include buttons for creating a new season-->
			<div class="col py-3" id="">
				<div class="row">
					<div class="col">
						<button class="btn btn-lg btn-rounded blue white-text" type="button" data-toggle="modal" data-target="#newSeasonForm">New Season</button>
					</div>
					<div class="col">
						@if($activeSeasons->isNotEmpty())
							@foreach($activeSeasons as $activeSeason)
								<a href="{{ route('home', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->season . ' ' . $activeSeason->year }}</a>
							@endforeach
						@else
						@endif
					</div>
				</div>
			</div>
			<div class="col-7 pb-3">
				<!-- Show league season info -->
				@if($showSeason != null)
					<div class="text-center coolText1">
						<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
					</div>
					
					<!-- League season info -->
					<div class="">
						{!! Form::open(['action' => ['LeagueProfileController@update', $showSeason->league_profile->id], 'method' => 'PATCH', 'files' => true]) !!}
							<div class="updateLeagueForm">
								<div class="md-form">
									<input type="text" name="leagues_address" class="form-control" id="leagues_address" placeholder="Address" value="{{ $showSeason->address }}" />

									<label for="leagues_address">Address</label>
								</div>
								
								<div class="row">
									<div class="col">
										<div class="md-form input-group">
											<div class="input-group-prepend">
												<i class="fa fa-dollar input-group-text" aria-hidden="true"></i>
											</div>
											
											<input type="number" name="leagues_fee" class="form-control" id="league_fee" value="{{ $showSeason->league_profile->leagues_fee }}"  step="0.01" />
											
											<div class="input-group-prepend">
												<span class="input-group-text">Per Team</span>
											</div>
											
											<label for="leagues_fee">Entry Fee</label>
										</div>
									</div>
									
									<div class="col">
										<div class="md-form input-group mb-5">
											<div class="input-group-prepend">
												<i class="fa fa-dollar input-group-text" aria-hidden="true"></i>
											</div>
											
											<input type="number" class="form-control" class="form-control" name="ref_fee" id="ref_fee" value="{{ $showSeason->league_profile->ref_fee }}" step="0.01" />
											
											<div class="input-group-prepend">
												<span class="input-group-text">Per Game</span>
											</div>
											
											<label for="ref_fee">Ref Fee</label>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col">
										<div class="md-form">
											<select class="mdb-select" name="age_group">
												@foreach($ageGroups as $ageGroup)
													<option value="{{ $ageGroup }}"{{ $ageGroup == $showSeason->age_group ? ' selected' : ''  }}>{{ ucwords(str_ireplace('_', ' ', $ageGroup)) }}</option>
												@endforeach
											</select>
											
											<label data-error="wrong" data-success="right" for="age_group" class="blue-text">Age Group</label>
										</div>
									</div>
									<div class="col">
										<div class="md-form">
											<select class="mdb-select" name="comp_group">
												@foreach($compGroups as $compGroup)
													<option value="{{ $compGroup }}"{{ $compGroup == $showSeason->comp_group ? ' selected' : ''  }}>{{ ucwords(str_ireplace('_', ' ', $compGroup)) }}</option>
												@endforeach
											</select>
											
											<label data-error="wrong" data-success="right" for="age_group" class="blue-text">Competition Group</label>
										</div>
									</div>
								</div>
								
								<div class="md-form">
									<button type="submit" class="btn btn-lg green m-0" id="">Update League</button>
									<button type="button" class="btn btn-lg orange" id="" data-toggle="modal" data-target="#start_playoffs">Start Playoffs</button>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
					<!--./ League season info /.-->
					
				@else
					<div class="coolText4 py-3 px-5">
						<h1 class="h1-responsive text-justify">Welcome to ToTheRec Leagues home page. Here you will be able to see your schedule, stats, and information for the selected season at a glance.<br/><br/>It doesn't look like you have any active seasons going for your league right now. Let'e get started by creating a new season. Click <a href="#" class="" type="button" data-toggle="modal" data-target="#newSeasonForm">here</a> to create a new season.</h1>
					</div>
				@endif
			</div>
			
			<!--Column will include seasons (archieved and current)-->
			<div class="col py-3">
				<!--Show completed season if any available-->
				<h2 class="text-center h2-responsive">Completed Seasons</h2>
				
				@if($completedSeasons->isNotEmpty())
					@foreach($completedSeasons as $completedSeason)
						<div class="text-center">
							<a href="#" class="">{{ ucfirst($completedSeason->season) . ' ' . $completedSeason->year }}</a>
						</div>
					@endforeach
				@else
					<div class="text-center">
						<h4 class="h4-responsive">You do not currently have any completed season in the archives</h4>
					</div>
				@endif
			</div>
		</div>
		<div class="row">
			<!-- League season schedule snap shot -->
			<div class="col-8 mx-auto my-5">
				<div class="my-5 d-flex align-items-center justify-content-center flex-column">
					<div class="d-flex w-100 justify-content-center align-items-center">
						<h1 class="h1-responsive">Upcoming Schedule</h1>
						<a href="{{ request()->query() == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient position-absolute m-0" style="right:0px;">Full Schedule</a>
					</div>
					
					<div class="">
						@if($showSeasonSchedule->isNotEmpty())
							@foreach($showSeasonSchedule as $upcomingGame)
								<div class="card">
									<div class="card-body">
										<p class="">{{ $upcomingGame->home_team }}</p>
										<p class="">vs</p>
										<p class="">{{ $upcomingGame->home_team }}</p>
									</div>
								</div>
							@endforeach
						@else
							<h3 class="h3-responsive">No upcoming games within the next week on this seasons schedule</h3>
						@endif
					</div>
				</div>
			</div>
			<!--./ League season schedule snap shot /.-->
			
			<!-- League season stats snap shot -->
			<div class="col-8 mx-auto my-5">
				<div class="d-flex w-100 justify-content-center align-items-center">
					<h1 class="h1-responsive">Quick Stats</h1>
					<a href="{{ request()->query() == null ? route('league_stat.index') : route('league_stat.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-sm blue-gradient position-absolute m-0" style="right:0px;">All Stats</a>
				</div>
				<div class="my-5 d-flex align-items-center justify-content-around">
					<!-- Season stat leaders by category -->
					@if($showSeasonStat->get()->isNotEmpty())
						<!-- Get the scoring leaders -->
						<div class="blue-gradient">
							<table class="table white-text">
								<thead>
									<tr>
										<th>Team</th>
										<th>Player</th>
										<th>PPG</th>
									</tr>
								</thead>
								<tbody>
									@foreach($showSeasonStat->scoringLeaders(5)->get() as $playerStat)
										<tr class="white-text">
											<td>{{ $playerStat->team_name }}</td>
											<td>{{ $playerStat->player_name }}</td>
											<td>{{ $playerStat->PPG != null ? $playerStat->PPG : 'N/A' }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						
						<!-- Get the rebounding leaders -->
						<div class="blue-gradient">
							<table class="table white-text">
								<thead>
									<tr>
										<th>Team</th>
										<th>Player</th>
										<th>RPG</th>
									</tr>
								</thead>
								<tbody>
									@foreach($showSeasonStat->reboundingLeaders(5)->get() as $playerStat)
										<tr class="white-text">
											<td>{{ $playerStat->team_name }}</td>
											<td>{{ $playerStat->player_name }}</td>
											<td>{{ $playerStat->RPG != null ? $playerStat->RPG : 'N/A' }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						
						<!-- Get the assisting leaders -->
						<div class="blue-gradient">
							<table class="table white-text">
								<thead>
									<tr>
										<th>Team</th>
										<th>Player</th>
										<th>APG</th>
									</tr>
								</thead>
								<tbody>
									@foreach($showSeasonStat->assistingLeaders(5)->get() as $playerStat)
										<tr class="white-text">
											<td>{{ $playerStat->team_name }}</td>
											<td>{{ $playerStat->player_name }}</td>
											<td>{{ $playerStat->APG != null ? $playerStat->APG : 'N/A' }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						
						<!-- Get the stealing leaders -->
						<div class="blue-gradient">
							<table class="table white-text">
								<thead>
									<tr>
										<th>Team</th>
										<th>Player</th>
										<th>SPG</th>
									</tr>
								</thead>
								<tbody>
									@foreach($showSeasonStat->stealingLeaders(5)->get() as $playerStat)
										<tr class="white-text">
											<td>{{ $playerStat->team_name }}</td>
											<td>{{ $playerStat->player_name }}</td>
											<td>{{ $playerStat->SPG != null ? $playerStat->SPG : 'N/A' }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						
						<!-- Get the blocking leaders -->
						<div class="blue-gradient">
							<table class="table white-text">
								<thead>
									<tr>
										<th>Team</th>
										<th>Player</th>
										<th>BPG</th>
									</tr>
								</thead>
								<tbody>
									@foreach($showSeasonStat->blockingLeaders(5)->get() as $playerBlocks)
										<tr class="white-text">
											<td>{{ $playerBlocks->team_name }}</td>
											<td>{{ $playerBlocks->player_name }}</td>
											<td>{{ $playerBlocks->BPG != null ? $playerBlocks->BPG : 'N/A' }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@else
						<h3 class="h3-responsive">There are no stats added for this league yet</h3>
					@endif
				</div>
			</div>
			<!--./ League season stats snap shot /.-->
			
			<!-- League season standings -->
			<div class="">
				
			</div>
			<!--./ League season standings /.-->
		</div>
		
		<!--New Season Modal-->
		<div class="modal fade" id="newSeasonForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					{!! Form::open(['action' => ['LeagueSeasonController@store', 'league' => $showSeason->league_profile->id], 'method' => 'POST']) !!}
						<div class="modal-header text-center">
							<h4 class="modal-title w-100 font-weight-bold">New Season</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body mx-3">
							<div class="row">
								<div class="col-6">
									<div class="md-form">
										<select class="mdb-select" name="season">
											<option value="" disabled selected>Choose A Season</option>
											<option value="winter">Winter</option>
											<option value="spring">Spring</option>
											<option value="summer">Summer</option>
											<option value="fall">Fall</option>
										</select>

										<label data-error="wrong" data-success="right" for="season" class="blue-text">Season</label>
									</div>
								</div>
								<div class="col-6">
									<div class="md-form">
										<select class="mdb-select" name="year">
											<option value="" disabled selected>Choose A Year</option>
											<option value="2018">2018</option>
											<option value="2019">2019</option>
											<option value="2020">2020</option>
											<option value="2021">2021</option>
										</select>

										<label data-error="wrong" data-success="right" for="season" class="blue-text">Year</label>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col">
									<div class="md-form input-group">
										<div class="input-group-prepend">
											<i class="fa fa-dollar input-group-text" aria-hidden="true"></i>
										</div>
										
										<input type="number" name="league_fee" class="form-control" id="league_fee" value="{{ $showSeason->league_profile->leagues_fee }}"  step="0.01" />
										
										<div class="input-group-prepend">
											<span class="input-group-text">Per Team</span>
										</div>
										
										<label for="leagues_fee">Entry Fee</label>
									</div>
								</div>
								<div class="col">
									<div class="md-form input-group">
										<div class="input-group-prepend">
											<i class="fa fa-dollar input-group-text" aria-hidden="true"></i>
										</div>
										
										<input type="number" class="form-control" class="form-control" name="ref_fee" id="ref_fee" value="{{ $showSeason->league_profile->ref_fee }}" step="0.01" />
										
										<div class="input-group-prepend">
											<span class="input-group-text">Per Game</span>
										</div>
										
										<label for="ref_fee">Ref Fee</label>
									</div>
								</div>
							</div>

							<div class="md-form">
								<select class="mdb-select" name="age_group">
									@foreach($ageGroups as $ageGroup)
										<option value="{{ $ageGroup }}">{{ ucwords(str_ireplace('_', ' ', $ageGroup)) }}</option>
									@endforeach
								</select>
								
								<label data-error="wrong" data-success="right" for="age_group" class="blue-text">Age Group</label>
							</div>

							<div class="md-form">
								<select class="mdb-select" name="comp_group">
									@foreach($compGroups as $compGroup)
										<option value="{{ $compGroup }}">{{ ucwords(str_ireplace('_', ' ', $compGroup)) }}</option>
									@endforeach
								</select>
								
								<label data-error="wrong" data-success="right" for="age_group" class="blue-text">Competition Group</label>
							</div>
							
							<div class="md-form">
								<input type="text" name="location" class="form-control" value="{{ old('location') ? old('location') : $showSeason->league_profile->address }}" />
								
								<label data-error="wrong" data-success="right" for="age_group">Games Location</label>
							</div>
						</div>
						<div class="modal-footer d-flex justify-content-center">
							<button type="submit" class="btn btn-deep-orange">Add Season</button>
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
						
						<h2 class="">Are you sure you want to start this seasons playoffs?</h2>
						
						<div class="">
							<button class="btn btn-lg green" type="button">Yes</button>
							<button class="btn btn-lg red" type="button">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
