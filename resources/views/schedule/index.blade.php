@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md mt-3">
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
						@php $seasonWeekGames = $showSeason->games()->getWeekGames($showWeekInfo->season_week)->get() @endphp
						<div class='leagues_schedule text-center mb-5'>
							<h2 class="h2-responsive">Week {{ $showWeekInfo->season_week }} Games</h2>
							<table id='week_{{ $showWeekInfo->season_week }}_schedule' class='weekly_schedule table'>
								<thead>
									<tr class="indigo darken-3 white-text">
										<th class="text-center" colspan="3">Match-Up</th>
										<th>Time</th>
										<th>Date</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@if($seasonWeekGames->isEmpty())
										<tr>
											<th colspan="6" class="">NO GAMES SCHEDULED FOR THIS WEEK</th>
										</tr>
									@else
										@foreach($seasonWeekGames as $game)
											<tr>
												<td>{{ $game->away_team }}</td>
												<td>vs</td>
												<td>{{ $game->home_team }}</td>
												<td>{{ $game->game_time() }}</td>
												<td>{{ $game->game_date() }}</td>
												<td><button class="btn btn-primary btn-rounded btn-sm my-0" type="button">Edit Game</button></td>
											</tr>
										@endforeach
									@endif
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
			<div class="col-md mt-3">
				<a href="{{ route('league_schedule.create') }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Week</a>
				<a href="{{ route('league_schedule.create') }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Game</a>
			</div>
		</div>
	</div>
@endsection