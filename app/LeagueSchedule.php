<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeagueSchedule extends Model
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
	* Get the league for the game object.
	*/
    public function league()
    {
        return $this->belongsTo('App\LeagueProfile');
    }
	
	/**
	* Get the result for the game object.
	*/
    public function result()
    {
        return $this->hasOne('App\LeagueScheduleResult');
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
	
	/**
	* Get a random game of the week.
	*/
	// public static function get_random_game() {
		// // Get a 1 week range to check game dates between
		// $addWeek = strtotime("+1 week");
		// $endRange = date("Y-m-d", $addWeek);
		// $begRange = date("Y-m-d");

		// // Get all the game dates between now and next week
		// $leagues = self::where([
			// ['game_date', '>=', $begRange],
			// ['game_date', '<=', $endRange],
		// ])
		// ->get()
		// ->first();
		
		// // If object return single object
		// // If array, get random index to return
		// if(is_object($leagues)) {
			// return $leagues;
		// } elseif(is_array($leagues)) {
			// $randomNum = rand(0, (count($leagues) - 1));
			// return $leagues[$randomNum];
		// }
	// }
	
	/**
	* Scope a query to only include games from now to next week.
	*/
	public function scopeUpcomingGames($query) 
	{
		$now = Carbon::now();

		return $query->where([
			['game_date', '<>', null],
			['game_date', '>=', $now->toDateString()]
		]);
	}
	
	/**
	* Scope a query to get all the weeks listed on the schedule.
	*/	
	public function scopeGetScheduleWeeks($query) 
	{
		return $query->select('season_week')
		->groupBy("season_week");
	}
	
	/**
	* Scope a query to get all the games on the schedule.
	*/
	public function scopeGetAllGames($query) 
	{
		return $query->orderBy("season_week");
	}
	
	/**
	* Scope a query to get all the games on the schedule for particular week.
	*/
	public function scopeGetWeekGames($query, $week) 
	{
		return $query->where("season_week", $week)->orderBy('game_date')->orderBy('game_time');
	}
	
	/**
	* Scope a query to get all the games on the schedule for particular week.
	*/
	public function scopeGetTeamGames($query, $teamID) 
	{
		return $query->where("home_team_id", $teamID)
			->orWhere('away_team_id', $teamID);
	}
}
