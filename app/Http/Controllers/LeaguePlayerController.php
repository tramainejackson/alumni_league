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

class LeaguePlayerController extends Controller
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
		$league = Auth::user()->leagues_profiles->where('user_id', Auth::id())->first();
		$showcaseGame = LeagueSchedule::get_random_game();
		
		if($showcaseGame != null) {
			$awayTeamLeader = LeagueStat::get_scoring_leader($showcaseGame->get_away_team_id());
			$homeTeamLeader = LeagueStat::get_scoring_leader($showcaseGame->get_home_team_id());
		}
		
		return view('index', compact('league', 'showcaseGame'));
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
     * Remove a individual player from the team.
     *
     * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request, LeaguePlayer $league_player)
    {
		// Delete Player
		if($league_player->delete()) {
			if($league_player->stats) {
				foreach($league_player->stats as $playerStat) {
					$playerStat->delete();
				}
				
				return redirect()->back()->with('status', 'Player Deleted Successfully');
			}
		}
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
