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

class LeagueStatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the stats index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$activeSeasons = $showSeason->league_profile->seasons()->active()->get();
		$seasonTeams = $showSeason->league_teams;
		
		$seasonStats = $showSeason->stats();		
		$allPlayers = $seasonStats->allFormattedStats();
		$allTeams = $seasonStats->allTeamStats();
		$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks()->get();

		return view('stats.index', compact('activeSeasons', 'showSeason', 'allPlayers', 'allTeams', 'seasonScheduleWeeks'));
    }
	
	/**
     * Show the stats to be edited for selected week.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_week(Request $request, $week)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks()->get();
		$weekGames 	= $showSeason->games()->getWeekGames($week)->orderBy('game_date')->orderBy('game_time')->get();

		return view('stats.edit', compact('seasonScheduleWeeks', 'showSeason', 'week', 'weekGames'));
    }
	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $week)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		
		$seasonStats = $showSeason->stats();

		return view('stats.edit', compact('activeSeasons', 'showSeason', 'week'));
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
