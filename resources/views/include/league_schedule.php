<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class League_Schedule extends DatabaseObject {
	
	protected static $table_name = "leagues_schedule";
	protected static $db_fields=array('leagues_profile_id', 'game_id', 'away_team_id', 'home_team_id', 'home_team', 'away_team',
		'home_team_score', 'away_team_score', 'game_location', 'game_time', 'game_date', 'season_week');

	private $id;
	protected $leagues_profile_id;
	protected $game_id;
	protected $away_team_id;
	protected $home_team_id;
	public $season_week;
	public $home_team;
	public $home_team_score;
	public $away_team;
	public $away_team_score;
	public $game_location;
	public $game_time;
	public $game_date;
	public $gameDate;
	
	function __construct() {
		
	}
	
	public static function get_weeks() {
		$weeks = self::find_by_sql("SELECT DISTINCT season_week FROM leagues_schedule;");
			
		return $weeks;
	}
	
	public static function get_game_id() {
		return $this->game_id;
	}
	
	public function get_away_team_id() {
		return $this->away_team_id;
	}
	
	public function get_home_team_id() {
		return $this->home_team_id;
	}
	
	public static function get_random_game() {
		// Get a 1 week range to check game dates between
		$addWeek = strtotime("+1 week");
		$endRange = date("Y-m-d", $addWeek);
		
		// Get all the game dates between now and next week
		$leagues = self::find_by_sql("SELECT * FROM leagues_schedule WHERE game_date BETWEEN CURDATE() AND '".$endRange."';");
		
		// If object return single object
		// If array, get random index to return
		if(is_object($leagues)) {
			return $leagues;
		} elseif(is_array($leagues)) {
			$randomNum = rand(0, (count($leagues) - 1));
			return $leagues[$randomNum];
		}
	}
	
}

?>