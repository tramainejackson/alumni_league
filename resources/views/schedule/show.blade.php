@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<div class="col mt-3"></div>
			
			<div class="col-12 col-lg-8">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				<div class="my-4">
					<div class="text-center mb-5">
						<h1 class="">Are you sure you want to delete this game?</h1>
						{!! Form::open(['action' => ['LeagueScheduleController@delete_game', 'league_schedule' => $league_schedule->id, 'season' => $showSeason->id, 'year' => $showSeason->year], 'method' => 'DELETE']) !!}
							<button class="btn red darken-2" type="submit">Delete Game</button>
						{!! Form::close() !!}
						
					</div>
					
					<div class="">
						<h2 class="h2-responsive text-center">Delete Game</h2>
						
						<div class="table-wrapper">
							<table class="table table-striped table-fixed text-center">
								<thead>
									<tr>
										<th>Away Team</th>
										<th>Home Team</th>
										<th><i class="fa fa-calendar mr-2" aria-hidden="true"></i>Date</th>
										<th><i class="fa fa-clock-o mr-2" aria-hidden="true"></i>Time</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{ $homeTeam->team_name }}</td>
										<td>{{ $awayTeam->team_name }}</td>
										<td>{{ $league_schedule->game_date() }}</td>
										<td>{{ $league_schedule->game_time() }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="">
					<div class="gameResults my-3">
						@if($result != null)
							<h2 class="h2-responsive mt-5">Game Result</h2>
							
							@if($result->game_complete == 'N')
								<p class="">There was no result for this game yet.</p>
							@else
								@if($result->forfeit == 'Y')
									@if($result->winning_team_id == $homeTeam->id)
										<p class="">{{ $homeTeam->team_name }} won by forfeit</p>
									@else
										<p class="">{{ $awayTeam->team_name }} won by forfeit</p>
									@endif
								@else
									@if($result->winning_team_id == $homeTeam->id)
										<p class="">{{ $homeTeam->team_name }} beat {{ $awayTeam->team_name }} {{ $result->home_team_score . ' - ' . $result->away_team_score }}</p>
									@else
										<p class="">{{ $awayTeam->team_name }} beat {{ $homeTeam->team_name }} {{ $result->away_team_score . ' - ' . $result->home_team_score  }}</p>
									@endif
								@endif
							@endif
						@endif
					</div>
					<div class="gameStats my-3">
						<h2 class="h2-responsive mt-5">Game Stats</h2>
						@if($allStats->isNotEmpty())
							<div class="table-wrapper">
								<table class="table table-striped table-fixed text-center">
									<thead>
										<tr>
											<th>Team Name</th>
											<th>Player name</th>
											<th>Points</th>
											<th>Assist</th>
											<th>Rebounds</th>
											<th>Steals</th>
											<th>Blocks</th>
										</tr>
									</thead>
									<tbody>
										@foreach($allStats as $playerStats)
											<tr>
												<td>{{ $playerStats->player->league_team->team_name }}</td>
												<td>#{{ $playerStats->player->jersey_num . ' ' . $playerStats->player->player_name }}</td>
												<td>{{ $playerStats->points != null ? $playerStats->points : '0'  }}</td>
												<td>{{ $playerStats->assist != null ? $playerStats->assist : '0' }}</td>
												<td>{{ $playerStats->rebounds != null ? $playerStats->rebounds : '0' }}</td>
												<td>{{ $playerStats->steals != null ? $playerStats->steals : '0' }}</td>
												<td>{{ $playerStats->blocks != null ? $playerStats->blocks : '0' }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						@else
							<h4 class="h4-responsive">No player stats for this game</h4>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md mt-3">
			</div>
		</div>
	</div>
@endsection