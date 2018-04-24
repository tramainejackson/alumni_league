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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$league = Auth::user()->leagues_profiles->first();
		$scoringLeaders = $league->get_scoring_leaders();
		$assistLeaders = $league->get_assist_leaders();
		$reboundsLeaders = $league->get_rebounds_leaders();
		$stealsLeaders = $league->get_steals_leaders();
		$blocksLeaders = $league->get_blocks_leaders();
		$allPlayers = $league->get_all_players_stats();
		$allTeams = $league->get_all_teams_stats();
		
		return view('stats.index', compact('league', 'scoringLeaders', 'assistLeaders', 'reboundsLeaders', 'stealsLeaders', 'blocksLeaders', 'allPlayers', 'allTeams'));
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
