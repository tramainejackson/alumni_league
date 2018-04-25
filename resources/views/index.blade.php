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
								<button class="btn btn-lg btn-rounded deep-orange white-text" type="button" href="" data-toggle="modal" data-target="">{{ $activeSeason->season . ' ' . $activeSeason->year }}</button>
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
						{!! Form::open(['action' => ['LeagueProfileController@update', $league->id], 'method' => 'PATCH', 'files' => true]) !!}
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
											
											<input type="number" name="leagues_fee" class="form-control" id="league_fee" value="{{ $league->leagues_fee }}"  step="0.01" />
											
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
											
											<input type="number" class="form-control" class="form-control" name="ref_fee" id="ref_fee" value="{{ $league->ref_fee }}" step="0.01" />
											
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
								</div>
							</div>
						{!! Form::close() !!}
					</div>
					<!--./ League season info /.-->
					
					<!-- League season schedule snap shot -->
					<div class="my-5 d-flex align-items-center justify-content-center flex-column">
						<div class="d-flex w-100 justify-content-center align-items-center">
							<h1 class="h1-responsive">Upcoming Schedule</h1>
							<a href="#" class="btn btn-sm blue-gradient position-absolute m-0" style="right:0px;">Full Schedule</a>
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
					<!--./ League season schedule snap shot /.-->
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
		
		<!--New Season Modal-->
		<div class="modal fade" id="newSeasonForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					{!! Form::open(['action' => ['LeagueSeasonController@store', 'league' => $league->id], 'method' => 'POST']) !!}
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
										
										<input type="number" name="league_fee" class="form-control" id="league_fee" value="{{ $league->leagues_fee }}"  step="0.01" />
										
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
										
										<input type="number" class="form-control" class="form-control" name="ref_fee" id="ref_fee" value="{{ $league->ref_fee }}" step="0.01" />
										
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
								<input type="text" name="location" class="form-control" value="{{ old('location') ? old('location') : $league->address }}" />
								
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
	</div>
@endsection
