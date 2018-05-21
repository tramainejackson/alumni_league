@extends('layouts.app')

@section('additional_scripts')
	<script type="text/javascript">
		$('nav').addClass('fixed-top scrolling-navbar');
		$('footer').remove();
	</script>
@endsection

@section('content')
	<div id="leagues_landing_page" class="">
		<div class="view">
			<div class="mask d-flex flex-column rgba-blue-light align-items-center justify-content-center white-text coolText3">
				<h1 class="font-weight-bold display-3 wow fadeInLeft" data-wow-delay="0.4s">Save Time. Get Organized.</h1>
				<h2 class="wow fadeInRight" data-wow-delay="0.4s">Manage your whole basketball league and keep everything in one location</h2>
				<h3 class="wow fadeInDown" data-wow-delay="0.4s">Keeps Stats, Standings, Scores and More</h3>
			</div>	
		</div>
		<div class="container-fluid">
			<div class="row align-items-stretch text-center mt-3 mb-5 coolText4">
				<div class="col-6 mt-5 mx-auto">
					<h2 class="h2-responsive">Keep in depth stats for all the players in the league. Teams and players will be able to see league leaders and their team stats as the season progresses.</h2>
					<img src="/images/stats_screen_shot.png" class="img-fluid z-depth-4 rounded" />
				</div>
				<div class="col-12 my-5"></div>
				<div class="col-5 mx-auto">
					<h2 class="h2-responsive">Standings are a breeze. Automatically updated with game results</h2>
					<img src="/images/standings_screen_shot.png" class="img-fluid z-depth-4 rounded" />
				</div>
				<div class="col-5 mx-auto">
					<h2 class="h2-responsive">Easily manage all your leagues games and their results in minutes</h2>
					<img src="/images/schedule_screen_shot.png" class="img-fluid z-depth-4 rounded" />
				</div>
			</div>
		</div>

		<!-- Blue Edge Header -->
		<div class="edge-header blue darken-2"></div>
		<div class="container free-bird">
			<div class="row align-items-stretch">
				<!--Card-->
				<div class="card mb-5 col p-0 mx-2">
					<!--Card image-->
					<div class="view gradient-card-header peach-gradient text-center py-3 coolText4">
						<h2 class="">Register</h2>
						<p class="">Get started by creating an account for your league</p>
					</div>
					<!--Card content-->
					<div class="card-body">
						<!-- Contact form -->
						{!! Form::open(['action' => ['HomeController@store'], 'method' => 'POST']) !!}
							<div class="col-8 mx-auto">
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
									
									<label for="contact_subject">League Name</label>
								</div>
								
								<!-- input subject -->
								<div class="md-form">
									<i class="fa fa-tag prefix"></i>
									
									<input type="text" name="contact_subject" id="contact_subject" class="form-control">
									
									<label for="contact_subject">League Address</label>
								</div>
								
								<!-- input subject -->
								<div class="md-form">
									<i class="fa fa-tag prefix"></i>
									
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

				<!--Card-->
				<div class="card mb-5 col p-0 mx-2">
					<!--Card image-->
					<div class="view gradient-card-header blue-gradient text-center py-3 coolText4">
						<h2 class="">Contact Us</h2>
						<p class="">Send us a message if you have any questions</p>
					</div>
					<!--Card content-->
					<div class="card-body">
						<!-- Contact form -->
						{!! Form::open(['action' => ['HomeController@store'], 'method' => 'POST']) !!}
							<div class="col-8 mx-auto">
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
									
									<textarea type="text" name="contact_message" id="contact_message" class="form-control md-textarea" rows="3"></textarea>
									
									<label for="contact_message">Your message</label>
								</div>

								<div class="text-center mt-4">
									<button class="btn btn-outline-secondary w-100" type="submit">Send<i class="fa fa-paper-plane-o ml-2"></i></button>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
				<!--/.Card-->
			</div>
		</div>
	</div>
	
@endsection