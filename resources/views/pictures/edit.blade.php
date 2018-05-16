@extends('layouts.app')

@section('content')
	<div class="container-fluid leagues_page_div">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md-3 mt-3"></div>
			<div class="col-12 col-md-4 mx-auto">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->season) . ' ' . $showSeason->year }}</h1>
				</div>
				
				<!--Card-->
				<div class="card card-cascade mb-4 reverse wider">
					<!--Card image-->
					<div class="view">
						<img src="{{ $league_picture->lg_photo() }}" class="img-fluid mx-auto" alt="photo">
					</div>
					<!--Card content-->
					<div class="card-body">						
						<!-- Create Form -->
						{!! Form::open(['action' => ['LeaguePictureController@update', $league_picture->id], 'method' => 'PATCH', 'files' => true]) !!}
							<!-- Picture Description -->
							<div class="md-form">
								<textarea type="text" name="description" class="form-control md-textarea" rows="3">{{ $league_picture->description }}</textarea>
								<label for="description">Description</label>
							</div>
							
							@if($errors->has('description'))
								<div class="md-form-errors red-text">
									<p class=""><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;{{ $errors->first('description') }}</p>
								</div>
							@endif

							<div class="md-form">
								<button class="btn blue lighten-1" type="submit">Update Description</button>
								<button class="btn red darken-1 white-text" type="button">Delete Picture</button>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
				<!--/.Card-->
			</div>
			<div class="col-md-3 mt-3">
				<a href="{{ route('league_pictures.create') }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">Add New Picture</a>
			</div>
		</div>
	</div>
@endsection