@extends('layouts.app')

@section('additional_scripts')
	<script type="text/javascript">
		$('nav.navbar').addClass('fixed-top scrolling-navbar');
	</script>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row welcomeVideo">
			<div class="col">
				<div class="jumbotron">
					<video loop="true" autoplay="true" muted="true">
						<source src="/videos/ChosenLeague.mp4" type="video/mp4">
					</video>
				</div>
			</div>
		</div>
		<div class="searches row py-5">
			<div class="searchesHeader col-12">
				<h2 class="">Check Out the Leagues and Rec Centers Around the City</h2>
			</div>

			<!-- City Leagues Section -->
			<div class="col mb-4" id="leagues_list_div">
				<div class="card">
					<div class="card-body">
						<div class="table-wrapper-2">
							<table class="table table-responsive-md table-striped table-hover">
								<thead>
									<tr>
										<th class="search_list_header"><a class="search_list_link text-center d-block coolText1 display-4 white-text" href="{{ route('leagues.index') }}">City Leagues</a></th>
									</tr>
								</thead>
								<tbody>
									@if(empty($getLeagues))
										<tr class="noLeaguesRow"><td>No Leagues Have Been Added Yet. Click <a class="noLeaguesLink" href="register.php?league_reg=true">here</a> to add your league.</td></tr>
									@else
										@foreach($getLeagues as $league)
											<tr class="{{ str_ireplace(" ", "_", $league->leagues_name) }}">
												<td class="text-center">
													<a class="quick_league">{{ ucwords(strtolower($league->leagues_name)) }}</a>
													<div class="leagueDiv">
														<div class="leagueDivHeader">
															<h2 class="">{{ ucwords($league->leagues_name) }}</h2>
														</div>
														<div class="leagueDivContent">
															<div class="leagueProfile">
																<span class="leagueProfileSub leagueProfileContent">Leagues Owner:</span>
																<span class="leagueProfileInfo leagueProfileContent"><?php echo $league->leagues_commish != "" ? $league->leagues_commish : "Call or See Website For More Info"; ?></span>
															</div>
														</div>
														<div class="leagueDivContent">
															<div class="leagueProfile">
																<span class="leagueProfileSub leagueProfileContent">Address:</span>
																<span class="leagueProfileInfo leagueProfileContent"><?php echo $league->leagues_address != "" ? $league->leagues_address : "Call or See Website For More Info"; ?></span>
															</div>
														</div>
														<div class="leagueDivContent">
															<div class="leagueProfile">
																<span class="leagueProfileSub leagueProfileContent">Phone:</span>
																<span class="leagueProfileInfo leagueProfileContent"><?php echo $league->leagues_phone != "" ? $league->leagues_phone : "Call or See Website For More Info"; ?></span>
															</div>
														</div>
														<div class="leagueDivContent">
															<div class="leagueProfile">
																<span class="leagueProfileSub leagueProfileContent">Email:</span>
																<span class="leagueProfileInfo leagueProfileContent"><?php echo $league->leagues_email != "" ? $league->leagues_email : "Call or See Website For More Info"; ?></span>
															</div>
														</div>
														
														@if($league->leagues_website != "")
															<div class="leagueDivContent">
																<div class="leagueProfile">
																	<span class="leagueProfileSub leagueProfileContent">Website:</span>
																	<span class="leagueProfileInfo leagueProfileContent">{{ $league->leagues_website }}</span>
																</div>
															</div>
														@endif
														
														<div class="leagueDivContent">
															<div class="leagueProfile">
																<span class="leagueProfileSub leagueProfileContent">Competition:</span>
																<span class="leagueProfileInfo leagueProfileContent"></span>
															</div>
														</div>
														<div class="leagueDivContent">
															<div class="leagueProfile">
																<span class="leagueProfileSub leagueProfileContent">Ages:</span>
																<span class="leagueProfileInfo leagueProfileContent"></span>
															</div>
														</div>
														<div class="leagueDivContent">
															<div class="leagueProfile">
																<span class="leagueProfileSub leagueProfileContent">Entry Fee:</span>
																<span class='leagueProfileInfo leagueProfileContent'></span>
															</div>
														</div>
														<div class="leagueDivContent">
															<div class="leagueProfile">
																<span class="leagueProfileSub leagueProfileContent">Referee Fee:</span>
																<span class="leagueProfileInfo leagueProfileContent"></span>
															</div>
														</div>
														@if($league->ttr_league_site != "")
															<div class="leagueDivContent">
																<div class="leagueProfile">
																	<span class="leagueProfileSub leagueProfileContent">TTR Site:</span>
																	<span class="leagueProfileInfo leagueProfileContent"></span>
																</div>
															</div>
														@endif
														@if($league->ttr_email != "")
															<div class="leagueDivContent">
																<div class="leagueProfile">
																	<span class="leagueProfileSub leagueProfileContent">TTR Email:</span>
																	<span class="leagueProfileInfo leagueProfileContent"></span>
																</div>
															</div>
														@endif
													</div>	
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- /City Leagues Section -->
			
			<!-- City Rec Centers Section -->
			<div class="col mb-4" id="recs_list_div">
				<div class="card">
					<div class="card-body">
						<div class="table-wrapper-2">
							<table class="table table-responsive-md table-striped table-hover">
								<thead>
									<tr>
										<th class="search_list_header"><a class="search_list_link text-center d-block coolText1 display-4 white-text" id="recs_link" href="recs.php">Rec Centers</a></th>
									</tr>
								</thead>
								<tbody>
									@foreach($getRecs as $showRec)
										<tr>
											<td class="text-center{{ in_array(str_ireplace(' ', '_', $showRec->recs_name), $fireRecs) ? ' d-flex align-items-center justify-content-between' : '' }}">
												@if(in_array(str_ireplace(" ", "_", $showRec->name), $fireRecs))
													<span><img src="/images/fire.png" class="fireIcon1" /></span>
												@endif
												
												<a class="quick_rec">{{ $showRec->name }}</a>
												
												@if(in_array(str_ireplace(" ", "_", $showRec->name), $fireRecs))
													<span><img src="/images/fire.png" class="fireIcon2" /></span>
												@endif
												
												<div class="recDiv">
													<div class="recDivHeader">
														<h2 class=""><?php echo $showRec->recs_name; ?><span><?php echo $showRec->nickname != "" ? $showRec->nickname : ""; ?><span></h2>
													</div>
													<div class="recDivContent">
														<div class="recProfile">
															<span class="recProfileSub recProfileContent">Rec Owner:</span>
															<span class="recProfileInfo recProfileContent"><?php echo $showRec->owner == "" ? $showRec->owner : "Call or See Website For More Info"; ?></span>
														</div>
														<div class="recProfile">
															<span class="recProfileSub recProfileContent">Address:</span>
															<span class="recProfileInfo recProfileContent"><?php echo $showRec->address == "" ? $showRec->address : "Call or See Website For More Info"; ?></span>
														</div>
														<div class="recProfile">
															<span class="recProfileSub recProfileContent">Phone:</span>
															<span class="recProfileInfo recProfileContent"><?php echo $showRec->phone; ?></span>
														</div>
														
														@if($showRec->website != "")
															<div class="recProfile">
																<span class="recProfileSub recProfileContent">Website:</span>
																<span class="recProfileInfo recProfileContent"><?php echo $showRec->website == "" ? $showRec->website : "No Website"; ?></span>
															</div>
														@endif
														
														<div class="recProfile">
															<span class="recProfileSub recProfileContent">Indoor/Outdoor Court:</span>
															<span class="recProfileInfo recProfileContent">
																<?php if($showRec->indoor == 1 && $showRec->outdoor == 1) { ?>
																	<?php echo "Yes/Yes"; ?>
																<?php } elseif($showRec->indoor == 1 && $showRec->outdoor == 0) { ?>
																	<?php echo "Yes/No"; ?>
																<?php } elseif($showRec->indoor == 0 && $showRec->outdoor == 1) { ?>
																	<?php echo "No/Yes"; ?>
																<?php } else { ?>
																	<?php echo "No/No"; ?>
																<?php } ?>
															</span>
														</div>
														<div class="recProfile">
															<span class="recProfileSub recProfileContent">Entry Fee:</span>
															<span class="recProfileInfo recProfileContent"><?php echo $showRec->fee; ?></span>
														</div>
													</div>
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>
			<!-- /City Rec Centers Section -->
		</div>
		
		<!-- Social Media Section -->
		<div class="socialMedia py-4 mb-5" id="twitterFeed">
			<div class="text-center">
				<h2 class="coolText1 display-3 twitterHeader">Tweetted</h2>
				<h4 class="">Join the conversation #sixers, #phillyhoops, #totherec</h4>
			</div>
			<div class="d-flex align-items-center justify-content-around">
				<div class="feed col-md-4 col-sm-3">
					<a class="twitter-timeline"  href="https://twitter.com/hashtag/Phillyhoops" data-widget-id="784071520561881088">#Phillyhoops Tweets</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
				<div class="feed col-md-4 col-sm-3">
					<a class="twitter-timeline"  href="https://twitter.com/hashtag/sixers" data-widget-id="784069581954551808">#sixers Tweets</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
				<div class="feed col-md-4 col-sm-3">
					<a class="twitter-timeline"  href="https://twitter.com/hashtag/ToTheRec" data-widget-id="784071799776616448">#ToTheRec Tweets</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
			</div>
		</div>
		<!-- /Social Media Section -->
	</div>
	
	@include("modal")
@endsection