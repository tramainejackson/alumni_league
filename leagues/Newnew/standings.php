<?php require_once	("../../include/initialize2.php"); ?>
<?php require_once("../../include/leagues_header.php"); ?>
<body>
<div class="leagues_page_div container-fluid">
	<?php include("leagues_menu.php"); ?>
	<h1>League Header or Banner</h1>
	<div id="league_standings">
		<?php $standings = League_Standings::get_league_standings(); ?>
		<table id="league_standings_table">
			<caption>Standings</caption>
			<tr>
				<th>Team Name</th>
				<th>Wins</th>
				<th>Losses</th>
				<th>Forfeits</th>
				<th>Win/Loss Pct.</th>
			</tr>
			<?php foreach($standings as $showStandings) { ?>
				<tr>
					<td><?php echo $showStandings->team_name; ?></td>
					<td><?php echo $showStandings->team_wins; ?></td>
					<td><?php echo $showStandings->team_losses; ?></td>
					<td><?php echo $showStandings->team_forfeits; ?></td>
					<td><?php echo $showStandings->winPERC; ?></td>
				</tr>
			<?php } ?>	
		</table>
	</div>
</div>
</body>
</html>