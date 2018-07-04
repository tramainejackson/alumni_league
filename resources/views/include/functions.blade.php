<?php
	$date = date("Y-m-d");
	$datetime = date("Y-m-d H:i:s");
	date_default_timezone_set("America/New_York");
	
	function find_ages() {
		$ages = array('10_and_under', '12_and_under', '14_and_under', '16_and_under', 
			'18_and_under', 'unlimited', '30_and_over', '50_and_over');
		
		return $ages;
	}
	
	function find_all_days() {
		$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'); 
		return $days;
	}
	
	function find_competitions() {
		$comp = array('coed', 'recreational', 'intermediate', 'competitive');
		
		return $comp;
	}
	
	function find_alphabet() {
		$alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
			'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
		
		return $alphabet;
	}

?>
