		@elseif(isset($_GET["filter"]))
			<div class="search_box">
				<input class="player_search" name="search" type="search" placeholder="Search Player"/>				
				<a class="addFilter" href="#">Search</a>
				<a class="removeFilter" href="players.php">Remove Filter</a>
			</div>
			@php $player = Player_Profile::get_player_profiles_by_letter($_GET["filter"]); endphp
			
			@if(is_object($player))
				@php $showPlayer = $player; @endphp
					<div class="playersPage">
						<div class="playerPicture">
							<div style="background-image:url(../uploads/{{ $showPlayer->picture }})" class=""></div>
						</div>
						<div class="playerNameHeader">
							<div class="">
								<h2 class="">
									@php $nickname = $showPlayer->nickname != "" ? "\"".$showPlayer->nickname."\"" : " "; @endphp
									{{ $nickname }}
								</h2>
							</div>
							<div class="">
								<h2 class="">
									{{ $showPlayer->firstname . " " .  $showPlayer->lastname }}
								</h2>
							</div>
						</div>
						<div class="playerBio">
							<ul>
								@php $checkVideoCount = Player_Profile::find_player_videos_by_id($showPlayer->get_player_id()); @endphp
								@php $bio  = $showPlayer->height != "" ? "<li class='playerBioItem'><span class='label'>Height:</span><span class='labelContent'>".$showPlayer->height."</span></li>" : ""; ?>
								@php $bio .= $showPlayer->weight > 0 ? "<li class='playerBioItem'><span class='label'>Weight:</span><span class='labelContent'>".$showPlayer->weight."</span></li>" : ""; ?>
								@php $bio .= $showPlayer->highschool != "" ? "<li class='playerBioItem' title='".$showPlayer->highschool."'><span class='label'>HS:</span><span class='labelContent'>".$showPlayer->highschool."</span></li>" : ""; ?>
								@php $bio .= $showPlayer->college != "" ? "<li class='playerBioItem' title='".$showPlayer->college."'><span class='label'>College:</span><span class='labelContent'>".$showPlayer->college."</span></li>" : ""; ?>
								@php $bio .= !empty($checkVideoCount) ? "<li class='playerBioItem'><span class='label'>Highlights:</span><span class='labelContent'>".count($checkVideoCount)."</span></li>" : ""; ?>
								{{ $bio; ?>
							</ul>
						</div>
						<div class="playerFooter">
							<a href="players.php?player={{ $showPlayer->firstname."_".$showPlayer->lastname."&num=".$showPlayer->get_player_id(); ?>">Go To Profile</a>						
						</div>
					</div>
			@else
				@foreach($player as $showPlayer)
					<div class="playersPage">
						<div class="playerPicture">
							<div style="background-image:url(../uploads/{{ $showPlayer->picture; ?>)" class=""></div>
						</div>
						<div class="playerNameHeader">
							<div class="">
								<h2 class="">
									@php $nickname = $showPlayer->nickname != "" ? "\"".$showPlayer->nickname."\"" : " "; ?>
									{{ $nickname;?>
								</h2>
							</div>
							<div class="">
								<h2 class="">
									{{ $showPlayer->firstname . " " .  $showPlayer->lastname;?>
								</h2>
							</div>
						</div>
						<div class="playerBio">
							<ul>
								@php $checkVideoCount = mysqli_num_rows(find_player_videos_by_id($showPlayer->get_player_id())); ?>
								@php $bio  = $showPlayer->height != "" ? "<li class='playerBioItem'><span class='label'>Height:</span><span class='labelContent'>".$showPlayer->height."</span></li>" : ""; ?>
								@php $bio .= $showPlayer->weight > 0 ? "<li class='playerBioItem'><span class='label'>Weight:</span><span class='labelContent'>".$showPlayer->weight."</span></li>" : ""; ?>
								@php $bio .= $showPlayer->highschool != "" ? "<li class='playerBioItem' title='".$showPlayer->highschool."'><span class='label'>HS:</span><span class='labelContent'>".$showPlayer->highschool."</span></li>" : ""; ?>
								@php $bio .= $showPlayer->college != "" ? "<li class='playerBioItem' title='".$showPlayer->college."'><span class='label'>College:</span><span class='labelContent'>".$showPlayer->college."</span></li>" : ""; ?>
								@php $bio .= $checkVideoCount > 0 ? "<li class='playerBioItem'><span class='label'>Highlights:</span><span class='labelContent'>".count($checkVideoCount)."</span></li>" : ""; ?>
								{{ $bio; ?>
							</ul>
						</div>
						<div class="playerFooter">
							<a href="players.php?player={{ $showPlayer->firstname."_".$showPlayer->lastname."&num=".$showPlayer->player_id; ?>">Go To Profile</a>						
						</div>
					</div>
				@endforeach
			@endif
		@elseif(isset($_GET["filter_search"]))
			<div class="search_box">
				<input class="player_search" name="search" type="search" placeholder="Search Player" value="{{ isset($_GET["filter_search"]) ? $_GET["filter_search"] : ""; ?>"/>				
				<a class="addFilter" href="#">Search</a>
				<a class="removeFilter" href="players.php">Remove Filter</a>
			</div>
			@php $player = Player_Profile::get_players_by_search($_GET["filter_search"]) @endphp
			@if(!empty($player))
				@if(is_object($player))
					@php $showPlayer = $player; @endphp
					<div class="playersPage">
						<div class="playerPicture">
							<div style="background-image:url(../uploads/{{ $showPlayer->picture }})" class=""></div>
						</div>
						<div class="playerNameHeader">
							<div class="">
								<h2 class="">
									@php $nickname = $showPlayer->nickname != "" ? "\"".$showPlayer->nickname."\"" : " " @endphp
									{{ $nickname }}
								</h2>
							</div>
							<div class="">
								<h2 class="">
									{{ $showPlayer->firstname . " " .  $showPlayer->lastname }}
								</h2>
							</div>
						</div>
						<div class="playerBio">
							<ul>
								@php $checkVideoCount = Video::find_player_videos_by_id($showPlayer->get_player_id()); ?>
								@php $bio  = $showPlayer->height != "" ? "<li class='playerBioItem'><span class='label'>Height:</span><span class='labelContent'>".$showPlayer->height."</span></li>" : ""; ?>
								@php $bio .= $showPlayer->weight > 0 ? "<li class='playerBioItem'><span class='label'>Weight:</span><span class='labelContent'>".$showPlayer->weight."</span></li>" : ""; ?>
								@php $bio .= $showPlayer->highschool != "" ? "<li class='playerBioItem' title='".$showPlayer->highschool."'><span class='label'>HS:</span><span class='labelContent'>".$showPlayer->highschool."</span></li>" : ""; ?>
								@php $bio .= $showPlayer->college != "" ? "<li class='playerBioItem' title='".$showPlayer->college."'><span class='label'>College:</span><span class='labelContent'>".$showPlayer->college."</span></li>" : ""; ?>
								@php $bio .= !empty($checkVideoCount) ? "<li class='playerBioItem'><span class='label'>Highlights:</span><span class='labelContent'>".count($checkVideoCount)."</span></li>" : ""; ?>
								{{ $bio }}
							</ul>
						</div>
						<div class="playerFooter">
							<a href="players.php?player={{ $showPlayer->firstname."_".$showPlayer->lastname."&num=".$showPlayer->get_player_id(); }}">Go To Profile</a>						
						</div>
					</div>
				@elseif(is_array($player))
					@foreach($player as $showPlayer)
						<div class="playersPage">
							<div class="playerPicture">
								<div style="background-image:url(../uploads/{{ $showPlayer->picture; ?>)" class=""></div>
							</div>
							<div class="playerNameHeader">
								<div class="">
									<h2 class="">
										@php $nickname = $showPlayer->nickname != "" ? "\"".$showPlayer->nickname."\"" : " "; ?>
										{{ $nickname }}
									</h2>
								</div>
								<div class="">
									<h2 class="">
										{{ $showPlayer->firstname . " " .  $showPlayer->lastname }}
									</h2>
								</div>
							</div>
							<div class="playerBio">
								<ul>
									@php $checkVideoCount = Video::find_player_videos_by_id($showPlayer->get_player_id()); ?>
									@php $bio  = $showPlayer->height != "" ? "<li class='playerBioItem'><span class='label'>Height:</span><span class='labelContent'>".$showPlayer->height."</span></li>" : ""; ?>
									@php $bio .= $showPlayer->weight > 0 ? "<li class='playerBioItem'><span class='label'>Weight:</span><span class='labelContent'>".$showPlayer->weight."</span></li>" : ""; ?>
									@php $bio .= $showPlayer->highschool != "" ? "<li class='playerBioItem' title='".$showPlayer->highschool."'><span class='label'>HS:</span><span class='labelContent'>".$showPlayer->highschool."</span></li>" : ""; ?>
									@php $bio .= $showPlayer->college != "" ? "<li class='playerBioItem' title='".$showPlayer->college."'><span class='label'>College:</span><span class='labelContent'>".$showPlayer->college."</span></li>" : ""; ?>
									@php $bio .= !empty($checkVideoCount) ? "<li class='playerBioItem'><span class='label'>Highlights:</span><span class='labelContent'>".count($checkVideoCount)."</span></li>" : ""; ?>
									{{ $bio; ?>
								</ul>
							</div>
							<div class="playerFooter">
								<a href="players.php?player={{ $showPlayer->firstname."_".$showPlayer->lastname."&num=".$showPlayer->get_player_id(); }}">Go To Profile</a>						
							</div>
						</div>
					@endforeach
				@endif
			@else
				<div id="noVideos_message">
					<p class="">No players meet the search critera for "{{ $_GET["filter_search"] }}"</p>
				</div>
			@endif
