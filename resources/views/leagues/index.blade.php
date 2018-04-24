@extends('layouts.app')

@section('content')
	<div id="backgroundImageL"></div>
	
	<div class="container-fluid">
		@foreach($leagues as $league)
			<h2 class="">{{ $league->leagues_name }}</h2>
		@endforeach
	</div>
@endsection