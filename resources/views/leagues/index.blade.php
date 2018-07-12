@extends('layouts.app')

@section('content')
	@include('include.functions')

	<div class="container-fluid bgrd4">
		
		@foreach($leagues as $league)
			<div class="row position-relative py-5 white-text">
				<div class="col-12 col-md-8 mx-auto">
					<div class="card card-image mb-3" style="background-image: url({{ $league->picture != null ? asset($league->picture) : $defaultImg }});">
						<div class="text-white text-left d-flex flex-column align-items-center rgba-black-strong p-2 p-lg-5">
							<div class="row">
								@if($league->seasons->isNotEmpty())
									<div class="col-8 mx-auto">
										<button class="btn btn-block green darken-1" type="button">Active Seasons <span class="badge-dark badge-pill">{{ $league->seasons()->active()->count() }}</span></button> 
									</div>
									
									<div class="col-8 mx-auto my-1">
										<button class="btn btn-block red darken-1" type="button">Completed Seasons <span class="badge-dark badge-pill">{{ $league->seasons()->completed()->count() }}</span></button>
									</div>
								@endif
							</div>
							
							<div class="mt-3 p-lg-2 rgba-black-light coolText3 rounded z-depth-1-half">
								<h2 class="h2-responsive">League Name: <a href="{{ route('league_profile.show', ['league' => str_ireplace(" ", "", strtolower($league->name))]) }}" class="">{{ $league->name }}</a></h2>
								
								<h2 class="h2-responsive">Commission Name: {{ $league->commish }}</h2>
								
								@if($league->address !== null)
									<h2 class="h2-responsive">Address: {{ $league->address }}</h2>
								@endif
								
								@if($league->phone !== null)
									<h2 class="h2-responsive">Phone: {{ $league->phone }}</h2>
								@endif
								
								@if($league->leagues_email !== null)
									<h2 class="h2-responsive">Email: {{ $league->leagues_email }} <button class="btn black white-text" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Send Email</button></h2>
								@endif
							</div>

							<hr/>
							
							<div class="d-flex justify-content-between flex-column flex-xl-row my-4">
								<div class="col-12 col-xl-6">
									<h1 class="h1-responsive">Ages</h1>
									<div class="row">
										@foreach(find_ages() as $age)
											<div class="col-6 my-1">
												<button class="btn btn rounded btn-block{{  str_contains($league->age, $age) ? ' default-color' : ' grey' }}" type="button">{{ str_ireplace('_', ' ', $age) }}</button>
											</div>
										@endforeach
									</div>
								</div>
								
								<div class="col-12 col-xl-6">
									<h1 class="h1-responsive">Competition</h1>
									
									<div class="row">
										@foreach(find_competitions() as $comp)
											<div class="col-6 my-1">
												<button class="btn btn rounded btn-block{{  str_contains($league->comp, $comp) ? ' primary-color' : ' grey' }}" type="button">{{ str_ireplace('_', ' ', $comp) }}</button>
											</div>
										@endforeach
									</div>
								</div>
							</div>
							
							@if($league->leagues_website != null)
								<a href="http://www.{{ $league->leagues_website }}" class="btn btn-lg secondary-color">View Website</a>
							@endif
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@endsection