@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col-md-2 mt-3 mr-auto"></div>
			<div class="col-12 col-md-6 mx-auto">
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->name) }}</h1>
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
								<textarea type="text" name="description" class="form-control md-textarea" rows="3" placeholder="Enter a Description Of The Picture">{{ $league_picture->description }}</textarea>
								
								<label for="description">Description</label>
							</div>
							
							@if($errors->has('description'))
								<div class="md-form-errors red-text">
									<p class=""><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;{{ $errors->first('description') }}</p>
								</div>
							@endif

							<div class="md-form">
								<button class="btn blue lighten-1" type="submit">Update Description</button>
								<button class="btn red darken-1 white-text" data-toggle="modal" data-target="#delete_picture" type="button">Delete Picture</button>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
				<!--/.Card-->
			</div>
			<div class="col-md-2 mt-3 ml-auto order-first order-md-0">
				<a href="{{ request()->query() == null ? route('league_pictures.create') : route('league_pictures.create', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text d-block" type="button">Add New Picture</a>
				
				<a href="{{ request()->query() == null ? route('league_pictures.index') : route('league_pictures.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text d-block" type="button">All Pictures</a>
			</div>
		</div>
		<div class="modal fade" id="delete_picture" tabindex="-1" role="dialog" aria-labelledby="deletePicture" aria-hidden="true" data-backdrop="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="h2-responsive">Delete Picture</h2>
					</div>
					<div class="modal-body">
						<h4 class="">Are you sure you want to delete this picture?</h4>
						
						<div class="">
							{!! Form::open(['action' => ['LeaguePictureController@destroy', $league_picture->id], 'method' => 'DELETE']) !!}
								<div class="d-flex align-items-center justify-content-between">
									<button type="submit" class="btn btn-success">Confirm</button>
									<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection