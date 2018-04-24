<?php require_once	("../../include/initialize2.php"); ?>
<?php require_once("../../include/leagues_header.php"); ?>
<body>
	<div class="container-fluid leagues_page_div">
	<?php require_once("leagues_menu.php"); ?>
		<h1>League Header or Banner Spring 2016 Schedule</h1>
		<?php $getWeeks = League_Schedule::get_weeks(); ?>
		<?php if(!empty($getWeeks)) { ?>
			<?php if(is_object($getWeeks)) { ?>
				<?php $showWeekInfo = $getWeeks; ?>
				<div class='leagues_schedule'>
					<table id='week_<?php echo $showWeekInfo->season_week; ?>_schedule' class='weekly_schedule'>
						<caption>Week&nbsp;<?php echo $showWeekInfo->season_week; ?>&nbsp;Schedule</caption>
						<tr>
							<th>Match-Up</th>
							<th>Time</th>
							<th>Date</th>
						</tr>
						<?php $getGames = League_Schedule::find_by_sql("SELECT *, DATE_FORMAT(game_date, '%m/%d/%Y') AS gameDate FROM leagues_schedule WHERE season_week='$showWeekInfo->season_week' ORDER BY game_id;"); ?>
						<?php if(is_object($getGames)) { ?>
							<?php $game = $getGames; ?>
							<tr>
								<td><?php echo $game->away_team ." vs ". $game->home_team; ?></td>
								<td><?php echo $game->game_time; ?></td>
								<td><?php echo $game->gameDate; ?></td>
							</tr>
						<?php } elseif(is_array($getGames)) { ?>
							<?php foreach($getGames as $game) { ?>
								<tr>
									<td><?php echo $game->away_team . " vs " . $game->home_team; ?></td>
									<td><?php echo $game->game_time; ?></td>
									<td><?php echo $game->gameDate; ?></td>
								</tr>
							<?php }  ?>
						<?php }  ?>
					</table>
				</div>
			<?php } elseif(is_array($getWeeks)) { ?>
				<?php foreach($getWeeks as $showWeekInfo) { ?>
					<div class='leagues_schedule'>
						<table id='week_<?php echo $showWeekInfo->season_week; ?>_schedule' class='weekly_schedule'>
							<caption>Week&nbsp;<?php echo $showWeekInfo->season_week; ?>&nbsp;Schedule</caption>
							<tr>
								<th>Match-Up</th>
								<th>Time</th>
								<th>Date</th>
							</tr>
							<?php $getGames = League_Schedule::find_by_sql("SELECT *, DATE_FORMAT(game_date, '%m/%d/%Y') AS gameDate FROM leagues_schedule WHERE season_week='$showWeekInfo->season_week' ORDER BY game_id;"); ?>
							<?php if(is_object($getGames)) { ?>
								<?php $game = $getGames; ?>
								<tr>
									<td><?php echo $game->away_team ." vs ". $game->home_team; ?></td>
									<td><?php echo $game->game_time; ?></td>
									<td><?php echo $game->gameDate; ?></td>
								</tr>
							<?php } elseif(is_array($getGames)) { ?>
								<?php foreach($getGames as $game) { ?>
									<tr>
										<td><?php echo $game->away_team . " vs " . $game->home_team; ?></td>
										<td><?php echo $game->game_time; ?></td>
										<td><?php echo $game->gameDate; ?></td>
									</tr>
								<?php }  ?>
							<?php }  ?>
						</table>
					</div>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</div>
	<?php require_once("../../include/leagues_footer.php"); ?>
</body>
</html>