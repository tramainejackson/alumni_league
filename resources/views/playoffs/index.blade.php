@extends('layouts.app')

@section('content')
	@include('include.functions')

	<div class="container-fluid bgrd1">
		<div class="row" id="">
			<!--Column will include buttons for creating a new season-->
			<div class="col py-3" id="">
				<button class="btn btn-lg btn-rounded blue white-text mb-2" type="button" data-toggle="modal" data-target="#newSeasonForm">New Season</button>
			</div>
		</div>

		<div class="row align-items-stretch">
			<div class="col-12 col-lg-10 pb-3 mx-auto">
				<!-- Show league season info -->
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->name) . ' ' . $showSeason->year }}</h1>
					<h1 class="display-4 coolText4">It's Playoff Time</h1>

					@if(Auth::check() && Auth::user()->type == 'admin')
						<button class="btn btn-rounded cyan accent-1 black-text coolText4" type="button" data-toggle="modal" data-target="#complete_season">Complete Season</button>
					@endif
				</div>

				@php
					$settings = $playoffSettings;
					$games = $allGames;
					$teams = $allTeams;
				@endphp

				<div class="view_schedule">
					@if($settings->season->champion_id != null)
						@php $champTeam = \App\LeagueTeam::find($settings->season->champion_id); @endphp
						<div class="col col-12 p-5 text-center champDiv">
							<div class="">
								<h3 class="display-2">2018 Champions</h3>
							</div>
							<div class="">
								<h4 class="display-3 mb-4">{{ $champTeam->team_name }}</h4>
							</div>
						</div>
					@endif
					
					@if($settings->playin_games == 'N')
						@php $x = 1; @endphp
						@php $rounds = $settings->total_rounds; @endphp
						@php $teams = $teams->count(); @endphp

						@if($rounds > 0)
							<div class="row playoffBracket d-none d-md-block">
								<div class="col">
									<main id="tournament">
										@while($rounds > 0)
											@php $totalGames = ($teams/2); @endphp
											<ul class="round round-{{ $x }}">
												<!--- Get games that are for round x from database --->
												@php $playoffSchedule = $showSeason->games()->roundGames($x)->orderBy('home_seed')->get(); @endphp
												@if($playoffSchedule->isNotEmpty())
													@while($playoffSchedule->isNotEmpty())
														@php $roundGames = $playoffSchedule->count(); @endphp
														@if($roundGames == ($teams/2))
															<?php if($roundGames == 1) { ?>
																<?php $playoffs = $playoffSchedule->shift(); ?>

																<li class="spacer">&nbsp;</li>
																
																<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
																<li class="game game-spacer">&nbsp;</li>
																<li class="game game-bottom{{ $playoffs->winning_team_id == $playoffs->away_team_id ? ' winner' : '' }}">{{ $playoffs->away_seed . ") " . $playoffs->away_team }} <span>{{ $playoffs->away_team_score }}</span></li>
															<?php } else { ?>
																<?php $playoffs = $playoffSchedule->shift(); ?>
																<li class="spacer">&nbsp;</li>
																
																<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
																<li class="game game-spacer">&nbsp;</li>
																<li class="game game-bottom{{ $playoffs->winning_team_id == $playoffs->away_team_id ? ' winner' : '' }}">{{ $playoffs->away_seed . ") " . $playoffs->away_team }} <span>{{ $playoffs->away_team_score }}</span></li>
															<?php } ?>
														@elseif(fmod(count($playoffSchedule),2) == 0)
															<?php $findGameIndex = (count($playoffSchedule) / 2); ?>
															
															<?php if($findGameIndex == 1) { ?>
																<?php $playoffs = $playoffSchedule->splice($findGameIndex,1)->first(); ?>
																<?php $playoffs2 = $playoffSchedule->splice(($findGameIndex-1),1)->first(); ?>

																<?php if($x > 1) { ?>
																	<li class="spacer">&nbsp;</li>											
																	<li class="game game-top{{ $playoffs->winning_team_id == $playoffs->away_team_id ? ' winner' : '' }}">{{ $playoffs->away_seed . ") " . $playoffs->away_team }} <span>{{ $playoffs->away_team_score }}</span></li>
																	<li class="game game-spacer">&nbsp;</li>
															<li class="game game-bottom{{ $playoffs->winning_team_id == $playoffs->home_team_id ? ' winner' : '' }}">{{ $playoffs->home_seed . ") " . $playoffs->home_team }} <span>{{ $playoffs->home_team_score }}</span></li>
																	
																	<li class="spacer">&nbsp;</li>
																	
																	<li class="game game-top <?php echo $playoffs2->winning_team_id == $playoffs2->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs2->away_seed . ") " . $playoffs2->away_team; ?> <span><?php echo $playoffs2->away_team_score; ?></span></li>
																	<li class="game game-spacer">&nbsp;</li>
																	<li class="game game-bottom{{ $playoffs2->winning_team_id == $playoffs2->home_team_id ? ' winner' : '' }}">{{ $playoffs2->home_seed . ") " . $playoffs2->home_team }} <span>{{ $playoffs2->home_team_score }}</span></li>
																<?php } else { ?>
																	<li class="spacer">&nbsp;</li>
																	
																	<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
																	<li class="game game-spacer">&nbsp;</li>
																	<li class="game game-bottom{{ $playoffs->winning_team_id == $playoffs->away_team_id ? ' winner' : '' }}">{{ $playoffs->away_seed . ") " . $playoffs->away_team }} <span>{{ $playoffs->away_team_score }}</span></li>
																	
																	<li class="spacer">&nbsp;</li>
																	
																	<li class="game game-top <?php echo $playoffs2->winning_team_id == $playoffs2->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs2->home_seed . ") " . $playoffs2->home_team; ?> <span><?php echo $playoffs2->home_team_score; ?></span></li>
																	<li class="game game-spacer">&nbsp;</li>
																	<li class="game game-bottom{{ $playoffs2->winning_team_id == $playoffs2->away_team_id ? ' winner' : '' }}">{{ $playoffs2->away_seed . ") " . $playoffs2->away_team }} <span>{{ $playoffs2->away_team_score }}</span></li>
																<?php } ?>
															<?php } else { ?>
																<?php $playoffs = $playoffSchedule->splice($findGameIndex,1)->first(); ?>
																<?php $playoffs2 = $playoffSchedule->splice(($findGameIndex-1),1)->first(); ?>

																<li class="spacer">&nbsp;</li>
																
																<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
																<li class="game game-spacer">&nbsp;</li>
																<li class="game game-bottom <?php echo $playoffs->winning_team_id == $playoffs->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs->away_seed . ") " . $playoffs->away_team; ?> <span><?php echo $playoffs->away_team_score; ?></span></li>
																
																<li class="spacer">&nbsp;</li>
																
																<li class="game game-top <?php echo $playoffs2->winning_team_id == $playoffs2->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs2->home_seed . ") " . $playoffs2->home_team; ?> <span><?php echo $playoffs2->home_team_score; ?></span></li>
																<li class="game game-spacer">&nbsp;</li>
																<li class="game game-bottom <?php echo $playoffs2->winning_team_id == $playoffs2->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs2->away_seed . ") " . $playoffs2->away_team; ?> <span><?php echo $playoffs2->away_team_score; ?></span></li>
															<?php } ?>
														@else
															<?php $playoffs = $playoffSchedule->pop(); ?>
														
															<?php if($x > 1) { ?>
																<li class="spacer">&nbsp;</li>
																
																<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs->away_seed . ") " . $playoffs->away_team; ?> <span><?php echo $playoffs->away_team_score; ?></span></li>
																<li class="game game-spacer">&nbsp;</li>
																<li class="game game-bottom <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
															<?php } else { ?>
																<li class="spacer">&nbsp;</li>
																
																<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
																<li class="game game-spacer">&nbsp;</li>
																<li class="game game-bottom <?php echo $playoffs->winning_team_id == $playoffs->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs->away_seed . ") " . $playoffs->away_team; ?> <span><?php echo $playoffs->away_team_score; ?></span></li>
															<?php } ?>
														@endif
													@endwhile
												@else
													@for($i=0; $i < $totalGames; $i++)
														<li class="spacer">&nbsp;</li>
														
														<li class="game game-top">TBD<span></span></li>
														<li class="game game-spacer">&nbsp;</li>
														<li class="game game-bottom">TBD<span></span></li>
													@endfor
												@endif
												<li class="spacer">&nbsp;</li>
											</ul>
											
											@php $teams = ($teams/2); @endphp
											@php $rounds--; @endphp
											@php $x++; @endphp
										@endwhile
									</main>
								</div>
							</div>
						@else
							<div class="row">
								<div class="col">
									<h3 class="text-center text-light">The tournament has not be generated yet</h3>
								</div>
							</div>
							<div class="row">
								<div class="col">
									@include('bracketology')
								</div>
							</div>
						@endif
						
					@elseif($settings->playin_games_complete == 'Y' && $settings->playin_games == 'Y')
						@php $x = 1; @endphp
						@php $rounds = $settings->total_rounds; @endphp
						@php $teams = $settings->teams_with_bye + $playInGames->count(); @endphp
						
						@if($nonPlayInGames->isNotEmpty())
							@for($i=$rounds; $i >= 0; $i--)
								@php $roundGames = $showSeason->games()->roundGames($i)->orderBy('home_seed')->get(); @endphp	
							
								@if($roundGames->isNotEmpty())
									<div class="row">
										<div class="col text-center">
											@if($i != $rounds)
												<h2 class="roundHeader text-center p-3 my-3">Round {{ $i }} Games</h2>

												@if(Auth::check() && Auth::user()->type == 'admin')
													<a href="{{ request()->query() == null ? route('edit_round', ['round' => $i]) : route('edit_round', ['round' => $i, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn rounded white black-text">Edit {{ $i }} Round</a>
												@endif
											@else
												<h2 class="roundHeader text-center p-3 my-3">Championship Game</h2>

												@if(Auth::check() && Auth::user()->type == 'admin')
													<a href="{{ request()->query() == null ? route('edit_round', ['round' => $i]) : route('edit_round', ['round' => $i, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn rounded white black-text">Edit Championship Game</a>
												@endif
											@endif
										</div>
									</div>
									<div class="row">
										@foreach($roundGames as $game)
											<div class="col-12 col-md-6 my-3 mx-auto">
												<div class="card">
													<div class="card-header {{ $game->game_complete == 'Y' ? 'bg-success text-white' : 'bg-danger text-white'}}">
														<h2 class="text-center">{{ $i == $rounds ? 'Championship Game' : 'Round ' .  $game->round . ' Game' }}</h2>
													</div>
													<div class="card-body">
														<p class="text-center">{{ $game->away_team}} vs {{ $game->home_team}}</p>
														
														@if($game->game_complete == "Y")
															@if($game->forfeit == "Y")
																<p class="text-center"><?php echo $game->losing_team_id == $game->home_team_id ? $game->home_team . " loss due to forfeit" : $game->away_team . " loss due to forfeit"; ?></p>
															@else
																<p class="text-center"><?php echo $game->losing_team_id == $game->home_team_id ? $game->away_team . " with the win over " . $game->home_team . " " . $game->away_team_score . " - " . $game->home_team_score : $game->home_team . " beat " . $game->away_team . " " . $game->home_team_score . " - " . $game->away_team_score; ?></p>
															@endif
														@endif
													</div>
												</div>
											</div>
										@endforeach	
									</div>
								@endif
							@endfor
						@endif
						
						@if($playInGames->isNotEmpty())
							<div class="row">
								<div class="col col-12 text-center">
									<h2 class="roundHeader p-3 my-3">Play In Games</h2>

									@if(Auth::check() && Auth::user()->type == 'admin')
										<a href="{{ request()->query() == null ? route('edit_playins') : route('edit_playins', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn rounded white black-text">Edit Playin</a>
									@endif
								</div>
								@foreach($playInGames as $game)
									<div class="col-12 col-md-6 my-3 mx-auto">
										<div class="card">
											<div class="card-header {{ $game->game_complete == 'Y' ? 'bg-success text-white' : 'bg-danger text-white'}}">
												<h2 class="text-center">Play In Game</h2>
											</div>
											<div class="card-body">
												<p class="text-center">{{ $game->away_team}} vs {{ $game->home_team}}</p>
												
												@if($game->game_complete == "Y")
													<?php if($game->forfeit == "Y") { ?>
														<p class="text-center"><?php echo $game->losing_team_id == $game->home_team_id ? $game->home_team . " loss due to forfeit" : $game->away_team . " loss due to forfeit"; ?></p>
													<?php } else { ?>
														<p class="text-center"><?php echo $game->losing_team_id == $game->home_team_id ? $game->away_team . " with the win over " . $game->home_team . " " . $game->away_team_score . " - " . $game->home_team_score : $game->home_team . " beat " . $game->away_team . " " . $game->home_team_score . " - " . $game->away_team_score; ?></p>
													<?php } ?>
												@endif
											</div>
										</div>
									</div>
								@endforeach	
							</div>
						@endif

						<div class="row playoffBracket d-none d-md-block">
							<div class="col">
								<main id="tournament">
									@while($rounds > 0)
										@php $totalGames = ($teams/2); @endphp
										<ul class="round round-{{ $x }}">
											<!--- Get games that are for round x from database --->
											@php $playoffSchedule = $showSeason->games()->roundGames($x)->orderBy('home_seed')->get(); @endphp
	
											@if($playoffSchedule->isNotEmpty())
												@while($playoffSchedule->isNotEmpty())
													@php $roundGames = $playoffSchedule->count(); @endphp
													@if($roundGames == ($teams/2))
														<?php if($roundGames == 1) { ?>
															<?php $playoffs = $playoffSchedule->shift(); ?>

															<li class="spacer">&nbsp;</li>
															
															<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
															<li class="game game-spacer">&nbsp;</li>
															<li class="game game-bottom <?php echo $playoffs->winning_team_id == $playoffs->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs->away_seed . ") " . $playoffs->away_team; ?> <span><?php echo $playoffs->away_team_score; ?></span></li>
														<?php } else { ?>
															<?php $playoffs = $playoffSchedule->shift(); ?>
															<li class="spacer">&nbsp;</li>
															
															<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
															<li class="game game-spacer">&nbsp;</li>
															<li class="game game-bottom <?php echo $playoffs->winning_team_id == $playoffs->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs->away_seed . ") " . $playoffs->away_team; ?> <span><?php echo $playoffs->away_team_score; ?></span></li>
														<?php } ?>
													@elseif(fmod(count($playoffSchedule),2) == 0)
														<?php $findGameIndex = (count($playoffSchedule) / 2); ?>
														
														<?php if($findGameIndex == 1) { ?>
															<?php $playoffs = $playoffSchedule->splice($findGameIndex,1)->first(); ?>
															<?php $playoffs2 = $playoffSchedule->splice(($findGameIndex-1),1)->first(); ?>

															<?php if($x > 1) { ?>
																<li class="spacer">&nbsp;</li>
																
																<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs->away_seed . ") " . $playoffs->away_team; ?> <span><?php echo $playoffs->away_team_score; ?></span></li>
																<li class="game game-spacer">&nbsp;</li>
																<li class="game game-bottom <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
																
																<li class="spacer">&nbsp;</li>
																
																<li class="game game-top <?php echo $playoffs2->winning_team_id == $playoffs2->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs2->away_seed . ") " . $playoffs2->away_team; ?> <span><?php echo $playoffs2->away_team_score; ?></span></li>
																<li class="game game-spacer">&nbsp;</li>
																<li class="game game-bottom <?php echo $playoffs2->winning_team_id == $playoffs2->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs2->home_seed . ") " . $playoffs2->home_team; ?> <span><?php echo $playoffs2->home_team_score; ?></span></li>
															<?php } else { ?>
																<li class="spacer">&nbsp;</li>
																
																<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
																<li class="game game-spacer">&nbsp;</li>
																<li class="game game-bottom <?php echo $playoffs->winning_team_id == $playoffs->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs->away_seed . ") " . $playoffs->away_team; ?> <span><?php echo $playoffs->away_team_score; ?></span></li>
																
																<li class="spacer">&nbsp;</li>
																
																<li class="game game-top <?php echo $playoffs2->winning_team_id == $playoffs2->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs2->home_seed . ") " . $playoffs2->home_team; ?> <span><?php echo $playoffs2->home_team_score; ?></span></li>
																<li class="game game-spacer">&nbsp;</li>
																<li class="game game-bottom <?php echo $playoffs2->winning_team_id == $playoffs2->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs2->away_seed . ") " . $playoffs2->away_team; ?> <span><?php echo $playoffs2->away_team_score; ?></span></li>
															<?php } ?>
														<?php } else { ?>
															<?php $playoffs = $playoffSchedule->splice($findGameIndex,1)->first(); ?>
															<?php $playoffs2 = $playoffSchedule->splice(($findGameIndex-1),1)->first(); ?>

															<li class="spacer">&nbsp;</li>
															
															<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
															<li class="game game-spacer">&nbsp;</li>
															<li class="game game-bottom <?php echo $playoffs->winning_team_id == $playoffs->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs->away_seed . ") " . $playoffs->away_team; ?> <span><?php echo $playoffs->away_team_score; ?></span></li>
															
															<li class="spacer">&nbsp;</li>
															
															<li class="game game-top <?php echo $playoffs2->winning_team_id == $playoffs2->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs2->home_seed . ") " . $playoffs2->home_team; ?> <span><?php echo $playoffs2->home_team_score; ?></span></li>
															<li class="game game-spacer">&nbsp;</li>
															<li class="game game-bottom <?php echo $playoffs2->winning_team_id == $playoffs2->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs2->away_seed . ") " . $playoffs2->away_team; ?> <span><?php echo $playoffs2->away_team_score; ?></span></li>
														<?php } ?>
													@else
														<?php $playoffs = $playoffSchedule->pop(); ?>
													
														<?php if($x > 1) { ?>
															<li class="spacer">&nbsp;</li>
															
															<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs->away_seed . ") " . $playoffs->away_team; ?> <span><?php echo $playoffs->away_team_score; ?></span></li>
															<li class="game game-spacer">&nbsp;</li>
															<li class="game game-bottom <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
														<?php } else { ?>
															<li class="spacer">&nbsp;</li>
															
															<li class="game game-top <?php echo $playoffs->winning_team_id == $playoffs->home_team_id ? "winner" : ""; ?>"><?php echo $playoffs->home_seed . ") " . $playoffs->home_team; ?> <span><?php echo $playoffs->home_team_score; ?></span></li>
															<li class="game game-spacer">&nbsp;</li>
															<li class="game game-bottom <?php echo $playoffs->winning_team_id == $playoffs->away_team_id ? "winner" : ""; ?>"><?php echo $playoffs->away_seed . ") " . $playoffs->away_team; ?> <span><?php echo $playoffs->away_team_score; ?></span></li>
														<?php } ?>
													@endif
												@endwhile
											@else
												@for($i=0; $i < $totalGames; $i++)
													<li class="spacer">&nbsp;</li>
													
													<li class="game game-top">TBD<span></span></li>
													<li class="game game-spacer">&nbsp;</li>
													<li class="game game-bottom">TBD<span></span></li>
												@endfor
											@endif
											<li class="spacer">&nbsp;</li>
										</ul>
										
										@php $teams = ($teams/2); @endphp
										@php $rounds--; @endphp
										@php $x++; @endphp
									@endwhile
								</main>
							</div>
						</div>
					@elseif($settings->playin_games_complete == 'N' && $settings->playin_games == 'Y')
						@php $playInGames = $showSeason->games()->playoffPlayinGames()->get(); @endphp
						@if($playInGames->isNotEmpty())
							<div class="divClass">
								<div class="col">
									<p class="text-center text-warning">*Once playin games complete, tournament bracket will be posted</p>
								</div>
							</div>
							<div class="row">
								<div class="col col-12 text-center">
									<h2 class="roundHeader p-3 my-3">Play In Games</h2>

									@if(Auth::check() && Auth::user()->type == 'admin')
										<a href="{{ request()->query() == null ? route('edit_playins') : route('edit_playins', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn rounded white black-text">Edit Playin Games</a>
									@endif
								</div>
								
								@foreach($playInGames as $game)
									<div class="col col-4 my-3">
										<div class="card">
											<div class="card-header {{ $game->game_complete == 'Y' ? 'bg-success text-white' : 'bg-danger text-white'}}">
												<h2 class="text-center">Play In Game</h2>
											</div>
											<div class="card-body">
												<p class="text-center">{{ $game->away_team}} vs {{ $game->home_team}}</p>
												
												@if($game->game_complete == "Y")
													@if($game->forfeit == "Y")
														<p class="text-center">{{ $game->losing_team_id == $game->home_team_id ? $game->home_team . " loss due to forfeit" : $game->away_team . " loss due to forfeit" }}</p>
													@else
														<p class="text-center">{{ $game->losing_team_id == $game->home_team_id ? $game->away_team . " with the win over " . $game->home_team . " " . $game->away_team_score . " - " . $game->home_team_score : $game->home_team . " beat " . $game->away_team . " " . $game->home_team_score . " - " . $game->away_team_score }}</p>
													@endif
												@endif
											</div>
										</div>
									</div>
								@endforeach	
							</div>
						@endif
						<div class="row playoffBracket d-none d-md-block">
							<div class="col">
								@include('bracketology')
							</div>
						</div>
					@endif
					<div class="row">
						<div class="col">
							<p class="">*Single game elimination for every round.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		@include('modals.new_season_modal')
		@include('modals.complete_playoffs_modal')

		<!-- Footer -->
		@include('layouts.footer')
		<!-- Footer -->
	</div>
@endsection
