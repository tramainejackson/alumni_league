<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeagueConference extends Model
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
		'league_season_id', 'conference_name',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'id',
	];

	/**
	 * Get the teams for the conference object.
	 */
	public function teams()
	{
		return $this->hasMany('App\LeagueTeam');
	}
}
