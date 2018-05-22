<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

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
	* Get the games for the league season object.
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
	* Get the championship team for the season.
	*/
    public function champion()
    {
        return $this->hasOne('App\LeagueTeam', 'champion_id');
    }
	
	/**
     * Scope a query to only include active seasons.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeActive($query)
    {
        return $query->where('active', 'Y');
    }
	
	/**
     * Scope a query to only include active seasons.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeCompleted($query)
    {
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
	public function create_playoff_settings()
	{
		$seasonPlayoffs = $this->playoffs;
		$totalPlayoffTeams = $teams = $this->league_teams->count();
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
			dd($seasonPlayoffs);
			$seasonPlayoffs->save();
			
			// Create playoff schedule
			if($seasonPlayoffs->playin_games == "Y") {
				$totalByeTeams = $seasonPlayoffs->teams_with_bye;
				$playInSeeds = $totalPlayoffTeams->count();
				$removeByeTeams = $totalPlayoffTeams->splice(0, $totalByeTeams);
				$totalPlayInGames = $totalPlayoffTeams->count() / 2;
				
				for($x=0; $x < $totalPlayInGames; $x++) {
					$playoffSchedule = new \App\Game();
					$playInSeeds--;
					$homeSeed = $awaySeed = $playInSeeds;
					$homeTeam = $totalPlayoffTeams->shift();
					$awayTeam = $totalPlayoffTeams->pop();
					$playoffSchedule->home_team = $homeTeam->team_name;
					$playoffSchedule->home_team_id = $homeTeam->id;
					$playoffSchedule->away_team = $awayTeam->team_name;
					$playoffSchedule->away_team_id = $awayTeam->id;
					$playoffSchedule->home_seed = $homeSeed;
					$playoffSchedule->away_seed = $awaySeed;
					$playoffSchedule->playin_game = "Y";
					if($playoffSchedule->save()) {
						// $playoffSchedule->set_game_id($database->insert_id());
						// $playoffSchedule->id = $database->insert_id();
						
						// if($playoffSchedule->save()) {
							// // Add players from both teams to the stats table
							// $newStats = new League_Stats();
							// if($newStats->add_new_stats($playoffSchedule->get_league_id(), $playoffSchedule->get_game_id(), $playoffSchedule->get_home_team_id(), $playoffSchedule->get_away_team_id(), "NULL", "Y")) {
								// // $message->success("<li>All players have been added for stat keeping</li>");
							// } else {
								// // $message->error("<li>Players not added for stat keeping</li>");
							// }
						// }
					}
				}
				
			} else {
				// dd($totalPlayoffTeams);
				while($totalPlayoffTeams->isNotEmpty()) {
					$playoffSchedule = new \App\Game();
					$homeSeed++;
					$awaySeed--;
					$homeTeam = $totalPlayoffTeams->shift();
					$awayTeam = $totalPlayoffTeams->pop();
					
					$playoffSchedule->home_team = $homeTeam->team_name;
					$playoffSchedule->home_team_id = $homeTeam->id;
					$playoffSchedule->away_team = $awayTeam->team_name;
					$playoffSchedule->away_team_id = $awayTeam->id;
					$playoffSchedule->home_seed = $homeSeed;
					$playoffSchedule->away_seed = $awaySeed;
					$playoffSchedule->playin_game = "N";
					$playoffSchedule->round = $round;
					if($playoffSchedule->save()) {
						// $playoffSchedule->set_game_id($database->insert_id());
						// $playoffSchedule->id = $database->insert_id();
						
						// if($playoffSchedule->save()) {
							// // Add players from both teams to the stats table
							// $newStats = new League_Stats();
							// if($newStats->add_new_stats($playoffSchedule->get_league_id(), $playoffSchedule->get_game_id(), $playoffSchedule->get_home_team_id(), $playoffSchedule->get_away_team_id(), $round, "Y")) {
								// // $message->success("<li>All players have been added for stat keeping</li>");
							// } else {
								// // $message->error("<li>Players not added for stat keeping</li>");
							// }
						// }
					}
				}
			}
		} else {
			$seasonPlayoffs->total_rounds = NULL;
			$seasonPlayoffs->teams_with_bye = NULL;
			$seasonPlayoffs->playin_games = "N";
			$seasonPlayoffs->playin_games_complete = "Y";
			$seasonPlayoffs->champion = NULL;
			$seasonPlayoffs->champion_id = NULL;
			$seasonPlayoffs->save();
		}
	}
}
