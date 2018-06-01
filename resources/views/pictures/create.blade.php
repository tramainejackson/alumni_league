@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col col-md d-none d-md-block mt-3 text-center">
				@if($activeSeasons->isNotEmpty())
					@foreach($activeSeasons as $activeSeason)
						<a href="{{ route('league_teams.create', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text d-block" type="button">{{ $activeSeason->name }}</a>
					@endforeach
				@else
				@endif
			</div>
			<div class="col-12 col-md-7 mx-auto">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
				</div>
				<div class="text-center coolText4">
					<h3 class="h3-responsive">League Pictures</h3>
					@if($seasonPictures->isNotEmpty())
						<h4 class="">Current Total: <span class="text-muted text-underline">{{ $seasonPictures->count() }}</span></h4>
					@endif
				</div>

				<!-- Create Form -->
				{!! Form::open(['action' => ['LeaguePictureController@store', 'season' => $showSeason->id, 'year' => $showSeason->year], 'method' => 'POST', 'files' => true]) !!}
					<div class="md-form">
						<div class="file-field">
							<div class="btn btn-primary btn-sm float-left">
								<span>Choose file</span>
								<input type="file" name="team_photo[]" multiple="multiple" />
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text" placeholder="Upload Up To 10 Pictures" />
							</div>
						</div>
					</div>
					
					@if($errors->has('team_photo'))
						<div class="md-form-errors red-text">
							<p class=""><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;{{ $errors->first('team_photo') }}</p>
						</div>
					@endif
					<div class="md-form text-center">
						<button type="submit" class="btn blue lighten-1">Upload Pictures</button>
					</div>
				{!! Form::close() !!}
			</div>
			<div class="col col-md mt-3 text-center order-first order-md-0">
				<a href="{{ request()->query() == null ? route('league_pictures.index') : route('league_pictures.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text d-block" type="button">All Pictures</a>
			</div>
		</div>
	</div>
@endsection