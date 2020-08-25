 <nav class="navbar navbar-expand-lg justify-content-between">
	<div class="d-flex align-items-center">
		<!-- Branding Image -->
		<a class="navbar-brand indigo-text" href="{{ route('welcome') }}">{{ $league->name }}</a>
	</div>

	<!-- SideNav slide-out button -->
	<button type="button" data-activates="slide-out" class="btn btn-primary p-3 button-collapse navbar-toggler" data-toggle="collapse" data-target="#app-navbar-collapse" aria-controls="app-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="sr-only">Toggle Navigation</span>
		<i class="fa fa-bars"></i>
	</button>

	<!-- Sidebar navigation -->
	<div id="slide-out" class="side-nav fixed">
		<div class="view">
			@if(Auth::guest())
			@else
				@if($showSeason->league_profile)

					@if(isset($allComplete))
						<img src="{{ asset($showSeason->picture) == null ? '/images/commissioner.jpg' : asset($showSeason->picture) }}" class="img-fluid" />
					@else
						<img src="{{ asset($showSeason->league_profile->picture) == null ? '/images/commissioner.jpg' : asset($showSeason->league_profile->picture) }}" class="img-fluid" />
					@endif
				@else
					<img src="{{ asset($showSeason->picture) == null ? '/images/commissioner.jpg' : asset($showSeason->picture) }}" class="img-fluid" />
				@endif

				<div class="mask">
					<a class='league_home position-absolute bottom btn btn-light-blue' href="{{ $queryStrCheck == null ? route('welcome') : route('welcome', ['season' => $queryStrCheck['season']]) }}">
						@if($showSeason->league_profile)
							{{ !isset($allComplete) ? $showSeason->league_profile->name : $showSeason->name }}
						@else
							{{ $showSeason->name }}
						@endif
					</a>
				</div>
			@endif
		</div>

		<ul class="custom-scrollbar nav navbar-nav">

			<!--/. Side navigation links -->
			<li class="nav-item">
				<a class='nav-link white-text' href="{{ $queryStrCheck == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => $queryStrCheck['season']])  }}">Schedule</a>
			</li>
			<li class="nav-item">
				<a class='nav-link white-text' href="{{ $queryStrCheck == null ? route('league_standings') : route('league_standings', ['season' => $queryStrCheck['season']]) }}">Standings</a>
			</li>
			<li class="nav-item">
				<a class='nav-link white-text' href="{{ $queryStrCheck == null ? route('league_stat.index') : route('league_stat.index', ['season' => $queryStrCheck['season']]) }}">Stats</a>
			</li>
			<li class="nav-item">
				<a class='nav-link white-text' href="{{ $queryStrCheck == null ? route('league_teams.index') : route('league_teams.index', ['season' => $queryStrCheck['season']]) }}">Teams</a>
			</li>
			<li class="nav-item">
				<a class='nav-link white-text' href="{{ $queryStrCheck == null ? route('league_pictures.index') : route('league_pictures.index', ['season' => $queryStrCheck['season']]) }}">League Pics</a>
			</li>

			@if(Auth::guest())
				<!-- Logins -->
				<li class="nav-item">
					<a href="{{ route('login') }}" class="nav-link btn indigo white-text">Login
						<i class="fa fa-user" aria-hidden="true"></i>
					</a>
				</li>
			@endif

			@if (Auth::check())
				@if($showSeason->league_profile)
					@if($showSeason)
						<div id="accordion1" class="accordion">
							<ul class="collapsible collapsible-accordion">
								<li class="position-relative">
									<a class="collapsible-header collapsed pl-1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Seasons</a>
									<i class="fa fa-angle-up rotate-icon"></i>
								</li>

								<div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion1" class="collapse">
									<ul class="list-unstyled">

										@foreach($activeSeasons as $activeSeason)
											<li class="">
												<a href="{{ route('welcome', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="" type="button">{{ $activeSeason->name }}</a>
											</li>
										@endforeach
									</ul>
								</div>
							</ul>
						</div>
					@else
					@endif
				@endif

				@if($showSeason->league_profile)
					@if(!isset($allComplete))
						<li class="nav-item" id="archivedItems">
							<div id="accordion1" class="accordion">
								<ul class="collapsible collapsible-accordion">
									<li class="position-relative">
										<a class="collapsible-header collapsed pl-1" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Archives</a>
										<i class="fa fa-angle-up rotate-icon"></i>
									</li>

									<div id="collapseTwo" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion2" class="collapse">
										<ul class="list-unstyled">
											@foreach($showSeason->league_profile->seasons()->completed()->get() as $completedSeason)
												<li class="">
													<a class="dropdown-item" href="{{ route('archives', ['season' => $completedSeason->id]) }}">{{ $completedSeason->name }}</a>
												</li>
											@endforeach
										</ul>
									</div>
								</ul>
							</div>
						</li>
					@endif
				@endif


				<li class="nav-item">
					<a class='nav-link white-text' href="{{ route('logout') }}"
						onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
						Logout
					</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</li>
			@endif
			<!--/. Side navigation links -->
		</ul>
	</div>
	<!--/. Sidebar navigation -->

	<div class="d-none d-lg-flex" id="">
		<!-- Right Side Of Navbar -->
		<ul class="nav navbar-nav navbar-right" id='leagues_menu'>
			<li class="nav-item">
				<a id="leagues_season_link" class='nav-link indigo-text' href="{{ $queryStrCheck == null ? route('league_seasons.index') : route('league_seasons.index', ['season' => $queryStrCheck['season']])  }}">Seasons</a>
			</li>
			<li class="nav-item">
				<a id="leagues_schedule_link" class='nav-link indigo-text' href="{{ $queryStrCheck == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => $queryStrCheck['season']])  }}">Schedule</a>
			</li>
			<li class="nav-item">
				<a id="" class='nav-link indigo-text' href="{{ $queryStrCheck == null ? route('league_standings') : route('league_standings', ['season' => $queryStrCheck['season']]) }}">Standings</a>
			</li>
			<li class="nav-item">
				<a id="" class='nav-link indigo-text' href="{{ $queryStrCheck == null ? route('league_stat.index') : route('league_stat.index', ['season' => $queryStrCheck['season']]) }}">Stats</a>
			</li>
			<li class="nav-item">
				<a id="" class='nav-link indigo-text' href="{{ $queryStrCheck == null ? route('league_teams.index') : route('league_teams.index', ['season' => $queryStrCheck['season']]) }}">Teams</a>
			</li>
			<li class="nav-item">
				<a id="" class='league_home nav-link indigo-text' href="{{ $queryStrCheck == null ? route('league_info') : route('league_info', ['season' => $queryStrCheck['season']]) }}">League Info</a>
			</li>
			{{--<li class="nav-item">--}}
				{{--<a id="" class='nav-link indigo-text' href="{{ $queryStrCheck == null ? route('league_pictures.index') : route('league_pictures.index', ['season' => $queryStrCheck['season']]) }}">League Pics</a>--}}
			{{--</li>--}}

			@if(Auth::check())
				<li class="nav-item">
					<a id="" class='nav-link indigo-text' href="{{ $queryStrCheck == null ? route('users.index') : route('users.index', ['season' => $queryStrCheck['season']]) }}">Users</a>
				</li>
			@endif
		</ul>
	</div>

	<div class="d-none d-lg-flex" id="">
		<ul class="nav navbar-nav navbar-right">
			@if(Auth::guest())
				<!-- Login -->
				<li class="nav-item">
					<a href="{{ route('login') }}" class="nav-link btn indigo white-text">Login
						<i class="fa fa-user" aria-hidden="true"></i>
					</a>
				</li>
			@else
				<li class="dropdown pt-2">
					<a href="#" class="dropdown-toggle indigo-text" data-toggle="dropdown" role="button" aria-expanded="false">
						{{ $showSeason->league_profile ? $showSeason->league_profile->commish : $showSeason->commish }} <span class="caret"></span>
					</a>

					<ul class="dropdown-menu" role="menu" style="min-width: 8rem;">
						<li>
							<a href="{{ route('logout') }}"
								onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								Logout
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</li>
			@endif
		</ul>
	</div>
</nav>