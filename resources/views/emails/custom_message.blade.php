<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jackson Rental Homes Contact</title>
	
	<style>
		@media (min-width: 1400px) {
            p, h3 {
                font-size: 150%;
            }
        }
		
		img {
			height: 300px;
			margin-top: -90px !important;
			margin-bottom: -90px !important;
			margin-left: auto !important;
			margin-right: auto !important;
			text-align: center; 
			display: block;
		}
	</style>
</head>
<body>
    <div id="app" class="container">
		<div style="position:relative; height:100%;">
			<div style="box-sizing: border-box; width: 100% !important;">
				<img src="{{ url('/images/jrh_logo.png') }}" class="" height="250px" style="margin:0 auto; text-align: center; display: block;" />
			</div>
			<div style="font-family: 'Playfair Display', serif;">
				<p style="padding: 0px 35px 15px;">{{ $body }}</p>
			</div>
			<footer style="box-sizing: border-box; width: 100% !important;">
				<h3 style="border-bottom:1px solid gray; text-align: center; background: #5b955a; color: whitesmoke; padding: 35px;">2017 {{ config('app.name') }}. All rights reserved.</h3>
			</footer>
		</div>
	</div>
</body>