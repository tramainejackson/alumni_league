<footer class="black d-flex justify-content-center align-items-center">
	<!-- Contact form -->
	{!! Form::open(['action' => ['HomeController@store'], 'method' => 'POST']) !!}
		<p class="h4 text-center mb-4">Write to us</p>

		<!-- input text -->
		<div class="md-form">
			<i class="fa fa-user prefix white-text"></i>
			<input type="text" name="contact_name" id="contact_name" class="form-control white-text">
			<label for="contact_name">Your name</label>
		</div>

		<!-- input email -->
		<div class="md-form">
			<i class="fa fa-envelope prefix white-text"></i>
			<input type="email" name="contact_email" id="contact_email" class="form-control white-text">
			<label for="contact_email">Your email</label>
		</div>
		
		<!-- input subject -->
		<div class="md-form">
			<i class="fa fa-tag prefix white-text"></i>
			<input type="text" name="contact_subject" id="contact_subject" class="form-control white-text">
			<label for="contact_subject">Subject</label>
		</div>
		
		<!-- textarea message -->
		<div class="md-form">
			<i class="fa fa-pencil prefix grey-text"></i>
			<textarea type="text" name="contact_message" id="contact_message" class="form-control white-text md-textarea" rows="3"></textarea>
			<label for="contact_message">Your message</label>
		</div>

		<div class="text-center mt-4">
			<button class="btn btn-outline-secondary w-100" type="submit">Send<i class="fa fa-paper-plane-o ml-2"></i></button>
		</div>
	{!! Form::close() !!}
	<!-- Contact form -->
</footer>