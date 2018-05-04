<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeagueStanding extends Model
{
	public function __construct() {
		
	}
	
	/**
	* Get the league for the team object.
	*/
    public function league()
    {
        return $this->belongsTo('App\LeagueProfile');
    }
	
	/**
	* Get the league for the team object.
	*/
    public function season()
    {
        return $this->belongsTo('App\LeagueSeason');
    }
	
	/**
	* Scope a query to get the standings for this season.
	*/
	public function scopeSeasonStandings($query) {
		return $query->select(DB::raw("*, ROUND(team_wins/team_games, 2) AS winPERC"))
		->orderBy('winPERC', 'desc')
		->orderBy('team_wins', 'desc')
		->orderBy('team_losses', 'asc');
	}
}
