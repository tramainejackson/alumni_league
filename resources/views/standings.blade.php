@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">
	
		<div class="row{{ $showSeason->league_profile && $standings->isNotEmpty() ? '' : ' view' }}">
			<!--Column will include buttons for creating a new season-->
			<div class="col col-lg-2 d-none d-lg-block mt-3" id="">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_standings', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn mw-100 mx-0 mx-auto btn-rounded deep-orange white-text{{ $activeSeason->id == $showSeason->id ? ' lighten-2' : '' }}" type="button">{{ $activeSeason->name }}</a>
					@endforeach
				@else
				@endif
			</div>
			
			<div class="col-12 col-lg-8 pt-3 d-flex justify-content-center flex-column">
				<div class="text-center coolText1">
					<div class="text-center p-4 card rgba-deep-orange-light white-text mb-3" id="">
						<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
					</div>
					
					@if($showSeason->is_playoffs == 'Y')
						<h1 class="display-4 coolText4">It's Playoff Time</h1>
					@endif
				</div>

				@if($standings != null && $standings->isNotEmpty())
					<div class="text-center coolText4 mt-3">
						<p class=""><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;Standings are not editable. They are automatically compiled from the games results&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></p>
					</div>

					<div id="league_standings">
						<table id="league_standings_table" class="table text-center table-striped table-responsive-sm table-dark table-bordered">
							<thead>
								<tr>
									<th class="font-weight-bold">Team Name</th>
									<th class="font-weight-bold">Wins</th>
									<th class="font-weight-bold">Losses</th>
									<th class="font-weight-bold">Forfeits</th>
									<th class="font-weight-bold">Win/Loss Pct.</th>
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
				@else
					<div class="text-center">
						<h1 class="h1-responsive coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;There are no standings for the selected season. Standings will be generated as teams are added.&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h1>
					</div>
				@endif

				@if($showSeason->has_conferences == 'Y' && $showSeason->conferences->isNotEmpty())
					@foreach($showSeason->conferences as $conference)
						@if($conference->teams->isNotEmpty())
							<div id="" class="league_conferences_standings">
								<table id="" class="table text-center table-striped table-responsive-sm table-secondary table-bordered league_conferences_table">
									<thead>
									<tr>
										<th class="font-weight-bold" colspan="3">{{ $conference->conference_name }}</th>
									</tr>
										<tr>
											<th class="font-weight-bold">Team Name</th>
											<th class="font-weight-bold">Wins</th>
											<th class="font-weight-bold">Losses</th>
										</tr>
									</thead>

									<tbody>
										@foreach($conference->teams as $showConferenceTeam)
											@php $showStandings = $showConferenceTeam->standings; @endphp

											<tr>
												<td>{{ $showStandings->team_name }}</td>
												<td>{{ $showStandings->team_wins == null ? '0' : $showStandings->team_wins }}</td>
												<td>{{ $showStandings->team_losses == null ? '0' : $showStandings->team_losses }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						@endif
					@endforeach
				@endif

				@if($showSeason->has_divisions == 'Y' && $showSeason->divisions->isNotEmpty())
					@foreach($showSeason->divisions as $division)
						@if($division->teams->isNotEmpty())
							<div id="" class="league_divisions_standings">
								<table id="" class="table text-center table-striped table-responsive-sm table-secondary table-bordered league_divisions_table">
									<thead>
										<tr>
											<th class="font-weight-bold" colspan="3">{{ $division->division_name }}</th>
										</tr>
										<tr>
											<th class="font-weight-bold">Team Name</th>
											<th class="font-weight-bold">Wins</th>
											<th class="font-weight-bold">Losses</th>
										</tr>
									</thead>

									<tbody>

										@foreach($division->teams as $showDivisionTeam)
											@php $showStandings = $showDivisionTeam->standings; @endphp

											<tr>
												<td>{{ $showStandings->team_name }}</td>
												<td>{{ $showStandings->team_wins == null ? '0' : $showStandings->team_wins }}</td>
												<td>{{ $showStandings->team_losses == null ? '0' : $showStandings->team_losses }}</td>
											</tr>
										@endforeach

									</tbody>
								</table>
							</div>
						@endif
					@endforeach
				@endif
			</div>
			
			<div class="col col-lg-2 text-center text-lg-right order-first order-lg-0"></div>
		</div>
	</div>
@endsection
