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

    <title>{{ $league->name }}</title>

    <!-- Styles -->
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	<!-- Bootstrap core CSS -->
	<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">

	<!-- Material Design Bootstrap -->
	<link href="{{ asset('/css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/ttr.css') }}" rel="stylesheet">
	
	@if(substr_count(request()->server('HTTP_USER_AGENT'), 'rv:') > 0)
		<link href="{{ asset('/css/myIEcss.css') }}" rel="stylesheet">
	@endif
	
	@yield('styles')
</head>
<body>

	@php
		$queryStrCheck = request()->query('season') != null ? ['season' => request()->query('season')] : null;
	@endphp

    <div id="app">

		@include('layouts.navigation')

		@if(session('status'))
			<!-- Add return message -->
			<div class="returnMessage">
				<h3 class="h3-responsive flashMessage hidden">{{ session('status') }}</h3>
			</div>
		@endif
		
        @yield('content')

    </div>

	<!-- SCRIPTS -->
	<!-- JQuery -->
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<!-- Bootstrap tooltips -->
	<script type="text/javascript" src="/js/popper.min.js"></script>
	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<!-- MDB core JavaScript -->
	<script type="text/javascript" src="/js/mdb.min.js"></script>
	<script type="text/javascript" src="/js/ttr.js"></script>

	{{--@if(session()->has('testdrive'))--}}
        {{--@if(session()->get('testdrive') == 'true')--}}
            {{--<script type="text/javascript" src="/js/test_drive_tutorial.js"></script>--}}
        {{--@endif--}}
	{{--@endif--}}

	@yield('additional_scripts')
</body>
</html>
