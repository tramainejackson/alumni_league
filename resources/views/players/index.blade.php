@extends('layouts.app')

@section('styles')
	<style type="text/css">
		.view {
			min-height: initial !important;
		}
	</style>
@endsection

@section('content')
	@include('include.functions')
	
	<div class="container-fluid" id="players_page">

		<h2 id="player_page_header" class="page_header">ToTheRec Players</h2>

		<div class="search_box">
			<input class="player_search" name="search" type="search" placeholder="Search Player"/>				
			<a class="addFilter" href="#">Search</a>
		</div>
		<div class="row">
			@php $recentPlayers = \App\PlayerProfile::find_recent_added_players(); @endphp
			@foreach($recentPlayers as $showPlayer)
				<div class="col-12 col-sm-6 col-md-3 col-lg-4 mb-2">
					<div class="card card-cascade narrower">

						<!--Card image-->
						<div class="view overlay">
							<img src="{{ $showPlayer->image != null ? $showPlayer->image : '/images/emptyface.jpg'}}" class="" />
							<a href="#!">
								<div class="mask rgba-white-slight"></div>
							</a>
						</div>
						<!--/.Card image-->

						<!--Card content-->
						<div class="card-body">
							<!--Title-->
							<h2 class="card-title text-center"><strong>{{ $showPlayer->full_name() }}</strong></h2>
							
							<!--Add Nickname if available-->
							@if($showPlayer->nickname != "")
								<h4 class="indigo-text text-center"><i class="fa fa-quote-left" aria-hidden="true"></i><strong>{{ $showPlayer->nickname }}</strong><i class="fa fa-quote-right" aria-hidden="true"></i></h4>
							@endif
							
							<div class="playerBio">
								<ul>
									@php $checkVideoCount = \App\PlayerProfile::find_player_videos_by_id($showPlayer->get_player_id()); @endphp
									
									@if($showPlayer->height != "")
										<li class='playerBioItem'>
											<span class='label'>Height:</span>
											<span class='labelContent'>{{ $showPlayer->height }}</span>
										</li>
									@endif
									
									@if($showPlayer->weight > 0)
										<li class='playerBioItem'>
											<span class='label'>Weight:</span>
											<span class='labelContent'>{{ $showPlayer->weight }}</span>
										</li>
									@endif
									
									@if($showPlayer->highschool != "")
										<li class='playerBioItem' title='{{ $showPlayer->highschool }}'>
											<span class='label'>HS:</span>
											<span class='labelContent'>{{ $showPlayer->highschool }}</span>
										</li>
									@endif
									
									@if($showPlayer->college != "")
										<li class='playerBioItem' title='{{ $showPlayer->college }}'>
											<span class='label'>College:</span>
											<span class='labelContent'>{{ $showPlayer->college }}</span>
										</li>
									@endif
									
									@if(!empty($checkVideoCount))
										<li class='playerBioItem'>
											<span class='label'>Highlights:</span>
											<span class='labelContent'>{{ count($checkVideoCount) }}</span>
										</li>
									@endif
								</ul>
							</div>
							<div class="playerFooter">
								<a href="{{ route('players.show', ['player' => $showPlayer->id]) }}">Go To Profile</a>
							</div>
						</div>
						<!--Card content-->
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection