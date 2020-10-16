<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class News extends Model
{
	use SoftDeletes;
	
	/**
	* Get the writer profile for the news article.
	*/
    public function writer()
    {
        return $this->belongsTo('App\WriterProfile');
    }
	
	/**
	* Get the writer profile for the news article.
	*/
    public function publish_date()
    {
		$date = new Carbon($this->publish_date);
		
        return $date->format('m/d/Y');
    }
	
	/**
	* Get the writers recent news article.
	*/
	public function scopeRecentPost($query, $exclude=null) {
		$date = Carbon::now()->subMonth();
		
		$post = $query->where([
			['created_at', '>', $date],
			['publish', '=', 'Y'],
			['id', '<>', $exclude]
		])
		->orderBy('created_at', 'desc')
		->get();

		return $post;
	}
	
	/**
	* Get the writers recent news article.
	*/
	public function scopePublished($query) {		
		$post = $query->where('publish', '=', 'Y')
		->get();

		return $post;
	}
	
	/**
	* Get the writers recent news article.
	*/
	public function scopeUnpublished($query) {		
		$post = $query->where('publish', null)
		->orWhere('publish', 'N')
		->get();

		return $post;
	}
	
	/**
	* Search news article.
	*/
	public function scopeSearch($query, $search) {
		$news = $query->where('title', 'like', '%' . $search . '%')
			->orWhere('article', 'like', '%' . $search . '%')
			->get();

		return $news;
	}
}
