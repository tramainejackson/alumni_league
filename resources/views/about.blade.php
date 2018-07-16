@extends('layouts.app')

@section('additional_scripts')
	<script type="text/javascript">
		$('footer').remove();
	</script>
@endsection

@section('content')
	<div id="leagues_landing_page" class="">
		<div class="view">
			<div class="mask d-flex flex-column rgba-blue-light align-items-center justify-content-md-center justify-content-around white-text coolText3 text-center">
				<h1 class="font-weight-bold display-3 wow fadeInLeft aboutPageH1" data-wow-delay="0.4s">Save Time. Get Organized.</h1>
				<h2 class="wow fadeInRight aboutPageH2" data-wow-delay="0.4s">Manage your whole basketball league and keep everything in one location</h2>
				<h3 class="wow fadeInDown aboutPageH3" data-wow-delay="0.4s">Keeps Stats, Standings, Scores and More</h3>
			</div>	
		</div>
		<div class="container-fluid">
			<div class="row align-items-stretch text-center mt-3 mb-5 coolText4">
				<div class="col-12 col-md-6 mt-5 mx-auto">
					<h2 class="h2-responsive">Keep in depth stats for all the players in the league. Teams and players will be able to see league leaders and their team stats as the season progresses.</h2>
					<img src="/images/stats_screen_shot.png" class="img-fluid z-depth-4 rounded" />
				</div>
				<div class="col-12 my-5"></div>
				<div class="col-12 col-md-5 mx-auto">
					<h2 class="h2-responsive">Standings are a breeze. Automatically updated with game results</h2>
					<img src="/images/standings_screen_shot.png" class="img-fluid z-depth-4 rounded" />
				</div>
				<div class="d-block d-md-none col-12 my-5"></div>
				<div class="col-12 col-md-5 mx-auto">
					<h2 class="h2-responsive">Easily manage all your leagues games and their results in minutes</h2>
					<img src="/images/schedule_screen_shot.png" class="img-fluid z-depth-4 rounded" />
				</div>
			</div>
		</div>
		
		<div class="" style="background: url(/images/league_reg_bkgrd.jpg); background-attachment: fixed; background-repeat: no-repeat; background-size: cover; background-position: center center;">
			<div class="container pt-5">
				<div class="row">
					<div class="col mt-5 coolText4 wow fadeInUpBig" data-wow-delay="0.5s">
						<h1 class="rounded p-4 text-center white h1-responsive">Get started by creating an account for your league. Have your league up and running in minutes.</h1>
					</div>
				</div>
				<div  class="row">
					<!--Card-->
					<div class="card mb-5 col p-0 mx-1 mx-md-5 wow fadeInUpBig" data-wow-delay="0.5s">
						<!--Card image-->
						<div class="view gradient-card-header peach-gradient text-center py-3 coolText4">
							<h2 class="">Register</h2>
						</div>
						<!--Card content-->
						<div class="card-body">
							<!-- Contact form -->
							{!! Form::open(['action' => ['HomeController@store'], 'method' => 'POST']) !!}
								<div class="col-12 col-md-8 mx-auto">
									<!-- input text -->
									<div class="md-form">
										<i class="fa fa-user prefix"></i>
										
										<input type="text" name="contact_name" id="contact_name" class="form-control" />
										
										<label for="contact_name">Your name</label>
									</div>

									<!-- input email -->
									<div class="md-form">
										<i class="fa fa-envelope prefix"></i>
										
										<input type="email" name="contact_email" id="contact_email" class="form-control" />
										
										<label for="contact_email">Your email</label>
									</div>
									
									<!-- input subject -->
									<div class="md-form">
										<i class="fa fa-id-badge prefix" aria-hidden="true"></i>
										
										<input type="text" name="contact_subject" id="contact_subject" class="form-control">
										
										<label for="contact_subject">League Name</label>
									</div>
									
									<!-- input subject -->
									<div class="md-form">
										<i class="fa fa-address-card prefix" aria-hidden="true"></i>
										
										<input type="text" name="contact_subject" id="contact_subject" class="form-control">
										
										<label for="contact_subject">League Address</label>
									</div>
									
									<!-- input subject -->
									<div class="md-form">
										<i class="fa fa-phone prefix" aria-hidden="true"></i>
										
										<input type="text" name="contact_subject" id="contact_subject" class="form-control">
										
										<label for="contact_subject">League Phone</label>
									</div>
									
									<div class="text-center mt-4">
										<button class="btn btn-outline-secondary w-100" type="submit">Register<i class="fa fa-paper-plane-o ml-2"></i></button>
									</div>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
					<!--/.Card-->
				</div>
			</div>
		</div>
		
		<div class="">
			<div class="view d-flex align-items-center justify-content-center text-center">
				<div class="">
					<h1 class="h1-responsive coolText3">Not sure if this is for your league or not?</h1>
					
					<h2 class="h2-responsive my-3 coolText3">Click here and take it for a test drive with the test account</h2>
					
					<p class="">
						<a href="{{ route('test_drive') }}" class="btn btn-lg peach-gradient">Test Drive</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	
	<!--Section: Contact v.2-->
	<section class="section container pb-5">

		<!--Section heading-->
		<h2 class="section-heading h1 pt-4 mb-5">Contact us</h2>

		<div class="card">
			<div class="card-body">
				
				<!--Google map-->
				<div id="map-container-8" class="z-depth-1-half map-container mb-4" style="height: 200px"></div>

				<!-- Contact form -->
				{!! Form::open(['action' => ['HomeController@store'], 'class' => 'w-100', 'method' => 'POST']) !!}
					<div class="row align-items-stretch d-flex justify-content-center">
						<div class="col-12 col-md-6">
							<!-- input text -->
							<div class="md-form">
								<i class="fa fa-user prefix"></i>
								
								<input type="text" name="contact_name" id="contact_name" class="form-control" />
								
								<label for="contact_name">Your name</label>
							</div>

							<!-- input email -->
							<div class="md-form">
								<i class="fa fa-envelope prefix"></i>
								
								<input type="email" name="contact_email" id="contact_email" class="form-control" />
								
								<label for="contact_email">Your email</label>
							</div>
							
							<!-- input subject -->
							<div class="md-form">
								<i class="fa fa-tag prefix"></i>
								
								<input type="text" name="contact_subject" id="contact_subject" class="form-control">
								
								<label for="contact_subject">Subject</label>
							</div>
							
							<!-- textarea message -->
							<div class="md-form">
								<i class="fa fa-pencil prefix"></i>
								
								<textarea type="text" name="contact_message" id="contact_message" class="form-control md-textarea" rows="5"></textarea>
								
								<label for="contact_message">Your message</label>
							</div>
						</div>

						<div class="d-none col-6 d-flex-md align-items-center justify-content-center">
							<ul class="contact-icons">
								<li class="py-3"><i class="fa fa-map-marker fa-2x"></i>
									<p>Philadelphia, PA 19140, USA</p>
								</li>

								<li class="py-3"><i class="fa fa-phone fa-2x"></i>
									<p>+1 267 879 4089</p>
								</li>

								<li class="py-3"><i class="fa fa-envelope fa-2x"></i>
									<p>totherec@gmail.com</p>
								</li>
							</ul>
						</div>
						<div class="col-8 mx-auto">
							<div class="text-center mt-4">
								<button class="btn btn-outline-secondary w-100" type="submit">Send<i class="fa fa-paper-plane-o ml-2"></i></button>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@endsection