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
	* Get the stats for the league season object.
	*/
    public function stats()
    {
        return $this->hasMany('App\LeagueStat');
    }
	
	/**
	* Get the games for the league season object.
	*/
    public function games()
    {
        return $this->hasMany('App\LeagueSchedule');
    }
	
	/**
	* Get the games for the league season object.
	*/
    public function standings()
    {
        return $this->hasOne('App\LeagueStanding');
    }
	
	/**
     * Scope a query to only include active seasons.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeActive($query)
    {
        return $query->where('active', 'Y');
    }
	
	/**
     * Scope a query to only include active seasons.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeCompleted($query)
    {
        return $query->where([
			['completed', 'Y'],
			['active', 'N'],
		]);
    }
}
