<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
	use SoftDeletes;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	/**
	 * Create full name accessor
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function full_name()	{
		return $this->name;
	}

	/**
	 * Create a readable sting for the phone number
	 */
	public function phone_number() {
		if($this->phone !== null && $this->phone !== '') {
			$phoneNum = substr($this->phone, 0 ,3) . '-' . substr($this->phone, 3 ,3) . '-' .substr($this->phone, 6 ,4);
		} else {
			$phoneNum = 'No Phone Number Listed';
		}

		return $phoneNum;
	}

	/**
	 * Scope a query to only include most recent consult request
	 * that hasn't been responded to yet.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeLeastRecent($query)	{
		return $query->where('responded', '=', 'N')
			->orderBy('created_at', 'asc')
			->get();
	}
}
