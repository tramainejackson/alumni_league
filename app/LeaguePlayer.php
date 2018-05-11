<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaguePlayer extends Model
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
	* Get the contact for the media object.
	*/
    public function player_profile()
    {
        return $this->belongsTo('App\PlayerProfile');
    }
	
	/**
	* Get the contact for the media object.
	*/
    public function league_team()
    {
        return $this->belongsTo('App\PlayerProfile');
    }
	
	/**
	* Get the league for the team object.
	*/
    public function league_profile()
    {
        return $this->belongsTo('App\LeagueProfile');
    }
	
	/**
	* Get the league for the team object.
	*/
    public function stats()
    {
        return $this->hasMany('App\LeagueStat');
    }
	
	/**
	* Scope a query to get the captain of the team
	*/
	public function scopeCaptain($query) {
		return $query->where('team_captain', 'Y')->first();
	}
}
