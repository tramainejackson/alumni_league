@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1>League Header or Banner</h1>
				<div id="league_standings">
					<table id="league_standings_table">
						<caption>Standings</caption>
						<tr>
							<th>Team Name</th>
							<th>Wins</th>
							<th>Losses</th>
							<th>Forfeits</th>
							<th>Win/Loss Pct.</th>
						</tr>
						<?php foreach($standings as $showStandings) { ?>
							<tr>
								<td><?php echo $showStandings->team_name; ?></td>
								<td><?php echo $showStandings->team_wins; ?></td>
								<td><?php echo $showStandings->team_losses; ?></td>
								<td><?php echo $showStandings->team_forfeits; ?></td>
								<td><?php echo $showStandings->winPERC; ?></td>
							</tr>
						<?php } ?>	
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
