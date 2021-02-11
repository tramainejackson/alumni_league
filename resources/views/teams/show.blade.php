@extends('layouts.app')

@section('content')
	<div class="container-fluid bgrd3">
		<div class="row">
			<!--Column will include buttons for creating a new season-->
			<div class="col mt-3 d-none d-xl-block"></div>
			<div class="col-12 col-xl-8 mx-auto">
				<div class="text-center coolText1">
					<h1 class="display-3 py-3">{{ ucfirst($showSeason->name) }}</h1>
				</div>
				
				<!--Card-->
				<div class="card card-cascade mb-4 reverse wider">
					<!--Card image-->
					<div class="view">
						<img src="{{ $league_team->team_picture != null ? $league_team->lg_photo() : $defaultImg }}" class="img-fluid mx-auto" alt="photo" style="max-width: 75%;">
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
											<th>Captain</th>
											<th>Jersey Num.</th>
											<th class="text-nowrap">Player Name</th>
										</tr>
									</thead>

									<tbody>
										@if($league_team->players->isNotEmpty())
											@foreach($league_team->players as $player)
												<tr class="">
													<td class="">
														@if($player->team_captain == 'Y')
															<i class="fas fa-chess-king fa-2x red-text"></i>
														@endif
													</td>
													<td class="">
														<p class="">{{ $player->jersey_num }}</p>
													</td>
													<td class="">
														<p class="">{{ $player->player_name }}</p>
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
			<div class="col mt-3 text-center text-xl-right order-first order-xl-0">
				<a href="{{ request()->query() == null ? route('league_teams.index') : route('league_teams.index', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn-lg btn-rounded mdb-color darken-3 white-text" type="button">All Teams</a>
			</div>
		</div>
	</div>

	<!-- Footer -->
	@include('content_parts.footer')
	<!-- Footer -->
@endsection