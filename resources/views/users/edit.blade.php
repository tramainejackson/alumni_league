@extends('layouts.app')

@section('title', 'The Alumni League Users')

@section('content')

    <div class="container-fluid">

        <div class="row my-5" id="">

            <div class="col-12 col-md-8 col-xl-6 mx-auto" id="">

                <div class="text-center" id="">
                    <!-- Back Button -->
                    <a href="{{ route('users.index') }}" class="btn btn-lg btn-primary mb-4">All Members</a>
                </div>

                <!--Section: Content-->
                <section class="text-center dark-grey-text mb-5">

                    <div class="card">
                        <div class="card-body rounded-top border-top pt-5 p-md-5">
                            
                            <form action="{{ action('UserController@update' , [$user->id]) }}" method="POST" enctype="multipart/form-data">

                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                <!-- Section heading -->
                                <h3 class="font-weight-bold my-4">Edit Member</h3>

                                <div class="form-row">
                                    <div class="col-12 col-md-6">

                                        <div class="md-form" id="">
                                            <!-- Name -->
                                            <input type="text" id="username" class="form-control" name='username' value='{{ $user->username }}' placeholder="Enter Member Username" {{ $errors->has('username') ? 'autofocus' : '' }} >

                                            <label for="username">Username</label>

                                            @if ($errors->has('username'))
                                                <span class="text-danger">{{ $errors->first('username') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">

                                        <div class="md-form" id="">
                                            <!-- Name -->
                                            <input type="text" id="name" class="form-control" name='name' value='{{ $user->name }}' placeholder="Enter Member Name" {{ $errors->has('name') ? 'autofocus' : '' }} >

                                            <label for="name">Name</label>

                                            @if ($errors->has('name'))
                                                <span class="text-danger">Name cannot be empty</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">

                                    <div class="col-12 col-md-6">

                                        <div class="md-form" id="">
                                            <!-- Phone -->
                                            <input type="number" id="phone" class="form-control" name='phone' value='{{ $user->phone }}' placeholder="Enter Phone Number" {{ $errors->has('phone') ? 'autofocus' : '' }} />

                                            <label for="phone">Phone</label>

                                            @if($errors->has('phone'))
                                                <span class="text-danger">Phone number has to be exactly 10 numbers</span>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">

                                        <div class="md-form" id="">
                                            <!-- Email -->
                                            <input type="email" id="email" class="form-control" name='email' value='{{ $user->email }}' placeholder="Enter Email Address" {{ $errors->has('email') ? 'autofocus' : '' }} />

                                            <label for="email">Email</label>

                                            @if($errors->has('email'))
                                                <span class="text-danger">@foreach($errors->get('email') as $value){{ $value }} @endforeach</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">

                                    <div class="col-12">

                                        <div class="md-form" id="">

                                            <select class="mdb-select md-form colorful-select dropdown-primary" id="user_type_select" name="type" onchange="playOptionSelect();">
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
                                </div>

                                <!-- This section is for player captain or coach only -->
                                <div class="form-row{{ $user->type == 'player' ? '' : ' d-none' }}" id="user_player_edit">
                                    <div class="col-12 text-center" id="">
                                        <h2 class="text-underline">Player/Coach Selections</h2>
                                        <span class="font-italic font-small text-muted text-warning">Players will receive an email after you select their team and saved their information</span>
                                    </div>

                                    <div class="md-form col-12 col-lg-6" id="">

                                        <select class="mdb-select md-form colorful-select dropdown-primary" id="user_season_select" name="season" onchange="userSeasonSelect();">
                                            <option value="" disabled selected>----Select An Active Season----</option>

                                            @foreach($activeSeasons as $activeSeason)
                                                <option value="{{ $activeSeason->id }}"{{ $activeSeason->id == $seasonID ? 'selected' : $loop->first ? 'selected' : '' }}>{{ ucwords($activeSeason->name) }}</option>
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
                                                    <option class="season_{{ $activeSeason->id }}_team" value="{{ $league_team->id }}"{{ $league_team->id == $teamID ? 'selected' : $loop->first ? 'selected' : '' }}>{{ ucwords($league_team->team_name) }}</option>
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

                                <div class="form-row" id="">
                                    <div class="col-12" id="">
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

    <!-- Footer -->
    @include('content_parts.footer')
    <!-- Footer -->
@endsection