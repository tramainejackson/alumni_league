<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeagueStanding extends Model
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
        'team_name', 'leagues_season_id',
    ];
	
	public function __construct() {
		
	}
	
	/**
	* Get the league for the standings object.
	*/
    public function league()
    {
        return $this->belongsTo('App\LeagueProfile');
    }
	
	/**
	* Get the season for the standings object.
	*/
    public function season()
    {
        return $this->belongsTo('App\LeagueSeason');
    }
	
	/**
	* Get the team for the standings object.
	*/
    public function team()
    {
        return $this->belongsTo('App\LeagueTeam', 'league_team_id');
    }
	
	/**
	* Scope a query to get the standings for this season.
	*/
	public function scopeSeasonStandings($query) {
		return $query->select(DB::raw("*, ROUND(team_wins/team_games, 2) AS winPERC"))
		->where('deleted_at', null)
		->orderBy('winPERC', 'desc')
		->orderBy('team_wins', 'desc')
		->orderBy('team_losses', 'asc');
	}
	
	/**
	* Scope a query to update standings for this season.
	*/
	public function scopeStandingUpdate($query) {
		$teamStandings = $query->where('deleted_at', null)->get();
		
		// Update each team standings row
		foreach($teamStandings as $teamStanding) {
			$teamPoints = 0;
			$teamWins = 0;
			$teamLosses = 0;
			$teamForfeits = 0;
			$team = LeagueTeam::find($teamStanding->league_team_id);
			$homeGames = $team->home_games()->get()->isNotEmpty() ? $team->home_games()->get() : null;
			$awayGames = $team->away_games()->get()->isNotEmpty() ? $team->away_games()->get() : null;

			// Results when the away team
			if($awayGames != null) {
				foreach($awayGames as $game) {
					if($game->result()->get()->first()) {
						$result = $game->result()->get()->first();
						
						if($result->game_complete == 'Y') {
							if($result->winning_team_id == $game->away_team_id) {
								$teamWins++;
							} else {
								$teamLosses++;
							}
							
							if($result->forfeit == 'Y') {
								if($result->losing_team_id == $game->away_team_id) {
									$teamForfeits++;
								}
							} else {
								$teamPoints += $result->away_team_score;
							}
						}
					}
				}
			}
			
			// Results when the home team
			if($homeGames != null) {
				foreach($homeGames as $game) {
					if($game->result()->get()->first()) {
						$result = $game->result()->get()->first();
						
						if($result->game_complete == 'Y') {
							if($result->winning_team_id == $game->home_team_id) {
								$teamWins++;
							} else {
								$teamLosses++;
							}
							
							if($result->forfeit == 'Y') {
								if($result->losing_team_id == $game->home_team_id) {
									$teamForfeits++;
								}
							} else {
								$teamPoints += $result->home_team_score;
							}
						}
					}
				}
			}
		
			$teamStanding->team_games	= $teamLosses + $teamWins;
			$teamStanding->team_wins 	= $teamWins;
			$teamStanding->team_losses 	= $teamLosses;
			$teamStanding->team_forfeits = $teamForfeits;
			$teamStanding->team_points 	= $teamPoints;
			
			$teamStanding->save();
		}
	}
}
