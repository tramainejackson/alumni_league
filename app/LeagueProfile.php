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
        'user_id', 'name', 'commish', 'address', 'phone', 'leagues_email',
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
	
	/**
	* Get the seasons for the league object.
	*/
    public function seasons()
    {
        return $this->hasMany('App\LeagueSeason');
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
		/* Changed to scopeSeasonStandings in LeagueStanding.php */
	}

}
