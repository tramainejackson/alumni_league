@extends('layouts.app')

@section('content')
	@include('include.functions')

	<div class="container-fluid playerProfileContainer" style="background: black">
		<div class="row playerBio mb-5 mb-md-0">
			{!! Form::open(['action' => ['PlayerProfileController@update', $player->id], 'method' => 'PATCH', 'files' => true, 'class' => 'col-12']) !!}
				<div class="container-fluid">
					<div class="row align-items-center justify-content-center view">
						<div class="offset-md-1 col-12 col-md-3">
							<div id="update_pic" class="card card-cascade narrower">
								<!-- Card Image -->
								<div class="view overlay" style="min-height: initial !important;">
									<img class="mx-auto" id="current_pic" src="{{ $player->image ? $player->image : '/images/emptyface.jpg' }}" alt="Player Card Image">
								</div>

								<!-- Card body -->
								<div id="" class="card-body">
									<h2 class="card-title text-center">
										<span class="">{{ $player->firstname }}</span>
										<span class="">{{ $player->nickname != null ? $player->nickname : "" }}</span>
										<span class="">{{ $player->lastname != null ? $player->lastname : '' }}</span>
									</h2>
									
									<h3 id="player_height" class="text-center">
										<span class=""><b>Height:</b></span>
										<span class="text-muted">{{ $player->height != "" ? $player->height : "N/A" }}</span>
									</h3>
									
									<h3 id="player_height" class="text-center">
										<span class=""><b>Weight:</b></span>
										<span class="text-muted">{{ $player->weight > 0 ? $player->weight . " lbs" : "N/A" }}</span>
									</h3>
								</div>
								
								<!-- Card footer -->
								<div class="rounded-bottom mdb-color lighten-3 text-center">
									<div class="md-form my-3">
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
							</div>
						</div>
						<div class="offset-md-2 col-12 col-md-6 updatePlayerForm">
							<div class="row align-items-center justify-content-between">
								<div class="col-6">
									<h2 class="coolText2 white-text"><u>Player Bio</u></h2>
								</div>
								<div class="col-6 text-right">
									<button type="submit" id="editProfile_btn" class="btn btn-lg indigo mx-0 my-3" value="">Update Profile</button>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="md-form">
										<input type="text" name="firstname" class="white-text form-control" id="firstname" value="{{ old('firstname') ? old('firstname') : $player->firstname }}" />
										
										<label for="firstname">First Name:</label>
									</div>
									
									@if($errors->has('firstname'))
										<!-- Return error message for firstname -->
										<div class="returnError">
											<p class="red-text">{{ $errors->first('firstname') }}</p>
										</div>
									@endif
								</div>
								<div class="col">
									<div class="md-form">
										<input type="text" name="nickname" class="white-text form-control" id="nickname" value="{{ old('nickname') ? old('nickname') : $player->nickname }}" />

										<label for="nickname">Nickname:</label>
									</div>
									
									@if($errors->has('nickname'))
										<!-- Return error message for nickname -->
										<div class="returnError">
											<p class="red-text">{{ $errors->first(nickname) }}</p>
										</div>
									@endif
								</div>
								<div class="col">
									<div class="md-form">
										<input type="text" name="lastname" class="white-text form-control" id="lastname" value="{{ old('lastname') ? old('lastname') : $player->lastname }}" />
										
										<label for="lastname">Last Name:</label>
									</div>
									
									@if($errors->has('lastname'))
										<!-- Return error message for lastname -->
										<div class="returnError">
											<p class="red-text">{{ $errors->first('lastname') }}</p>
										</div>
									@endif
								</div>
							</div>
							
							<div class="md-form">
								<input type="text" name="email" class="white-text form-control" id="email" value="{{ old('email') ? old('email') : $player->user->email }}" />
								
								<label for="dob">Email:</label>
							</div>
							
							@if($errors->has('email'))
								<!-- Return error message for email -->
								<div class="returnError">
									<p class="red-text">{{ $errors->first('email') }}</p>
								</div>
							@endif
							
							<div class="md-form">
								<input type="text" name="dob" id="dob" class="white-text form-control datetimepicker" value="{{ $player->dob }}" />
								
								<label for="dob">Date of Birth:</label>
							</div>
							
							<div class="row">
								<div class="col">
									<div class="md-form">
										<input type="text" name="highschool" class="white-text form-control" id="highschool" value="{{ $player->highschool }}" />
										
										<label for="highschool">High School:</label>
									</div>
								</div>
								<div class="col">
									<div class="md-form">
										<input type="text" name="college" class="white-text form-control" id="college" value="{{ $player->college }}" />

										<label for="college">College:</label>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col">
									<div class="md-form">
										<input type="text" name="height" class="white-text form-control" id="height" value="{{ $player->height }}" />
										
										<label for="height">Height:</label>
									</div>
								</div>
								<div class="col">
									<div class="md-form">
										<input type="number" name="weight" class="white-text form-control" id="weight" value="{{ $player->weight }}" min="0" max="999"/>
										
										<label for="weight">Weight:</label>
									</div>
									
									@if($errors->has('weight'))
										<!-- Return error message for weight -->
										<div class="returnError">
											<p class="red-text">{{ $errors->first('weight') }}</p>
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>

			{!! Form::close() !!}
		</div>
		
		<!-- My player leagues -->
		<div class="row view playerLeagues mb-5 mb-md-0">
			<div class="myLeagues col-12">
				<div class="text-center coolText2 white-text">
					<h1 class="h1-responsive display-2">My Leagues</h1>
				</div>
				
				@if($leagues->isEmpty())
				<div class="linkLeague col-12 col-lg-4">
					<div class="">
						<div class="">
							<h2 class="">Add League</h2>
						</div>
						<div class="">
							<p class="">It looks like you've been added to a league that keeps stats and is associated with ToTheRec. Are you playing in any of the following leagues?</p>
						</div>
						<div class="linkLeagueOptions">
							<?php $checkLink = $checkLinks; ?>
							<?php $linkLeague = League_Profile::get_league_by_id($checkLink->get_league_id()); ?>
							<div class="linkLeagueOption">
								<span class="linkLeagueName"><b>League Name:</b> {{ $linkLeague->leagues_name }}</span>
								<button class="btn btn-success addLeague{{ $linkLeague->get_league_id() }}">Add</button>
								<button class="btn btn-danger declineLeague{{ $linkLeague->get_league_id() }}">Decline</button>
							</div>
						</div>
					</div>
				</div>
				@endif
				
				@if($leagues->isNotEmpty())
				<div class="indProfileLeagues">
					@foreach($leagues as $playerLeagueProfile)
					@php 
						$linkedLeague = $playerLeagueProfile->league_profile;
						$linkedPlayer = $playerLeagueProfile;
						$linkedPlayerTeam = $playerLeagueProfile->league_team;
						$getStandings = $linkedLeague->standings; 
						$getStats = \App\LeagueStat::get_formatted_stats($playerLeagueProfile->id);
					@endphp
					
					<!-- Rotating card -->
					<div class="card-wrapper mx-auto mx-md-0">
						<div id="card-1" class="card-rotating effect__click text-center h-100 w-100">
						
							<!-- Front Side -->
							<div class="face front">
								<!-- Image-->
								<div class="card-up">
									<img  class="card-img-top" src="https://mdbootstrap.com/img/Photos/Others/photo7.jpg" alt="Image with a photo of clouds.">
								</div>

								<!-- Content -->
								<div class="card-body white">
									<h1 class="coolText1 h1-responsive">{{ $linkedLeague->leagues_name }}</h1>
									<h3 class="">{{ $linkedLeague->commish }}</h3>
									<h3 class="">{{ $linkedLeague->address }}</h3>
									<h3 class=""><a href="#">{{ $linkedLeague->leagues_website }}</a></h3>
									<!-- Triggering button -->
									<a class="rotate-btn" data-card="card-1"><i class="fa fa-undo"></i> Click here to see league stats</a>
								</div>
							</div>
							<!--./ Front Side /.-->
							
							<!-- Back Side -->
							<div class="face back">
								<!-- Triggering button -->
								<div class="card-body white">
									<a class="rotate-btn" data-card="card-1"><i class="fa fa-undo"></i> Click here to see league info</a>
									<div class="d-flex flex-column flex-md-row align-items-center justify-content-around">
										<div id="view_standings" class="mr-2">
											<table class="table table-responsive table-sm table-striped" id="view_standings_table">
												<thead class="mdb-color darken-3">
													<tr class="text-white">
														<th>Team Name</th>
														<th>Wins</th>
														<th>Losses</th>
														<th>Forfeits</th>
														<th>Win Perc.</th>
														<th>Total Points</th>
													</tr>
												</thead>
												
												@if(empty($getStandings))
												<tr>
													<td colspan='5'>No standings to display yet.</td>
												</tr>
												
												@else
												<tbody>
													@foreach($getStandings as $showStanding)
													<tr class="linkStandingsTeam">
														<td>{{ $showStanding->team_name }}</td>
														<td>{{ $showStanding->team_wins != null ? $showStanding->team_wins : '0' }}</td>
														<td>{{ $showStanding->team_losses != null ? $showStanding->team_losses : '0' }}</td>
														<td>{{ $showStanding->team_forfeits != null ? $showStanding->team_forfeits : '0' }}</td>
														<td>{{ $showStanding->winPERC != null ? $showStanding->winPERC : "0.00" }}</td>
														<td>{{ $showStanding->team_points != null ? $showStanding->team_points : "TBD" }}</td>
													</tr>
													@endforeach
												</tbody>
												@endif
											</table>
										</div>
										<div class="indProfileLeaguesTeamStats ml-2">
											@if(!empty($getStats))
											<table class="table table-responsive table-sm table-striped" id="view_stats_table">
												<thead class="mdb-color darken-3">
													<tr class="text-white">
														<th class="" colspan='6'>Stats</th>
													</tr>
												<thead>
												<tbody>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="" colspan=''>PPG</th>
														<td class="" colspan='3'>{{ $getStats->PPG != null ? $getStats->PPG : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="">APG</th>
														<td class="" colspan='3'>{{ $getStats->APG != null ? $getStats->APG : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="">RPG</th>
														<td class="" colspan='3'>{{ $getStats->RPG != null ? $getStats->RPG : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="">SPG</th>
														<td class="" colspan='3'>{{ $getStats->SPG != null ? $getStats->SPG : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="">BPG</th>
														<td class="" colspan='3'>{{ $getStats->BPG != null ? $getStats->BPG : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="">Total PTS</th>
														<td class="" colspan='3'>{{ $getStats->TPTS != null ? $getStats->TPTS : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="">Total 3's</th>
														<td class="" colspan='3'>{{ $getStats->TTHR != null ? $getStats->TTHR : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="">Total AST</th>
														<td class="" colspan='3'>{{ $getStats->TASS != null ? $getStats->TASS : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="">Total RBD</th>
														<td class="" colspan='3'>{{ $getStats->TRBD != null ? $getStats->TRBD : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="">Total STL</th>
														<td class="" colspan='3'>{{ $getStats->TSTL != null ? $getStats->TSTL : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
													<tr class="">
														<th class="">&nbsp;</th>
														<th class="">Total BLK</th>
														<td class="" colspan='3'>{{ $getStats->TBLK != null ? $getStats->TBLK : '0' }}</td>
														<td class="">&nbsp;</td>
													</tr>
												</tbody>
											</table>
											
											@else
											<ul class="">
												<li class="">No player stats added</li>
											</ul>
											@endif
										</div>
									</div>
								</div>
							</div>
							<!--./ Back Side /.-->
							
						</div>
					</div>
					@endforeach
				</div>
				@endif
			</div>
		</div>			
		<!--/. My player leagues /.-->
		
		<!-- My player playgrounds -->
		<div class="row view playerPlaygrounds mb-5 mb-md-0" id="player_playgrounds" style="overflow:visible">
			<div class="myPlayground col-12">
				<div class="text-center coolText2 white-text mb-3">
					<h1 class="indProfileHeader h1-responsive display-2">My Playgrounds</h1>
				</div>
				
				{!! Form::open(['action' => ['PlayerProfileController@update_playgrounds', $player->id], 'method' => 'PATCH']) !!}
					<div class="myPlaygroundClass d-flex flex-column flex-lg-row align-items-center justify-content-between">
						<p class="white-text">List up to 3 of your top places to play for the best runs.</p>
						
						<div class="">
							<button type="button" class="btn btn-lg indigo addPlayground">Add Another Playground</button>
							<button type="submit" class="btn btn-lg green darken-3 white-text">Update Playgrounds</button>
						</div>
					</div>
					<div class="myPlaygroundClass">
						@if($player->playgrounds->isNotEmpty())
							<ol class="white-text myPlaygroundsList">
								<!-- Hidden default list item -->
								<li class="hidden defaultPlaygroundItem" hidden>
									<div class="row">
										<div class="col">
											<div class="md-form">
												<select class="" name="rec_name[]" id="select_rec" disabled>
													<option class="blank" value="" selected>------- Select A Rec -------</option>
													@foreach($recs as $rec)
														<option value="{{ str_ireplace(" ", "_", $rec->name) }}">{{ str_ireplace("_", " ", $rec->name) }}</option>
													@endforeach
												</select>
												
												<label for="rec_name" class="blue-text">Select A Location</label>
											</div>
										</div>
										<div class="col">
											<div class="md-form white-text">
												<select class="" name="day_name[]" id="select_day" disabled>
													<option class="blank" value="" selected>------- Select A Day -------</option>
													@foreach($days as $day)
														<option class="white-text" value="{{ $day->day_name }}">{{ $day->day_name }}</option>
													@endforeach
												</select>

												<label for="day_name" class="blue-text">Select A Day</label>
											</div>
										</div>
										<div class="col">
											<div class="md-form">
												<input type="text" name="time[]" class="timepicker form-control white-text" value="" style="padding: 12px 0px;" disabled />
												
												<label for="rec_name" class="white-text">Select A Time</label>
											</div>
										</div>
									</div>
								</li>
						
								@foreach($player->playgrounds as $myPlayground)
									@php
										$time = "";
										$timeArray = explode(':', $myPlayground->time);
										
										if($timeArray[0] > 12) {
											$time = ($timeArray[0] - 12) . ':' . $timeArray[1] . ' PM';
										} elseif($timeArray[0] == '0') {
											$time = '12:' . $timeArray[1] . ' AM';
										} elseif($timeArray[0] == '12') {
											$time = '12:' . $timeArray[1] . ' PM';
										} else {
											$time = $timeArray[0] . ':' . $timeArray[1] . ' AM';
										}
									@endphp
									<li class="">
										<div class="row">
											<div class="col">
												<div class="md-form">
													<select class="mdb-select" name="rec_name[]">
														<option class="blank" value="" selected>------- Select A Rec -------</option>
														@foreach($recs as $rec)
															<option value="{{ str_ireplace(" ", "_", $rec->name) }}"{{ str_ireplace(" ", "_", $rec->name) == $myPlayground->playground ? ' selected' : ''}}>{{ $rec->name }}</option>
														@endforeach
													</select>
													
													<label for="rec_name" class="blue-text">Select A Location</label>
												</div>
											</div>
											<div class="col">
												<div class="md-form white-text">
													<select class="mdb-select" name="day_name[]">
														<option class="blank" value="" selected>------- Select A Day -------</option>
														@foreach($days as $day)
															<option class="white-text" value="{{ $day->day_name }}"{{ $day->day_name == $myPlayground->day ? ' selected' : '' }}>{{ $day->day_name }}</option>
														@endforeach
													</select>

													<label for="day_name" class="blue-text">Select A Day</label>
												</div>
											</div>
											<div class="col">
												<div class="md-form">
													<input type="text" name="time[]" class="timepicker form-control white-text" value="{{ $time }}" style="padding: 12px 0px;" />
													
													<label for="rec_name" class="white-text">Select A Time</label>
												</div>
												
												<input type="text" name="playground_id[]" class="hidden" value="{{ $myPlayground->id }}" hidden />
											</div>
										</div>
									</li>
								@endforeach
							</ol>
						@else
							<ul class="">
								@for($i=0; $i < 3; $i++)
									<li class="row">
										<span class="myPlaygroundRank col-md-1">
											<select class="browser-default" name="" disabled>
												<option value="1"{{ $i == "0" ? " selected" : "" }}>1</option>
												<option value="2"{{ $i == "1" ? " selected" : "" }}>2</option>
												<option value="3"{{ $i == "2" ? " selected" : "" }}>3</option>
											</select>
										</span>
										<span class="myPlaygroundRank col-md-4">
											<select class="browser-default" name="rec_name[]">
												<option class="blank" value="" selected>------- Select A Rec -------</option>
												@foreach($recs as $rec)
													<option value="{{ str_ireplace(" ", "_", $rec->name) }}">{{ str_ireplace("_", " ", $rec->name) }}</option>
												@endforeach
											</select>
										</span>
										<span class="myPlaygroundRank col-md-4">
											<select class="browser-default" name="day_name[]">
												<option class="blank" value="">------- Select A Day -------</option>

												@foreach($days as $day)
													<option value="{{ $day->id }}">{{ $day->day_name }}</option>
												@endforeach
											</select>
										</span>
										<span class="myPlaygroundRank col-md-2">
											<input type="text" name="time_name[]" class="timepicker" value="" />
										</span>
									</li>
								@endfor
							</ul>
						@endif
					</div>
				{!! Form::close() !!}
			</div>
		</div>
		<!--./ My player playgrounds /.-->
		
		<!-- My Player Videos -->
		<div class="row view playerVideos pb-5 pb-md-0">
			<div class="col-12">
				<div class="text-center coolText2 white-text">
					<h1 class="indProfileHeader h1-responsive display-2">My Highlight Reel</h1>
				</div>
				<?php if(!empty($videos)) { ?>
					<?php if(isset($_GET["remove_video"])) { ?>
						<div class="deleteVids">
							<a id="addNewClips_icon" href="player_page.php?add_video=true" title="Add Video"></a>
							<a class="deleteClip" href="player_page.php?remove_video=true" title="Delete Video"></a>
							<div class="editClips_div">
								<form action="delete_video.php" method="post" enctype="multipart/form-data">
									<?php while($showVideo = mysqli_fetch_assoc($videos)) { ?>
										<div class="myVideo">
											<h2>Uploaded: <?php $date = date_create($showVideo["upload_date"]); echo date_format($date, "m/d/y"); ?><span class="myVideoID"><input type="checkbox" name="remove_video_id" class="" value="{{ $showVideo["upload_id"]; ?>" /></span></h2>
											<video class="currentVideo">
												<source src="{{ $showVideo["file"]; ?>" type="video/mp4">
												<source src="{{ $showVideo["file"]; ?>" type="video/ogg">
												<source src="{{ $showVideo["file"]; ?>">
												Your browser does not support the video tag.
											</video>
										</div>
									<?php } ?>
									<input type="submit" name="submit" id="updateVideo_btn" value="Remove Selected Videos"/>
								</form>
							</div>
						</div>
					<?php } elseif(isset($_GET["add_video"])) { ?>
						<div class="addVids">
							<a id="addNewClips_icon" href="player_page.php?add_video=true" title="Add Video"></a>
							<a class="deleteClip" href="player_page.php?remove_video=true" title="Delete Video"></a>
							<form action="video_upload.php" method="post" enctype="multipart/form-data">
								<div class="addVideoDiv">
									<span class="">Add New Video</span>
									<input type="file" name="file" class="" />
								</div>
								<input type="submit" name="submit" id="updateVideo_btn" value="Add New Video"/>
							</form>
						</div>
					<?php } else { ?>
						<div class="updateVids">
							<a id="addNewClips_icon" href="player_page.php?add_video=true" title="Add Video"></a>
							<a class="deleteClip" href="player_page.php?remove_video=true" title="Delete Video"></a>
							<div class="editClips_div">
								@foreach($videos as $showVideo)
									<div class="myVideo">
										<h2>Uploaded: <?php $date = date_create($showVideo["upload_date"]); echo date_format($date, "m/d/y"); ?><span class="myVideoID" hidden></span></h2>
										<video class="currentVideo">
											<source src="{{ $showVideo->file }}" type="video/mp4">
											<source src="{{ $showVideo->file }}" type="video/ogg">
											Your browser does not support the video tag.
										</video>
									</div>
								@endforeach
							</div>	
						</div>
					<?php } ?>
				<?php }	else { ?>
					<?php if(isset($_GET["add_video"])) { ?>
						<div class="addVids">
							<a id="addNewClips_icon" href="player_page.php?add_video=true" title="Add Video"></a>
							<form action="video_upload.php" method="post" enctype="multipart/form-data">
								<div class="addVideoDiv">
									<span class="">Add New Video</span>
									<input type="file" name="file" class="" />
								</div>
								<input type="submit" name="submit" id="updateVideo_btn" value="Add New Video"/>
							</form>
						</div>
					<?php }	else { ?>
						<div class="updateVids">
							<a id="addNewClips_icon" href="player_page.php?add_video=true" title="Add Video"></a>
							<div class="viewCurrent_clips">
								<div id="noVideos_message">
									<p>You currently do not have any videos added to your player profile.</p>
								</div>
							</div>
						</div>	
					<?php } ?>
				<?php }	 ?>
			</div>
		</div>
		<!--./ My Player Videos /.-->
	</div>
@endsection