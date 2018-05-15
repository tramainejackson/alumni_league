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
    public function index(Request $request)
    {
		$league = Auth::user()->leagues_profiles->first();
		$completedSeasons = $league->seasons()->completed()->get();
		$activeSeasons = $league->seasons()->active()->get();
		$ageGroups = explode(' ', $league->age);
		$compGroups = explode(' ', $league->comp);
		
		// Get the season to show
		$showSeason = '';

		if($request->query('season') != null && $request->query('year') != null) {
			$showSeason = $league->seasons()->active()->find($request->query('season'));
		} else {
			$showSeason = $league->seasons()->active()->first();
		}

		$showSeasonSchedule = $showSeason->games()->upcomingGames()->get();
		$showSeasonStat = $showSeason->stats()->get();
		$showSeasonTeams = $showSeason->league_teams;
		$showSeasonUnpaidTeams = $showSeason->league_teams()->unpaid();
		$showSeasonPlayers = $showSeason->league_players;
		
		return view('index', compact('completedSeasons', 'activeSeasons', 'showSeason', 'showSeasonSchedule', 'showSeasonStat', 'showSeasonPlayers', 'showSeasonTeams', 'ageGroups', 'compGroups', 'showSeasonUnpaidTeams'));
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
    public function standings(Request $request)
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

		$standings = $showSeason != null ? $showSeason->standings()->seasonStandings()->get() : null;

        return view('standings', compact('activeSeasons', 'standings', 'league', 'showSeason'));
    }
	
	/**
     * Show the leagues info page.
     *
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
		$league = Auth::user()->leagues_profiles->first();
		$showSeason = $league->seasons()->active()->first();

        return view('info', compact('league', 'showSeason'));
    }
}
