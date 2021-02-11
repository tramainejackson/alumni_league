@extends('layouts.app')

@section('content')
	<div id="leagues_landing_page" class="">
		<div class="view">
			<div class="mask d-flex flex-column rgba-blue-light align-items-center justify-content-center white-text coolText3 text-center">
				<h1 class="font-weight-bold display-2 wow fadeInLeft aboutPageH1" data-wow-delay="1.0s">The</h1>
				<h2 class="wow fadeInRight aboutPageH2 display-3" data-wow-delay="1.0s">Alumni League</h2>
			</div>	
		</div>
		<div class="container-fluid">
			<div class="row align-items-stretch text-center mt-3 mb-5 coolText4">
				<div class="col-12 col-md-6 mt-5 mx-auto">
					<h2 class="h2-responsive">We keep in depth stats for all the players in the league. Teams and players will be able to see league leaders and their team stats as the season progresses.</h2>
					<img src="/images/stats_screen_shot.png" class="img-fluid z-depth-4 rounded" />
				</div>
				<div class="col-12 my-5"></div>
				<div class="col-12 col-md-5 mx-auto">
					<h2 class="h2-responsive">Check out standings to see where your team ranks amongst the rest of the league</h2>
					<img src="/images/standings_screen_shot.png" class="img-fluid z-depth-4 rounded" />
				</div>
				<div class="d-block d-md-none col-12 my-5"></div>
				<div class="col-12 col-md-5 mx-auto">
					<h2 class="h2-responsive">Stay up to date with all the teams schedules and find the best games to check out</h2>
					<img src="/images/schedule_screen_shot.png" class="img-fluid z-depth-4 rounded" />
				</div>
			</div>
		</div>
		
		<div class="rgba-black-strong" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/images/alumni_league2.png'); background-attachment: fixed; background-repeat: no-repeat; background-size: cover; background-position: center center;">

			<div class="d-flex align-items-center justify-content-around" id="">
				<a href="{{ route('league_info') }}" class="btn btn-outline-white my-5">Contact Us</a>
			</div>

			{{--<div class="container pt-5">--}}
				{{--<div class="row">--}}
					{{--<div class="col mt-5 coolText4 wow fadeInUpBig" data-wow-delay="0.5s">--}}
						{{--<h1 class="rounded p-4 text-center white h1-responsive">Get started by creating an account for your league. Have your league up and running in minutes.</h1>--}}
					{{--</div>--}}
				{{--</div>--}}
				{{--<div  class="row">--}}
					{{--<!--Card-->--}}
					{{--<div class="card mb-5 col p-0 mx-1 mx-md-5 wow fadeInUpBig" data-wow-delay="0.5s">--}}
						{{--<!--Card image-->--}}
						{{--<div class="view gradient-card-header peach-gradient text-center py-3 coolText4" style="height: auto">--}}
							{{--<h2 class="">Register</h2>--}}
						{{--</div>--}}
						{{--<!--Card content-->--}}
						{{--<div class="card-body">--}}
							{{--<!-- Contact form -->--}}
							{{--{!! Form::open(['action' => ['HomeController@store'], 'method' => 'POST']) !!}--}}
								{{--<div class="col-12 col-md-8 mx-auto">--}}
									{{--<!-- input text -->--}}
									{{--<div class="md-form">--}}
										{{--<i class="fa fa-user prefix"></i>--}}
										{{----}}
										{{--<input type="text" name="contact_name" id="contact_name" class="form-control" />--}}
										{{----}}
										{{--<label for="contact_name">Your name</label>--}}
									{{--</div>--}}

									{{--<!-- input email -->--}}
									{{--<div class="md-form">--}}
										{{--<i class="fa fa-envelope prefix"></i>--}}
										{{----}}
										{{--<input type="email" name="contact_email" id="contact_email" class="form-control" />--}}
										{{----}}
										{{--<label for="contact_email">Your email</label>--}}
									{{--</div>--}}
									{{----}}
									{{--<!-- input subject -->--}}
									{{--<div class="md-form">--}}
										{{--<i class="fa fa-id-badge prefix" aria-hidden="true"></i>--}}
										{{----}}
										{{--<input type="text" name="contact_subject" id="contact_subject" class="form-control">--}}
										{{----}}
										{{--<label for="contact_subject">League Name</label>--}}
									{{--</div>--}}
									{{----}}
									{{--<!-- input subject -->--}}
									{{--<div class="md-form">--}}
										{{--<i class="fa fa-address-card prefix" aria-hidden="true"></i>--}}
										{{----}}
										{{--<input type="text" name="contact_subject" id="contact_subject" class="form-control">--}}
										{{----}}
										{{--<label for="contact_subject">League Address</label>--}}
									{{--</div>--}}
									{{----}}
									{{--<!-- input subject -->--}}
									{{--<div class="md-form">--}}
										{{--<i class="fa fa-phone prefix" aria-hidden="true"></i>--}}
										{{----}}
										{{--<input type="text" name="contact_subject" id="contact_subject" class="form-control">--}}
										{{----}}
										{{--<label for="contact_subject">League Phone</label>--}}
									{{--</div>--}}
									{{----}}
									{{--<div class="text-center mt-4">--}}
										{{--<button class="btn btn-outline-secondary w-100" type="submit">Register<i class="fa fa-paper-plane-o ml-2"></i></button>--}}
									{{--</div>--}}
								{{--</div>--}}
							{{--{!! Form::close() !!}--}}
						{{--</div>--}}
					{{--</div>--}}
					{{--<!--/.Card-->--}}
				{{--</div>--}}
			{{--</div>--}}
		</div>
		
		{{--<div class="">--}}
			{{--<div class="view d-flex align-items-center justify-content-center text-center rgba-black-slight">--}}
				{{--<div class="">--}}
					{{--<h1 class="h1-responsive coolText3">Not sure if this is for your league or not?</h1>--}}
					{{----}}
					{{--<h2 class="h2-responsive my-3 coolText3">Click here and take it for a test drive with the test account</h2>--}}
					{{----}}
					{{--<p class="">--}}
						{{--<a href="{{ route('test_drive') }}" class="btn btn-lg peach-gradient">Test Drive</a>--}}
					{{--</p>--}}
				{{--</div>--}}
			{{--</div>--}}
		{{--</div>--}}
	</div>

	<div class="container-fluid pt-5 my-5">
		<section class="p-md-3 mx-md-5">
			<div class="row d-flex justify-content-between align-items-center">
				<div class="col-md-6 mb-4">
					<h1 class="font-weight-bold mb-3">Keep It 300!</h1>
					<p class="text-muted pt-3">
						Talk that talk! We don't shy away from anything. The players, rivalries, and love for the
						game is as real as it come. The conversation never ends. Either on FB or the Gram, if you got something to
						say, say it with ya chest! We keep it 300 over here.
					</p>
				</div>
				<div class="col-md-6 col-lg-4 d-sm-flex justify-content-center mb-md-0 mb-5 d-none">
					<img src="{{ asset('/images/alumni_league4.png') }}" alt="" class="img-fluid">
				</div>
			</div>
			<div class="row pt-3">
				<div class="col-lg-4 col-md-6 mb-5">
					<h4 class="font-weight-bold mb-3">
						<i class="fas fa-users purple-text"></i> Family Fun
					</h4>

					<p class="text-muted mb-lg-0">Brings the whole family out to enjoy some great basketball. We provide a concession stand with hot dogs, chips and drinks for all.</p>
				</div>
				<div class="col-lg-4 col-md-6 mb-5">
					<h4 class="font-weight-bold mb-3">
						<i class="fab fa-hotjar red-text"></i> Competitive Play
					</h4>

					<p class="text-muted mb-lg-0">This is the best basketball league in the Tri-State area. POINT. BLANK. PERIOD. Be careful what you ask for. We give out all the smoke</p>
				</div>
				<div class="col-lg-4 col-md-6 mb-5">
					<h4 class="font-weight-bold mb-3">
						<i class="fas fa-basketball-ball orange-text"></i> Women's Basketball
					</h4>

					<p class="text-muted mb-md-0">We have not forgot about our women's athletes. Check out the women's league and show your support for them as well.</p>
				</div>
			</div>
		</section>
	</div>

	<!-- Footer -->
	@include('content_parts.footer')
	<!-- Footer -->
@endsection