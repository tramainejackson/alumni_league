@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<h1>League Header or Banner Spring 2016 Schedule</h1>
		@if($getWeeks->isNotEmpty())
			@foreach($getWeeks as $showWeekInfo)
				<div class='leagues_schedule'>
					<table id='week_{{ $showWeekInfo->season_week }}_schedule' class='weekly_schedule table table-responsive'>
						<thead>
							<tr>
								<th class="text-center" colspan="3">Match-Up</th>
								<th>Time</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							@foreach($getGames as $game)
								@if($showWeekInfo->season_week == $game->season_week)
									<tr>
										<td>{{ $game->away_team }}</td>
										<td>vs</td>
										<td>{{ $game->home_team }}</td>
										<td>{{ $game->game_time }}</td>
										<td>{{ $game->game_date }}</td>
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
			@endforeach
		@else
		@endif
	</div>
@endsection