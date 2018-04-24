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
					echo "<button id='league_schedule_btn' class='individual_league_btn'><a href='#'>League Schedule</a></button disabled>";
					echo "<button id='league_standings_btn' class='individual_league_btn'><a href='/leagues/".str_ireplace(" ", "_", $row4['leagues_name'])."/standings.php'>League Standings</a></button>";
					echo "<button id='league_stats_btn' class='individual_league_btn'><a href='/leagues/".str_ireplace(" ", "_", $row4['leagues_name'])."/stats.php'>League Stats</a></button>";
				echo "</nav>";
				}
	?>
		<div class="leagues_schedule">
			<table id="week_1_schedule" class="weekly_schedule">
				<caption>Week 1 Schedule</caption>
				<tr>
					<th>Match-Up</th>
					<th>Time</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>Team 1 vs. Team 2</td>
					<td>1/1/2000</td>
					<td>12:00PM</td>
				</tr>
				<tr>
					<td>Team 3 vs. Team 4</td>
					<td>1/1/2000</td>
					<td>1:00PM</td>
				</tr>
				<tr>
					<td>Team 5 vs. Team 6</td>
					<td>1/1/2000</td>
					<td>2:00PM</td>
				</tr>
				<tr>
					<td>Team 7 vs. Team 8</td>
					<td>1/1/2000</td>
					<td>3:00PM</td>
				</tr>
				<tr>
					<td>Team 9 vs. Team 10</td>
					<td>1/1/2000</td>
					<td>4:00PM</td>
				</tr>
				<tr>
					<td>Team 11 vs. Team 12</td>
					<td>1/1/2000</td>
					<td>5:00PM</td>
				</tr>
			</table>
		</div>	
		
		<div class="leagues_schedule">
			<table id="week_2_schedule" class="weekly_schedule">
				<caption>Week 2 Schedule</caption>
				<tr>
					<th>Match-Up</th>
					<th>Time</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>Team 1 vs. Team 2</td>
					<td>1/1/2000</td>
					<td>12:00PM</td>
				</tr>
				<tr>
					<td>Team 3 vs. Team 4</td>
					<td>1/1/2000</td>
					<td>1:00PM</td>
				</tr>
				<tr>
					<td>Team 5 vs. Team 6</td>
					<td>1/1/2000</td>
					<td>2:00PM</td>
				</tr>
				<tr>
					<td>Team 7 vs. Team 8</td>
					<td>1/1/2000</td>
					<td>3:00PM</td>
				</tr>
				<tr>
					<td>Team 9 vs. Team 10</td>
					<td>1/1/2000</td>
					<td>4:00PM</td>
				</tr>
				<tr>
					<td>Team 11 vs. Team 12</td>
					<td>1/1/2000</td>
					<td>5:00PM</td>
				</tr>
			</table>
		</div>	
		
		<div class="leagues_schedule">
			<table id="week_3_schedule" class="weekly_schedule">
				<caption>Week 3 Schedule</caption>
				<tr>
					<th>Match-Up</th>
					<th>Time</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>Team 1 vs. Team 2</td>
					<td>1/1/2000</td>
					<td>12:00PM</td>
				</tr>
				<tr>
					<td>Team 3 vs. Team 4</td>
					<td>1/1/2000</td>
					<td>1:00PM</td>
				</tr>
				<tr>
					<td>Team 5 vs. Team 6</td>
					<td>1/1/2000</td>
					<td>2:00PM</td>
				</tr>
				<tr>
					<td>Team 7 vs. Team 8</td>
					<td>1/1/2000</td>
					<td>3:00PM</td>
				</tr>
				<tr>
					<td>Team 9 vs. Team 10</td>
					<td>1/1/2000</td>
					<td>4:00PM</td>
				</tr>
				<tr>
					<td>Team 11 vs. Team 12</td>
					<td>1/1/2000</td>
					<td>5:00PM</td>
				</tr>
			</table>
		</div>	
		
		<div class="leagues_schedule">
			<table id="week_4_schedule" class="weekly_schedule">
				<caption>Week 4 Schedule</caption>
				<tr>
					<th>Match-Up</th>
					<th>Time</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>Team 1 vs. Team 2</td>
					<td>1/1/2000</td>
					<td>12:00PM</td>
				</tr>
				<tr>
					<td>Team 3 vs. Team 4</td>
					<td>1/1/2000</td>
					<td>1:00PM</td>
				</tr>
				<tr>
					<td>Team 5 vs. Team 6</td>
					<td>1/1/2000</td>
					<td>2:00PM</td>
				</tr>
				<tr>
					<td>Team 7 vs. Team 8</td>
					<td>1/1/2000</td>
					<td>3:00PM</td>
				</tr>
				<tr>
					<td>Team 9 vs. Team 10</td>
					<td>1/1/2000</td>
					<td>4:00PM</td>
				</tr>
				<tr>
					<td>Team 11 vs. Team 12</td>
					<td>1/1/2000</td>
					<td>5:00PM</td>
				</tr>
			</table>
		</div>	
		
		<div class="leagues_schedule">
			<table id="week_5_schedule" class="weekly_schedule">
				<caption>Week 5 Schedule</caption>
				<tr>
					<th>Match-Up</th>
					<th>Time</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>Team 1 vs. Team 2</td>
					<td>1/1/2000</td>
					<td>12:00PM</td>
				</tr>
				<tr>
					<td>Team 3 vs. Team 4</td>
					<td>1/1/2000</td>
					<td>1:00PM</td>
				</tr>
				<tr>
					<td>Team 5 vs. Team 6</td>
					<td>1/1/2000</td>
					<td>2:00PM</td>
				</tr>
				<tr>
					<td>Team 7 vs. Team 8</td>
					<td>1/1/2000</td>
					<td>3:00PM</td>
				</tr>
				<tr>
					<td>Team 9 vs. Team 10</td>
					<td>1/1/2000</td>
					<td>4:00PM</td>
				</tr>
				<tr>
					<td>Team 11 vs. Team 12</td>
					<td>1/1/2000</td>
					<td>5:00PM</td>
				</tr>
			</table>
		</div>	
		
		<div class="leagues_schedule">
			<table id="week_6_schedule" class="weekly_schedule">
				<caption>Week 6 Schedule</caption>
				<tr>
					<th>Match-Up</th>
					<th>Time</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>Team 1 vs. Team 2</td>
					<td>1/1/2000</td>
					<td>12:00PM</td>
				</tr>
				<tr>
					<td>Team 3 vs. Team 4</td>
					<td>1/1/2000</td>
					<td>1:00PM</td>
				</tr>
				<tr>
					<td>Team 5 vs. Team 6</td>
					<td>1/1/2000</td>
					<td>2:00PM</td>
				</tr>
				<tr>
					<td>Team 7 vs. Team 8</td>
					<td>1/1/2000</td>
					<td>3:00PM</td>
				</tr>
				<tr>
					<td>Team 9 vs. Team 10</td>
					<td>1/1/2000</td>
					<td>4:00PM</td>
				</tr>
				<tr>
					<td>Team 11 vs. Team 12</td>
					<td>1/1/2000</td>
					<td>5:00PM</td>
				</tr>
			</table>
		</div>	
		
		<div class="leagues_schedule">
			<table id="week_7_schedule" class="weekly_schedule">
				<caption>Week 7 Schedule</caption>
				<tr>
					<th>Match-Up</th>
					<th>Time</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>Team 1 vs. Team 2</td>
					<td>1/1/2000</td>
					<td>12:00PM</td>
				</tr>
				<tr>
					<td>Team 3 vs. Team 4</td>
					<td>1/1/2000</td>
					<td>1:00PM</td>
				</tr>
				<tr>
					<td>Team 5 vs. Team 6</td>
					<td>1/1/2000</td>
					<td>2:00PM</td>
				</tr>
				<tr>
					<td>Team 7 vs. Team 8</td>
					<td>1/1/2000</td>
					<td>3:00PM</td>
				</tr>
				<tr>
					<td>Team 9 vs. Team 10</td>
					<td>1/1/2000</td>
					<td>4:00PM</td>
				</tr>
				<tr>
					<td>Team 11 vs. Team 12</td>
					<td>1/1/2000</td>
					<td>5:00PM</td>
				</tr>
			</table>
		</div>
		
		<div class="leagues_schedule">
			<table id="week_8_schedule" class="weekly_schedule">
				<caption>Week 8 Schedule</caption>
				<tr>
					<th>Match-Up</th>
					<th>Time</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>Team 1 vs. Team 2</td>
					<td>1/1/2000</td>
					<td>12:00PM</td>
				</tr>
				<tr>
					<td>Team 3 vs. Team 4</td>
					<td>1/1/2000</td>
					<td>1:00PM</td>
				</tr>
				<tr>
					<td>Team 5 vs. Team 6</td>
					<td>1/1/2000</td>
					<td>2:00PM</td>
				</tr>
				<tr>
					<td>Team 7 vs. Team 8</td>
					<td>1/1/2000</td>
					<td>3:00PM</td>
				</tr>
				<tr>
					<td>Team 9 vs. Team 10</td>
					<td>1/1/2000</td>
					<td>4:00PM</td>
				</tr>
				<tr>
					<td>Team 11 vs. Team 12</td>
					<td>1/1/2000</td>
					<td>5:00PM</td>
				</tr>
			</table>
		</div>	
		
		<div class="leagues_schedule">
			<table id="week_9_schedule" class="weekly_schedule">
				<caption>Week 9 Schedule</caption>
				<tr>
					<th>Match-Up</th>
					<th>Time</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>Team 1 vs. Team 2</td>
					<td>1/1/2000</td>
					<td>12:00PM</td>
				</tr>
				<tr>
					<td>Team 3 vs. Team 4</td>
					<td>1/1/2000</td>
					<td>1:00PM</td>
				</tr>
				<tr>
					<td>Team 5 vs. Team 6</td>
					<td>1/1/2000</td>
					<td>2:00PM</td>
				</tr>
				<tr>
					<td>Team 7 vs. Team 8</td>
					<td>1/1/2000</td>
					<td>3:00PM</td>
				</tr>
				<tr>
					<td>Team 9 vs. Team 10</td>
					<td>1/1/2000</td>
					<td>4:00PM</td>
				</tr>
				<tr>
					<td>Team 11 vs. Team 12</td>
					<td>1/1/2000</td>
					<td>5:00PM</td>
				</tr>
			</table>
		</div>	
		
		<div class="leagues_schedule">
			<table id="week_10_schedule" class="weekly_schedule">
				<caption>Week 10 Schedule</caption>
				<tr>
					<th>Match-Up</th>
					<th>Time</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>Team 1 vs. Team 2</td>
					<td>1/1/2000</td>
					<td>12:00PM</td>
				</tr>
				<tr>
					<td>Team 3 vs. Team 4</td>
					<td>1/1/2000</td>
					<td>1:00PM</td>
				</tr>
				<tr>
					<td>Team 5 vs. Team 6</td>
					<td>1/1/2000</td>
					<td>2:00PM</td>
				</tr>
				<tr>
					<td>Team 7 vs. Team 8</td>
					<td>1/1/2000</td>
					<td>3:00PM</td>
				</tr>
				<tr>
					<td>Team 9 vs. Team 10</td>
					<td>1/1/2000</td>
					<td>4:00PM</td>
				</tr>
				<tr>
					<td>Team 11 vs. Team 12</td>
					<td>1/1/2000</td>
					<td>5:00PM</td>
				</tr>
			</table>
		</div>	
</body>
</html>