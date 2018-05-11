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
		
		$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks();

		return view('schedule.index', compact('showSeason', 'activeSeasons', 'seasonScheduleWeeks'));
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

		$weekCount = $showSeason->games->max('season_week');
		
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
		$showSeason = $this->find_season(request());

		$weekGames = $showSeason->games()->getWeekGames($week)->orderBy('game_date')->orderBy('game_time')->get();
		
		return view('schedule.edit', compact('showSeason', 'weekGames'));
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
			} else {}
		}

		return redirect()->action('LeagueScheduleController@index')->with('status', $newGameCount . 'Game(s) Added Successfully');
    }
	
	/**
     * Store a new week on the schedule.
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

		return redirect()->back()->with('status', 'Week ' . $week . ' updated successfully');
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
			$showSeason = $league->seasons()->active()->first();
		}
		
		return $showSeason;
	}
}
