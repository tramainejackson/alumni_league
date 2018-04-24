<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Calendar_Event extends DatabaseObject {
	
	protected static $table_name = "calendar_event";
	protected static $db_fields=array('calendar_event_id', 'event_name', 'event_info', 'event_location',
		'event_start_time',  'event_date', 'show_event');
	protected $calendar_event_id;
	protected $event_name;
	protected $event_info;
	protected $event_location;
	protected $event_start_time;
	protected $event_date;
	protected $show_event;
	public $id;
	
	function __construct() {
		
	}

	public function get_calendar_event_id() {
		return $this->calendar_event_id;
	}
	
	public function get_event_name() {
		return $this->event_name;
	}

	public function get_event_info() {
		return $this->event_info;
	}
	
	public function get_event_location() {
		return $this->event_location;
	}
	
	public function get_event_time() {
		return $this->event_start_time;
	}
	
	public function get_event_date() {
		return $this->event_date;
	}
	
	public function show_event() {
		if($this->show_event == 'Y') {
			return true;
		} else {
			return false;
		}
	}
	
	public static function get_calendar_events() {
		$events = self::find_by_sql("SELECT * FROM calendar_event WHERE;");
		return $events;
	}
	
	public static function get_team_by_id($leaguesID=0, $teamID=0) {
		$teams = self::find_by_sql("SELECT * FROM leagues_teams WHERE leagues_profile_id = '".$leaguesID."' AND leagues_teams_id = '".$teamID."';");
		return $teams;
	}
	
	public static function get_team_players($leaguesID=0, $teamID=0) {
		$players = self::find_by_sql("SELECT * FROM leagues_players WHERE leagues_profile_id = '".$leaguesID."' AND leagues_teams_id = '".$teamID."';");
		return $players;
	}

}
?>