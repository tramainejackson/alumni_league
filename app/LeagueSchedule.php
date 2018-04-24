<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
	* Get the league for the team object.
	*/
    public function league()
    {
        return $this->belongsTo('App\LeagueProfile');
    }
	
	/**
	* Get a random game of the week.
	*/
	public static function get_random_game() {
		// Get a 1 week range to check game dates between
		$addWeek = strtotime("+1 week");
		$endRange = date("Y-m-d", $addWeek);
		$begRange = date("Y-m-d");

		// Get all the game dates between now and next week
		$leagues = self::where([
			['game_date', '>=', $begRange],
			['game_date', '<=', $endRange],
		])
		->get()
		->first();
		
		// If object return single object
		// If array, get random index to return
		if(is_object($leagues)) {
			return $leagues;
		} elseif(is_array($leagues)) {
			$randomNum = rand(0, (count($leagues) - 1));
			return $leagues[$randomNum];
		}
	}
}
