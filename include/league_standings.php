<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class League_Standings extends DatabaseObject {
	
	protected static $table_name = "leagues_standings";
	protected static $db_fields=array('leagues_profile_id', 'player_profile_id', 'ttr_player_id', 'leagues_teams_id',
		'team_name', 'player_name', 'jersey_num', 'games_played', 'points', 'threes_made', 'ft_made', 'rebounds', 
		'assist', 'steals', 'blocks');

	private $id;
	protected $leagues_profile_id;
	protected $leagues_teams_id;
	public $team_name;
	public $team_games;
	public $team_wins;
	public $team_losses;
	public $team_points;
	public $team_forfeits;
	public $winPERC;
	
	function __construct() {
		
	}
	
	public static function get_leagues_profile_id() {
		return $this->leagues_profile_id;
	}
	
	public function get_team_id() {
		return $this->leagues_teams_id;
	}
	
	private function sql_formatted_standings($leagueID=0) {
		$sqlFormat = "SELECT *, ROUND(team_wins/team_games, 2) AS winPERC 
			FROM leagues_standings 
			WHERE leagues_profile_id='".$leagueID."'
			ORDER BY team_wins/team_games DESC";
		return $sqlFormat;
	}
	
	public static function get_league_standings($leagueID=0) {
		$sql = self::sql_formatted_standings($leagueID);
		$standings = self::find_by_sql($sql);
		
		return $standings;
	}
	
}

?>