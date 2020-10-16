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
                                    <div class="col-md-3 mb-4">

                                        <div class="md-form" id="">
                                            <!-- Name -->
                                            <input type="text" id="title" class="form-control" name='title' value='{{ $user->title }}' placeholder="Enter Member Title">

                                            <label for="title">Title</label>

                                            @if ($errors->has('title'))
                                                <span class="text-danger">Title cannot be empty</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-9 mb-4">

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