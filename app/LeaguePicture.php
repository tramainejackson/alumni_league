<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaguePicture extends Model
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
        '',
    ];
	
	/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        '',
    ];
	
	/**
	* Get the season for the picture object.
	*/
    public function season()
    {
        return $this->belongsTo('App\LeagueSeason');
    }
	
	/**
	* Get the large league picture.
	*/
    public function lg_photo()
    {
        return asset(str_ireplace('images', 'images/lg', $this->picture_path));
    }
	
	/**
	* Get the small league picture.
	*/
    public function sm_photo()
    {
        return asset(str_ireplace('images', 'images/sm', $this->picture_path));
    }
	
	/**
	* Scope a query to get all the pictures that have a description
	*/
	public function scopeDescription($query) {
		return $query->where('description', '<>', null);
	}
}
