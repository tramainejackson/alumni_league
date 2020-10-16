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
	
	@yield('styles')
</head>
<body>

	<div class="container-fluid bgrd3">
		<div class="row">
			<div class="col view d-flex align-items-center justify-content-center">
				
				<!-- Error Message -->
				<div class="" id="" onclick="move()">
					<h1 class="text-center p-3 rounded mt-5 bg-warning">This is not a functional page. You will be redirected in <span class="redirectTimer">10</span> seconds</h1>
				</div>
				
				<script>
					var countdown = 10;
					var timer = setInterval(frame, 1000);

					function frame() {
						if(countdown == 0) {
							clearInterval(timer);
							window.history.back()
						} else {
							countdown--;
							$('.redirectTimer').text(countdown);
						}
					}

				</script>

			</div>
		</div>
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
	
</body>
</html>