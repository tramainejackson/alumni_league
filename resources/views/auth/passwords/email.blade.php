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
                                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">

                                        {{ csrf_field() }}

                                        <div class="md-form">
                                            <i class="fa fa-envelope prefix grey-text"></i>

                                            <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" required />

                                            <label for="email">Email Address</label>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="md-form">
                                            <button type="submit" class="btn btn-lg deep-orange white-text ml-0">Send Password Reset Link</button>
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
    @include('layouts.footer')
    <!-- Footer -->
@endsection
