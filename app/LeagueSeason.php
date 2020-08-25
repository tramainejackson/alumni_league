<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\LeagueSchedule;

class LeagueSeason extends Model
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
        'league_profile_id', 'active', 'completed', 'paid',
    ];
	
	/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'league_profile_id',
    ];
	
	/**
	* Get the league for the team object.
	*/
    public function league_profile()
    {
        return $this->belongsTo('App\LeagueProfile');
    }
	
	/**
	* Get the league for the team object.
	*/
    public function playoffs()
    {
        return $this->hasOne('App\PlayoffSetting');
    }
	
	/**
	* Get the teams for the selected season.
	*/
    public function league_teams()
    {
        return $this->hasMany('App\LeagueTeam');
    }
	
	/**
	* Get the contact for the media object.
	*/
    public function league_players()
    {
        return $this->hasMany('App\LeaguePlayer');
    }

	/**
	* Get the stats for the league season object.
	*/
    public function stats()
    {
        return $this->hasMany('App\LeagueStat');
    }
	
	/**
	* Get the games for the league season object.
	*/
    public function games()
    {
        return $this->hasMany('App\LeagueSchedule');
    }
	
	/**
	* Get the standings for the league season object.
	*/
    public function standings()
    {
        return $this->hasMany('App\LeagueStanding');
    }
	
	/**
	* Get the pictures for the league season object.
	*/
    public function pictures()
    {
        return $this->hasMany('App\LeaguePicture');
    }

	/**
	* Get the conferences for the league season object.
	*/
    public function conferences()
    {
        return $this->hasMany('App\LeagueConference');
    }

	/**
	* Get the divisions for the league season object.
	*/
    public function divisions()
    {
        return $this->hasMany('App\LeagueDivision');
    }
	
	/**
	* Get the championship team for the season.
	*/
    public function champion()
    {
        return $this->hasOne('App\LeagueTeam', 'id', 'champion_id');
    }
	
	/*
	*
	* Complete non playin games playoff games round
	*
	*/
	public function complete_round($round=0) {
		$games = $this->games()->roundGames($round)->get();
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
				$settings = $this->playoffs;
				
				if($newRound <= $settings->total_rounds) {
					
					// Check to see if there is already a new round of games
					// Update the new round of games with the correct winning teams
					$nextRound = $this->games()->roundGames($newRound)->get();
					if($nextRound->isNotEmpty()) {
						foreach($nextRound as $nextRoundGame) {
							$nextRoundGame->delete();							
						}
					}
					
					for($x=0; $x < $games->count(); $x+2) {
						$playoffSchedule = new LeagueSchedule();
						$homeTeam = $games->shift();
						$awayTeam = $games->pop();

						$playoffSchedule->home_seed = $homeTeam->result->winning_team_id == $homeTeam->home_team_id ? $homeTeam->home_seed : $homeTeam->away_seed;
						$playoffSchedule->away_seed = $awayTeam->result->winning_team_id == $awayTeam->home_team_id ? $awayTeam->home_seed : $awayTeam->away_seed;
						
						// Get the 2 winning teams team object
						$homeTeam = LeagueTeam::find($homeTeam->result->winning_team_id);
						$awayTeam = LeagueTeam::find($awayTeam->result->winning_team_id);
						
						$playoffSchedule->home_team = $homeTeam->team_name;
						$playoffSchedule->away_team = $awayTeam->team_name;
						$playoffSchedule->home_team_id = $homeTeam->id;
						$playoffSchedule->away_team_id = $awayTeam->id;

						$playoffSchedule->league_season_id = $settings->league_season_id;
						$playoffSchedule->round = $newRound;
						
						if($playoffSchedule->save()) {
							// Add home and away players stats
							if($awayTeam->players->count() > 0) {
								foreach($awayTeam->players as $awayPlayer) {
									$newPlayerStat = new LeagueStat();
									$newPlayerStat->league_teams_id = $awayTeam->id;
									$newPlayerStat->league_season_id = $this->id;
									$newPlayerStat->league_schedule_id = $playoffSchedule->id;
									$newPlayerStat->league_player_id = $awayPlayer->id;
									$newPlayerStat->game_played = 0;
									
									if($newPlayerStat->save()) {}
								}
							}
							
							if($homeTeam->players->count() > 0) {
								foreach($homeTeam->players as $homePlayer) {
									$newPlayerStat = new LeagueStat();
									$newPlayerStat->league_teams_id = $homeTeam->id;
									$newPlayerStat->league_season_id = $this->id;
									$newPlayerStat->league_schedule_id = $playoffSchedule->id;
									$newPlayerStat->league_player_id = $homePlayer->id;
									$newPlayerStat->game_played = 0;
									
									if($newPlayerStat->save()) {}
								}
							}
						}
					}
				} else {					
					$this->champion_id = $game->result->winning_team_id;
					
					if($this->save()) {}
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
		$games 	= $this->games()->playoffPlayinGames()->get();
		$roundGames = $this->games()->playoffRounds()->get();
		$completeGames = 0;
		$newRound = 1;
		
		// Delete any tournament games that comes after the playin games
		if($roundGames->isNotEmpty()) {
			$deleteGames = $this->games()->playoffNonPlayinGames();
			
			foreach($deleteGames as $deleteGame) {
				$deleteGame->delete();
			}
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
				$settings = $this->playoffs;
				$standings = $this->standings()->get();
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
				// dd($this->games()->playoffRounds()->where('round', 1)->get());

				if($this->games()->playoffRounds()->where('round', 1)->get()->isNotEmpty()) {
					foreach($this->games()->playoffRounds()->where('round', 1)->get() as $playoffGameDelete) {
						$playoffGameDelete->delete();
					}
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

					if($playoffSchedule->save()) {
						// Add home and away players stats
						if($awayTeam->players->count() > 0) {
							foreach($awayTeam->players as $awayPlayer) {
								$newPlayerStat = new LeagueStat();
								$newPlayerStat->league_teams_id = $awayTeam->id;
								$newPlayerStat->league_season_id = $this->id;
								$newPlayerStat->league_schedule_id = $playoffSchedule->id;
								$newPlayerStat->league_player_id = $awayPlayer->id;
								$newPlayerStat->game_played = 0;
								
								if($newPlayerStat->save()) {}
							}
						}
						
						if($homeTeam->players->count() > 0) {
							foreach($homeTeam->players as $homePlayer) {
								$newPlayerStat = new LeagueStat();
								$newPlayerStat->league_teams_id = $homeTeam->id;
								$newPlayerStat->league_season_id = $this->id;
								$newPlayerStat->league_schedule_id = $playoffSchedule->id;
								$newPlayerStat->league_player_id = $homePlayer->id;
								$newPlayerStat->game_played = 0;
								
								if($newPlayerStat->save()) {}
							}
						}
					}
					
					$homeSeed++;
					$awaySeed--;
				}

				$settings->playin_games_complete = "Y";
				
				if($settings->save()){}
			}
		}
	}

	/**
     * Scope a query to only include active seasons.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeActive($query) {
    	return $query->where('active', 'Y')->get();
    }
	/**
     * Scope a query to only include active seasons.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeShowSeason($query, $season=null, $year=null) {
	    if(request()->query('season') != null) {
		    $season = request()->query('season');
	    }

	    if(request()->query('year') != null) {
		    $year = request()->query('year');
	    }

	    if($season != null && $year != null) {
		    return $query->where([
		    	['active', 'Y'],
		    	['id', $season],
		    	['year', $year],
		    	['completed', 'N'],
		    ])->get()->last();
	    } elseif($season == null && $year != null) {
		    return $query->where([
			    ['active', 'Y'],
			    ['year', $year],
			    ['completed', 'N'],
		    ])->get()->last();
	    } elseif($season != null && $year == null) {
		    return $query->where([
			    ['active', 'Y'],
			    ['id', $season],
			    ['completed', 'N'],
		    ])->get()->last();
	    } else {
		    return $query->where([
			    ['completed', 'N'],
			    ['active', 'Y'],
		    ])->get()->last();
	    }
    }
	
	/**
     * Scope a query to only include active seasons.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeCompleted($query) {
        return $query->where([
			['completed', 'Y'],
			['active', 'N'],
		]);
    }
	
	/**
	*
	* Start the playoffs for the selected season
	*
	**/
	public function create_playoff_settings() {
		$this->is_playoffs = 'Y';
		$seasonPlayoffs = $this->playoffs;
		$totalPlayoffTeams = $this->league_teams;
		$teams = $totalPlayoffTeams->count();
		$checkSchedule = $this->games->count();

		$target = 0;
		$round = 1;
		$rounds = 1;
		$homeSeed = 0;
		$awaySeed = $teams + 1;
		
		if($teams > 3) {
			// Create playoff settings
			do {
				$target = pow($teams, 1/$rounds);
				
				if($target <= 2) {
					if($target != 2) {
						$target = 0;
						$remainingTeams = 0;
						do {
							$teams--;
							$remainingTeams++;
							$target = pow($teams, 1/($rounds-1));
							if($target == 2) {
								if(fmod($remainingTeams, 2) != 0) {
									if($remainingTeams == 1) {
									} else {
									}
								}
							}
						} while($target != 2);
						$rounds--;
					} else {
						break;
					}
				} else {
					$rounds++;			
				}
			} while($target != 2);
			
			$seasonPlayoffs->total_rounds = $rounds;
			$seasonPlayoffs->teams_with_bye = 0;
			$seasonPlayoffs->playin_games = "N";
			$seasonPlayoffs->playin_games_complete = "Y";
			
			if(isset($remainingTeams)) {
				$seasonPlayoffs->teams_with_bye = ($teams - $remainingTeams);
				$seasonPlayoffs->playin_games = "Y";
				$seasonPlayoffs->playin_games_complete = "N";
			}

			$seasonPlayoffs->save();
			
			// Create playoff schedule
			if($seasonPlayoffs->playin_games == "Y") {
				$totalByeTeams = $seasonPlayoffs->teams_with_bye;
				$playInSeeds = $totalPlayoffTeams->count();
				$removeByeTeams = $totalPlayoffTeams->splice(0, $totalByeTeams);
				$totalPlayInGames = $totalPlayoffTeams->count() / 2;
				
				for($x=0; $x < $totalPlayInGames; $x++) {
					$playoffSchedule = new LeagueSchedule();
					$playInSeeds--;
					$homeSeed = $awaySeed = $playInSeeds;
					$homeTeam = $totalPlayoffTeams->shift();
					$awayTeam = $totalPlayoffTeams->pop();
					$playoffSchedule->league_season_id = $this->id;
					$playoffSchedule->home_team = $homeTeam->team_name;
					$playoffSchedule->home_team_id = $homeTeam->id;
					$playoffSchedule->away_team = $awayTeam->team_name;
					$playoffSchedule->away_team_id = $awayTeam->id;
					$playoffSchedule->home_seed = $homeSeed;
					$playoffSchedule->away_seed = $awaySeed;
					$playoffSchedule->playin_game = "Y";
					
					if($playoffSchedule->save()) {}
				}
				
			} else {
				while($totalPlayoffTeams->isNotEmpty()) {
					$playoffSchedule = new LeagueSchedule();
					$homeSeed++;
					$awaySeed--;
					$homeTeam = $totalPlayoffTeams->shift();
					$awayTeam = $totalPlayoffTeams->pop();
					
					$playoffSchedule->league_season_id = $this->id;
					$playoffSchedule->home_team = $homeTeam->team_name;
					$playoffSchedule->home_team_id = $homeTeam->id;
					$playoffSchedule->away_team = $awayTeam->team_name;
					$playoffSchedule->away_team_id = $awayTeam->id;
					$playoffSchedule->home_seed = $homeSeed;
					$playoffSchedule->away_seed = $awaySeed;
					$playoffSchedule->playin_game = "N";
					$playoffSchedule->round = $round;
					
					if($playoffSchedule->save()) {
						// Add home and away players stats
						if($awayTeam->players->count() > 0) {
							foreach($awayTeam->players as $awayPlayer) {
								$newPlayerStat = new LeagueStat();
								$newPlayerStat->league_teams_id = $awayTeam->id;
								$newPlayerStat->league_season_id = $showSeason->id;
								$newPlayerStat->league_schedule_id = $newGame->id;
								$newPlayerStat->league_player_id = $awayPlayer->id;
								$newPlayerStat->game_played = 0;
								
								if($newPlayerStat->save()) {}
							}
						}
						
						if($homeTeam->players->count() > 0) {
							foreach($homeTeam->players as $homePlayer) {
								$newPlayerStat = new LeagueStat();
								$newPlayerStat->league_teams_id = $homeTeam->id;
								$newPlayerStat->league_season_id = $showSeason->id;
								$newPlayerStat->league_schedule_id = $newGame->id;
								$newPlayerStat->league_player_id = $homePlayer->id;
								$newPlayerStat->game_played = 0;
								
								if($newPlayerStat->save()) {}
							}
						}
					}
				}
			}
			
			if($this->save()) {
				return 'Playoffs Started and Schedule Generated';
			}
		} else {
			$seasonPlayoffs->total_rounds = NULL;
			$seasonPlayoffs->teams_with_bye = NULL;
			$seasonPlayoffs->playin_games = "N";
			$seasonPlayoffs->playin_games_complete = "Y";
			
			if($seasonPlayoffs->save()) {
				$this->champion_id = NULL;
				$this->is_playoffs = 'N';
				
				if($this->save()) {
					return 'Not enough teams to create a playoff schedule';
				}
			}
		}
	}
}
