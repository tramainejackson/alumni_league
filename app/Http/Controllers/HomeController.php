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

class HomeController extends Controller
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
		$league = Auth::user()->leagues_profiles->first();
		$completedSeasons = $league->seasons()->completed()->get();
		$activeSeasons = $league->seasons()->active()->get();
		$ageGroups = explode(' ', $league->age);
		$compGroups = explode(' ', $league->comp);
		
		// Get the season to show
		$showSeason = $league->seasons()->active()->first();

		if($showSeason != null) {
			$showSeasonSchedule = $showSeason->games()->upcomingGames()->get();
			$showSeasonStat = $showSeason->stats;
			dd($showSeasonStat);
		}
		
		return view('index', compact('league', 'completedSeasons', 'activeSeasons', 'showSeason', 'showSeasonSchedule', 'showSeasonStat', 'ageGroups', 'compGroups'));
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
	
	/**
     * Show the application about us page for public.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return view('about', compact(''));
    }
	
	/**
     * Show the leagues standings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function standings()
    {
		$league = Auth::user()->leagues_profiles->first();
		$standings = $league->get_league_standings();

        return view('standings', compact('standings', 'league'));
    }
	
	/**
     * Show the leagues info page.
     *
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
		$league = Auth::user()->leagues_profiles->first();

        return view('info', compact('league'));
    }
}
