@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="row my-5" id="">

            <div class="col-8 mx-auto" id="">

                <!--Section: Content-->
                <section class="text-center dark-grey-text mb-5">

                    <div class="card">
                        <div class="card-body rounded-top border-top p-5">

                            <!-- Section heading -->
                            <h3 class="font-weight-bold my-4">Edit Member</h3>
                            
                            <form action="{{ action('MemberController@update' , [$member->id]) }}" method="POST">

                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div class="md-form" id="">
                                            <!-- Name -->
                                            <input type="text" id="title" class="form-control" name='title' value='{{ $member->title }}' placeholder="Enter Member Title">

                                            <label for="title">Title</label>

                                            @if ($errors->has('title'))
                                                <span class="text-danger">Title cannot be empty</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="md-form" id="">
                                            <!-- Name -->
                                            <input type="text" id="name" class="form-control" name='name' value='{{ $member->name }}' placeholder="Enter Member Name">

                                            <label for="name">Name</label>

                                            @if ($errors->has('name'))
                                                <span class="text-danger">Name cannot be empty</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-4">

                                        <div class="md-form" id="">
                                            <!-- Email -->
                                            <input type="email" id="email" class="form-control" name='email' value='{{ $member->email }}' placeholder="Enter Email Address">

                                            <label for="email">Email</label>

                                            @if ($errors->has('email'))
                                                <span class="text-danger">Email Address cannot be empty</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-4">

                                        <div class="md-form" id="">
                                            <!-- Bio -->
                                            <textarea type="number" id="bio" class="md-textarea form-control" name='bio' placeholder="Enter Member Bio" rows="10">{{ $member->bio }}</textarea>

                                            <label for="bio">Bio</label>
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
                        </div>
                    </div>
                </section>
                <!--Section: Content-->
            </div>
        </div>
    </div>
@endsection