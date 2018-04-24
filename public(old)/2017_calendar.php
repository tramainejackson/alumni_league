<?php
	$nbaGames = NBA_Calendar::get_games();
	$calendar = Calendar::get_all_months();
	$gameDates = array();
	
	//Create an array for all the games
	foreach($nbaGames as $nbaGame) {
		$thisDate = strtotime($nbaGame->game_date);
		array_push($gameDates, $thisDate);
	}
	
	foreach($calendar as $month) {
		$day = 1;
		$day_count = 1;
		$monthNum = $month->month_id;
		$monthName = $month->month_name;
		$totalDays = $month->month_days;
		$year = "2017";
		$firstDay = getdate(strtotime($day." ".$monthName." ".$year));
		$getFirstDayofMonth = $firstDay["weekday"];
		$getCurrentMonth = getdate();
		
		switch($getFirstDayofMonth) {   
			case "Sunday": $blank = 0; break;
			case "Monday": $blank = 1; break;   
			case "Tuesday": $blank = 2; break;   
			case "Wednesday": $blank = 3; break;   
			case "Thursday": $blank = 4; break;   
			case "Friday": $blank = 5; break;   
			case "Saturday": $blank = 6; break;   
		}
		
		if($getCurrentMonth["mon"] == $monthNum) { ?>
			<table id="<?php echo strtolower($monthName)."_calendar"; ?>" class="allCalendar_table currentMonth">
				<caption>
					<span><button class="prevMonth"></button></span>
					<span class="showingMonth"><?php echo $monthName; ?></span>
					<span class="showingYear"><?php echo $year; ?></span>
					<span><button class="nextMonth"></button></span>
				</caption>
				<tr>
		<?php } else { ?>
			<table id="<?php echo strtolower($monthName)."_calendar"; ?>" class="allCalendar_table">
				<caption>
					<span><button class="prevMonth"></button></span>
					<span class="showingMonth"><?php echo $monthName; ?></span>
					<span class="showingYear"><?php echo $year; ?></span>
					<span><button class="nextMonth"></button></span>
				</caption>
				<tr>
		<?php } ?>
		
				<th class="weekDayName">Sun</th>
				<th class="weekDayName">Mon</th>
				<th class="weekDayName">Tue</th>
				<th class="weekDayName">Wed</th>
				<th class="weekDayName">Thu</th>
				<th class="weekDayName">Fri</th>
				<th class="weekDayName">Sat</th>
			</tr>
			<tr>
		
		<?php while($blank > 0) {
			echo "<td></td>";   
			$blank = $blank-1;
			$day_count++;
		}
		
		//count up the days, untill we've done all of them in the month  
		while ( $day <= $totalDays ) {  
			$newDate = strtotime($day . " " . $monthName . " " . $year);

			if(in_array($newDate, $gameDates)) {
				$getIndGame = NBA_Calendar::find_game_by_date($year."-".$monthNum."-".$day);
				if($getIndGame->home_team == "Sixers") {
					echo "<td class='weekDayContent homeGame'><span class='weekDayNum'>".$day."</span><span class='nbaMatchup'>".$getIndGame->away_team." vs ".$getIndGame->home_team."</span><span class='gameTime'>".$getIndGame->game_time."</span></td>";
				} else {					
					echo "<td class='weekDayContent awayGame'><span class='weekDayNum'>".$day."</span><span class='nbaMatchup'>".$getIndGame->away_team." vs ".$getIndGame->home_team."</span><span class='gameTime'>".$getIndGame->game_time."</span></td>";
				}
			} else {
				echo "<td class='weekDayContent'><span class='weekDayNum'>".$day."</span></td>";
			}
			$day++;   
			$day_count++;    

			//Make sure we start a new row every week  
			if ($day_count > 7) {  
				echo "</tr><tr>";  
				$day_count = 1;  
			}	  
		}
		
		//Finaly we finish out the table with some blank details if needed  
		while ( $day_count >1 && $day_count <=7 ) {   
			echo "<td></td>";   
			$day_count++;   
		}    
		echo "</tr></table>";
	}	
?>