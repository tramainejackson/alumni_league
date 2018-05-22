@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		@if($showSeason->active == 'Y' && $showSeason->paid == 'Y')
			<div class="row">
				<!--Column will include buttons for creating a new season-->
				<div class="col-md mt-3">
					@if($activeSeasons->isNotEmpty())
						@foreach($activeSeasons as $activeSeason)
							<a href="{{ route('league_pictures.index', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->season . ' ' . $activeSeason->year }}</a>
						@endforeach
					@else
					@endif
				</div>
				<div class="col-12 col-md-8">
					<div class="text-center coolText1">
						<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
					</div>
					<div class="text-center coolText4">
						<h3 class="h3-responsive">League Pictures</h3>
						@if($seasonPictures->isNotEmpty())
							<h4 class="">Total: <span class="text-muted text-underline">{{ $seasonPictures->count() }}</span></h4>
						@endif
					</div>
					
					@if($seasonPictures->isNotEmpty())
						<div class="row">
							@foreach($seasonPictures as $picture)
								<div class="col-4 my-2">
									<div class="view overlay" style="min-height:initial !important;">
										<img alt="picture" src="{{ $picture->sm_photo() }}" class="img-fluid" />
										
										<div class="mask flex-center flex-column rgba-red-strong">
											<p class="coolText4 p-2">{{ $picture->description != null ? $picture->description : 'No Description' }}</p>
											<a href="{{ request()->query() == null ? route('league_pictures.edit', ['league_picture' => $picture->id]) : route('league_pictures.edit', ['league_picture' => $picture->id, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-rounded blue white-text">Edit Picture</a>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					@else
						<div class="mt-3">
							<h3 class="h3-responsive text-center">There are no pictures added for this season yet</h3>
						</div>
					@endif
				</div>

				<div class="col-md mt-3">
					<a href="{{ request()->query() == null ? route('league_pictures.create') : route('league_pictures.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Pictures</a>
				</div>
			</div>
		@else
			<div class="row">
				<div class="container my-5">
					<div class="row">
						<div class="col text-center coolText4">
							<h3 class="h3-responsive">League Pictures</h3>
							@if($seasonPictures->isNotEmpty())
								<h4 class="">Total: <span class="text-muted text-underline">{{ $seasonPictures->count() }}</span></h4>
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col">
							<h1 class="h1-responsive text-justify coolText4">Welcome to ToTheRec Leagues home page. Here you will be able to see your pictures for the selected season. You'll be able to upload pictures to showcase all the players from start to finish.<br/><br/>It doesn't look like you have any active seasons going for your league right now. Let'e get started by creating a new season. Click <a href="#" class="" type="button" data-toggle="modal" data-target="#newSeasonForm">here</a> to create a new season.</h1>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
@endsection