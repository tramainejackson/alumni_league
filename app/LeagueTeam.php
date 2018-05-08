<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeagueTeam extends Model
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
        'team_name', 'leagues_profile_id', 'fee_paid',
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
    public function players()
    {
        return $this->hasMany('App\LeaguePlayer');
    }
	
	/**
	* Get the league for the team object.
	*/
    public function season()
    {
        return $this->belongsTo('App\LeagueSeason');
    }
	
	/**
	* Scope a query to get all the teams who haven't paid yet
	*/
	public function scopeUnpaid($query) {
		return $query->where('fee_paid', 'N');
	}
}
