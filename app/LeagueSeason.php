<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeagueSeason extends Model
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
	* Get the contact for the media object.
	*/
    public function league_teams()
    {
        return $this->hasMany('App\LeagueTeam');
    }

	/**
	* Get the league for the team object.
	*/
    public function stats()
    {
        return $this->hasMany('App\LeagueStat');
    }
}
