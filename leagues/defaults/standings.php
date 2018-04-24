<?php require_once("../../include/sessions.php"); ?>
<?php require_once("../../include/court.php"); ?>
<?php require_once("../../include/functions.php"); ?>
<?php require_once("../../include/leagues_header.php"); ?>
<body>
<h1>League Header or Banner</h1>
	<?php
		$leagues_id = 1;
		$query4 = "SELECT * FROM `leagues_profile` WHERE `leagues_id` = '$leagues_id'";
		$results4 = mysqli_query($connect, $query4) or die ("Unable to run query");
		$row_cnt = mysqli_num_rows($results4);
				while($row4 = mysqli_fetch_assoc($results4))
				{
				echo "<nav>";					
					echo "<button id='league_schedule_btn' class='individual_league_btn'><a href='/leagues/".str_ireplace(" ", "_", $row4['leagues_name'])."/schedule.php'>League Schedule</a></button>";
					echo "<button id='league_standings_btn' class='individual_league_btn'><a href='#'>League Standings</a></button disabled>";
					echo "<button id='league_stats_btn' class='individual_league_btn'><a href='/leagues/".str_ireplace(" ", "_", $row4['leagues_name'])."/stats.php'>League Stats</a></button>";
				echo "</nav>";
				}
	?>
	<div id="league_standings">
		<table id="league_standings_table">
			<caption>Standings</caption>
			<tr>
				<th>Team Name</th>
				<th>Wins</th>
				<th>Losses</th>
				<th>Forfeits</th>
				<th>Win/Loss Pct.</th>
				<th>Points/Game</th>
			</tr>
			<tr>
				<td>Team 1</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 2</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 3</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 4</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 5</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 6</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 7</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 8</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 9</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 10</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 11</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Team 12</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>	
</body>
</html>