<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class LeagueProfile extends Model
{
    use SoftDeletes;

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];
	
	/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];
	
	/**
	* Get the players for the league object.
	*/
    public function players()
    {
        return $this->hasMany('App\LeaguePlayer');
    }
	
	/**
	* Get the team for the league object.
	*/
    public function teams()
    {
        return $this->hasMany('App\LeagueTeam');
    }
	
	/**
	* Get the standings for the league object.
	*/
    public function standings()
    {
        return $this->hasMany('App\LeagueStanding');
    }
	
	/**
	* Get the standings for the league object.
	*/
    public function stats()
    {
        return $this->hasMany('App\LeagueStat');
    }
	
	private function sql_formatted_stats($leagueID=0) {
		$sqlFormat = "*, FORMAT(SUM(points)/SUM(game_played), 1) AS PPG,
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
			SUM(blocks) AS TBLK";
		return $sqlFormat;
	}
	
	public function get_league_standings() {
		$standings = DB::table('league_standings')
		->select(DB::raw("*, ROUND(team_wins/team_games, 2) AS winPERC"))
		->where('leagues_profile_id', $this->attributes['id'])
		->orderBy('winPERC', 'desc')
		->get();
		
		return $standings;
	}
	
	public function get_scoring_leaders() { 
		$statQuery = $this->sql_formatted_stats();
		
		$players = DB::table('league_stats')
		->select(DB::raw($statQuery))
		->where('leagues_profile_id', $this->attributes['id'])
		->groupBy('league_player_id')
		->orderBy('TPTS', 'desc')
		->get();

		return $players;
	}

	public function get_assist_leaders() { 
		$statQuery = $this->sql_formatted_stats();
		
		$players = DB::table('league_stats')
		->select(DB::raw($statQuery))
		->where('leagues_profile_id', $this->attributes['id'])
		->groupBy('league_player_id')
		->orderBy('TASS', 'desc')
		->get();

		return $players;
	}
	
	public function get_rebounds_leaders($returnTotal=0) { 
		$statQuery = $this->sql_formatted_stats();
		
		$players = DB::table('league_stats')
		->select(DB::raw($statQuery))
		->where('leagues_profile_id', $this->attributes['id'])
		->groupBy('league_player_id')
		->orderBy('TRBD', 'desc')
		->get();

		return $players;
	}
	
	public function get_steals_leaders($returnTotal=0) { 
		$statQuery = $this->sql_formatted_stats();
		
		$players = DB::table('league_stats')
		->select(DB::raw($statQuery))
		->where('leagues_profile_id', $this->attributes['id'])
		->groupBy('league_player_id')
		->orderBy('TSTL', 'desc')
		->get();

		return $players;
	}
	
	public function get_blocks_leaders($returnTotal=0) { 
		$statQuery = $this->sql_formatted_stats();
		
		$players = DB::table('league_stats')
		->select(DB::raw($statQuery))
		->where('leagues_profile_id', $this->attributes['id'])
		->groupBy('league_player_id')
		->orderBy('TBLK', 'desc')
		->get();

		return $players;
	}
	
	public function get_all_players_stats() { 
		$statQuery = $this->sql_formatted_stats();
		
		$players = DB::table('league_stats')
		->select(DB::raw($statQuery))
		->where('leagues_profile_id', $this->attributes['id'])
		->groupBy('league_player_id')
		->orderBy('TPTS', 'desc')
		->get();

		return $players;
	}
	
	public function get_all_teams_stats() {
		$teams = DB::table('league_stats')
		->join('league_standings', 'league_stats.league_team_id', '=', 'league_standings.league_team_id')
		->join('league_teams', 'league_stats.league_team_id', '=', 'league_teams.id')
		->select(DB::raw("DISTINCT
			SUM(points) AS TPTS,
			SUM(threes_made) AS TTHR,
			SUM(ft_made) AS TFTS,
			SUM(assist) AS TASS,
			SUM(rebounds) AS TRBD,
			SUM(steals) AS TSTL,
			SUM(blocks) AS TBLK,
			FORMAT(SUM(points)/team_games, 1) AS PPG,
			FORMAT(SUM(threes_made)/team_games, 1) AS TPG,
			FORMAT(SUM(ft_made)/team_games, 1) AS FTPG,
			FORMAT(SUM(assist)/team_games, 1) AS APG,
			FORMAT(SUM(steals)/team_games, 1) AS SPG,
			FORMAT(SUM(rebounds)/team_games, 1) AS RPG,
			FORMAT(SUM(blocks)/team_games, 1) AS BPG,
			league_standings.league_team_id,
			league_standings.team_name,
			team_wins,
			team_losses,
			team_games,
			team_picture")
		)
		->groupBy('league_team_id')
		->orderBy('TPTS', 'desc')
		->get();
		
		return $teams;
	}

}
