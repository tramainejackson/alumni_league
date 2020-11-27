@extends('layouts.app')

@section('content')

    <div class="container" id="clients">

        <div class="row mt-5 mb-5">
            <div class="col-12 col-md-8 text-center mx-auto mb-5">

                <div class="py-5" id="">

                    <!-- Subtitle -->
                    <p class="my-0 pre_title">{{ $client->profession }}</p>

                    <!-- Title -->
                    <h2 class="display-2 text-center">{{ $client->full_name() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container fluid" id="">

        <div class="row my-5" id="">
            <div class="col-5 mx-auto text-center" id="">
                <p class="card-text">{!! nl2br($client->bio) !!}</p>
            </div>

            <div class="col-7 mx-auto" id="">

            </div>
        </div>
    </div>
@endsection