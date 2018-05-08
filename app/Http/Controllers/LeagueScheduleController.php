<?php

namespace App\Http\Controllers;

use App\PlayerProfile;
use App\LeagueProfile;
use App\LeagueSchedule;
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
     * Show the application welcome page for public.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_game(Request $request)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$time = new Carbon($request->game_time);
		
		$newGame = new LeagueSchedule();
		$newGame->league_season_id = $showSeason->id;
		$newGame->season_week = $request->season_week;
		$newGame->away_team_id = $request->away_team;
		$newGame->home_team_id = $request->home_team;
		$newGame->game_time = $time->toTimeString();
		$newGame->game_date = $request->date_picker_submit;
		
		if($newGame->save()) {
			return redirect()->back()->with('status', 'Game Added Successfully');
		} else {}
    }
	
	/**
     * Show the application about us page for public.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        return view('about', compact(''));
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
