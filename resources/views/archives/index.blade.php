@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row mt-4">
			<div class="col-12 col-xl-8 mx-auto">
				<h2 class="h2 h2-responsive">Here are a list of the completed seasons so far. Click on any season to see the past Champion, Standings, Teams and Stats</h2>
			</div>
		</div>
		<div class="row pb-5">
			@foreach($completedSeasons as $completedSeason)
				<div class="col-md-5 mt-5 pb-5">
					<div class="text-center pb-5">
						<a href="{{ route('archives_show', ['season' => $completedSeason->id]) }}" class="btn btn-rounded btn-lg purple white-text darken-2 d-block">
							<span class="text-underline">{{ ucfirst($completedSeason->name) }}</span>
							<br/>
							<span class="">{{ $completedSeason->season }}</span>
							<span class="">{{ $completedSeason->year }}</span>
						</a>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<!-- Footer -->
	@include('content_parts.footer')
	<!-- Footer -->
@endsection
