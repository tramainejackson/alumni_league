<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
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
        'username', 'email', 'password', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token) {
		$this->notify(new ResetPasswordNotification($token));
	}

	/**
	* Get the leagues profile for the user.
	*/
    public function leagues_profiles() {
        return $this->hasMany('App\LeagueProfile');
    }
	
	/**
	* Get the league player profiles for the user.
	*/
    public function league_player_profiles() {
        return $this->hasMany('App\LeaguePlayer');
    }

	/**
	* Get the player profile for the user.
	*/
//    public function player_profiles() {
//        return $this->hasMany('App\PlayerProfile');
//    }

	/**
	 * Get the name of the member
	 */
	public function getTitleAttribute($value) {
		return ucwords(strtolower($value));
	}

	/**
	 * Get the link of the member
	 */
	public function getLinkAttribute($value) {
		return strtolower($value);
	}

	/**
	 * Get the owner of the member
	 */
	public function getNameAttribute($value) {
		return ucwords(strtolower($value));
	}

	/**
	 * Set the name of the member
	 */
	public function setTitleAttribute($value) {
		$this->attributes['title'] = ucwords(strtolower($value));
	}

	/**
	 * Set the link of the member
	 */
	public function setLinkAttribute($value) {
		$this->attributes['link'] = strtolower($value);
	}

	/**
	 * Set the owner of the member
	 */
	public function setNameAttribute($value) {
		$this->attributes['name'] = ucwords(strtolower($value));
	}

	/**
	 * Check for active users
	 */
	public function scopeShowMembers($query) {
		return $query->where('active', '=', 1)
			->get();
	}
}
