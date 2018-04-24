<?php require_once("../../include/initialize2.php"); ?>
<?php require_once("../../include/leagues_header.php"); ?>

<body>
	<div class="leagues_page_div container-fluid">
		<?php require_once("leagues_menu.php")?>
		<?php $showcaseGame = League_Schedule::get_random_game(); ?>
		<?php $awayTeamLeader = League_Stats::get_scoring_leader($showcaseGame->get_away_team_id()); ?>
		<?php $homeTeamLeader = League_Stats::get_scoring_leader($showcaseGame->get_home_team_id()); ?>
		<div id="match_ups">	
			<div id="match_ups_headline" class="row">
				<h2>Upcoming Match-Up</h2>
				<p>Best Head to Head Match-Up For the Upcoming Week</p>
			</div>
			<div class="row">
				<div id="match_ups_information">
					<p id="game_location">&nbsp;Location:<?php echo $showcaseGame->game_location; ?></p>
					<p id="game_time">&nbsp;Date:<?php echo datetime_to_text($showcaseGame->game_date); ?></p>
					<p id="game_time">&nbsp;Time:<?php echo $showcaseGame->game_time; ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<h1 class=""><?php echo $showcaseGame->away_team; ?></h1>
				</div>
				<div id="versus" class="match_ups_div col-md-2">			
					<p>VS</p>
				</div>
				<div class="col-md-5">
					<h1 class=""><?php echo $showcaseGame->home_team; ?></h1>
				</div>
			</div>
			<div class="row">
				<div id="contender_1" class="contenders match_ups_div col-md-6">
					<div class="row">
						<div class="col-md-4">
							<img src="../../uploads/emptyface.jpg" class="" />
						</div>
						<div class="col-md-8">
							<ul class="">
								<li class="">PPG:&nbsp;<?php echo $awayTeamLeader->PPG; ?></li>
								<li class="">APG:&nbsp;<?php echo $awayTeamLeader->APG; ?></li>
								<li class="">RPG:&nbsp;<?php echo $awayTeamLeader->RPG; ?></li>
								<li class="">SPG:&nbsp;<?php echo $awayTeamLeader->SPG; ?></li>
								<li class="">BPG:&nbsp;<?php echo $awayTeamLeader->BPG; ?></li>
							</ul>
						</div>
					</div>
				</div>
				<div id="contender_2" class="contenders match_ups_div col-md-6">
					<div class="row">
						<div class="col-md-4">
							<img src="../../uploads/emptyface.jpg" class="" />
						</div>
						<div class="col-md-8">
							<ul class="">
								<li class="">PPG:&nbsp;<?php echo $homeTeamLeader->PPG; ?></li>
								<li class="">APG:&nbsp;<?php echo $homeTeamLeader->APG; ?></li>
								<li class="">RPG:&nbsp;<?php echo $homeTeamLeader->RPG; ?></li>
								<li class="">SPG:&nbsp;<?php echo $homeTeamLeader->SPG; ?></li>
								<li class="">BPG:&nbsp;<?php echo $homeTeamLeader->BPG; ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require_once("../../include/leagues_footer.php"); ?>
</body>
</html>