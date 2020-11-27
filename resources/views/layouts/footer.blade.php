<footer class="page-footer font-small blue-grey darken-3">
	<!-- Work In Progress -->
	<section class="">

		<!-- Footer Elements -->
		<div class="container">

			<!-- Grid row-->
			<div class="row">

				<!-- Grid column -->
				<div class="col-md-12 py-2 py-md-5">
					<div class="mb-5 flex-center">

						<!-- Facebook -->
						<a class="fb-ic">
							<i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
						</a>

					{{--<!-- Twitter -->--}}
					{{--<a class="tw-ic">--}}
					{{--<i class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>--}}
					{{--</a>--}}
					<!-- Google +-->
					{{--<a class="gplus-ic">--}}
					{{--<i class="fab fa-google-plus-g fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>--}}
					{{--</a>--}}
					<!--Linkedin -->
					{{--<a class="li-ic">--}}
					{{--<i class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>--}}
					{{--</a>--}}

					<!--Instagram-->
						<a class="ins-ic">
							<i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
						</a>
					</div>
				</div>
				<!-- Grid column -->

			</div>
			<!-- Grid row-->

		</div>
		<!-- Footer Elements -->

		<!-- Copyright -->
		<div class="footer-copyright text-center py-3 white-text">
			<p class="d-inline-block">© 2020 Copyright:</p>
			<a href="https://thealumnileague.com/"> thealumnileague.com</a>
		</div>
		<!-- Copyright -->

	</section>
	<!--Section: Work In Progress-->

	<!--Section: Contact v.2-->
	<section class="section container pb-5 d-none">
		<div class="card">
			<div class="card-body">
				<!--Card heading-->
				<h2 class="section-heading">Contact us</h2>

				<!--Google map-->
				<iframe
					width="600"
					height="450"
					frameborder="0" style="border:0"
					src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCyVYk1IxEdKvFpzUodUZgaLsaN5g9AAoE&q=Philadelphia+WA" allowfullscreen>
				</iframe>

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
</footer>