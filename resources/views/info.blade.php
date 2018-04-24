@extends('layouts.app')

@section('content')
	@include('include.functions')
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 mx-auto leagueContactInfo">
				{!! Form::open(['action' => ['LeagueProfileController@update', $league->id], 'method' => 'PATCH', 'files' => true]) !!}
					<div class="row">
						<div class="col-5 my-3 mx-auto">
							<div id="update_pic" class="card card-cascade mx-auto">
								<!--Card Image-->
									<div class="view" style="min-height: initial !important;">
										<img id="current_pic" class="card-img-top" src="{{ $league->leagues_picture != null ? asset($league->leagues_picture) : '/images/commissioner.jpg' }}">
									</div>
								<!--./Card Image/.-->
								
								<!--Card Body-->
									<div class="card-body">
										<!--Title-->
										<h1 class="card-title coolText1 text-center">{{ $league->leagues_name }}</h1>
									</div>
								<!--./Card Body/.-->
								
								<!--Card Footer/.-->
									<div class="card-footer grey">
										<div class="md-form">
											<div class="file-field">
												<div class="btn btn-primary btn-sm float-left">
													<span class="changeSpan">Change Photo</span>
													<input type="file" name="file" id="file">
												</div>
												<div class="file-path-wrapper">
													<input class="file-path validate" type="text" placeholder="Upload your file">
												</div>
											</div>
										</div>
									</div>
								<!--./Card Footer/.-->
							</div>
						</div>
					</div>
					<div class="updateLeagueForm">
						<div class="md-form">
							<input type="text" name="leagues_name" class="form-control" id="leagues_name" value="{{ $league->leagues_name }}" />
							
							<label for="leagues_name">League Name</label>
						</div>
						<div class="md-form">
							<input type="text" name="leagues_commish" class="form-control" id="leagues_commish" placeholder="Commissioner" value="{{ $league->commish }}" />

							<label for="leagues_commish">Commissioner</label>
						</div>
						<div class="md-form">
							<input type="text" name="leagues_address" class="form-control" id="leagues_address" placeholder="Address" value="{{ $league->address }}" />

							<label for="leagues_address">League Address</label>
						</div>
						<div class="md-form">
							<input type="text" name="leagues_phone" class="form-control" id="leagues_phone" placeholder="Phone" value="{{ $league->leagues_phone }}" />

							<label for="leagues_phone">League Phone</label>
						</div>
						<div class="md-form">
							<input type="text" name="leagues_email" class="form-control" id="leagues_email" value="{{ $league->leagues_email }}" />

							<label for="leagues_email">League Email</label>
						</div>
						<div class="md-form">
							<input type="text" name="leagues_website" class="form-control" id="leagues_website" value="{{ $league->leagues_website }}" />

							<label for="leagues_website">League Website</label>
						</div>
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
						<div class="md-form mb-5">
							@php $ages = find_all_ages(); @endphp
							@php $ageArray =  explode(" ", $league->age); @endphp
							<div class="row">
								@foreach($ages as $age)
									<div class="col-6 col-md-3">
										<button type="button" class="btn btn-lg gray mx-0 w-100 ageBtnSelect{{ in_array($age, $ageArray) ? ' blue ' : '' }}">{{ str_ireplace("_", " ", ucwords($age)) }}
											<input type="checkbox" class="hidden" name="age[]" value="{{ $age }}" hidden{{ in_array($age, $ageArray) ? ' checked ' : '' }}/>
										</button>
									</div>
								@endforeach
							</div>

							<label for="leagues_ages">League Ages</label>
						</div>
						<div class="md-form">
							@php $getComp = find_competitions(); @endphp
							@php $compArray =  explode(" ", $league->comp); @endphp
							<div class="row">
								@foreach($getComp as $comp)
									<div class="col-6 col-lg-3">
										<button class="btn btn-lg gray mx-0 w-100 compBtnSelect{{ in_array($comp, $compArray) ? ' orange' : '' }}" type="button">{{ str_ireplace("_", " ", ucwords($comp)) }}
											<input type="checkbox" class="hidden" name="leagues_comp[]" value="{{ $comp }}" hidden{{ in_array($comp, $compArray) ? ' checked ' : '' }}/>
										</button>
									</div>
								@endforeach
							</div>
							
							<label for="leagues_comp">League Competition</label>
						</div>
						<div class="md-form">
							<button type="submit" name="submit" class="btn btn-lg green m-0" id="" value="">Update League</button>
						</div>
					</div>
				{!! Form::close() !!}
				
				<!-- Dropdown button to show the league rules -->
				<button class="mb-4" id="league_rules_btn">SEE LEAGUE RULES</button>

			</div>
			<div class="col-12">
				<div id="leagues_rules">
					<h2>Leagues Rules</h2>
					<ul>
						<li>All teams must arrive 15 minutes before their scheduled game time.</li>
						<li>All players must wear their teams jersey. If a player does not have a jersey, that player will not be allowed to play.</li>
						<li>If teams aren't present 10 minutes after their scheduled game time they will be issued a forfeit.</li>
						<li>Ref fees will be collected at halftime of every game.</li>
						<li>After 5 fouls a player fouls out.</li>
						<li>20 minutes halves with a running clock except the last 2 minutes of each half.</li>
						<li>Each team has 4 timeouts per game.</li>
						<li>Each overtime period will be 3 minutes</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection
