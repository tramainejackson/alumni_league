@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md" id="">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_schedule.index', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->season . ' ' . $activeSeason->year }}</a>
					@endforeach
				@else
				@endif
			</div>
			<div class="col-12 col-md-8">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				@if($seasonScheduleWeeks->get()->isNotEmpty())
					@foreach($seasonScheduleWeeks->get() as $showWeekInfo)
						<div class='leagues_schedule'>
							<h2 class="">{{ $showWeekInfo->season_week }}</h2>
							<table id='week_{{ $showWeekInfo->season_week }}_schedule' class='weekly_schedule table table-responsive'>
								<thead>
									<tr>
										<th class="text-center" colspan="3">Match-Up</th>
										<th>Time</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									@foreach($seasonWeekGames->getWeekGames($showWeekInfo->season_week)->get() as $game)
										<tr>
											<td>{{ $game->away_team }}</td>
											<td>vs</td>
											<td>{{ $game->home_team }}</td>
											<td>{{ $game->game_time }}</td>
											<td>{{ $game->game_date }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endforeach
				@else
					<div class="text-center">
						<p class="">There are no stats for the selected season</p>
					</div>
				@endif
			</div>
			<div class="col-md"></div>
		</div>
	</div>
@endsection