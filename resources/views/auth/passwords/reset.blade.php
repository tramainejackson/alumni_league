@extends('layouts.app')

@section('content')

    <div class="view" id="login_page">
        <div class="mask rgba-black-light d-flex justify-content-center align-items-center">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-around">
                    <div class="col col-md-10 col-lg-6 pb-md-2">
                        <div class="card wow fadeInLeft" data-wow-delay="0.3s">
                            <div class="card-body">
                                <div class="text-center">
                                    <h1 class="font-weight-bold h1-responsive text-underline">Reset Password</h1>
                                </div>

                                <div class="">
                                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">

                                        {{ csrf_field() }}

                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="md-form">

                                            <div class="col-12">
                                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                                <label for="email" class="label">Email Address</label>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="md-form">
                                            <div class="col-12">
                                                <input id="password" type="password" class="form-control" name="password" required>

                                                <label for="password" class="label">Password</label>

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="md-form">
                                            <div class="col-12">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                                <label for="password-confirm" class="label">Confirm Password</label>

                                                @if ($errors->has('password_confirmation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="md-form">
                                            <button type="submit" class="btn btn-lg deep-orange white-text ml-0">Reset Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('content_parts.footer')
    <!-- Footer -->
@endsection
