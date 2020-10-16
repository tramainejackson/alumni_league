@extends('layouts.app')

@section('content')
	@include('include.functions')
	
	<div class="container-fluid bgrd4">
		<div class="row py-3">
			@if($league->seasons()->active()->count() > 0)
				<div class="col-2">
					<h4 class="h4-responsive text-center white-text">Active Seasons</h4>
					
					<div class="">
						@foreach($league->seasons()->active()->get() as $active)
							<a href="{{ route('league_profile.season', ['league' => str_ireplace(' ', '', strtolower($league->name)), 'season' => str_ireplace(' ', '', strtolower($active->name))]) }}" class="btn btn-block blue darken-1 my-1">{{ $active->name }}</a>
						@endforeach
					</div>
				</div>
			@endif
			
			<div class="col-8 text-center white-text mx-auto">
				<img src="{{ $league->picture !== null ? asset($league->picture) : $defaultImg }}" class="img-fluid z-depth-1 rounded-circle" />
				<h1 class="h1-responsive">{{ ucwords($league->name) }}</h1>
				
				<div class="indLeaguesInfo">
					<p class="m-1">Address: {{ $league->address != "" ? $league->address : "No Address Listed" }}</p>
				</div>
				<div class="indLeaguesInfo">
					<p class="m-1">Phone #: {{ $league->phone != "" ? $league->phone : "No Phone Number Listed" }}</p>
				</div>
				
				@if($league->leagues_email !== null)
					<div class="indLeaguesInfo">
						<p class="m-1">Email: {{ $league->leagues_email }}</p>
					</div>
				@endif
				
				<div class="indLeaguesInfo">
					<p class="m-1">Entry Fee: {{ $league->leagues_fee != null ? '$'. $league->leagues_fee . ' /Per Team' : "Please Contact For League Entry" }}</p>
				</div>
				
				<div class="indLeaguesInfo">
					<p class="m-1">Ref Fee: {{ $league->ref_fee != null ? '$' . $league->ref_fee . ' /Per Game' : "No Ref Fee's Added Yet" }}</p>
				</div>
				
				@if($league->leagues_website != null)
					<div class="indLeaguesInfo">
						<a href="http://www.{{ $league->leagues_website }}" class="btn btn-lg secondary-color">View Website</a>
					</div>
				@endif
				
				<div class="row my-5">
					<div class="col-12 col-xl-6">
						<h4 class="h4-responsive">Ages</h4>
						<div class="row">
							@foreach(find_ages() as $age)
								<div class="col-6 my-1">
									<button class="btn btn rounded btn-block{{  str_contains($league->age, $age) ? ' default-color' : ' grey' }}" type="button">{{ str_ireplace('_', ' ', $age) }}</button>
								</div>
							@endforeach
						</div>
					</div>
					
					<div class="col-12 col-xl-6">
						<h4 class="h4-responsive">Competition</h4>
						
						<div class="row">
							@foreach(find_competitions() as $comp)
								<div class="col-6 my-1">
									<button class="btn btn rounded btn-block{{  str_contains($league->comp, $comp) ? ' primary-color' : ' grey' }}" type="button">{{ str_ireplace('_', ' ', $comp) }}</button>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			
			@if($league->seasons()->completed()->count() > 0)
				<div class="col-2">
					<h4 class="h4-responsive text-center white-text">Completed Seasons</h4>
					
					<div class="">
						@foreach($league->seasons()->completed()->get() as $completed)
							<a href="{{ route('league_profile.season', ['league' => str_ireplace(' ', '', strtolower($league->name)), 'season' => str_ireplace(' ', '', strtolower($completed->name))]) }}" class="btn btn-block orange darken-1 my-1">{{ $completed->name }}</a>
						@endforeach
					</div>
				</div>
			@endif
		</div>
	</div>
@endsection