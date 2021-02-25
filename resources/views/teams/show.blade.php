@extends('layouts.app')

@section('title', 'The Alumni League Teams')

@section('content')

	<div class="container-fluid bgrd3">

		<div class="row">

			<div class="col-12 my-3 text-center">
				<a class="btn btn-rounded mdb-color darken-3 white-text" type="button" href="{{ request()->query() == null ? route('league_teams.index') : route('league_teams.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}">All Teams</a>
			</div>

			<div class="col-12 col-xl-8 mx-auto">

				<div class="text-center coolText1">
					<div class="text-center p-4 card rgba-deep-orange-light white-text my-3" id="">
						<h1 class="h1-responsive text-uppercase">{{ $showSeason->name }}</h1>
					</div>
				</div>
				
				<!--Card-->
				<div class="card card-cascade mb-4 reverse wider">
					<!--Card image-->
					<div class="view">
						<img src="{{ asset($league_team->sm_photo()) }}" class="img-fluid mx-auto" alt="photo" style="max-width: 75%;">
					</div>
					<!--Card content-->
					<div class="card-body rgba-white-strong rounded z-depth-1-half">
						<!--Title-->
						<h2 class="card-title h2-responsive text-center">{{ $league_team->team_name }} Players</h2>

						<!-- Team Info -->
						<!-- Team Players Info -->
						<div class="mt-4 position-relative">

							<div class="table-wrapper">
								<table class="table table-hover table-striped text-center" id="team_players_table">

									<thead>
										<tr>
											<th>Jersey Num.</th>
											<th class="text-nowrap">Player Name</th>
											<th>Captain</th>
										</tr>
									</thead>

									<tbody>
										@if($league_team->players->isNotEmpty())
											@foreach($league_team->players as $player)
												<tr class="">
													<td class="">
														<p class="">#{{ $player->jersey_num }}</p>
													</td>
													<td class="">
														<p class="">{{ $player->player_name }}</p>
													</td>
													<td class="">
														@if($player->team_captain == 'Y')
															<i class="fas fa-chess-king fa-2x red-text"></i>
														@endif
													</td>
												</tr>
											@endforeach
										@else
											<tr class="">
												<th colspan="6" class="text-center">No Players Added for this team yet</th>
											</tr>
										@endif

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!--/.Card-->
			</div>
		</div>
	</div>

	<!-- Footer -->
	@include('content_parts.footer')
	<!-- Footer -->
@endsection