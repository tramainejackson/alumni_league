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

	public $showSeason;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth')->only('index');

	    $this->showSeason = LeagueProfile::find(2)->seasons()->showSeason();
    }

	public function get_season() {
		return $this->showSeason;
	}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
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
    public function welcome() {
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
    public function destroy(Request $request, LeaguePlayer $league_player) {
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
}
