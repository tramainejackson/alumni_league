@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">
		<div class="row{{ $showSeason->league_profile && $seasonPictures->isNotEmpty() ? '' : ' view' }}">
			<!--Column will include buttons for creating a new season-->
			<div class="col col-lg-3 mt-3 d-none d-lg-block">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_pictures.index', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text d-block" type="button">{{ $activeSeason->name }}</a>
					@endforeach
				@else
				@endif
			</div>

			<div class="col-12 col-lg-7{{ $showSeason->league_profile && $seasonPictures->isNotEmpty() ? '' : ' d-flex align-items-center justify-content-center flex-column' }}">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
				</div>
				
				@if($seasonPictures->isNotEmpty())
					<div class="text-center coolText4">
						<h4 class="">Total: <span class="text-muted text-underline">{{ $seasonPictures->count() }}</span></h4>
					</div>
				

					<div class="row">
						@foreach($seasonPictures as $picture)
							<div class="col-12 col-lg-10 col-xl-4 my-2 mx-auto">
								<div class="view overlay" style="min-height:initial !important;">
									<img alt="picture" src="{{ $picture->sm_photo() }}" class="img-fluid mx-auto" />
									
									<div class="mask flex-center flex-column rgba-red-strong">
										<p class="coolText4 p-2">{{ $picture->description != null ? $picture->description : 'No Description' }}</p>
										<a href="{{ request()->query() == null ? route('league_pictures.edit', ['league_picture' => $picture->id]) : route('league_pictures.edit', ['league_picture' => $picture->id, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-rounded blue white-text">Edit Picture</a>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				@else
					<div class="text-center">
						<h1 class="h1-responsive coolText4"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;There are no pictures added for this season yet&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></h1>
					</div>
				@endif
			</div>

			<div class="col col-lg-2 mt-3 text-center order-first order-lg-0">
				<a href="{{ request()->query() == null ? route('league_pictures.create') : route('league_pictures.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text d-lg-block text-nowrap text-truncate text-center" type="button">Add New Pictures</a>
			</div>
		</div>
	</div>
@endsection