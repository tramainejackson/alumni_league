<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Member extends Authenticatable
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
        'title', 'name', 'bio', 'avatar'
    ];
	
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
	 * Get the avatar of the member
	 */
	public function getAvatarAttribute($value) {

		// Check if file exist
		$img_file = Storage::disk('public')->exists('images/' . $value . '_sm.png');

		if($img_file) {
			$img_file = $value . '_sm.png';
		} else {
			$img_file = 'default.png';
		}

		return $img_file;
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
	 * Check for active clients
	 */
	public function scopeShowMembers($query) {
		return $query->where('active', '=', 1)
			->get();
	}
}
