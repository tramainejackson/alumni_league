@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
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
										<a href="{{ route('league_pictures.edit', ['league_picture' => $picture->id]) }}" class="btn btn-rounded blue white-text">Edit Description</a>
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
	</div>
@endsection