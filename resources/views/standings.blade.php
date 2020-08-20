@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">
	
		<div class="row{{ $showSeason->league_profile && $standings->isNotEmpty() ? '' : ' view' }}">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md mt-3 d-none d-md-block" id="">
				<a href="{{ route('league_standings', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->name }}</a>
			</div>
			
			<div class="col-12 col-lg-8{{ $showSeason->league_profile && $standings->isNotEmpty() ? '' : ' d-flex align-items-center justify-content-center flex-column' }}">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
					
					@if($showSeason->is_playoffs == 'Y')
						<h1 class="display-4 coolText4">It's Playoff Time</h1>
					@endif
				</div>

				@if($standings != null && $standings->isNotEmpty())
					<div class="text-center coolText4 mt-3">
						<p class=""><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;Standings are not editable. They are automatically compiled from the games results&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></p>
					</div>
					<div id="league_standings">
						<table id="league_standings_table" class="table text-center table-striped table-responsive-sm table-secondary table-bordered ">
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
			</div>
			
			<div class="col-md"></div>
		</div>
	</div>
@endsection
