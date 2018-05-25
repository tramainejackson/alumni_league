<?php

namespace App\Http\Controllers;

use App\PlayerProfile;
use App\LeagueProfile;
use App\LeagueSchedule;
use App\LeagueScheduleResult;
use App\LeagueStanding;
use App\LeaguePlayer;
use App\LeagueTeam;
use App\LeagueStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeagueScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$activeSeasons = $showSeason->league_profile->seasons()->active()->get();

		if($showSeason->is_playoffs == 'Y') {
			$playoffRounds = $showSeason->games()->playoffRounds()->orderBy('round', 'desc')->get();
			$nonPlayInGames = $showSeason->games()->playoffNonPlayinGames();
			$playInGames = $showSeason->games()->playoffPlayinGames();
			$playoffSettings = $showSeason->playoffs;
			
			return view('playoffs.schedule', compact('showSeason', 'activeSeasons', 'playInGames', 'nonPlayInGames', 'playoffRounds', 'playoffSettings'));
		} else {
			$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks();
			
			return view('schedule.index', compact('showSeason', 'activeSeasons', 'seasonScheduleWeeks'));
		}
    }
	
	/**
     * Show the application create team page.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$activeSeasons = $showSeason->league_profile->seasons()->active()->get();

		$weekCount = $showSeason->games()->getScheduleWeeks()->get();
		
		return view('schedule.create', compact('showSeason', 'activeSeasons', 'showSeason', 'weekCount'));
    }
	
	/**
     * Edit the schedule for a particular week.
     *
     * @return \Illuminate\Http\Response
    */
    public function edit($week)
    {
		// Get the season to show
		$showSeason	= $this->find_season(request());
		$thisWeek 	= $week;
		$weekGames 	= $showSeason->games()->getWeekGames($week)->orderBy('game_date')->orderBy('game_time')->get();
		
		return view('schedule.edit', compact('showSeason', 'weekGames', 'thisWeek'));
    }
	
	/**
     * Edit the schedule for a particular week.
     *
     * @return \Illuminate\Http\Response
    */
    public function edit_playins()
    {
		// Get the season to show
		$showSeason	= $this->find_season(request());
		$weekGames 	= $showSeason->games()->playoffPlayinGames()->get();
		
		return view('playoffs.edit', compact('showSeason', 'weekGames'));
    }
	
	/**
     * Edit the schedule for a playoff round selected.
     *
     * @return \Illuminate\Http\Response
    */
    public function edit_round($round)
    {
		// Get the season to show
		$showSeason	= $this->find_season(request());
		$weekGames 	= $showSeason->games()->roundGames($round)->get();

		return view('playoffs.edit_round', compact('showSeason', 'weekGames', 'round'));
    }
	
	/**
     * Store a new game on the schedule.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_game(Request $request)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$awayTeam = LeagueTeam::find($request->away_team);
		$homeTeam = LeagueTeam::find($request->home_team);
		$time = new Carbon($request->game_time);
		
		$newGame = new LeagueSchedule();
		$newGame->league_season_id = $showSeason->id;
		$newGame->season_week = $request->season_week;
		$newGame->away_team_id = $awayTeam->id;
		$newGame->away_team = $awayTeam->team_name;
		$newGame->home_team_id = $homeTeam->id;
		$newGame->home_team = $homeTeam->team_name;
		$newGame->game_time = $time->toTimeString();
		$newGame->game_date = $request->date_picker_submit;
		
		if($newGame->save()) {
			// Add home and away players stats
			foreach($awayTeam->players as $awayPlayer) {
				$newPlayerStat = new LeagueStat();
				$newPlayerStat->league_teams_id = $awayTeam->id;
				$newPlayerStat->league_season_id = $showSeason->id;
				$newPlayerStat->league_schedule_id = $newGame->id;
				$newPlayerStat->league_player_id = $awayPlayer->id;
				$newPlayerStat->game_played = 0;
				
				if($newPlayerStat->save()) {}
			}
			
			foreach($homeTeam->players as $homePlayer) {
				$newPlayerStat = new LeagueStat();
				$newPlayerStat->league_teams_id = $homeTeam->id;
				$newPlayerStat->league_season_id = $showSeason->id;
				$newPlayerStat->league_schedule_id = $newGame->id;
				$newPlayerStat->league_player_id = $homePlayer->id;
				$newPlayerStat->game_played = 0;
				
				if($newPlayerStat->save()) {}
			}
				
			return redirect()->back()->with('status', 'Game Added Successfully');
		} else {}
    }
	
	/**
     * Store a new week on the schedule.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_week(Request $request)
    {
		// dd($request);
		// Get the season to show
		$showSeason = $this->find_season(request());
		$newGameCount = 0;
		$weekCount = $showSeason->games->max('season_week') + 1;
		
		foreach($request->home_team as $key => $homeTeam) {
			$awayTeam = LeagueTeam::find($request->away_team[$key]);
			$homeTeam = LeagueTeam::find($homeTeam);
			$time = new Carbon($request->game_time[$key]);
			$date = $request->date_picker[($key*2)+1];
			
			$newGame = new LeagueSchedule();
			$newGame->league_season_id = $showSeason->id;
			$newGame->season_week = $weekCount;
			$newGame->away_team_id = $awayTeam->id;
			$newGame->away_team = $awayTeam->team_name;
			$newGame->home_team_id = $homeTeam->id;
			$newGame->home_team = $homeTeam->team_name;
			$newGame->game_time = $time->toTimeString();
			$newGame->game_date = $date;
			
			if($newGame->save()) {
				$newGameCount++;

				// Add home and away players stats
				foreach($awayTeam->players as $awayPlayer) {
					$newPlayerStat = new LeagueStat();
					$newPlayerStat->league_teams_id = $awayTeam->id;
					$newPlayerStat->league_season_id = $showSeason->id;
					$newPlayerStat->league_schedule_id = $newGame->id;
					$newPlayerStat->league_player_id = $awayPlayer->id;
					$newPlayerStat->game_played = 0;
					
					if($newPlayerStat->save()) {}
				}
				
				foreach($homeTeam->players as $homePlayer) {
					$newPlayerStat = new LeagueStat();
					$newPlayerStat->league_teams_id = $homeTeam->id;
					$newPlayerStat->league_season_id = $showSeason->id;
					$newPlayerStat->league_schedule_id = $newGame->id;
					$newPlayerStat->league_player_id = $homePlayer->id;
					$newPlayerStat->game_played = 0;
					
					if($newPlayerStat->save()) {}
				}
			} else {}
		}

		return redirect()->action('LeagueScheduleController@index')->with('status', $newGameCount . 'Game(s) Added Successfully');
    }
	
	/**
	 * Update a week on the schedule.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update_week(Request $request, $week)
	{
		// dd($request);
		// Get the season to show
		$showSeason = $this->find_season(request());
		
		// Add all the new games that were added to the schedule
		// If any are set
		if(isset($request->new_away_team) || isset($request->new_home_team)) {
			foreach($request->new_away_team as $key => $away_team_id) {
				$awayTeam	= LeagueTeam::find($request->new_away_team[$key]);
				$homeTeam 	= LeagueTeam::find($request->new_home_team[$key]);
				$time 		= new Carbon($request->new_game_time[$key]);
				$date 		= $request->new_date_picker[($key*2)+1];
				
				$newGame = new LeagueSchedule();
				$newGame->league_season_id = $showSeason->id;
				$newGame->season_week = $week;
				$newGame->away_team_id = $awayTeam->id;
				$newGame->away_team = $awayTeam->team_name;
				$newGame->home_team_id = $homeTeam->id;
				$newGame->home_team = $homeTeam->team_name;
				$newGame->game_time = $time->toTimeString();
				$newGame->game_date = $date;
				
				if($newGame->save()) {
					if($request->new_home_score > 0 || $request->new_away_score > 0) {
						$result = new LeagueScheduleResult();
						$result->home_team_score = $request->new_home_score[$key];
						$result->away_team_score = $request->new_away_score[$key];
						
						if($request->new_home_score > $request->new_away_score) {
							$result->winning_team_id = $homeTeam->id;
							$result->losing_team_id = $awayTeam->id;
						} else {
							$result->losing_team_id = $homeTeam->id;
							$result->winning_team_id = $awayTeam->id;
						}
						
						$result->game_complete = 'Y';
						$result->forfeit = 'N';
						$result->league_schedule_id = $newGame->id;
						$result->league_season_id = $newGame->league_season_id;

						if($result->save()) {}
					}
				} else {}
			}
		}
		
		// Update all the games which are previously scheduled
		foreach($request->game_id as $key => $game_id) {
			$game		= LeagueSchedule::find($game_id);
			$awayTeam	= LeagueTeam::find($request->away_team[$key]);
			$homeTeam 	= LeagueTeam::find($request->home_team[$key]);
			$time 		= new Carbon($request->game_time[$key]);
			$date 		= $request->date_picker[($key*2)+1];

			// Check if any games are set to forfeit
			// If there are check and see if this game id is
			// in either the home or away array
			$awayForfeit = isset($request->away_forfeit) ? in_array($game->id, $request->away_forfeit) ? : null : null;
			$homeForfeit = isset($request->home_forfeit) ? in_array($game->id, $request->home_forfeit) ? : null : null;
			
			$game->league_season_id = $showSeason->id;
			$game->away_team_id = $awayTeam->id;
			$game->away_team = $awayTeam->team_name;
			$game->home_team_id = $homeTeam->id;
			$game->home_team = $homeTeam->team_name;
			$game->game_time = $time->toTimeString();
			$game->game_date = $date;
			
			if($game->save()) {
				// If stats exist then check if teams were changed
				// If teams were changed then remove team that was changed and 
				// add new players
				if($game->player_stats->isNotEmpty()) {
					$currentTeamID1 = $game->player_stats()->teams()[0]->league_teams_id;
					$currentTeamID2 = $game->player_stats()->teams()[1]->league_teams_id;
					
					// Remove team players if they do not 
					// match either team that was saved
					// for this game
					if($currentTeamID1 != $awayTeam->id && $currentTeamID1 != $homeTeam->id) {
						$removeTeam = LeagueTeam::find($currentTeamID1);
						$removeStats = $game->player_stats()->where([
							['league_teams_id', $currentTeamID1],
							['deleted_at', null],
						])->get();
						
						foreach($removeStats as $removeTeamPlayerStat) {
							if($removeTeamPlayerStat->delete()) {}
						}
					}
					
					// Remove team players if they do not match either team that was saved
					// for this game
					if($currentTeamID2 != $awayTeam->id && $currentTeamID2 != $homeTeam->id) {
						$removeTeam = LeagueTeam::find($currentTeamID2);
						$removeStats = $game->player_stats()->where([
							['league_teams_id', $currentTeamID2],
							['deleted_at', null],
						])->get();
						
						foreach($removeStats as $removeTeamPlayerStat) {
							if($removeTeamPlayerStat->delete()) {}
						}
					}
					
					// Add away team players if they do not already have stats 
					// added for this week
					if($currentTeamID1 != $awayTeam->id && $currentTeamID2 != $awayTeam->id) {
						foreach($awayTeam->players as $awayPlayer) {
							$newPlayerStat = new LeagueStat();
							$newPlayerStat->league_teams_id = $awayTeam->id;
							$newPlayerStat->league_season_id = $showSeason->id;
							$newPlayerStat->league_schedule_id = $game->id;
							$newPlayerStat->league_player_id = $awayPlayer->id;
							$newPlayerStat->game_played = 0;
							
							if($newPlayerStat->save()) {}
						}
					}
					
					// Add home team players if they do not already have stats 
					// added for this week
					if($currentTeamID1 != $homeTeam->id && $currentTeamID2 != $homeTeam->id) {
						foreach($homeTeam->players as $homePlayer) {
							$newPlayerStat = new LeagueStat();
							$newPlayerStat->league_teams_id = $homeTeam->id;
							$newPlayerStat->league_season_id = $showSeason->id;
							$newPlayerStat->league_schedule_id = $game->id;
							$newPlayerStat->league_player_id = $homePlayer->id;
							$newPlayerStat->game_played = 0;
							
							if($newPlayerStat->save()) {}
						}
					}
				} else {
					foreach($awayTeam->players as $awayPlayer) {
						$newPlayerStat = new LeagueStat();
						$newPlayerStat->league_teams_id = $awayTeam->id;
						$newPlayerStat->league_season_id = $showSeason->id;
						$newPlayerStat->league_schedule_id = $game->id;
						$newPlayerStat->league_player_id = $awayPlayer->id;
						$newPlayerStat->game_played = 0;
						
						if($newPlayerStat->save()) {}
					}
					
					foreach($homeTeam->players as $homePlayer) {
						$newPlayerStat = new LeagueStat();
						$newPlayerStat->league_teams_id = $homeTeam->id;
						$newPlayerStat->league_season_id = $showSeason->id;
						$newPlayerStat->league_schedule_id = $game->id;
						$newPlayerStat->league_player_id = $homePlayer->id;
						$newPlayerStat->game_played = 0;
						
						if($newPlayerStat->save()) {}
					}
				}
				
				$result = '';
				
				// Update game result row if it exist
				if(LeagueScheduleResult::where('league_schedule_id', $game_id)->first()) {
					$result = LeagueScheduleResult::where('league_schedule_id', $game_id)->first();
				} else {
					$result = new LeagueScheduleResult();
				}
				
				$result->league_schedule_id = $game_id;
				$result->league_season_id = $showSeason->id;
				$result->home_team_score = $request->home_score[$key];
				$result->away_team_score = $request->away_score[$key];
				$result->forfeit = 'N';
				$result->game_complete = 'N';
					
				// If forfeit
				if($homeForfeit != null || $awayForfeit != null) {
					$result->forfeit = 'Y';
					$result->game_complete = 'Y';
					$result->home_team_score = null;
					$result->away_team_score = null;
					
					if($awayForfeit != null) {
						$result->winning_team_id = $homeTeam->id;
						$result->losing_team_id = $awayTeam->id;
					} else {
						$result->losing_team_id = $homeTeam->id;
						$result->winning_team_id = $awayTeam->id;
					}
				} else {
					if($result->home_team_score > 0 || $result->away_team_score > 0) {
						if($result->home_team_score > $result->away_team_score) {
							$result->winning_team_id = $homeTeam->id;
							$result->losing_team_id = $awayTeam->id;
						} else {
							$result->losing_team_id = $homeTeam->id;
							$result->winning_team_id = $awayTeam->id;
						}
						
						$result->game_complete = 'Y';
					}
				}
						
				if($result->save()) {}
				
			} else {}
		}

		// Update the standings after updating all the games
		$showSeason->standings()->standingUpdate();

		return redirect()->back()->with('status', 'Week ' . $week . ' updated successfully');
	}
	
	/**
	 * Delete week
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete_week($week)
	{
		// Get the season to show
		$showSeason = $this->find_season(request());
		$weekGames = LeagueSchedule::getWeekGames($week)->get();

		foreach($weekGames as $weekGame) {
			if($weekGame->delete()) {
				if($weekGame->result) {
					if($weekGame->result->delete()) {}
				}
				
				if($weekGame->stats) {
					foreach($weekGame->player_stats as $stats) {
						$stats->delete();
					}
				}
			}
		}
		
		// Update the standings after updating all the games
		$showSeason->standings()->standingUpdate();
		
		return redirect()->action('LeagueScheduleController@index', ['season' => $showSeason->id, 'year' => $showSeason->year])->with('status', 'Week ' . $week . ' Deleted Successfully');
	}
	
	/**
	 * Update a game on the schedule.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update_game(Request $request)
	{
		// Get the season to show
		$showSeason = $this->find_season(request());

		$game		= LeagueSchedule::find($request->edit_game_id);
		$awayTeam	= LeagueTeam::find($request->edit_away_team);
		$homeTeam 	= LeagueTeam::find($request->edit_home_team);
		$time 		= new Carbon($request->edit_game_time);
		$date 		= '';
		
		if($request->edit_date_picker_submit != null) {
			$date = new Carbon($request->edit_date_picker_submit);
		} else {
			$date = explode('-', $request->edit_date_picker);
			$date = Carbon::create($date['2'], $date[0], $date[1]);
		}

		// Check if any games are set to forfeit
		// If there are check and see if this game id is
		// in either the home or away array
		$awayForfeit = isset($request->away_forfeit) ? $request->away_forfeit : null;
		$homeForfeit = isset($request->home_forfeit) ? $request->home_forfeit : null;
		
		$game->league_season_id	= $showSeason->id;
		$game->away_team_id 	= $awayTeam->id;
		$game->away_team 		= $awayTeam->team_name;
		$game->home_team_id 	= $homeTeam->id;
		$game->home_team 		= $homeTeam->team_name;
		$game->game_time 		= $time->toTimeString();
		$game->game_date 		= $date->toDateString();
		
		if($game->save()) {
			$result = '';

			// If stats exist then check if teams were changed
			// If teams were changed then remove team that was changed and 
			// add new players
			if($game->player_stats->isNotEmpty()) {
				$currentTeamID1 = $game->player_stats()->teams()[0]->league_teams_id;
				$currentTeamID2 = $game->player_stats()->teams()[1]->league_teams_id;
				// Remove team players if they do not match either team that was saved
				// for this game
				if($currentTeamID1 != $awayTeam->id && $currentTeamID1 != $homeTeam->id) {
					$removeTeam = LeagueTeam::find($currentTeamID1);
					$removeStats = $game->player_stats()->where([
						['league_teams_id', $currentTeamID1],
						['deleted_at', null],
					])->get();
					
					foreach($removeStats as $removeTeamPlayerStat) {
						if($removeTeamPlayerStat->delete()) {}
					}
				}
				
				// Remove team players if they do not match either team that was saved
				// for this game
				if($currentTeamID2 != $awayTeam->id && $currentTeamID2 != $homeTeam->id) {
					$removeTeam = LeagueTeam::find($currentTeamID2);
					$removeStats = $game->player_stats()->where([
						['league_teams_id', $currentTeamID2],
						['deleted_at', null],
					])->get();
					
					foreach($removeStats as $removeTeamPlayerStat) {
						if($removeTeamPlayerStat->delete()) {}
					}
				}
				
				// Add away team players if they do not already have stats 
				// added for this week
				if($currentTeamID1 != $awayTeam->id && $currentTeamID2 != $awayTeam->id) {
					foreach($awayTeam->players as $awayPlayer) {
						$newPlayerStat = new LeagueStat();
						$newPlayerStat->league_teams_id = $awayTeam->id;
						$newPlayerStat->league_season_id = $showSeason->id;
						$newPlayerStat->league_schedule_id = $game->id;
						$newPlayerStat->league_player_id = $awayPlayer->id;
						$newPlayerStat->game_played = 0;
						
						if($newPlayerStat->save()) {}
					}
				}
				
				// Add home team players if they do not already have stats 
				// added for this week
				if($currentTeamID1 != $homeTeam->id && $currentTeamID2 != $homeTeam->id) {
					foreach($homeTeam->players as $homePlayer) {
						$newPlayerStat = new LeagueStat();
						$newPlayerStat->league_teams_id = $homeTeam->id;
						$newPlayerStat->league_season_id = $showSeason->id;
						$newPlayerStat->league_schedule_id = $game->id;
						$newPlayerStat->league_player_id = $homePlayer->id;
						$newPlayerStat->game_played = 0;
						
						if($newPlayerStat->save()) {}
					}
				}
				
			} else {
				foreach($awayTeam->players as $awayPlayer) {
					$newPlayerStat = new LeagueStat();
					$newPlayerStat->league_teams_id = $awayTeam->id;
					$newPlayerStat->league_season_id = $showSeason->id;
					$newPlayerStat->league_schedule_id = $game->id;
					$newPlayerStat->league_player_id = $awayPlayer->id;
					$newPlayerStat->game_played = 0;
					
					if($newPlayerStat->save()) {}
				}
				
				foreach($homeTeam->players as $homePlayer) {
					$newPlayerStat = new LeagueStat();
					$newPlayerStat->league_teams_id = $homeTeam->id;
					$newPlayerStat->league_season_id = $showSeason->id;
					$newPlayerStat->league_schedule_id = $game->id;
					$newPlayerStat->league_player_id = $homePlayer->id;
					$newPlayerStat->game_played = 0;
					
					if($newPlayerStat->save()) {}
				}
			}
			
			// Update game result row if it exist
			if(LeagueScheduleResult::where('league_schedule_id', $game->id)->first()) {
				$result = LeagueScheduleResult::where('league_schedule_id', $game->id)->first();
			} else {
				$result = new LeagueScheduleResult();
			}
			
			$result->league_schedule_id = $game->id;
			$result->league_season_id = $showSeason->id;
			$result->home_team_score = $request->edit_home_score;
			$result->away_team_score = $request->edit_away_score;
			$result->forfeit = 'N';
			$result->game_complete = 'N';
				
			// If forfeit
			if($homeForfeit != null || $awayForfeit != null) {
				$result->forfeit = 'Y';
				$result->game_complete = 'Y';
				$result->home_team_score = null;
				$result->away_team_score = null;
				
				if($awayForfeit != null) {
					$result->winning_team_id = $homeTeam->id;
					$result->losing_team_id = $awayTeam->id;
				} else {
					$result->losing_team_id = $homeTeam->id;
					$result->winning_team_id = $awayTeam->id;
				}
			} else {
				if($result->home_team_score > 0 || $result->away_team_score > 0) {
					if($result->home_team_score > $result->away_team_score) {
						$result->winning_team_id = $homeTeam->id;
						$result->losing_team_id = $awayTeam->id;
					} else {
						$result->losing_team_id = $homeTeam->id;
						$result->winning_team_id = $awayTeam->id;
					}
					
					$result->game_complete = 'Y';
				}
			}
					
			if($result->save()) {}
			
		} else {}

		// Update the standings after updating all the games
		$showSeason->standings()->standingUpdate();

		return redirect()->back()->with('status', 'Game updated successfully');
	}

	/**
	 * Delete game
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete_game(LeagueSchedule $league_schedule)
	{
		// dd($league_schedule);
		// Get the season to show
		$showSeason = $this->find_season(request());

		if($league_schedule->delete()) {
			if($league_schedule->result) {
				if($league_schedule->result->delete()) {}
			}
			
			if($league_schedule->stats) {
				foreach($league_schedule->player_stats as $stats) {
					$stats->delete();
				}
			}
		}
		
		// Update the standings after updating all the games
		$showSeason->standings()->standingUpdate();
		
		return redirect()->action('LeagueScheduleController@edit', ['week' => $league_schedule->season_week, 'season' => $showSeason->id, 'year' => $showSeason->year])->with('status', 'Game Deleted Successfully');
	}
	
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update_playoff_week(Request $request)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$playoffRound = isset($request->round_id) ? $request->round_id : null;

		// Update all the games which are previously scheduled
		foreach($request->game_id as $key => $game_id) {
			$game		= LeagueSchedule::find($game_id);
			$awayTeam	= LeagueTeam::find($request->away_team[$key]);
			$homeTeam 	= LeagueTeam::find($request->home_team[$key]);
			$time 		= new Carbon($request->game_time[$key]);
			$date 		= $request->date_picker[($key*2)+1];

			// Check if any games are set to forfeit
			// If there are check and see if this game id is
			// in either the home or away array
			$awayForfeit = isset($request->away_forfeit) ? in_array($game->id, $request->away_forfeit) ? : null : null;
			$homeForfeit = isset($request->home_forfeit) ? in_array($game->id, $request->home_forfeit) ? : null : null;
			
			$game->league_season_id = $showSeason->id;
			$game->away_team_id = $awayTeam->id;
			$game->away_team = $awayTeam->team_name;
			$game->home_team_id = $homeTeam->id;
			$game->home_team = $homeTeam->team_name;
			$game->game_time = $time->toTimeString();
			$game->game_date = $date;

			if($game->save()) {
				$result = '';
				
				// Update game result row if it exist
				if(LeagueScheduleResult::where('league_schedule_id', $game_id)->first()) {
					$result = LeagueScheduleResult::where('league_schedule_id', $game_id)->first();
				} else {
					$result = new LeagueScheduleResult();
				}
				
				$result->league_schedule_id = $game_id;
				$result->league_season_id = $showSeason->id;
				$result->home_team_score = $request->home_score[$key];
				$result->away_team_score = $request->away_score[$key];
				$result->forfeit = 'N';
				$result->game_complete = 'N';
					
				// If forfeit
				if($homeForfeit != null || $awayForfeit != null) {
					$result->forfeit = 'Y';
					$result->game_complete = 'Y';
					$result->home_team_score = null;
					$result->away_team_score = null;
					
					if($awayForfeit != null) {
						$result->winning_team_id = $homeTeam->id;
						$result->losing_team_id = $awayTeam->id;
					} else {
						$result->losing_team_id = $homeTeam->id;
						$result->winning_team_id = $awayTeam->id;
					}
				} else {
					if($result->home_team_score > 0 || $result->away_team_score > 0) {
						if($result->home_team_score > $result->away_team_score) {
							$result->winning_team_id = $homeTeam->id;
							$result->losing_team_id = $awayTeam->id;
						} else {
							$result->losing_team_id = $homeTeam->id;
							$result->winning_team_id = $awayTeam->id;
						}
						
						$result->game_complete = 'Y';
					}
				}
						
				if($result->save()) {}
				
			} else {}
		}
		
		if(isset($request->round_id)) {
			$showSeason->complete_round($playoffRound);
		} else {
			$showSeason->complete_playins();
		}
		
		return redirect()->action('LeagueScheduleController@index');
    }
	
	/**
	 * Show individual game for deletion
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(LeagueSchedule $league_schedule)
	{
		// Get the season to show
		$showSeason = $this->find_season(request());
		$allStats = $league_schedule->player_stats()->get();
		$result = $league_schedule->result ? $league_schedule->result : null;
		$homeTeam = $league_schedule->home_team_obj;
		$awayTeam = $league_schedule->away_team_obj;

		return view('schedule.show', compact('league_schedule', 'allStats', 'showSeason', 'result', 'homeTeam', 'awayTeam'));
	}

	/**
     * Check for a query string and get the current season.
     *
     * @return seaon
    */
	public function find_season(Request $request) {
		$league = Auth::user()->leagues_profiles->first();
		
		$showSeason = '';
		
		if($request->query('season') != null && $request->query('year') != null) {
			$showSeason = $league->seasons()->active()->find($request->query('season'));
		} else {
			if($league->seasons()->get()->count() == 1) {
				if($league->seasons()->active()->first()) {
					$showSeason = $league->seasons()->active()->first();
				} else {
					$showSeason = $league->seasons()->first();
				}
			} else {
				$showSeason = $league->seasons()->active()->first();
			}
		}
		
		return $showSeason;
	}
}
