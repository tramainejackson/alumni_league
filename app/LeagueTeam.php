<?php

namespace App;

use App\LeagueProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
        return $this->belongsTo('App\LeagueProfile', 'league_profile_id');
    }
	
	/**
	* Get the players for the team object.
	*/
    public function players()
    {
        return $this->hasMany('App\LeaguePlayer');
    }
	
	/**
	* Get the home games for the team object.
	*/
    public function home_games()
    {
        return $this->hasMany('App\LeagueSchedule', 'home_team_id');
    }
	
	/**
	* Get the away games for the team object.
	*/
    public function away_games()
    {
        return $this->hasMany('App\LeagueSchedule', 'away_team_id');
    }
	
	/**
	* Get the season for the team object.
	*/
    public function season()
    {
        return $this->belongsTo('App\LeagueSeason', 'league_season_id');
    }
	
	/**
	* Get the standings for the team object.
	*/
    public function standings()
    {
        return $this->hasOne('App\LeagueStanding');
    }

	/**
	* Get the standings for the team object.
	*/
    public function conference()
    {
        return $this->belongsTo('App\LeagueConference', 'league_conference_id');
    }

	/**
	* Get the standings for the team object.
	*/
    public function division() {
        return $this->belongsTo('App\LeagueDivision', 'league_division_id');
    }
	
	/**
	* Get the large team picture.
	*/
    public function lg_photo() {
	    // Check if file exist
	    if(file_exists(str_ireplace('public/images', 'storage/images/lg', $this->team_picture))) {
		    $path = str_ireplace('public/images', 'storage/images/lg', $this->team_picture);
	    } else {
		    $path = str_ireplace('public/images', 'storage/images/lg', LeagueProfile::find(2)->picture);
	    }

	    return $path;
    }
	
	/**
	* Get the small team picture.
	*/
    public function sm_photo() {
	    // Check if file exist
	    if(file_exists(str_ireplace('public/images', 'storage/images/sm', $this->team_picture))) {
		    $path = str_ireplace('public/images', 'storage/images/sm', $this->team_picture);
	    } else {
		    $path = str_ireplace('public/images', 'storage/images/sm', LeagueProfile::find(2)->picture);
	    }

	    return $path;
    }
	
	/**
	* Scope a query to get all the teams who haven't paid yet
	*/
	public function scopeUnpaid($query) {
		return $query->where('fee_paid', 'N');
	}
	
	/**
	* Scope a query to get all the games for this team
	*/
	public function scopeGames($query) {
		return $query->where('home_team_id', $this->id)
			->orWhere('away_team_id', $this->id);
	}
}
