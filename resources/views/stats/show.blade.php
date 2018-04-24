@extends('layouts.app')

@section('content')
	@include('include.functions')
	
		<div class="indLeague" style="background-image:url('images/{{ $league->leagues_picture }}');">
			<h1 class="">
				{{ ucwords($league->leagues_name) }}
				@if($league->ttr_league == "Y") 
					<span class="ttrSite">This Leagues Keeps Online Stats. Click <a href="{{ $league->ttr_league_site }}" class="" target="_blank">here</a> to see.</span>
				@endif
			</h1>
			<div class="indLeaguesInfo">
				<span>Address:</span>
				<span class="">{{ $league->leagues_address != "" ? $league->leagues_address : "No Address Listed" }}</span>
			</div>
			<div class="indLeaguesInfo">
				<span>Phone #:</span>
				<span class="">{{ $league->leagues_phone != "" ? $league->leagues_phone : "No Phone Number Listed" }}</span>
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
			<div class="indLeaguesInfo compLevelTable">
				<span>Comp Levels:</span>
				<div class="container-fluid">
					<div class="row">
						@if($league->leagues_comp != "") 
							<ul class="compLevelsList">
								@php $levelsArray = explode(" ", $league->leagues_comp); @endphp
								@for($i=0; $i < count($levelsArray); $i++) 
									<li class="col-md-4">{{ str_ireplace(" ", "", ucwords(str_ireplace("_", " ", $levelsArray[$i]))) }}</li>
								@endfor
							</ul>
						@else
							<span class="">{{ $league->leagues_comp }}</span>
						@endif
					</div>
				</div>
			</div>
			<div class="indLeaguesInfo ageLevelTable">
				<span>Age Levels:</span>
				<div class="container-fluid">
					<div class="row">
						@if($league->leagues_comp != "") 
							<ul class="compLevelsList">
								@php $agesArray = explode(" ", $league->leagues_age); @endphp
								@for($i=0; $i < count($agesArray); $i++) 
									<li class="col-md-4">{{ ucwords(str_ireplace("_", " ", $agesArray[$i])) }}</li>
								@endfor
							</ul>
						@else
							<span class="">{{ $league->leagues_age }}</span>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection