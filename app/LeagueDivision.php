<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeagueDivision extends Model
{

	/**
	 * Get the teams for the division object.
	 */
	public function teams()
	{
		return $this->hasMany('App\LeagueTeam');
	}

}
