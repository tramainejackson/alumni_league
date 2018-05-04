<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class LeagueStat extends Model
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
	* Get the league for the team object.
	*/
    public function league()
    {
        return $this->belongsTo('App\LeagueProfile');
    }
	
	/**
	* Get the contact players the team object.
	*/
    public function player()
    {
        return $this->belongsTo('App\LeaguePlayer');
    }
	
	/**
	* Scope a query to get the scoring leaders for this league.
	*/
	public function scopeStealingLeaders($query, $limit) {
		return $query->select(DB::raw(self::get_formatted_stats()))
		->groupBy('league_players_id')
		->orderBy('SPG', 'desc')
		->limit($limit);
	}
	
	/**
	* Scope a query to get the scoring leaders for this league.
	*/
	public function scopeScoringLeaders($query, $limit) {
		return $query->select(DB::raw(self::get_formatted_stats()))
		->groupBy('league_players_id')
		->orderBy('PPG', 'desc')
		->limit($limit);
	}
	
	/**
	* Scope a query to get the assist leaders for this league.
	*/
	public function scopeAssistingLeaders($query, $limit) {
		return $query->select(DB::raw(self::get_formatted_stats()))
		->groupBy('league_players_id')
		->orderBy('APG', 'desc')
		->limit($limit);
	}
	
	/**
	* Scope a query to get the scoring leaders for this league.
	*/
	public function scopeReboundingLeaders($query, $limit) {
		return $query->select(DB::raw(self::get_formatted_stats()))
		->groupBy('league_players_id')
		->orderBy('RPG', 'desc')
		->limit($limit);
	}
	
	/**
	* Scope a query to get the scoring leaders for this league.
	*/
	public function scopeBlockingLeaders($query, $limit) {
		return $query->select(DB::raw(self::get_formatted_stats()))
		->groupBy('league_players_id')
		->orderBy('BPG', 'desc')
		->limit($limit);
	}
	
	public static function get_formatted_stats() {
		$format = "*, FORMAT(SUM(points)/SUM(game_played), 1) AS PPG,
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
		";
			
		return $format;
	}
}
