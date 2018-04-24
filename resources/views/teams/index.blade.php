@extends('layouts.app')

@section('content')
	<div class="container-fluid">

		<div id="backgroundImageR"></div>
		<div class="recsPageContainer">
			<div class="">
				<h2 id="rec_page_header" class="page_header">Philly Rec Centers</h2>
			</div>
			<div class="search_box">
				<input id="rec_search" name="search" type="search" placeholder="Search Center"/>
			</div>
			<div id="all_recs_frame">
				<div id="all_recs">
					@foreach($getRecs as $showRec)
						<div class="recsPage">
							@if($showRec->recs_name != "")
								@if($showRec->recs_nickname != "")
									<h3 id="{{ strtolower(str_ireplace(" ", "", $showRec->recs_name)) }}" class="recs_header" title="{{ $showRec->recs_name }}"><b>"{{ $showRec->recs_nickname }}"</b>&nbsp;{{ $showRec->recs_name }}</h3>
								@else
									<h3 id="{{ strtolower(str_ireplace(" ", "", $showRec->recs_name)) }}" class="recs_header" title="{{ $showRec->recs_name }}">{{ $showRec->recs_name }}</h3>
								@endif
							@endif
							<ul class="recsPageList">
								<li><span class="listLabel">Rec Advisor:</span><span class="listContent" title="{{ $showRec->recs_owner }}">{{ $showRec->recs_owner != "" ? $showRec->recs_owner : "None Available" }}</span></li>
								<li><span class="listLabel">Address:</span><span class="listContent" title="{{ $showRec->recs_address }}">{{ $showRec->recs_address != "" ? $showRec->recs_address : "None Available" }}</span></li>
								<li><span class="listLabel">Website:</span><span class="listContent" title="{{ $showRec->recs_website }}">{{ $showRec->recs_website != "" ? $showRec->recs_website : "None Available" }}</span></li>
								<li><span class="listLabel">Indoor Gym:</span><span class="listContent" title="">{{ $showRec->indoor == 1 ? "Yes" : "No" }}</span></li>
								<li><span class="listLabel">Blacktop:</span><span class="listContent" title="">{{ $showRec->outdoor == 1 ? "Yes" : "No" }}</span></li>
								<li><span class="listLabel">Cost:</span><span class="listContent" title="">{{ $showRec->fee != "" ? "Yes" : "No" }}</span></li>
								<li><span class="listLabel">More Info:</span><span class="listContent" title="{{ $showRec->recs_phone }}">{{ $showRec->recs_phone }}</span></li>
							</ul>
							@if(in_array(str_ireplace(" ", "_", $showRec->recs_name), $fireRecs))
								<span><img src="images/fire.png" class="fireIcon2" /></span>
							@endif
						</div>
					@endforeach
				</div>
			</div>
			<button id="showAllRecs">Show All Rec Centers</button>
			<button id="scroll_to_top"></button>
		</div>
	</div>
	
	@include("modal")
@endsection