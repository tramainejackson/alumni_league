<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeagueScheduleResult extends Model
{
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
	
	/*
	*
	* Format the game date
	*
	*/
	public function game_date() 
	{
		$dt = new Carbon($this->game_date);
		return $dt->format('m-d-Y');
	}
	
	/*
	*
	* Format the game time to include either AM or PM
	*
	*/
	public function game_time()
	{
		$dt = new Carbon($this->game_time);
		return $dt->format('g:i A');
	}

}
