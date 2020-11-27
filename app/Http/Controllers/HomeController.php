<?php

namespace App\Http\Controllers;

use App\PlayerProfile;
use App\LeagueProfile;
use App\LeagueRule;
use App\LeagueSchedule;
use App\LeagueStanding;
use App\LeaguePlayer;
use App\LeagueTeam;
use App\LeagueStat;
use App\LeagueSeason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
//		$showSeason = $this->showSeason;
//    	$completedSeasons = $this->league->seasons()->completed()->get();
//		$activeSeasons = $this->league->seasons()->active()->get();
//		$ageGroups = explode(' ', $this->league->age);
//		$compGroups = explode(' ', $this->league->comp);
//		$showSeasonSchedule = $this->showSeason->games()->upcomingGames()->get();
//		$showSeasonStat = $this->showSeason->stats()->get();
//		$showSeasonTeams = $this->showSeason->league_teams;
//		$showSeasonUnpaidTeams = $this->showSeason->league_teams()->unpaid();
//		$showSeasonPlayers = $this->showSeason->league_players;
//
//		if($this->showSeason->is_playoffs == 'Y') {
//
//			$allGames = $this->showSeason->games;
//			$allTeams = $this->showSeason->league_teams;
//			$playoffSettings = $this->showSeason->playoffs;
//			$nonPlayInGames = $this->showSeason->games()->playoffNonPlayinGames()->get();
//			$playInGames = $this->showSeason->games()->playoffPlayinGames()->get();
//
//			return view('playoffs.index', compact('ageGroups', 'compGroups', 'completedSeasons', 'activeSeasons', 'showSeason', 'nonPlayInGames', 'playInGames', 'playoffSettings', 'allGames', 'allTeams'));
//
//		} else {
//
//			return view('index', compact('completedSeasons', 'activeSeasons', 'showSeason', 'showSeasonSchedule', 'showSeasonStat', 'showSeasonPlayers', 'showSeasonTeams', 'ageGroups', 'compGroups', 'showSeasonUnpaidTeams'));
//
//		}
    }
	
	/**
     * Show the application about us page for public.
     *
     * @return \Illuminate\Http\Response
     */
    public function about() {
		// Get the season to show
		$showSeason = $this::get_season();

		if(Auth::check()) {

			if($showSeason !== null) {

				return view('about2', compact('showSeason'));

			} else {

				return view('seasons.no_season', compact('showSeason'));

			}
		} else {

			return view('about2', compact('showSeason'));
			
		}
    }
	
	/**
     * Show the leagues settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_setting() {

	    if($this->showSeason !== null) {

		    $standings = $this->showSeason->standings()->seasonStandings()->get();

			return view('standings', compact('standings', 'showSeason'));

		} else {

			return view('seasons.no_season', compact('showSeason'));

		}
    }

	/**
     * Show the leagues standings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function standings() {
	    // Get the season to show
	    $showSeason = $this::get_season();

	    if($showSeason) {
		    $standings = $showSeason->standings()->seasonStandings()->get();

			return view('standings', compact('standings', 'league', 'showSeason'));

		} else {
			return view('seasons.no_season', compact('showSeason'));
		}
    }
	
	/**
     * Show the leagues info page.
     *
     * @return \Illuminate\Http\Response
     */
    public function info() {
		// Get the season to show
	    $showSeason = $this::get_season();

	    return view('info', compact('showSeason'));
    }
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function test_drive(Request $request) {
//		Auth::loginUsingId(6);
//
//	    // Store a piece of data in the session...
//	    session(['testdrive' => 'true']);
//
//		return redirect()->action('HomeController@index');
//    }

	/**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function remove_test_drive(Request $request) {
//	    // Remove a piece of data in the session...
//	    session()->forget('testdrive');
//
//		return redirect()->action('HomeController@index');
//    }

}
