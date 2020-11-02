<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeagueRule extends Model
{
    use SoftDeletes;
	
	/**
	* Get the league for the team object.
	*/
    public function league_profile()
    {
        return $this->belongsTo('App\LeagueProfile');
    }
	
	/**
	* Scope a query to get the captain of the team
	*/
//	public function scopeCaptain($query) {
//		return $query->where('team_captain', 'Y')
//			->get();
//	}
}
