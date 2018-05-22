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
		// Get the season to show
		$showSeason = $this->find_season(request());
		
		$completedSeasons = $showSeason->league_profile->seasons()->completed()->get();
		$activeSeasons = $showSeason->league_profile->seasons()->active()->get();
		$ageGroups = explode(' ', $showSeason->league_profile->age);
		$compGroups = explode(' ', $showSeason->league_profile->comp);

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
		if(Auth::check()) {
			// Get the season to show
			$showSeason = $this->find_season(request());
		}
		
        return view('about', compact('showSeason'));
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
		// Get the season to show
		$showSeason = $this->find_season(request());
		$activeSeasons = $showSeason->league_profile->seasons()->active()->get();

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

		// Get the season to show
		$showSeason = $this->find_season(request());

        return view('info', compact('league', 'showSeason'));
    }
	
	/**
     * Check for a query string and get the current season.
     *
     * @return seaon
    */
	public function find_season(Request $request) {
		if(Auth::check()) {
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
}
