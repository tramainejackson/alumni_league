<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Favicon -->
	<!-- <link rel="shortcut icon" href="/favicon_jrh.ico" type="image/x-icon">
	<link rel="icon" href="/favicon_jrh.ico" type="image/x-icon"> -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ToTheRec') }}</title>

    <!-- Styles -->
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Bootstrap core CSS -->
	<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link href="{{ asset('/css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/ttr.css') }}" rel="stylesheet">
	
	@if(substr_count(request()->server('HTTP_USER_AGENT'), 'rv:') > 0)
		<link href="{{ asset('/css/myIEcss.css') }}" rel="stylesheet">
	@endif
	
	@yield('addt_style')
</head>
<body>
	@php
		$queryStrCheck = request()->query('season') != null && request()->query('year') != null ? ['season' => request()->query('season'), 'year' => request()->query('year')] : null;
	@endphp

    <div id="app">
        <nav class="navbar navbar-expand-lg justify-content-between">
			<div class="d-flex align-items-center">
				
				<!-- Branding Image -->
				@if(Auth::guest())
					<a class="navbar-brand" href="{{ route('welcome') }}">{{ config('app.name', 'ToTheRec') }}</a>
				@else
					<a class="navbar-brand" href="{{ $queryStrCheck == null ? route('league_info') : route('league_info', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">{{ config('app.name', 'ToTheRec') }}</a>
				@endif
				
				<ul class="nav navbar-nav" id=''>
					<li class="nav-item">
						<a class='league_home nav-link' href="{{ route('league_profile.index') }}">Leagues</a>
					</li>
				</ul>
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
						@if(isset($allComplete))
							<img src="{{ asset($showSeason->picture) == null ? '/images/commissioner.jpg' : asset($showSeason->picture) }}" class="img-fluid" />
						@else
							<img src="{{ asset($showSeason->league_profile->picture) == null ? '/images/commissioner.jpg' : asset($showSeason->league_profile->picture) }}" class="img-fluid" />
						@endif
					
						<div class="mask">
							<a class='league_home position-absolute bottom btn btn-light-blue' href="{{ $queryStrCheck == null ? route('home') : route('home', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">{{ !isset($allComplete) ? $showSeason->league_profile->name : $showSeason->name }}</a>
						</div>
					@endif
				</div>
				<ul class="custom-scrollbar nav navbar-nav">
					<!--/. Side navigation links -->
					
					@if (Auth::guest())
						<!-- Logins -->
						<li class="nav-item">
							<a href="{{ route('login') }}" class="nav-link btn indigo">Login
								<i class="fa fa-user" aria-hidden="true"></i>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('register') }}" class="nav-link btn indigo lighten-1">Register
								<i class="fa fa-user" aria-hidden="true"></i>
							</a>
						</li>
					@else
						<li class="nav-item">
							<a class='nav-link white-text' href="{{ $queryStrCheck == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']])  }}">Schedule</a>
						</li>
						<li class="nav-item">
							<a class='nav-link white-text' href="{{ $queryStrCheck == null ? route('league_standings') : route('league_standings', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">Standings</a>
						</li>
						<li class="nav-item">
							<a class='nav-link white-text' href="{{ $queryStrCheck == null ? route('league_stat.index') : route('league_stat.index', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">Stats</a>
						</li>
						<li class="nav-item">
							<a class='nav-link white-text' href="{{ $queryStrCheck == null ? route('league_teams.index') : route('league_teams.index', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">Teams</a>
						</li>
						<li class="nav-item">
							<a class='nav-link white-text' href="{{ $queryStrCheck == null ? route('league_pictures.index') : route('league_pictures.index', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">League Pics</a>
						</li>
						
						@if($activeSeasons->isNotEmpty())
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
													<a href="{{ route('home', ['season' => $activeSeason->id, 'year' => $activeSeason->year]) }}" class="" type="button">{{ $activeSeason->name }}</a>
												</li>
											@endforeach
										</ul>
									</div>
								</ul>
							</div>
						@else
						@endif
					
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
					@if(!Auth::guest())
						<li class="nav-item">
							<a class='league_home nav-link' href="{{ $queryStrCheck == null ? route('home') : route('home', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">{{ $showSeason->league_profile->name }}</a>
						</li>
						<li class="nav-item">
							<a class='nav-link' href="{{ $queryStrCheck == null ? route('league_schedule.index') : route('league_schedule.index', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']])  }}">Schedule</a>
						</li>
						<li class="nav-item">
							<a class='nav-link' href="{{ $queryStrCheck == null ? route('league_standings') : route('league_standings', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">Standings</a>
						</li>
						<li class="nav-item">
							<a class='nav-link' href="{{ $queryStrCheck == null ? route('league_stat.index') : route('league_stat.index', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">Stats</a>
						</li>
						<li class="nav-item">
							<a class='nav-link' href="{{ $queryStrCheck == null ? route('league_teams.index') : route('league_teams.index', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">Teams</a>
						</li>
						<li class="nav-item">
							<a class='nav-link' href="{{ $queryStrCheck == null ? route('league_pictures.index') : route('league_pictures.index', ['season' => $queryStrCheck['season'], 'year' => $queryStrCheck['year']]) }}">League Pics</a>
						</li>
					@endif
				</ul>
			</div>
			
			<div class="d-none d-lg-flex" id="">
				<ul class="nav navbar-nav navbar-right">
					@if(Auth::guest())
						<!-- Logins -->
						<li class="nav-item">
							<a href="{{ route('login') }}" class="nav-link btn indigo">Login
								<i class="fa fa-user" aria-hidden="true"></i>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('register') }}" class="nav-link btn indigo lighten-1">Register
								<i class="fa fa-user" aria-hidden="true"></i>
							</a>
						</li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								{{ $showSeason->league_profile->commish }} <span class="caret"></span>
							</a>

							<ul class="dropdown-menu" role="menu">
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
		
		@if(session('status'))
			<!-- Add return message -->
			<div class="returnMessage">
				<h3 class="h3-responsive flashMessage hidden">{{ session('status') }}</h3>
			</div>
		@endif
		
        @yield('content')
		
		@include('footer')
    </div>

	<!-- SCRIPTS -->
	<!-- JQuery -->
	<script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
	<!-- Bootstrap tooltips -->
	<script type="text/javascript" src="/js/popper.min.js"></script>
	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<!-- MDB core JavaScript -->
	<script type="text/javascript" src="/js/mdb.min.js"></script>
	<!--Google Maps-->
	<script src="https://maps.google.com/maps/api/js"></script>
	<script type="text/javascript" src="/js/ttr.js"></script>
	
	@yield('additional_scripts')
</body>
</html>
