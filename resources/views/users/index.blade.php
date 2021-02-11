@extends('layouts.app')

@section('content')

    <div class="container" id="clients">

        <div class="row mt-5 mb-5">
            <div class="col-12 col-md-8 text-center mx-auto mb-5">

                <div class="py-5" id="">

                    <!-- Subtitle -->
                    <h3 class="my-0 pre_title">The Team</h3>

                    <!-- Title -->
                    <h2 class="display-2 text-center">Users</h2>

                    <!-- User Count -->
                    <p class="text-center font-italic font-weight-bold text-muted mt-n3">Total: {{ $allUsers->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="">

        {{-- Create New Member Field--}}
        <div class="row" id="">

            <div class="col-12 col-lg-5 mb-5" id="">

                <div class="card mb-5" id="">

                    <div class="card-body" id="">

                        <h3 class="card-title text-center mb-5">Create New User</h3>

                        <form class="" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">

                            {{ csrf_field() }}

                            <div class="col-md-12 mb-4">

                                <div class="md-form" id="">

                                    <!-- Title -->
                                    <input type="text" id="username" class="form-control" name='username' value='{{ old('username') }}' placeholder="Enter username" {{ $errors->has('username') ? 'autofocus' : '' }}/>

                                    <label class="" for="username">Username</label>

                                    @if ($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-12 mb-4">

                                <div class="md-form" id="">

                                    <!-- Name -->
                                    <input type="text" id="name" class="form-control" name='name' value='{{ old('name') }}' placeholder="Enter Full Name" {{ $errors->has('name') ? 'autofocus' : '' }}/>

                                    <label class="" for="name">Name</label>

                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-12 mb-4">

                                <div class="md-form" id="">

                                    <!-- Email -->
                                    <input type="email" id="email" class="form-control" name='email' value='{{ old('email') }}' placeholder="Enter Email Address" {{ $errors->has('email') ? 'autofocus' : '' }}/>

                                    <label class="" for="email">Email</label>

                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-12 mb-4">

                                <div class="md-form" id="">

                                    <!-- Phone -->
                                    <input type="text" id="phone" class="form-control" name='phone' value='{{ old('phone') }}' placeholder="Enter Phone Number" {{ $errors->has('phone') ? 'autofocus' : '' }}/>

                                    <label class="" for="phone">Phone</label>

                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-12 mb-4">

                                <div class="md-form" id="">

                                    <select class="mdb-select md-form colorful-select dropdown-primary" name="type">
                                        <option value="" disabled selected>----Select A User Type----</option>
                                        <option value="admin">Administrator</option>
                                        <option value="statistician">Statitician</option>
                                        <option value="player">Player/Coach</option>
                                    </select>
                                    <!-- Type -->

                                    <label class="mdb-main-label" for="type">Type</label>

                                    @if ($errors->has('type'))
                                        <span class="text-danger">{{ $errors->first('type') }}</span>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-12 my-5">

                                <div class="md-form" id="">

                                    <div class="form-inline pt-5 ml-0" id="">
                                        <div class="btn-group">
                                            <button type="button" class="btn activeYes showClient{{ old('active') == true ? ' btn-success active' : ' btn-blue-grey' }}">
                                                <input type="checkbox" name="active" value="Y" hidden {{ old('active') == true ? 'checked' : '' }} />Yes
                                            </button>
                                            <button type="button" class="btn activeNo showClient{{ old('active') == false ? ' btn-danger active' : ' btn-blue-grey' }}">
                                                <input type="checkbox" name="active" value="N" {{ old('active') == false ? 'checked' : '' }} hidden />No
                                            </button>
                                        </div>
                                    </div>

                                    <label for="active">Active</label>
                                </div>
                            </div>

                            <div class="col-md-12">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-rounded">Create New Team Member</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg" id="">

                @if($allUsers->count() > 0)

                    @foreach($allUsers as $user)

                        <div class="row my-5" id="">
                            <div class="col text-center" id="">
                                <div class="" id="">
                                    <a class="btn btn-outline-info" href="{{ route('users.edit', [$user->id]) }}">Edit Member Info</a>
                                </div>

                                <div class="" id="">
                                    <h5 class="card-title"><b>Name:</b> {{ $user->name }}</h5>
                                </div>

                                <div class="" id="">
                                    <p class="card-title"><b>Access Type:</b> {{ $user->type == 'player' ? 'Player/Coach' : ucfirst($user->type) }}</p>
                                </div>

                                <div class="" id="">
                                    <button type="button" class="btn rounded{{ $user->active == 'Y' ? ' btn-dark-green' : ' btn-danger' }}">{{ $user->active == 'Y' ? 'Active' : 'Inactive' }}</button>
                                </div>
                            </div>
                        </div>

                        {{--<div class="row mb-5" id="">--}}
                            {{--<div class="col-9 mx-auto" id="">--}}
                                {{--<p class="card-text">{!! nl2br($user->bio) !!}</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        @if(!$loop->last)
                            <hr/>
                        @endif

                    @endforeach

                @else

                    <div class="d-flex justify-content-center align-items-center col-9 mx-auto" id="">
                        <h1>You Do Not Have Any Current Members Listed</h1>
                    </div>

                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('content_parts.footer')
    <!-- Footer -->
@endsection