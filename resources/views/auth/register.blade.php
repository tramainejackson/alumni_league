@extends('layouts.app')

@section('scripts')
	<script type="text/javascript">
		$('nav.navbar').addClass('fixed-top scrolling-navbar');
		$('.registerContainer').css({'paddingTop' : ($('nav.navbar').height() + 20) + 'px'});
	</script>
@endsection

@section('content')
	<div class="" style="background-image: url('/images/login_page_pic.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
		<div class="mask rgba-black-strong d-flex justify-content-center align-items-center py-4">
			<div class="container registerContainer">
				<div class="row">
					<div class="col-12 col-xl-8 mx-auto">
						<div class="card wow fadeInLeft registrationFormCard" data-wow-delay="0.3s">
							<div class="card-body">
								<div class="text-center">
									<h1 class="font-weight-bold h1-responsive text-underline">Register</h1>
								</div>
								
								<div class="">
									{!! Form::open(['route' => ['register'], 'method' => 'POST']) !!}
										<div class="">
											<h2 class="text-muted"><u>Registration Type</u></h2>
											
											<div class="d-flex align-items-center justify-content-around profileSelection">
												<button type="button" class="btn btn-lg green active">Player Profile
													<input type="checkbox" name="player_profile" class="hidden" value="Y" checked hidden />
												</button>
												<button type="button" class="btn btn-lg grey">League Profile
													<input type="checkbox" name="league_profile" class="hidden" value="Y" hidden />
												</button>
											</div>
										</div>
										<div class="md-form{{ $errors->has('name') ? ' has-error' : '' }}">
											<i class="fa fa-user prefix grey-text"></i>
											
											<input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

											<label for="username" class="">Username</label>
											
											@if ($errors->has('username'))
												<span class="help-block">
													<strong>{{ $errors->first('username') }}</strong>
												</span>
											@endif
										</div>

										<div class="md-form{{ $errors->has('email') ? ' has-error' : '' }}">
											<i class="fa fa-envelope prefix grey-text"></i>
											
											<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

											<label for="email" class="">E-Mail Address</label>
											
											@if ($errors->has('email'))
												<span class="help-block">
													<strong>{{ $errors->first('email') }}</strong>
												</span>
											@endif
										</div>

										<div class="md-form{{ $errors->has('password') ? ' has-error' : '' }}">
											<i class="fa fa-lock prefix grey-text"></i>
											
											<input id="password" type="password" class="form-control" name="password" required>

											<label for="password" class="">Password</label>
											
											@if ($errors->has('password'))
												<span class="help-block">
													<strong>{{ $errors->first('password') }}</strong>
												</span>
											@endif
										</div>

										<div class="md-form">
											<i class="fa fa-lock prefix red-text"></i>
											
											<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

											<label for="password-confirm" class="">Confirm Password</label>
										</div>

										<div class="md-form">
											<div class="col-md-6 col-md-offset-4">
												<button type="submit" class="btn btn-primary">
													Register
												</button>
											</div>
										</div>
									{!! Form::close() !!}
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-xl-4 mx-auto mt-xl-0 mt-4">
						<div class="wow fadeInRight" data-wow-delay="0.3s">
							<div class="forgotPassword text-center">
								<h1 class="white-text">New user!</h1>
							</div>
							<div class="white-text">
								<div class="mb-3 registrationTypeDesc">
									<p class="mt-3"><span class="rgba-indigo-strong px-1">Player Profile:</span> Create a player profile if you want to showcase your stats and videos of you handling business on the court.</p>
									<p class="mt-3"><span class="rgba-cyan-strong px-1">League Profile:</span> Create a league profile to promote your league to gain more traction and get the word out about your league. We also have online stat tracking so your teams/players can see their stats online.</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
