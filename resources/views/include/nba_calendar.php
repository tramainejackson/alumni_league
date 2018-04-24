<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class NBA_Calendar extends DatabaseObject {
	
	protected static $table_name = "nba_calendar";
	protected static $db_fields=array('game_id', 'home_team', 'away_team', 'game_location',
		'game_time', 'game_date');

	public $id;
	public $game_id;
	public $home_team;
	public $away_team;
	public $game_location;
	public $game_time;
	public $game_date;
	
	function __construct() {
		
	}
	
	public static function find_game_by_date($date) {
		$game = self::find_by_sql("SELECT * FROM nba_calendar WHERE game_date = '".$date."' LIMIT 1;");

		// echo"<pre>";
		// print_r($game);
		// echo"</pre>";
		
		return $game;
	}
	
	public static function get_games() {
		$games = self::find_by_sql("SELECT * FROM nba_calendar");
		
		return $games;
	}
	
} ?>