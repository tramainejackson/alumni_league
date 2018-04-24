@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1>League Header or Banner</h1>
				<div id="league_standings">
					<table id="league_standings_table" class="table table-responsive">
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
			</div>
		</div>
	</div>
@endsection
