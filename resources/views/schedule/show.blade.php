@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md mt-3">
			</div>
			<div class="col-12 col-md-8">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				<div class="my-4">
					<h2 class="h2-responsive text-center">Delete Game</h2>
				</div>
				
				{!! Form::open(['action' => ['LeagueScheduleController@destroy', 'league_schedule' => $league_schedule->id], 'method' => 'DELETE']) !!}
				{!! Form::close() !!}
			</div>
			<div class="col-md mt-3">
			</div>
		</div>
	</div>
@endsection