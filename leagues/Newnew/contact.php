<?php require_once	("../../include/initialize2.php"); ?>
<?php require_once("../../include/leagues_header.php"); ?>
<body>
	<div class="leagues_page_div container-fluid">
		<?php include("leagues_menu.php");
		echo "<h1>League Header or Banner</h1>";
		
		$league = "Newnew";
		$query3 = "SELECT * FROM `leagues_profile` WHERE `leagues_name` = '$league'";
		$results3 = mysqli_query($connect, $query3) or die ("Unable to run query results 3 ".mysql_error($connect));
		$row_cnt = mysqli_num_rows($results3);
		while($row3 = mysqli_fetch_assoc($results3))
		{
			$no_site = "None";
			echo "<div class='leagueContactInfo'>
					<table class=leagues_page_table>
					<tr>
						<td><b>League Owner:</b></td><td>".$row3['leagues_commish']."</td>
					</tr>
					<tr>
						<td><b>Competition Level:</b></td><td>".str_ireplace("_", "-", str_ireplace(" ", ", ", ucwords($row3['leagues_comp'])))."</td>
					</tr>
					<tr>
						<td><b>Leagues Age:</b></td><td>".str_ireplace("_", " ", str_ireplace(" ", ", ", ucwords($row3['leagues_age'])))."</td>
					</tr>";
					
				if($row3['leagues_fee'] > 0)
				{
					echo "<tr><td><b>Entry Fee:</b></td><td>$".$row3['leagues_fee']."</td></tr>";
				}
				else
				{
					echo "<tr><td><b>Entry Fee:</b></td><td>Call for more information</td></tr>";
				}
				if($row3['ref_fee'] > 0)
				{
					echo "<tr><td><b>Ref Fees per/g:</b></td><td>$".$row3['ref_fee']."</td></tr>";					
				}
				else
				{
					echo "<tr><td><b>Ref Fees per/g:</b></td><td>Call for more information</td></tr>";					
				}
				
				echo "<tr>
						<td><b>More Info:</b></td><td>".$row3['leagues_phone']."</td>
					</tr>
					<tr>
						<td><b>League Address:</b></td><td>".$row3['leagues_address']."</td>
					</tr>
					</table>
				</div>";
		}
		?>
		<button id="league_rules_btn">SEE LEAGUE RULES</button>
		<div id="leagues_rules">
			<h2>Leagues Rules</h2>
			<ul>
				<li>All teams must arrive 15 minutes before their scheduled game time.</li>
				<li>All players must wear their teams jersey. If a player does not have a jersey, that player will not be allowed to play.</li>
				<li>If teams aren't present 10 minutes after their scheduled game time they will be issued a forfeit.</li>
				<li>Ref fees will be collected at halftime of every game.</li>
				<li>After 5 fouls a player fouls out.</li>
				<li>20 minutes halves with a running clock except the last 2 minutes of each half.</li>
				<li>Each team has 4 timeouts per game.</li>
				<li>Each overtime period will be 3 minutes</li>
			</ul>
		</div>
	</div>
	<?php require_once("../../include/leagues_footer.php"); ?>
</body>
</html>	