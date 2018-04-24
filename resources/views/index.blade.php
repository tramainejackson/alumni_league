@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row align-items-stretch">
			<!--Column will include buttons for creating a new season-->
			<div class="col" id="">
				<button class="btn btn-lg btn-rounded blue white-text" type="button" href="" data-toggle="modal" data-target="#newSeasonForm">New Season</button>
			</div>
			<div class="col">
				<!-- Show league season(s) -->
				
			</div>
			<!--Column will include seasons (archieved and current)-->
			<div class="col">
				<h2 class="text-center h2-responsive">Archives</h2>
			</div>
		</div>
		
		<!--Showcase Games will probably be moved to schedule page-->
		<div class="row">
			<div class="col-md-8 mx-auto">
				@if($showcaseGame != null)
					<div id="match_ups">
						<div id="match_ups_headline" class="row">
							<h2>Upcoming Match-Up</h2>
							<p>Best Head to Head Match-Up For the Upcoming Week</p>
						</div>
						<div class="row">
							<div id="match_ups_information">
								<p id="game_location">&nbsp;Location:<?php echo $showcaseGame->game_location; ?></p>
								<p id="game_time">&nbsp;Date:<?php echo datetime_to_text($showcaseGame->game_date); ?></p>
								<p id="game_time">&nbsp;Time:<?php echo $showcaseGame->game_time; ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5">
								<h1 class=""><?php echo $showcaseGame->away_team; ?></h1>
							</div>
							<div id="versus" class="match_ups_div col-md-2">			
								<p>VS</p>
							</div>
							<div class="col-md-5">
								<h1 class=""><?php echo $showcaseGame->home_team; ?></h1>
							</div>
						</div>
						<div class="row">
							<div id="contender_1" class="contenders match_ups_div col-md-6">
								<div class="row">
									<div class="col-md-4">
										<img src="../../uploads/emptyface.jpg" class="" />
									</div>
									<div class="col-md-8">
										<ul class="">
											<li class="">PPG:&nbsp;<?php echo $awayTeamLeader->PPG; ?></li>
											<li class="">APG:&nbsp;<?php echo $awayTeamLeader->APG; ?></li>
											<li class="">RPG:&nbsp;<?php echo $awayTeamLeader->RPG; ?></li>
											<li class="">SPG:&nbsp;<?php echo $awayTeamLeader->SPG; ?></li>
											<li class="">BPG:&nbsp;<?php echo $awayTeamLeader->BPG; ?></li>
										</ul>
									</div>
								</div>
							</div>
							<div id="contender_2" class="contenders match_ups_div col-md-6">
								<div class="row">
									<div class="col-md-4">
										<img src="../../uploads/emptyface.jpg" class="" />
									</div>
									<div class="col-md-8">
										<ul class="">
											<li class="">PPG:&nbsp;<?php echo $homeTeamLeader->PPG; ?></li>
											<li class="">APG:&nbsp;<?php echo $homeTeamLeader->APG; ?></li>
											<li class="">RPG:&nbsp;<?php echo $homeTeamLeader->RPG; ?></li>
											<li class="">SPG:&nbsp;<?php echo $homeTeamLeader->SPG; ?></li>
											<li class="">BPG:&nbsp;<?php echo $homeTeamLeader->BPG; ?></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
		
		<!--New Season Modal-->
		<div class="modal fade" id="newSeasonForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		@php $ageGroups = explode(' ', $league->age); @endphp
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
