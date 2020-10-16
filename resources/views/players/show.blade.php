@extends('layouts.app')

@section('content')
	@include('include.functions')
	
	<div class="playerDisplay">
		<div class="search_box">
			<input class="player_search" name="search" type="search" placeholder="Search Player"/>				
			<a class="addFilter" href="#">Search</a>
		</div>
		<div class="playerPageInfo" id="player_demographics">
			<div class="playerPagePic">
				<img id="playerPic" class="playerPic_class" src="../uploads/{{ $player->picture }}">
			</div>
			<div class="playerPageBioHeader">
				<h2 id="contact_header">{{ $player->nickname != "" ? $player->firstname . " \"". $player->nickname ."\" " . $player->lastname : $player->full_name() }}</h2>
				<h3 id="contact_header2" class="">{{ $player->height != "" ? "<span>Height: " . $player->height . "</span>" : "" . $player->weight > 0 ? "<span>Weight: " . $player->weight . " lbs.</span>" : "" }}</h3>
			</div>
			<div class="playerPageBio">
				<table>
						<tr>
							<td><b>High School:</b></td>
							<td>{{ $player->highschool != "" ? $player->highschool : "No HS Entered" }}</td>
						</tr>
						<tr>
							<td><b>College:</b></td>
							<td>{{ $player->college != "" ? $player->college : "No College Entered" }}</td>
						</tr>
						<tr>
							<td><b>Age:</b></td>
							<td>{{ $player->dob != 0 ? $player->get_player_age() : "No DOB Entered" }}</td>
						</tr>
						@if($player->show_email == "Y")
							<tr>
								<td><b>Email:</b></td>
								<td>{{ $player->email != "" ? $player->email : "No Email Address Entered" }}</td>
							</tr>
						@endif
				</table>
			</div>
		</div>
		@if($player->ttr_player == "Y")
			@php $playerLeaguesInfo = explode(";", $player->ttr_player_info); @endphp
			<div class="playerLeagues">
				@foreach($playerLeaguesInfo as $getLeaguesInfo)
					@if(!empty($getLeaguesInfo))
						@php $sepInfo = explode("_", $getLeaguesInfo); @endphp
						@php $leaguesID = str_ireplace("League", "", $sepInfo[0]); @endphp
						@php $leaguesPlayerID = str_ireplace("Player", "", $sepInfo[1]); @endphp
						@php $linkedLeague = !isset($sepInfo[2]) ? League_Profile::get_league_by_id($leaguesID) : ""; @endphp
						@php $linkedPlayer = !isset($sepInfo[2]) ? League_Player::get_ttr_player_by_id($leaguesID, $leaguesPlayerID) : ""; @endphp
						@php $linkedPlayerTeam = !isset($sepInfo[2]) ? League_Team::get_team_by_id($leaguesID, $linkedPlayer->get_leagues_teams_id()) : ""; @endphp

						@php // '$sepInfo[2]' indicates that a league was declined @endphp
						@if(!isset($sepInfo[2]))
							<div class="playerProfileLeaguesInfo">
								<h2 class="">Leagues I'm Playing In</h2>
								<div class="">
									<a href="#collapse_{{ str_ireplace(" ", "", strtolower($linkedLeague->leagues_name)) }}" class="indProfileLeaguesLink" data-toggle="collapse"><b>League:</b> {{ $linkedLeague->leagues_name }}</a>
								</div>
								<div id="collapse_{{ str_ireplace(" ", "", strtolower($linkedLeague->leagues_name)) }}" class="collapse">
									@php $getStandings = League_Standings::get_league_standings($linkedPlayer->get_league_id()); @endphp
									<div id="view_standings" class="playerProfileLeaguesTeamStandings">
										<table id="view_standings_table">
											<caption>Standings</caption>
											<tr>
												<th>Team Name</th>
												<th>Wins</th>
												<th>Losses</th>
												<th>Forfeits</th>
												<th>Win Perc.</th>
												<th>Total Points</th>
											</tr>
											@if(empty($getStandings))
												<tr>
													<td colspan='5'>No standings to display yet.</td>
												</tr>
											@else
												@if(is_array($getStandings))
													@foreach($getStandings as $showStanding)
														<tr class="{{ $showStanding->get_team_id() == $linkedPlayer->get_leagues_teams_id() ? 'linkStandingsTeam' : '' }}">
															<td>{{ $showStanding->team_name }}</td>
															<td>{{ $showStanding->team_wins != null ? $showStanding->team_wins : 0 }}</td>
															<td>{{ $showStanding->team_losses != null ? $showStanding->team_losses : 0 }}</td>
															<td>{{ $showStanding->team_forfeits != null ? $showStanding->team_forfeits : 0 }}</td>
															<td>{{ $showStanding->winPERC != null ? $showStanding->winPERC : "0.00" }}</td>
															<td>{{ $showStanding->team_points != null ? $showStanding->team_points : "TBD" }}</td>
														</tr>
													@endforeach
												@elseif(is_object($getStandings))
													@php $showStanding = $getStandings @endphp
													<tr class="{{ $showStanding->get_team_id() == $linkedPlayer->get_leagues_teams_id() ? 'linkStandingsTeam' : '' }}">
														<td>{{ $showStanding->team_name }}</td>
														<td>{{ $showStanding->team_wins != null ? $showStanding->team_wins : 0 }}</td>
														<td>{{ $showStanding->team_losses != null ? $showStanding->team_losses : 0 }}</td>
														<td>{{ $showStanding->team_forfeits != null ? $showStanding->team_forfeits : 0 }}</td>
														<td>{{ $showStanding->winPERC != null ? $showStanding->winPERC : "0.00" }}</td>
														<td>{{ $showStanding->team_points != null ? $showStanding->team_points : "TBD" }}</td>
													</tr>
												@endif
											@endif
										</table>
									</div>
									<div class="playerProfileLeaguesTeamStats">
										@php $getStats = League_Stats::get_player_stats_by_id($leaguesID, $leaguesPlayerID); @endphp
										@if(!empty($getStats))
											<table id="view_stats_table">
												<caption class="">#{{ $getStats->jersey_num }} Stats</caption>
												<tr>
													<th>PPG</th>
													<th>APG</th>
													<th>RPG</th>
													<th>SPG</th>
													<th>BPG</th>
													<th>PTS</th>
													<th>3's</th>
													<th>AST</th>
													<th>RBD</th>
													<th>STL</th>
													<th>BLK</th>
												</tr>
												<tr>
													<td>{{ $getStats->PPG != null ? $getStats->PPG : "0.00" }}</td>
													<td>{{ $getStats->APG != null ? $getStats->APG : "0.00" }}</td>
													<td>{{ $getStats->RPG != null ? $getStats->RPG : "0.00" }}</td>
													<td>{{ $getStats->SPG != null ? $getStats->SPG : "0.00" }}</td>
													<td>{{ $getStats->BPG != null ? $getStats->BPG : "0.00" }}</td>
													<td>{{ $getStats->TPTS != null ? $getStats->TPTS : "0" }}</td>
													<td>{{ $getStats->TTHR != null ? $getStats->TTHR : "0" }}</td>
													<td>{{ $getStats->TASS != null ? $getStats->TASS : "0" }}</td>
													<td>{{ $getStats->TRBD != null ? $getStats->TRBD : "0" }}</td>
													<td>{{ $getStats->TSTL != null ? $getStats->TSTL : "0" }}</td>
													<td>{{ $getStats->TBLK != null ? $getStats->TBLK : "0" }}</td>
												</tr>
											</table>
										@else
											<ul class="">
												<li class="">No player stats added</li>
											</ul>
										@endif
									</div>
									<div class="playerProfileLeaguesLink">
										<a href="{{ $linkedLeague->ttr_league_site }}" class="" target="_blank">Go To League Site</a>
									</div>
								</div>
							</div>
						@else
						@endif
					@endif
				@endforeach
			</div>
		@endif
		
		@if($player->player_playground != NULL || $player->player_playground != "")
			<div class="playerPlaygrounds">
				@php $playgrounds = explode("; ", $player->player_playground) @endphp
				<h2 class="">Here's where I catch my best games</h2>
				<ol class="">
					@for($ii=0; $ii < count($playgrounds); $ii++)
						@php $counter = $ii + 1; @endphp
						<li class="">{{ $counter . ". " . str_ireplace("_", " ", $playgrounds[$ii]) }}</li>
					@endfor
				</ol>
			</div>
		@endif
		<div class="playerPageVideos" id="player_videos">
			@php $getPlayerVideos = DB::table('videos')->where('player_id', $player->id)->get(); @endphp
			@if(!empty($getPlayerVideos))
				<div class="">
					<h2 class="playerPageVideosHeader">Highlights</h2>
					@foreach($getPlayerVideos as $showVideo)
						<div class="playerPageVideo ">
							<h2>Uploaded:<span class="myVideoID" hidden>{{ $showVideo->id }}</span></h2>
							<video class="currentVideo">
								<source src="{{ $showVideo->file }}" type="video/mp4">
								<source src="{{ $showVideo->file }}" type="video/ogg">
								Your browser does not support the video tag.
							</video>
						</div>
					@endforeach
				</div>
			@else
				<div class="">
					<h2 class="playerPageVideosNone">This Player Hasn't Decided To Showcase Their Skills Yet. No Highlights To Show</h2>
				</div>
			@endif
		</div>
	</div>
@endsection