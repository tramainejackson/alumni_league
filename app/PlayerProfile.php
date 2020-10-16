<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PlayerProfile extends Model
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
    public function user()
    {
        return $this->belongsTo('App\User');
    }
	
	/**
	* Get the players profile photo.
	*/
    public function image()
    {
        return $this->hasOne('App\PlayerProfileImages');
    }
	
	/**
	* Get the players profile photo.
	*/
    public function playgrounds()
    {
        return $this->hasMany('App\PlayerPlayground');
    }
	
	/**
	* Get the players profile photo.
	*/
    public function videos()
    {
        return $this->hasMany('App\PlayerProfileVideos');
    }
	
	/**
	* Get the players profile photo.
	*/
    public function leagues()
    {
        return $this->hasMany('App\LeaguePlayer');
    }
	
	/**
	* Get the players full name.
	*/
	public function full_name() {
		return $this->firstname . " " . $this->lastname;
	}
	
	/**
     *
     * Get all the rec centers from the player profiles and 
     * count the most popular ones
     *
     * @var array
    */
	public static function get_fire_recs() {
		$playerPlaygrounds = DB::table('player_playgrounds')->get();
		if(!empty($playerPlaygrounds)) {
			$fireRecs = [];
			$returnArray = [];
			
			foreach($playerPlaygrounds as $playground) {
				for($i=0; $i < count($playerPlaygrounds); $i++) { 
					array_push($fireRecs, $playground->playground);
				}
			}

			//Sort the array by rec name and how many times it was selected
			$orderArray = array_count_values($fireRecs);
			
			//Sort the array again to put the recs selected the most at the beginning
			uasort($orderArray, function ($a, $b) {
				if ($a==$b) return 0;
				return ($b<$a)?-1:1;
			});
			
			//Get the top 3 keys of the array and return them as the fire recs
			$fireRecs = array_keys($orderArray);
			
			//Add top 3 recs to an array
			//Return the top 3 array
			isset($fireRecs[0]) ? array_push($returnArray, $fireRecs[0]) : "";
			isset($fireRecs[1]) ? array_push($returnArray, $fireRecs[1]) : "";
			isset($fireRecs[2]) ? array_push($returnArray, $fireRecs[2]) : "";
			
			return $returnArray;
		
		} else {
			return false;
		}
	}
	
	public static function get_player_profiles_by_letter($letter) {
		$players = self::where('lastname', 'LIKE', $letter . '%')->orderBy('lastname', 'desc')->get();
		
		return $players;
	}
	
	public static function find_recent_added_players() {
		$date = Carbon::now()->subMonth();
		$players = self::where('created_at', '>', $date)->orderBy('created_at', 'desc')->get();

		return $players;
	}
	
	public static function find_player_videos_by_id($ID) {
		$playerVideo = DB::table('videos')->where('player_id', $ID)->get();
		
		return $playerVideo;
	}
	
	public function get_player_id() {
		return $this->player_id;
	}
}
