@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1>League Header or Banner</h1>
				<div class='leagueContactInfo'>
					<table class='leagues_page_table'>
						<tr>
							<td><b>League Owner:</b></td>
							<td>{{ $league->leagues_commish }}</td>
						</tr>
						<tr>
							<td><b>Competition Level:</b></td>
							<td>{{ str_ireplace("_", "-", str_ireplace(" ", ", ", ucwords($league->leagues_comp))) }}</td>
						</tr>
						<tr>
							<td><b>Leagues Age:</b></td>
							<td>{{ str_ireplace("_", " ", str_ireplace(" ", ", ", ucwords($league->leagues_age))) }}</td>
						</tr>
						
						<tr>
							<td><b>Entry Fee:</b></td>
							<td>${{ $league->leagues_fee }}</td>
						</tr>
						
						<tr>
							<td><b>Ref Fees per/g:</b></td>
							<td>${{ $league->ref_fee }}</td>
						</tr>
					
						<tr>
							<td><b>More Info:</b></td>
							<td>{{ $league->leagues_phone }}</td>
						</tr>
						<tr>
							<td><b>League Address:</b></td>
							<td>{{ $league->leagues_address }}</td>
						</tr>
					</table>
				</div>
				
				<button id="league_rules_btn">SEE LEAGUE RULES</button>
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
