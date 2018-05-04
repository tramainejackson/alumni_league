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
    public function index(Request $request)
    {
		$league = Auth::user()->leagues_profiles->first();
		$activeSeasons = $league->seasons()->active()->get();

		// Get the season to show
		$showSeason = '';

		if($request->query('season') != null && $request->query('year') != null) {
			$showSeason = $league->seasons()->active()->find($request->query('season'));
		} else {
			$showSeason = $league->seasons()->active()->first();
		}
		
		$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks();
		$seasonWeekGames= $showSeason->games();

		return view('schedule.index', compact('showSeason', 'activeSeasons', 'seasonScheduleWeeks', 'seasonWeekGames'));
    }
	
	/**
     * Show the application welcome page for public.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
		$getRecs = RecCenter::all();
		$getLeagues = LeagueProfile::all();
		$fireRecs = PlayerProfile::get_fire_recs();
		
        return view('welcome', compact('getRecs', 'getLeagues', 'fireRecs'));
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
}
