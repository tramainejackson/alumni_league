@extends('layouts.app')

@section('content')
	@include('include.functions')

	<div class="container-fluid">
		<div class="row align-items-stretch">
			<!--Column will include buttons for creating a new season-->
			<div class="col py-3" id="">
				<div class="row">
					<div class="col">
						<button class="btn btn-lg btn-rounded blue white-text" type="button" data-toggle="modal" data-target="#newSeasonForm">New Season</button>
					</div>
					@if($activeSeasons->isNotEmpty())
						<div class="col d-none d-lg-block">
							@foreach($activeSeasons as $activeSeason)
								<a href="{{ route('home', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="btn btn-lg btn-rounded deep-orange white-text" type="button">{{ $activeSeason->name }}</a>
							@endforeach
						</div>
					@else
					@endif
				</div>
			</div>
			<div class="col-12 col-lg-7 pb-3">
				<!-- Show league season info -->
				<div class="text-center coolText1">
					<h1 class="display-3">{{ ucfirst($showSeason->name) . ' ' . $showSeason->year }}</h1>
					<h1 class="display-4 coolText4">It's Playoff Time</h1>
					<button class="btn btn-rounded cyan accent-1 black-text coolText4" type="button" data-toggle="modal" data-target="#complete_season">Complete Season</button>
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
											
												<a href="{{ request()->query() == null ? route('edit_round', ['round' => $i]) : route('edit_round', ['round' => $i, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn rounded white black-text">Edit {{ $i }} Round</a>
											@else
												<h2 class="roundHeader text-center p-3 my-3">Championship Game</h2>
											
												<a href="{{ request()->query() == null ? route('edit_round', ['round' => $i]) : route('edit_round', ['round' => $i, 'season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn rounded white black-text">Edit Championship Game</a>
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
									
									<a href="{{ request()->query() == null ? route('edit_playins') : route('edit_playins', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn rounded white black-text">Edit Playin</a>
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

									<a href="{{ request()->query() == null ? route('edit_playins') : route('edit_playins', ['season' => request()->query('season'), 'year' => request()->query('year')]) }}" class="btn btn rounded white black-text">Edit Playin Games</a>
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
			
			<!--Column will include seasons (archieved and current)-->
			<div class="col py-3 d-none d-lg-block">
				<!--Show completed season if any available-->
				<h2 class="text-center h2-responsive">Completed Seasons</h2>
				
				@if($completedSeasons->isNotEmpty())
					@foreach($completedSeasons as $completedSeason)
						<div class="text-center">
							<a href="{{ route('archives', ['season' => $completedSeason->id]) }}" class="btn btn-rounded btn-lg purple darken-2 d-block">{{ ucfirst($completedSeason->name) }}</a>
						</div>
					@endforeach
				@else
					<div class="text-center">
						<h4 class="h4-responsive">You do not currently have any completed season in the archives</h4>
					</div>
				@endif
			</div>
		</div>
		
		<!--New Season Modal-->
		<div class="modal fade" id="newSeasonForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					{!! Form::open(['action' => ['LeagueSeasonController@store', 'league' => $showSeason->league_profile->id], 'method' => 'POST']) !!}
						<div class="modal-header text-center">
							<h4 class="modal-title w-100 font-weight-bold">New Season</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body mx-3">
							<div class="row">
								<div class="col-12 col-lg">
									<div class="md-form">
										<select class="mdb-select" name="season" required>
											<option value="" disabled selected>Choose A Season</option>
											<option value="winter">Winter</option>
											<option value="spring">Spring</option>
											<option value="summer">Summer</option>
											<option value="fall">Fall</option>
										</select>

										<label data-error="wrong" data-success="right" for="season" class="blue-text">Season</label>
									</div>
								</div>
								<div class="col-12 col-lg">
									<div class="md-form">
										<select class="mdb-select" name="year" required>
											<option value="" disabled selected>Choose A Year</option>
											<option value="2018">2018</option>
											<option value="2019">2019</option>
											<option value="2020">2020</option>
											<option value="2021">2021</option>
										</select>

										<label data-error="wrong" data-success="right" for="season" class="blue-text">Year</label>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-12 col-lg">
									<div class="md-form input-group">
										<div class="input-group-prepend">
											<i class="fa fa-dollar input-group-text" aria-hidden="true"></i>
										</div>
										
										<input type="number" name="league_fee" class="form-control" id="league_fee" value="{{ $showSeason->league_profile->leagues_fee == null ? 0.00 : $showSeason->league_profile->leagues_fee }}" step="0.01" placeholder="League Entry Fee" required />
										
										<div class="input-group-prepend">
											<span class="input-group-text">Per Team</span>
										</div>
										
										<label for="leagues_fee">Entry Fee</label>
									</div>
								</div>
								<div class="col-12 col-lg">
									<div class="md-form input-group">
										<div class="input-group-prepend">
											<i class="fa fa-dollar input-group-text" aria-hidden="true"></i>
										</div>
										
										<input type="number" class="form-control" class="form-control" name="ref_fee" id="ref_fee" value="{{ $showSeason->league_profile->ref_fee == null ? 0.00 : $showSeason->league_profile->ref_fee }}" step="0.01" placeholder="League Referee Fee" required />
										
										<div class="input-group-prepend">
											<span class="input-group-text">Per Game</span>
										</div>
										
										<label for="ref_fee">Ref Fee</label>
									</div>
								</div>
							</div>

							<div class="md-form">
								<select class="mdb-select" name="age_group">
									@if(head($ageGroups) == '' || head($ageGroups) == null)
										<option value="blank" selected disabled>You do not have any age groups selected to choose from</option>
									@else
										@foreach($ageGroups as $ageGroup)
											<option value="{{ $ageGroup }}">{{ ucwords(str_ireplace('_', ' ', $ageGroup)) }}</option>
										@endforeach
									@endif
								</select>
								
								<label data-error="wrong" data-success="right" for="age_group" class="blue-text">Age Group</label>
							</div>

							<div class="md-form">
								<select class="mdb-select" name="comp_group">
									@if(head($ageGroups) == '' || head($ageGroups) == null)
										<option value="blank" selected disabled>You do not have any competition groups selected to choose from</option>
									@else
										@foreach($compGroups as $compGroup)
											<option value="{{ $compGroup }}">{{ ucwords(str_ireplace('_', ' ', $compGroup)) }}</option>
										@endforeach
									@endif
								</select>
								
								<label data-error="wrong" data-success="right" for="age_group" class="blue-text">Competition Group</label>
							</div>
							
							<div class="md-form">
								<input type="text" name="location" class="form-control" value="{{ old('location') ? old('location') : $showSeason->league_profile->address }}" />
								
								<label data-error="wrong" data-success="right" for="age_group">Games Location</label>
							</div>
						</div>
						<div class="modal-footer d-flex justify-content-center">
							<button type="submit" class="btn btn-deep-orange">Add Season</button>
						</div>
					{!! Form::close() !!}
					
					<script src="https://www.paypalobjects.com/api/checkout.js"></script>

					<div id="paypal-button"></div>

					<div id="confirm" class="hidden">
						<div>Ship to:</div>
						<div><span id="recipient"></span>, <span id="line1"></span>, <span id="city"></span></div>
						<div><span id="state"></span>, <span id="zip"></span>, <span id="country"></span></div>

						<button id="confirmButton">Complete Payment</button>
					</div>

					<div id="thanks" class="hidden">
						Thanks, <span id="thanksname"></span>!
					</div>

					<script>
						paypal.Button.render({

							env: 'production', // sandbox | production

							client: {
								sandbox:    'AZri7zmZvEDIt-EyO1A1kfvDzygfGcuOjVdowBT1pqqmuZFDhkKq9HG2HSMlkzo5ibNUBFf3-3GsuiGu',
								production: 'AS7p39CJ_I30Af236rVzKtkoq2LzJw5ZMJnFwcuPOXUVWwehJ7OJscCl43jknJB_sdjBqNVbTUYexfIN'
							},

							payment: function(data, actions) {
								return actions.payment.create({
									payment: {
										transactions: [
											{
												amount: { total: '0.01', currency: 'USD' }
											}
										]
									}
								});
							},

							// Wait for the payment to be authorized by the customer

							onAuthorize: function(data, actions) {

								// Get the payment details

								return actions.payment.get().then(function(data) {

									// Display the payment details and a confirmation button

									var shipping = data.payer.payer_info.shipping_address;

									document.querySelector('#recipient').innerText = shipping.recipient_name;
									document.querySelector('#line1').innerText     = shipping.line1;
									document.querySelector('#city').innerText      = shipping.city;
									document.querySelector('#state').innerText     = shipping.state;
									document.querySelector('#zip').innerText       = shipping.postal_code;
									document.querySelector('#country').innerText   = shipping.country_code;

									document.querySelector('#paypal-button').style.display = 'none';
									document.querySelector('#confirm').style.display = 'block';

									// Listen for click on confirm button

									document.querySelector('#confirmButton').addEventListener('click', function() {

										// Disable the button and show a loading message

										document.querySelector('#confirm').innerText = 'Loading...';
										document.querySelector('#confirm').disabled = true;

										// Execute the payment

										return actions.payment.execute().then(function() {

											// Show a thank-you note

											document.querySelector('#thanksname').innerText = shipping.recipient_name;

											document.querySelector('#confirm').style.display = 'none';
											document.querySelector('#thanks').style.display = 'block';
										});
									});
								});
							}

						}, '#paypal-button');

					</script>
				</div>
			</div>
		</div>
		
		<!-- Complete season -->
		<div class="modal fade coolText4" id="complete_season" tabindex="-1" role="dialog" aria-labelledby="completeSeason" aria-hidden="true" data-backdrop="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="">Complete Season</h1>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="red-text"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;Completing your season will add this season to the archives and remove it as an active season&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></p>
						
						<h2 class="h2-responsive my-5">Are you sure you want to complete this seasons?</h2>
						
						<div class="d-flex align-items-center justify-content-between">
							<button class="btn btn-lg green" type="button" onclick="event.preventDefault(); document.getElementById('complete_season_form').submit();">Yes</button>
								{!! Form::open(['action' => ['LeagueSeasonController@complete_season', 'season' => $showSeason->id, 'year' => $showSeason->year], 'id' => 'complete_season_form', 'method' => 'POST']) !!}
								{!! Form::close() !!}
							<button class="btn btn-lg btn-warning" type="button" data-dismiss="modal" aria-label="Close">No</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
