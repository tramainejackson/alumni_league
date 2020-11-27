@extends('layouts.app')

@section('content')

    <div class="container" id="clients">

        <div class="row mt-5 mb-5">
            <div class="col-12 col-md-8 text-center mx-auto mb-5">

                <div class="py-5" id="">

                    <!-- Subtitle -->
                    <p class="my-0 pre_title">Keeping Up With Demand</p>

                    <!-- Title -->
                    <h2 class="display-2 text-center">Messages</h2>

                    <!-- Title -->
                    <p class="text-center">Total Messages: {{ $messages->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container fluid" id="">

            @if($messages->count() > 0)

                @foreach($messages as $message)

                    <div class="row my-5" id="">

                        <div class="col" id="">

                            <div class="card" id="">

                                <div class="card-body" id="">

                                    <div class="" id="">
                                        <h3 class="card-title"><span class="font-weight-bold">Name: </span>{{ $message->full_name() }} </h3>
                                    </div>

                                    <div class="" id="">
                                        <p class="card-text"><span class="font-weight-bold">Email Address: </span>{{ $message->email }}</p>
                                        <p class="card-text"><span class="font-weight-bold">Phone #: </span>{{ $message->phone }}</p>
                                        <p class="card-text"><span class="font-weight-bold">Reason: </span>{{ str_ireplace(';', ', ', $message->reason) }}</p>
                                        <p class="card-text"><span class="font-weight-bold">Message: </span>{!! nl2br($message->message) !!}</p>
                                    </div>

                                    <div class="" id="">
                                        <form action="{{ route('messages.destroy', [$message->id]) }}" method="POST">

                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}

                                            <button class='btn btn-danger ml-0' type='submit'>Remove Message</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$loop->last)
                        <hr/>
                    @endif

                @endforeach

            @else

                <div class="row" id="">
                    <div class="d-flex justify-content-center align-items-center col-9 mx-auto" id="">
                        <h1>You Do Not Have Any Current Messages</h1>
                    </div>
                </div>

            @endif
        </div>

        <div class="row" id="">

            <div class="col-12 col-lg-8" id="">


            </div>
        </div>
    </div>
@endsection