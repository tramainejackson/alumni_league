<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\LeagueTeam;
use App\LeagueStanding;

class LeagueSchedule extends Model
{
	use SoftDeletes;
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];
	
	/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];
	
	/**
	* Get the league for the game object.
	*/
    public function league()
    {
        return $this->belongsTo('App\LeagueProfile');
    }
	
	/**
	* Get the season for the game object.
	*/
    public function season()
    {
        return $this->belongsTo('App\LeagueSeason', 'league_season_id');
    }
	
	/**
	* Get the result for the game object.
	*/
    public function result()
    {
        return $this->hasOne('App\LeagueScheduleResult');
    }
	
	/**
	* Get the player stats for the game object.
	*/
    public function player_stats()
    {
        return $this->hasMany('App\LeagueStat');
    }
	
	/**
	* Get the home team for the scheduled game object.
	*/
    public function home_team_obj()
    {
        return $this->belongsTo('App\LeagueTeam', 'home_team_id');
    }
	
	/**
	* Get the away team for the scheduled game object.
	*/
    public function away_team_obj()
    {
        return $this->belongsTo('App\LeagueTeam', 'away_team_id');
    }
	
	/*
	*
	* Format the game date
	*
	*/
	public function game_date() 
	{
		$dt = new Carbon($this->game_date);
		return $dt->format('m-d-Y');
	}
	
	/*
	*
	* Format the game time to include either AM or PM
	*
	*/
	public function game_time()
	{
		$dt = new Carbon($this->game_time);
		return $dt->format('g:i A');
	}
	
	/*
	*
	* Check and see if the game is a playoff game
	*
	*/
	public function is_playoff_game()
	{
		if($this->season_week == null && ($this->playin_game != null || $this->round != null)) {
			return true;
		} else {
			return false;
		}
	}
	
	/*
	*
	* Check and see if the game is a playoff playin game
	*
	*/
	public function is_playin_game()
	{
		if($this->season_week == null && $this->playin_game == 'Y') {
			return true;
		} else {
			return false;
		}
	}
	
	/*
	*
	* Complete non playin games playoff games round
	*
	*/
	public function complete_round($round=0) {
		$games = LeagueSchedule::roundGames($round)->get();
		$completeGames = 0;
		$newRound = ($round + 1);

		if($games->isNotEmpty()) {
			if($games->isNotEmpty()) {
				foreach($games as $game) {
					if($game->result) {
						if($game->result->game_complete == "Y") {
							$completeGames++;
						}
					}
				}
			} else {
				$completeGames = 0;
			}
			
			if($games->count() == $completeGames) {
				$settings = $this->season->playoffs;
				
				if($newRound <= $settings->total_rounds) {
					
					// Check to see if there is already a new round of games
					// Update the new round of games with the correct winning teams
					$nextRound = LeagueSchedule::roundGames($newRound)->get();
					if($nextRound->isNotEmpty()) {
						foreach($nextRound as $nextRoundGame) {
							$nextRoundGame->delete();							
						}
					}
					
					for($x=0; $x < $games->count(); $x+2) {
						$playoffSchedule = new LeagueSchedule();
						$homeTeam = $games->shift();
						$awayTeam = $games->pop();
						
						$playoffSchedule->home_seed = $homeTeam->winning_team_id == $homeTeam->home_team_id ? $homeTeam->home_seed : $homeTeam->away_seed;
						$playoffSchedule->away_seed = $awayTeam->winning_team_id == $awayTeam->home_team_id ? $awayTeam->home_seed : $awayTeam->away_seed;
						
						// Get the 2 winning teams team object
						$homeTeam = LeagueTeam::find($homeTeam->winning_team_id);
						$awayTeam = LeagueTeam::find($homeTeam->winning_team_id);
						
						$playoffSchedule->home_team = $homeTeam->team_name;
						$playoffSchedule->away_team = $awayTeam->team_name;
						$playoffSchedule->home_team_id = $homeTeam->id;
						$playoffSchedule->away_team_id = $awayTeam->id;

						$playoffSchedule->league_season_id = $settings->league_season_id;
						$playoffSchedule->round = $newRound;
						
						if($playoffSchedule->save()) {}
					}
				} else {
					$settings->champion = $game->winning_team_id == $game->home_team_id ? $game->home_team : $game->away_team;
					
					$settings->season->champion_id = $game->winning_team_id;
					
					if($settings->save()) {}
				}
			}
		}
	}
	
	/*
	*
	* Complete playoff playin games games
	*
	*/
	public function complete_playins() {
		$games 	= LeagueSchedule::playoffPlayinGames()->get();
		$roundGames = LeagueSchedule::playoffRounds()->get();
		$completeGames = 0;
		$newRound = 1;
		
		// Delete any tourname games that comes after the playin games
		if($roundGames->isNotEmpty()) {
			$deleteGames = \App\Game::where('playin_game', 'N');
			$deleteGames->delete();
		}
		
		// Check to make sure that the completed playin games is equal
		// to the total amount of playin games
		if($games->isNotEmpty()) {
			if($games->isNotEmpty()) {
				foreach($games as $game) {
					if($game->result) {
						if($game->result->game_complete == "Y") {
							$completeGames++;
						}
					}
				}
			} else {
				$completeGames = 0;
			}
			
			if($games->count() == $completeGames) {
				$settings = $this->season->playoffs;
				$standings = LeagueStanding::seasonStandings()->get();
				$playoffTeams = collect();
				
				// Get the teams who have a bye
				// Add them to the array of playoff teams
				$totalByeTeams = $settings->teams_with_bye;
				
				for($x=1; $x <= $totalByeTeams; $x++) {
					$byeTeam = $standings->shift();
					$byeTeam = $byeTeam->team;
					
					$playoffTeams->push($byeTeam);
				}
				
				// Get the teams that have won their bye game
				// Add them to the array of playoff teams
				if($games->isNotEmpty()) {
					foreach($games as $game) {
						$team = LeagueTeam::find($game->result->winning_team_id);
						$playoffTeams->push($team);
					}
				}

				$homeSeed = 1;
				$awaySeed = $playoffTeams->count();

				if(LeagueSchedule::playoffRounds()->where('round', 1)->get()->isNotEmpty()) {
					LeagueSchedule::playoffRounds()->where('round', 1)->delete();
				}
				
				for($x=0; $x < $playoffTeams->count(); $x+2) {
					$playoffSchedule = new LeagueSchedule();
					$homeTeam = $playoffTeams->shift();
					$awayTeam = $playoffTeams->pop();

					$playoffSchedule->home_team = $homeTeam->team_name;
					$playoffSchedule->home_team_id = $homeTeam->id;
					$playoffSchedule->away_team = $awayTeam->team_name;
					$playoffSchedule->away_team_id = $awayTeam->id;
					$playoffSchedule->round = $newRound;
					$playoffSchedule->home_seed = $homeSeed;
					$playoffSchedule->away_seed = $awaySeed;
					$playoffSchedule->league_season_id = $settings->league_season_id;
					// $playoffSchedule->game_time = "12:00";
					// $playoffSchedule->game_date = date("Y-m-d");

					if($playoffSchedule->save()) {}
					
					$homeSeed++;
					$awaySeed--;
				}

				$settings->playin_games_complete = "Y";
				
				if($settings->save()){}
			}
		}
	}
	
	/**
	* Scope a query to only include games from now to next week.
	*/
	public function scopeUpcomingGames($query) {
		$now = Carbon::now();

		return $query->where([
			['game_date', '<>', null],
			['game_date', '>=', $now->toDateString()]
		]);
	}
	
	/**
	* Scope a query to get all the weeks listed on the schedule.
	*/	
	public function scopeGetScheduleWeeks($query) {
		return $query->select('season_week')
			->where('season_week', '<>', null)
			->groupBy("season_week");
	}

	/**
	* Scope a query to get the asg listed on the schedule.
	*/
	public function scopeGetASG($query) {
		return $query->select('*')
			->where('all_star_game', '=', 'Y');
	}
	
	/**
	* Scope a query to get all the playoff games listed on the schedule.
	* Excluding the playin games
	*/	
	public function scopePlayoffRounds($query) {
		return $query->select('round')
			->where([
				['season_week', null],
				['playin_game', 'N'],
				['round', '>', 0],
			])
			->groupBy("round");
	}
	
	/**
	* Scope a query to get all the playoff playin games listed on the schedule.
	*/	
	public function scopePlayoffNonPlayinGames($query) {
		return $query->select('*')
			->where([
				['season_week', null],
				['playin_game', 'N'],
				['round', '<>', null],
			]);
	}
	
	/**
	* Scope a query to get all the playoff playin games listed on the schedule.
	*/	
	public function scopeRoundGames($query, $round) {
		return $query->select('*')
			->where([
				['season_week', null],
				['playin_game', 'N'],
				['round', $round],
			]);
	}
	
	/**
	* Scope a query to get all the playoff playin games listed on the schedule.
	*/	
	public function scopePlayoffPlayinGames($query) {
		return $query->select('*')
			->where([
				['season_week', null],
				['playin_game', 'Y'],
			]);
	}
	
	/**
	* Scope a query to get all the games on the schedule.
	*/
	public function scopeGetAllGames($query) 
	{
		return $query->orderBy("season_week");
	}
	
	/**
	* Scope a query to get all the games on the schedule for particular week.
	*/
	public function scopeGetWeekGames($query, $week) 
	{
		return $query->where("season_week", $week)->orderBy('game_date')->orderBy('game_time');
	}
	
	/**
	* Scope a query to get all the games on the schedule for particular week.
	*/
	public function scopeGetRoundGames($query, $round) 
	{
		return $query->where([
				["round", $round],
				["season_week", null],
			])->orderBy('game_date')->orderBy('game_time');
	}
	
	/**
	* Scope a query to get all the games on the schedule for particular week.
	*/
	public function scopeGetTeamGames($query, $teamID) 
	{
		return $query->where("home_team_id", $teamID)
			->orWhere('away_team_id', $teamID);
	}
}
