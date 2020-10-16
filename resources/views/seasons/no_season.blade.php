@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">
	
		<div class="row view">
			
			<div class="d-flex align-items-center justify-content-center flex-column col-12 col-lg-8 mx-auto">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
				</div>

				<div class="coolText4 py-3 px-5">
					<h1 class="h1-responsive text-justify">It doesn't look like you have any active seasons going for your league right now. Let'e get started by creating a new season. Click <a href="/home?new_season">here</a> to create a new season.</h1>
				</div>
			</div>
		</div>
	</div>
@endsection
