@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="row my-5" id="">

            <div class="col-8 mx-auto" id="">

                <!-- Back Button -->
                <a href="{{ route('users.index') }}" class="btn btn-lg btn-primary mb-4">All Members</a>

                <!--Section: Content-->
                <section class="text-center dark-grey-text mb-5">

                    <div class="card">
                        <div class="card-body rounded-top border-top p-5">
                            
                            <form action="{{ action('UserController@update' , [$user->id]) }}" method="POST" enctype="multipart/form-data">

                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                <!-- Section heading -->
                                <h3 class="font-weight-bold my-4">Edit Member</h3>

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div class="md-form" id="">
                                            <!-- Name -->
                                            <input type="text" id="username" class="form-control" name='username' value='{{ $user->username }}' placeholder="Enter Member Username">

                                            <label for="username">Username</label>

                                            @if ($errors->has('username'))
                                                <span class="text-danger">Username cannot be empty</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">

                                        <div class="md-form" id="">
                                            <!-- Name -->
                                            <input type="text" id="name" class="form-control" name='name' value='{{ $user->name }}' placeholder="Enter Member Name">

                                            <label for="name">Name</label>

                                            @if ($errors->has('name'))
                                                <span class="text-danger">Name cannot be empty</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div class="md-form" id="">

                                            <select class="mdb-select md-form colorful-select dropdown-primary" name="type" onchange="playOptionSelect();">
                                                <option value="" disabled selected>----Select A User Type----</option>
                                                <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Administrator</option>
                                                <option value="statitician" {{ $user->type == 'statitician' ? 'selected' : '' }}>Statitician</option>
                                                <option value="player" {{ $user->type == 'player' ? 'selected' : '' }}>Player/Coach</option>
                                            </select>
                                            <!-- Type -->

                                            <label class="mdb-main-label text-left" for="type">Type</label>

                                            @if ($errors->has('type'))
                                                <span class="text-danger">{{ $errors->first('type') }}</span>
                                            @endif

                                            <i class="fas fa-info-circle position-absolute top right mt-n4" data-toggle="popover" title="Access Types" data-content="<b>Admin:</b> Access to Everything</br><b>Player/Coach:</b> Can ONLY Access the team assigned to to edit player names and jersey #'s</br><b>Statitician:</b> Can ONLY access game results"></i>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">

                                        <div class="md-form" id="">
                                            <!-- Email -->
                                            <input type="email" id="email" class="form-control" name='email' value='{{ $user->email }}' placeholder="Enter Email Address">

                                            <label for="email">Email</label>

                                            @if ($errors->has('email'))
                                                <span class="text-danger">Email Address cannot be empty</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <!-- This section is for player captain or coach only -->
                                <div class="row{{ $user->type == 'player' ? '' : ' d-none' }}" id="user_player_edit">
                                    <h2>Test</h2>
                                </div>

                                <div class="row" id="">
                                    <div class="form-group text-center">
                                        <label for="conferences" class="d-block form-control-label">Active</label>

                                        <div class="btn-group">
                                            <button type="button" class="btn activeYes{{ $showSeason->has_conferences == 'Y' ? ' active btn-success' : ' btn-blue-grey' }}" style="line-height:1.5">
                                                <input type="checkbox" name="conferences" value="Y" {{ $showSeason->has_conferences == 'Y' ? 'checked' : '' }} hidden />Yes
                                            </button>
                                            <button type="button" class="btn activeNo{{ $showSeason->has_conferences == 'N' ? ' active btn-success' : ' btn-blue-grey' }}" style="line-height:1.5">
                                                <input type="checkbox" name="conferences" value="N" {{ $showSeason->has_conferences == 'N' ? 'checked' : '' }} hidden />No
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info btn-rounded">Update Member Info</button>
                                        </div>

                                    </div>
                                </div>
                            </form>

                            <form class="position-absolute top right" method="POST" action="{{ route('users.destroy', [$user->id]) }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}

                                <button class="btn btn-danger mr-3 mt-3" type="submit">Delete Member</button>
                            </form>
                        </div>
                    </div>
                </section>
                <!--Section: Content-->
            </div>
        </div>
    </div>
@endsection