@extends('layouts.app')

@section('additional_scripts')
	<script type="text/javascript">
		if(screen.width < 576) {
			$('.registrationView').removeClass('view');
			$('.registrationView .mask').addClass('py-5');
		}
	</script>
@endsection

@section('content')
	<div class="view registrationView" style="background-image: url('/images/sports_office.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
		<div class="mask rgba-black-light d-flex justify-content-center align-items-center">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<div class="card wow fadeInLeft registrationFormCard" data-wow-delay="0.3s">
							<div class="card-body">
								<div class="text-center">
									<h1 class="font-weight-bold h1-responsive text-underline">Register</h1>
								</div>
								
								<div class="">
									{!! Form::open(['route' => ['register'], 'method' => 'POST']) !!}
										<div class="row">
											<div class="col-12 col-md">
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
											</div>
											<div class="col-12 col-md">
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
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md">
												<div class="md-form{{ $errors->has('commish_name') ? ' has-error' : '' }}">
													<i class="fa fa-lock prefix grey-text"></i>
													
													<input id="commish_name" type="text" class="form-control" name="commish_name" required>

													<label for="commish_name" class="">Your Name</label>
													
													@if ($errors->has('commish_name'))
														<span class="help-block">
															<strong>{{ $errors->first('commish_name') }}</strong>
														</span>
													@endif
												</div>
											</div>
											<div class="col-12 col-md">
												<div class="md-form{{ $errors->has('league_name') ? ' has-error' : '' }}">
													<i class="fa fa-lock prefix grey-text"></i>
													
													<input id="league_name" type="text" class="form-control" name="league_name" required>

													<label for="league_name" class="">League Name</label>
													
													@if ($errors->has('league_name'))
														<span class="help-block">
															<strong>{{ $errors->first('league_name') }}</strong>
														</span>
													@endif
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-12 col-md">
												<div class="md-form{{ $errors->has('league_phone') ? ' has-error' : '' }}">
													<i class="fa fa-lock prefix grey-text"></i>
													
													<input id="league_phone" type="text" class="form-control" name="league_phone">

													<label for="league_phone" class="">League Phone</label>
													
													@if ($errors->has('league_phone'))
														<span class="help-block">
															<strong>{{ $errors->first('league_phone') }}</strong>
														</span>
													@endif
												</div>
											</div>
											<div class="col-12 col-md">
												<div class="md-form{{ $errors->has('league_address') ? ' has-error' : '' }}">
													<i class="fa fa-lock prefix grey-text"></i>
													
													<input id="league_address" type="text" class="form-control" name="league_address">

													<label for="league_address" class="">League Address</label>
													
													@if ($errors->has('league_address'))
														<span class="help-block">
															<strong>{{ $errors->first('league_address') }}</strong>
														</span>
													@endif
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md">
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
											</div>
											<div class="col-12 col-md">
												<div class="md-form">
													<i class="fa fa-lock prefix red-text"></i>
													
													<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

													<label for="password-confirm" class="">Confirm Password</label>
												</div>
											</div>
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
					<div class="col-4 d-none d-md-block">
						<div class="wow fadeInRight" data-wow-delay="0.3s">
							<div class="forgotPassword text-center">
								<h1 class="white-text">New user!</h1>
							</div>
							<div class="white-text">
								<div class="mb-3 registrationTypeDesc">
									<p class="mt-3">Create a league profile to promote your league to gain more traction and get the word out about your league. We also have online stat tracking so your teams/players can see their stats online.</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
