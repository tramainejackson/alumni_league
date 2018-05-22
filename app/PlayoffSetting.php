<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayoffSetting extends Model
{
    use SoftDeletes;
	
	/**
	* Get the seaon for the playoff settings object.
	*/
    public function season()
    {
        return $this->belongsTo('App\LeagueSeason');
    }
	
	/**
	* Get the games for the seasons playoffs.
	*/
    public function games()
    {
        return $this->belongsTo('App\LeagueSeason');
    }
}
