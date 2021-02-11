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
                                                <span class="text-danger">{{ $errors->first('username') }}</span>
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

                                            <select class="mdb-select md-form colorful-select dropdown-primary" id="user_type_select" name="type" onchange="playOptionSelect();">
                                                <option value="" disabled selected>----Select A User Type----</option>
                                                <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Administrator</option>
                                                <option value="statitician" {{ $user->type == 'statistician' ? 'selected' : '' }}>Statitician</option>
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
                                            <input type="email" id="email" class="form-control" name='email' value='{{ $user->email }}' placeholder="Enter Email Address" />

                                            <label for="email">Email</label>

                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <!-- This section is for player captain or coach only -->
                                <div class="row{{ $user->type == 'player' ? '' : ' d-none' }}" id="user_player_edit">
                                    <div class="col-12 text-center" id="">
                                        <h2 class="text-underline">Player/Coach Selections</h2>
                                    </div>

                                    <div class="md-form col-12 col-lg-6" id="">

                                        <select class="mdb-select md-form colorful-select dropdown-primary" id="user_season_select" name="season" onchange="userSeasonSelect();">
                                            <option value="" disabled selected>----Select An Active Season----</option>

                                            @foreach($activeSeasons as $activeSeason)
                                                <option value="{{ $activeSeason->id }}"{{ $activeSeason->id == $seasonID ? 'selected' : '' }}>{{ ucwords($activeSeason->name) }}</option>
                                            @endforeach
                                        </select>
                                        <!-- Type -->

                                        <label class="mdb-main-label text-left" for="season">Season Select</label>

                                        @if ($errors->has('type'))
                                            <span class="text-danger">{{ $errors->first('season') }}</span>
                                        @endif
                                    </div>

                                    <div class="md-form col-12 col-lg-6" id="">

                                        <select class="mdb-select md-form colorful-select dropdown-primary" id="user_team_select" name="season_team">
                                            <option value="" disabled selected>----Select A Team----</option>

                                            @foreach($activeSeasons as $activeSeason)
                                                @foreach($activeSeason->league_teams as $league_team)
                                                    <option class="season_{{ $activeSeason->id }}_team" value="{{ $league_team->id }}" {{ $league_team->id == $teamID ? 'selected' : '' }}>{{ ucwords($league_team->team_name) }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        <!-- Type -->

                                        <label class="mdb-main-label text-left" for="season_team">Team Select</label>

                                        @if ($errors->has('type'))
                                            <span class="text-danger">{{ $errors->first('season_team') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row" id="">
                                    <div class="form-group text-center">
                                        <label for="active" class="d-block form-control-label">Active</label>

                                        <div class="btn-group">
                                            <button type="button" class="btn activeYes{{ $user->active == 'Y' ? ' active btn-success' : ' btn-blue-grey' }}" style="line-height:1.5">
                                                <input type="checkbox" name="active" value="Y" {{ $user->active == 'Y' ? 'checked' : '' }} hidden />Yes
                                            </button>
                                            <button type="button" class="btn activeNo{{ $user->active == 'N' ? ' active btn-success' : ' btn-blue-grey' }}" style="line-height:1.5">
                                                <input type="checkbox" name="active" value="N" {{ $user->active == 'N' ? 'checked' : '' }} hidden />No
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

                            <form action="{{ route('password.email') }}" method="POST">

                                {{ csrf_field() }}

                                <div class="md-form" hidden>
                                    <i class="fa fa-envelope prefix grey-text"></i>

                                    <input type="text" name="adminPSResetRequest" value="true" hidden>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required />

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="md-form">
                                    <button type="submit" class="btn btn-rounded deep-orange white-text ml-0">Send User A Password Reset Link</button>
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

    <!-- Footer -->
    @include('content_parts.footer')
    <!-- Footer -->
@endsection