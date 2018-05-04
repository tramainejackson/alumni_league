@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md" id="">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_standings', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->season . ' ' . $activeSeason->year }}</a>
					@endforeach
				@else
				@endif
			</div>
			<div class="col-12 col-md-8">
				@if($showSeason)
					<div class="text-center coolText1">
						<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
					</div>
				@else
					<h1 class="h1-responsive">Sorry We Were Unable To Find Any Standings For This Season</h1>
				@endif

				@if($standings != null && $standings->isNotEmpty())
					<div id="league_standings">
						<table id="league_standings_table" class="table text-center table-striped">
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
										<td>{{ $showStandings->team_wins }}</td>
										<td>{{ $showStandings->team_losses }}</td>
										<td>{{ $showStandings->team_forfeits }}</td>
										<td>{{ $showStandings->winPERC }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@else
					<div class="text-center">
						<p class="">There are no standings for the selected season</p>
					</div>
				@endif
			</div>
			<div class="col-md"></div>
		</div>
	</div>
@endsection
