<nav class="navbar navbar-expand-lg justify-content-between">
	<div class="d-flex align-items-center">
		<!-- Brand -->
		<a class="navbar-brand waves-effect indigo-text" href="{{ route('welcome', ['season' => $showSeason->id], false) }}">
			<img src="{{ asset('images/alumni_league_logo_lg_sm.png') }}" height="50px" alt="Logo">
		</a>
	</div>

	<!-- SideNav slide-out button -->
	<button type="button" data-activates="slide-out" class="btn btn-primary p-3 button-collapse navbar-toggler" data-toggle="collapse" data-target="#app-navbar-collapse" aria-controls="app-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="sr-only">Toggle Navigation</span>
		<i class="fa fa-bars"></i>
	</button>

	<!-- Sidebar navigation -->
	<div id="slide-out" class="side-nav fixed">
		<div class="view">
			@if($showSeason->league_profile)
				<img src="{{ asset($showSeason->league_profile->picture) == null ? '/images/commissioner.jpg' : asset($showSeason->league_profile->picture) }}" class="img-fluid" />
			@else
				<img src="{{ asset($showSeason->picture) == null ? '/images/commissioner.jpg' : asset($showSeason->picture) }}" class="img-fluid" />
			@endif
		</div>

		<ul class="custom-scrollbar nav navbar-nav p-2">
			<!--/. Side navigation links -->
			@if($activeSeasons->isNotEmpty())
				<li id="accordion1" class="accordion nav-link nav-item{{ substr_count(url()->current(),'season') > 0 ? ' activeNav': '' }}">
					<ul class="collapsible collapsible-accordion">
						<li class="position-relative">
							<a class="collapsible-header collapsed pl-1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="font-size: 1rem;">Seasons</a>
							<i class="fa fa-angle-up rotate-icon"></i>
						</li>

						<div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion1" class="collapse">
							<ul class="list-unstyled">
								<a id="" class='white-text' href="{{ $queryStrCheck == null ? route('league_seasons.index') : route('league_seasons.index', ['season' => $queryStrCheck['season']]) }}">Seasons Info</a>

								<div class="dropdown-divider"></div>

								@foreach($activeSeasons as $activeSeason)
									<li>
										<a href="{{ (substr_count(url()->current(),'archive') > 0) || (request()->getPathInfo() == '/') ? route('league_seasons.index', ['season' => $activeSeason->id], false) : url()->current() . '?season=' . $activeSeason->id }}" class="white-text{{ $activeSeason->id == $showSeason->id ? ' rgba-grey-strong white-text' : '' }}">{{ $activeSeason->name }}</a>
									</li>
								@endforeach
							</ul>
						</div>
					</ul>
				</li>
			@else
			@endif

			<li class="nav-item">
				<a id="leagues_schedule_link" class='nav-link white-text{{ substr_count(url()->current(),'schedule') > 0 ? ' activeNav': '' }}' href="{{ route('league_schedule.index', ['season' => $showSeason->id], false) }}">Schedule</a>
			</li>
			<li class="nav-item">
				<a id="" class='nav-link white-text{{ substr_count(url()->current(),'standings') > 0 ? ' activeNav': '' }}' href="{{ route('league_standings', ['season' => $showSeason->id], false) }}">Standings</a>
			</li>
			<li class="nav-item">
				<a id="" class='nav-link white-text{{ substr_count(url()->current(),'stats') > 0 ? ' activeNav': '' }}' href="{{ route('league_stats.index', ['season' => $showSeason->id], false) }}">Stats</a>
			</li>
			<li class="nav-item">
				<a id="" class='nav-link white-text{{ substr_count(url()->current(),'teams') > 0 ? ' activeNav': '' }}' href="{{ route('league_teams.index', ['season' => $showSeason->id], false) }}">Teams</a>
			</li>
			<li class="nav-item">
				<a id="" class='league_home nav-link white-text{{ substr_count(url()->current(),'info') > 0 ? ' activeNav': '' }}' href="{{ route('league_info', ['season' => $showSeason->id], false) }}">League Info</a>
			</li>

			{{-- Add History Tab If League Has Completed Seasons--}}
			@if($completedSeasons->isNotEmpty())
				<li class="nav-item" id="archivedItems">
					<a id="" class='nav-link white-text{{ substr_count(url()->current(),'archive') > 0 ? ' activeNav': '' }}' href="{{ route('archives_index') }}">History</a>
				</li>
			@endif
			{{--<li class="nav-item">--}}
				{{--<a class='nav-link white-text' href="{{ route('league_pictures.index', ['season' => $showSeason->id], false) }}">League Pics</a>--}}
			{{--</li>--}}

			@if (Auth::check())
				<li class="nav-item">
					<a class='nav-link white-text' href="{{ route('logout') }}"
						onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
						Logout
					</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</li>
			@else
				<!-- Logins -->
				<li class="nav-item">
					<a href="{{ route('login') }}" class="nav-link btn indigo white-text">Login
						<i class="fa fa-user" aria-hidden="true"></i>
					</a>
				</li>
			@endif
			<!--/. Side navigation links -->
		</ul>
	</div>
	<!--/. Sidebar navigation -->

	<div class="d-none d-lg-flex" id="">
		<!-- Right Side Of Navbar -->
		<ul class="nav navbar-nav navbar-right" id='leagues_menu'>
			@if($activeSeasons->isNotEmpty())
				<li class="nav-item dropdown">
					<a id="leagues_season_link" class='nav-link dropdown-toggle indigo-text{{ substr_count(url()->current(),'season') > 0 ? ' activeNav': '' }}' href="{{ route('league_seasons.index', ['season' => $showSeason->id], false) }}" type="button" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ request()->query('season') != null ? \App\LeagueSeason::showSeason(request()->query('season'))->name : 'Seasons' }}</a>

					<div class="dropdown-menu dropdown-secondary" aria-labelledby="leagues_season_link">
						<a id="" class='nav-link indigo-text' href="{{ $queryStrCheck == null ? route('league_seasons.index') : route('league_seasons.index', ['season' => $queryStrCheck['season']]) }}">Seasons</a>

						<div class="dropdown-divider"></div>

						@foreach($activeSeasons as $activeSeason)
							<a href="{{ (substr_count(url()->current(),'archive') > 0) || (request()->getPathInfo() == '/') ? route('league_seasons.index', ['season' => $activeSeason->id], false) : url()->current() . '?season=' . $activeSeason->id }}" class="dropdown-item indigo-text{{ $activeSeason->id == $showSeason->id ? ' rgba-grey-strong white-text' : '' }}">{{ $activeSeason->name }}</a>
						@endforeach
					</div>
				</li>
			@else
				<li class="nav-item">
					<a id="leagues_season_link" class='nav-link indigo-text{{ substr_count(url()->current(),'season') > 0 ? ' activeNav': '' }}' href="{{ route('league_seasons.index', ['season' => $showSeason->id], false) }}">Seasons</a>
				</li>
			@endif

			<li class="nav-item">
				<a id="leagues_schedule_link" class='nav-link indigo-text{{ substr_count(url()->current(),'schedule') > 0 ? ' activeNav': '' }}' href="{{ route('league_schedule.index', ['season' => $showSeason->id], false) }}">Schedule</a>
			</li>
			<li class="nav-item">
				<a id="" class='nav-link indigo-text{{ substr_count(url()->current(),'standings') > 0 ? ' activeNav': '' }}' href="{{ route('league_standings', ['season' => $showSeason->id], false) }}">Standings</a>
			</li>
			<li class="nav-item">
				<a id="" class='nav-link indigo-text{{ substr_count(url()->current(),'stats') > 0 ? ' activeNav': '' }}' href="{{ route('league_stats.index', ['season' => $showSeason->id], false) }}">Stats</a>
			</li>
			<li class="nav-item">
				<a id="" class='nav-link indigo-text{{ substr_count(url()->current(),'teams') > 0 ? ' activeNav': '' }}' href="{{ route('league_teams.index', ['season' => $showSeason->id], false) }}">Teams</a>
			</li>
			<li class="nav-item">
				<a id="" class='league_home nav-link indigo-text{{ substr_count(url()->current(),'info') > 0 ? ' activeNav': '' }}' href="{{ route('league_info', ['season' => $showSeason->id], false) }}">League Info</a>
			</li>

			@if($completedSeasons->isNotEmpty())
				<li class="nav-item">
					<a id="" class='nav-link indigo-text{{ substr_count(url()->current(),'archive') > 0 ? ' activeNav': '' }}' href="{{ route('archives_index') }}">History</a>
				</li>
			@endif
			{{--<li class="nav-item">--}}
				{{--<a id="" class='nav-link indigo-text' href="{{ $queryStrCheck == null ? route('league_pictures.index') : route('league_pictures.index', ['season' => $queryStrCheck['season']]) }}">League Pics</a>--}}
			{{--</li>--}}

			@if(Auth::check())
				@if(Auth::user()->type == 'admin')
					<li class="nav-item">
						<a id="" class='nav-link indigo-text{{ substr_count(url()->current(),'message') > 0 ? ' activeNav': '' }}' href="{{ route('messages.index', ['season' => $showSeason->id], false) }}">Messages</a>
					</li>
					<li class="nav-item">
						<a id="" class='nav-link indigo-text{{ substr_count(url()->current(),'user') > 0 ? ' activeNav': '' }}' href="{{ route('users.index', ['season' => $showSeason->id], false) }}">Users</a>
					</li>
				@endif
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
						<span class="text-truncate">{{ Auth::user()->name }}</span><span class="caret"></span>
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