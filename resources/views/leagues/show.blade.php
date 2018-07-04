@extends('layouts.app')

@section('content')
	@include('include.functions')
	
		<div class="" style="">
			<h1 class="">
				{{ ucwords($league->name) }}
				@if($league->seasons()->active()->count() > 0)
					@foreach($league->seasons()->active() as $active)
						<span class="ttrSite">This Leagues Keeps Online Stats. Click <a href="#" class="" target="_blank">here</a> to see.</span>
					@endforeach	
				@endif
			</h1>
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
	</div>
@endsection