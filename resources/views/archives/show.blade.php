@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-11 col-md-10 col-xl-8 mx-auto">
				<div class="text-center coolText4 mt-3">
					<div class="text-center coolText1">
						<h1 class="display-3">{{ ucfirst($archiveSeason->name) }}</h1>
						<h3 class="h3-responsive">{{ ucfirst($archiveSeason->season) . ' ' . $archiveSeason->year }}</h3>
					</div>
				</div>
				
				<!-- Season ending Champion -->
				<div class="text-center coolText4 my-4">
					@if($archiveSeason->champion_id != null) 
						<h2 class="h2-responsive">This seasons Champion was {{ $archiveSeason->champion->team_name }}.</h2>
					@else
						<p class="">There was no Champion crowned for this season.</p>
					@endif
				</div>
				<!--/. Season ending Champion ./-->
				
				<!-- Season ending Champion Team Players -->
				<div class="">
					@php $archiveSeason->championCaptain = $archiveSeason->champion->players()->captain(); @endphp

					<div class="col-12 col-lg-10 mx-auto">
						<div class="card card-cascade wider my-4">
							<!-- Card image -->
							<div class="view overlay">
								<img class="card-img-top" src="{{ $archiveSeason->champion->team_picture != null ? $archiveSeason->champion->sm_photo() : $defaultImg }}" alt="Card image cap">
								<a href="#!">
									<div class="mask rgba-white-slight"></div>
								</a>
							</div>
							
							<!-- Card content -->
							<div class="card-body text-center position-relative">
								<!-- Title -->
								<h1 class="card-title h1-responsive font-weight-bold">{{ $archiveSeason->champion->team_name }}</h1>
								
								<table class="table table-hover table-striped table-responsive-sm" id="champion_team_table">
									<thead>
										<tr>
											<th class="text-nowrap">Players</th>
										</tr>
									</thead>
									<tbody>
										@if($archiveSeason->champion->players->isNotEmpty())
											@foreach($archiveSeason->champion->players as $player)
												<tr class="">
													<td class="">
														<p class="">{{ '#' .  $player->jersey_num . ' ' .  $player->player_name }}</p>
													</td>
												</tr>
											@endforeach
										@else
											<tr class="">
												<th colspan="6" class="text-center">No Players Added for this team</th>
											</tr>
										@endif
										<tr class="newPlayerRow hidden" hidden>
											<td class="text-center">&nbsp;</td>
											<td class="">
												<input type="number" name="new_jers_num[]" class="form-control" value="" placeholder="Enter Jersey #" disabled />
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
					</div>
				</div>
				<!--/. Season ending Champion Team Players ./-->
				
				<hr/>
				
				<!-- Season ending standings -->
				<div class="text-center coolText4 my-4"> 
					<h2 class="h2-responsive">Season Final Standings</h2>
				</div>
				<div id="" class="table-wrapper">
					<table id="league_standings_table" class="table text-center table-striped table-fixed">
						<thead>
							<tr>
								<th>Team Name</th>
								<th>Wins</th>
								<th>Losses</th>
								<th>Forfeits</th>
								<th>Win/Loss Pct.</th>
							</tr>
						</thead>
						<tbody>
							@foreach($standings as $showStandings)
								<tr>
									<td>{{ $showStandings->team_name }}</td>
									<td>{{ $showStandings->team_wins == null ? '0' : $showStandings->team_wins }}</td>
									<td>{{ $showStandings->team_losses == null ? '0' : $showStandings->team_losses }}</td>
									<td>{{ $showStandings->team_forfeits == null ? '0' : $showStandings->team_forfeits }}</td>
									<td>{{ $showStandings->winPERC == null ? '0.00' : $showStandings->winPERC }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!--/. Season ending standings ./-->
				
				<hr/>
				
				<!-- Season ending player stats -->
				<div class="text-center coolText4 my-4"> 
					<h2 class="h2-responsive">Season Final Stats</h2>
				</div>
				<div class="table-wrapper" id="player_stats">
					<table class="table table-striped" id="player_stats_table">
						<thead>
							<tr>
								<th></th>
								<th>Total Points</th>
								<th>PPG</th>
								<th>3's</th>
								<th>3's PG</th>
								<th>FT</th>
								<th>FTPG</th>
								<th>Assists</th>
								<th>APG</th>
								<th>Rebounds</th>
								<th>RPG</th>
								<th>Steals</th>
								<th>SPG</th>
								<th>Blocks</th>
								<th>BPG</th>
							</tr>
						</thead>
						<tbody>
							@foreach($playersStats->get() as $showPlayer)
								<tr data-toggle="modal" data-target="#player_card" class="text-center">
									<td class='playerNameTD text-nowrap'>#{{ $showPlayer->player->jersey_num . ' ' . $showPlayer->player->player_name }}</td>
									<td class='totalPointsTD'>{{ $showPlayer->TPTS == null ? 0 : $showPlayer->TPTS }}</td>
									<td class='pointsPGTD'>{{ $showPlayer->PPG == null ? 0 : $showPlayer->PPG }}</td>
									<td class='totalThreesTD'>{{ $showPlayer->TTHR == null ? 0 : $showPlayer->TTHR }}</td>
									<td class='threesPGTD'>{{ $showPlayer->TPG == null ? 0 : $showPlayer->TPG }}</td>
									<td class='totalFTTD'>{{ $showPlayer->TFTS == null ? 0 : $showPlayer->TFTS }}</td>
									<td class='freeThrowsPGTD'>{{ $showPlayer->FTPG == null ? 0 : $showPlayer->FTPG }}</td>
									<td class='totalAssTD'>{{ $showPlayer->TASS == null ? 0 : $showPlayer->TASS }}</td>
									<td class='assistPGTD'>{{ $showPlayer->APG == null ? 0 : $showPlayer->APG }}</td>
									<td class='totalRebTD'>{{ $showPlayer->TRBD == null ? 0 : $showPlayer->TRBD }}</td>
									<td class='rebPGTD'>{{ $showPlayer->RPG == null ? 0 : $showPlayer->RPG }}</td>
									<td class='totalStealsTD'>{{ $showPlayer->TSTL == null ? 0 : $showPlayer->TSTL }}</td>
									<td class='stealsPGTD'>{{ $showPlayer->SPG == null ? 0 : $showPlayer->SPG }}</td>
									<td class='totalBlocksTD'>{{ $showPlayer->TBLK == null ? 0 : $showPlayer->TBLK }}</td>
									<td class='blocksPGTD'>{{ $showPlayer->BPG == null ? 0 : $showPlayer->BPG }}</td>
									<td class='teamNameTD' hidden>{{ $showPlayer->player->team_name }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!--/. Season ending player stats ./-->
			</div>
		</div>

		<hr>

		<div class="row mt-4 mb-5">
			<div class="col-12">
				<h2 class="text-center">Other Archived Seasons</h2>
			</div>

			@foreach($completedSeasons as $completedSeason)
				<div class="col-md-5 mt-3">
					<div class="text-center">
						<a href="{{ route('archives_show', ['season' => $completedSeason->id]) }}" class="btn btn-rounded btn-lg purple white-text darken-2 d-block">
							<span class="text-underline">{{ ucfirst($completedSeason->name) }}</span>
							<br/>
							<span class="">{{ $completedSeason->season }}</span>
							<span class="">{{ $completedSeason->year }}</span>
						</a>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<!-- Footer -->
	@include('content_parts.footer')
	<!-- Footer -->
@endsection
