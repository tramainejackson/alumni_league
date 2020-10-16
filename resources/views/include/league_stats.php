<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');
class League_Stats extends DatabaseObject {
	
	protected static $table_name = "leagues_stats";
	protected static $db_fields = array('leagues_stats_id', 'leagues_profile_id', 'player_profile_id', 'leagues_teams_id',
		'team_name', 'player_name', 'jersey_num', 'game_played', 'playoff_game', 'points', 'threes_made', 'ft_made', 'rebounds', 
		'assist', 'steals', 'blocks', 'leagues_players_id', 'game_id', 'round', 'ttr_player', 'ttr_player_picture');
	protected $leagues_stats_id;
	protected $leagues_profile_id;
	protected $leagues_players_id;
	protected $player_profile_id;
	protected $leagues_teams_id;
	protected $game_id;
	public $id;
	public $team_name;
	public $player_name;
	public $jersey_num;
	public $points;
	public $threes_made;
	public $ft_made;
	public $rebounds;
	public $assist;
	public $steals;
	public $blocks;
	public $PPG;
	public $APG;
	public $RPG;
	public $SPG;
	public $BPG;
	public $TPG;
	public $FTPG;
	public $TPTS;
	public $TTHR;
	public $TFTS;
	public $TASS;
	public $TRBD;
	public $TSTL;
	public $TBLK;
	public $game_played;
	public $ttr_player;
	public $ttr_player_picture;
	
	function __construct() {
		
	}

	public function get_league_stat_id() {
		return $this->leagues_stats_id;
	}

	public function get_league_id() {
		return $this->leagues_profile_id;
	}
	
	public function get_player_profile_id() {
		return $this->player_profile_id;
	}

	public function get_league_player_id() {
		return $this->leagues_players_id;
	}
	
	public function get_team_id() {
		return $this->leagues_teams_id;
	}
	
	public function set_ttr_players_id($playerID=0) {
		$this->player_profile_id = $playerID;
	}
	
	public function get_ttr_players_id() {
		return $this->player_profile_id;
	}
	
	public function get_game_id() {
		return $this->game_id;
	}
	
	public static function get_player_stats_by_id($leaguesID=0, $playerID=0) {
		$sqlFormat = "SELECT DISTINCT *, FORMAT(SUM(points)/SUM(game_played), 1) AS PPG,
			FORMAT(SUM(threes_made)/SUM(game_played), 1) AS TPG,
			FORMAT(SUM(ft_made)/SUM(game_played), 1) AS FTPG,
			FORMAT(SUM(assist)/SUM(game_played), 1) AS APG,
			FORMAT(SUM(rebounds)/SUM(game_played), 1) AS RPG,
			FORMAT(SUM(steals)/SUM(game_played), 1) AS SPG,
			FORMAT(SUM(blocks)/SUM(game_played), 1) AS BPG,
			SUM(points) AS TPTS,
			SUM(threes_made) AS TTHR,
			SUM(ft_made) AS TFTS,
			SUM(assist) AS TASS,
			SUM(rebounds) AS TRBD,
			SUM(steals) AS TSTL,
			SUM(blocks) AS TBLK
			FROM leagues_stats
			WHERE leagues_profile_id = '".$leaguesID."' 
			AND leagues_players_id = '".$playerID."' 
			GROUP BY leagues_players_id";
		$players = self::find_by_sql($sqlFormat);
		return $players;
	}
	
	public static function get_player_by_id($leaguesID=0, $playerID=0) {
		$player = self::find_by_sql("SELECT DISTINCT * FROM leagues_stats WHERE leagues_profile_id = '".$leaguesID."' AND leagues_players_id = '".$playerID."';");

		return $player;
	}
	
	public static function get_ttr_player_by_id($leaguesID=0, $playerID=0) {
		$player = self::find_by_sql("SELECT DISTINCT * FROM leagues_stats WHERE leagues_profile_id = '".$leaguesID."' AND leagues_players_id = '".$playerID."' AND ttr_player = 'Y';");

		return $player;
	}
	
	public function get_game_by_id($gameID=0, $leagueID=0) {
		$game = self::find_by_sql("SELECT * FROM leagues_stats WHERE game_id = '".$gameID."' AND leagues_profile_id = '".$leagueID."';");
		return $game;
	}

	private function sql_formatted_stats($leagueID=0) {
		$sqlFormat = "SELECT *, FORMAT(SUM(points)/SUM(game_played), 1) AS PPG,
			FORMAT(SUM(threes_made)/SUM(game_played), 1) AS TPG,
			FORMAT(SUM(ft_made)/SUM(game_played), 1) AS FTPG,
			FORMAT(SUM(assist)/SUM(game_played), 1) AS APG,
			FORMAT(SUM(rebounds)/SUM(game_played), 1) AS RPG,
			FORMAT(SUM(steals)/SUM(game_played), 1) AS SPG,
			FORMAT(SUM(blocks)/SUM(game_played), 1) AS BPG,
			SUM(points) AS TPTS,
			SUM(threes_made) AS TTHR,
			SUM(ft_made) AS TFTS,
			SUM(assist) AS TASS,
			SUM(rebounds) AS TRBD,
			SUM(steals) AS TSTL,
			SUM(blocks) AS TBLK
			FROM leagues_stats
			WHERE leagues_profile_id = '".$leagueID."'
			GROUP BY leagues_players_id";
		return $sqlFormat;
	}
	
	public static function get_all_stats($leagueID=0) {
		global $database;
		
		$stats = self::find_by_sql("SELECT DISTINCT leagues_profile_id FROM leagues_stats WHERE leagues_profile_id = '".$leagueID."';");
		return $stats;
	}
	
	public function get_scoring_leaders($returnTotal=0) { 
		$statQuery = $this->sql_formatted_stats($this->get_league_id());
		$player = self::find_by_sql($statQuery . " ORDER BY TPTS DESC LIMIT ".$returnTotal.";");
		return $player;
	}
	
	public function get_assist_leaders($returnTotal=0) { 
		$statQuery = $this->sql_formatted_stats($this->get_league_id());
		$player = self::find_by_sql($statQuery . " ORDER BY TASS DESC LIMIT ".$returnTotal.";");
		return $player;
	}
	
	public function get_rebounds_leaders($returnTotal=0) { 
		$statQuery = $this->sql_formatted_stats($this->get_league_id());
		$player = self::find_by_sql($statQuery . " ORDER BY TRBD DESC LIMIT ".$returnTotal.";");
		return $player;
	}
	
	public function get_steals_leaders($returnTotal=0) { 
		$statQuery = $this->sql_formatted_stats($this->get_league_id());
		$player = self::find_by_sql($statQuery . " ORDER BY TSTL DESC LIMIT ".$returnTotal.";");
		return $player;
	}
	
	public function get_blocks_leaders($returnTotal=0) { 
		$statQuery = $this->sql_formatted_stats($this->get_league_id());
		$player = self::find_by_sql($statQuery . " ORDER BY TBLK DESC LIMIT ".$returnTotal.";");
		return $player;
	}
	
	public function get_all_players_stats() { 
		$statQuery = self::sql_formatted_stats($this->get_league_id());
		$player = self::find_by_sql($statQuery . " ORDER BY TPTS DESC;");
		return $player;
	}
	
	public function get_all_teams_stats() {
		$teams = self::find_by_sql("
			SELECT DISTINCT
			SUM(t1.points) AS TPTS,
			SUM(t1.threes_made) AS TTHR,
			SUM(t1.ft_made) AS TFTS,
			SUM(t1.assist) AS TASS,
			SUM(t1.rebounds) AS TRBD,
			SUM(t1.steals) AS TSTL,
			SUM(t1.blocks) AS TBLK,
			FORMAT(SUM(t1.points)/t2.team_games, 1) AS PPG,
			FORMAT(SUM(t1.threes_made)/t2.team_games, 1) AS TPG,
			FORMAT(SUM(t1.ft_made)/t2.team_games, 1) AS FTPG,
			FORMAT(SUM(t1.assist)/t2.team_games, 1) AS APG,
			FORMAT(SUM(t1.steals)/t2.team_games, 1) AS SPG,
			FORMAT(SUM(t1.rebounds)/t2.team_games, 1) AS RPG,
			FORMAT(SUM(t1.blocks)/t2.team_games, 1) AS BPG,
			t2.team_name,
			t2.team_wins,
			t2.team_losses,
			t2.team_games,
			t3.team_picture
			FROM leagues_stats AS t1
			JOIN leagues_standings AS t2 ON t1.leagues_teams_id = t2.leagues_teams_id
			JOIN leagues_teams AS t3 ON t1.leagues_teams_id = t3.leagues_teams_id
			GROUP BY t1.leagues_teams_id 
			ORDER BY TPTS DESC;"
		);
		return $teams;
	}
	
	public static function get_team_game_stats($gameID=0, $teamID=0, $leaguesID=0) {
		$statQuery = self::sql_formatted_stats();
		$player = self::find_by_sql("SELECT * FROM leagues_stats WHERE game_id = '".$gameID."' AND leagues_teams_id = '".$teamID."' AND leagues_profile_id = '".$leaguesID."';");
		return $player;
	}
	
	public static function get_weeks() {
		$weeks = self::find_by_sql("SELECT DISTINCT season_week FROM leagues_schedule;");
		return $weeks;
	}
	
	public static function game_team_change($leagueID=0, $oldTeam=0, $newTeam=0, $gameID=0) {
		self::add_new_team_stats($leagueID, $gameID, $newTeam);
		self::delete_game_team_stats($leagueID, $gameID, $oldTeam);
	}
}
?>