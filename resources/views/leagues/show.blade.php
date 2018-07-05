@extends('layouts.app')

@section('content')
	@include('include.functions')
	
	<div class="container-fluid">
		<div class="row py-3">
			@if($league->seasons()->active()->count() > 0)
				<div class="col-2">
					<h4 class="h4-responsive">Active Seasons</h4>
					
					<div class="">
						@foreach($league->seasons()->active()->get() as $active)
							<a href="{{ route('league_profile.season', ['league' => str_ireplace(' ', '', strtolower($league->name)), 'season' => str_ireplace(' ', '', strtolower($active->name))]) }}" class="btn btn-block blue darken-1 my-1">{{ $active->name }}</a>
						@endforeach
					</div>
				</div>
			@endif
			
			<div class="col-8 mx-auto">
				<img src="{{ $league->picture !== null ? asset($league->picture) : $defaultImg }}" class="img-fluid z-depth-1 rounded-circle" />
				<h1 class="h1-responsive">{{ ucwords($league->name) }}</h1>
				
				<div class="indLeaguesInfo">
					<span>Address:</span>
					<span class="">{{ $league->address != "" ? $league->address : "No Address Listed" }}</span>
				</div>
				<div class="indLeaguesInfo">
					<span>Phone #:</span>
					<span class="">{{ $league->phone != "" ? $league->phone : "No Phone Number Listed" }}</span>
				</div>
				<div class="indLeaguesInfo">
					<span>Email:</span>
					<span class="">{{ $league->leagues_email != "" ? $league->leagues_email : "No Email Address Listed" }}</span>
				</div>
				<div class="indLeaguesInfo">
					<span>Website:</span>
					<span class="">{{ $league->leagues_website != "" ? "<a href='http://".$league->leagues_website."'>".$league->leagues_website."</a>" : "No Website For This League" }}</span>
				</div>
				<div class="indLeaguesInfo">
					<span>Entry Fee:</span>
					<span class="">{{ $league->leagues_fee != null ? $league->leagues_fee : "Please Contact For League Entry" }}</span>
				</div>
				<div class="indLeaguesInfo">
					<span>Ref Fee:</span>
					<span class="">{{ $league->ref_fee != null ? $league->ref_fee : "No Ref Fee's Added Yet" }}</span>
				</div>
				
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
			
			@if($league->seasons()->completed()->count() > 0)
				<div class="col-2">
					<h4 class="h4-responsive">Completed Seasons</h4>
					
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