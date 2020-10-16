<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerProfileImages extends Model
{
    use SoftDeletes;
	
	/**
	* Get the contact for the media object.
	*/
    public function player_profile()
    {
        return $this->belongsTo('App\PlayerProfile');
    }
}
