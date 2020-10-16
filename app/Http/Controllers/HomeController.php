<?php

namespace App\Http\Controllers;

use App\PlayerProfile;
use App\LeagueProfile;
use App\LeagueSchedule;
use App\LeagueStanding;
use App\LeaguePlayer;
use App\LeagueTeam;
use App\LeagueStat;
use App\LeagueSeason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class HomeController extends Controller
{

	public $showSeason;
	public $activeSeasons;
	public $league;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth')->only('index');

	    $this->league = LeagueProfile::find(2);
	    $this->showSeason = LeagueProfile::find(2)->seasons()->showSeason();
	    $this->activeSeasons = LeagueProfile::find(2)->seasons()->active();
    }

	public function get_season() {
		return $this->showSeason;
	}

	public function get_league() {
		return $this->league;
	}

	public function get_active_seasons() {
		return $this->activeSeasons;
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
	    $activeSeasons = $this::get_active_seasons();

		if(Auth::check()) {

			if($showSeason !== null) {

				return view('about2', compact('showSeason', 'activeSeasons'));

			} else {

				return view('seasons.no_season', compact('activeSeasons', 'showSeason'));

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
	    // Get the season to show
	    $showSeason = $this->showSeason;

	    if($this->showSeason !== null) {

			$activeSeason = $this->showSeason;
		    $standings = $activeSeason->standings()->seasonStandings()->get();

			return view('standings', compact('activeSeason', 'standings', 'league', 'showSeason'));

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
	    $activeSeasons = $this::get_active_seasons();

	    if($this->league->seasons->isNotEmpty()) {

		    $standings = $showSeason->standings()->seasonStandings()->get();

			return view('standings', compact('activeSeasons', 'standings', 'league', 'showSeason'));

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
	    $activeSeasons = $this::get_active_seasons();

	    if($activeSeasons->count() < 1 && $this->league->seasons()->completed()->count() > 0) {
		    $showSeason = $this->league;
	    } else {
	    }

	    return view('info', compact('league', 'showSeason', 'activeSeasons'));
    }
	
	/**
     * Show the leagues archived season.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive(LeagueSeason $season) {
		// Get the season to show
		$showSeason = $season;
		$league = $showSeason->league_profile;
		$activeSeasons = $league->seasons()->active()->get();
		$completedSeasons = $league->seasons()->completed()->get();
		$standings = $showSeason->standings()->seasonStandings()->get();
		$playersStats = $showSeason instanceof \App\LeagueProfile ? collect() : $showSeason->stats()->allFormattedStats();
		
		// Resize the default image
		Image::make(public_path('images/commissioner.jpg'))->resize(800, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');
		
		return view('archives.index', compact('league', 'showSeason', 'activeSeasons', 'completedSeasons', 'standings', 'playersStats', 'defaultImg'));			
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
	
	/**
     * Check for a query string and get the current season.
     *
     * @return seaon
    */
//	public static function find_season(Request $request) {
//
//		if(Auth::check()) {
//
//			$league = Auth::user()->leagues_profiles->first();
//			$showSeason = '';
//
//			if($request->query('season') != null && $request->query('year') != null) {
//
//				$showSeason = $league->seasons()->active()->find($request->query('season'));
//
//			} else {
//
//				if($league) {
//
//					if($league->seasons()->active()->count() < 1 && $league->seasons()->completed()->count() > 0) {
//
//						$showSeason = $league;
//
//					} else {
//
//						if($league->seasons()->active()->first()) {
//
//							$showSeason = $league->seasons()->active()->first();
//
//						} else {
//
//							if($league->seasons()->first()) {
//
//								$showSeason = $league->seasons()->first();
//
//							} else {
//
//								$showSeason = $league;
//
//							}
//
//						}
//
//					}
//
//				} else {
//
//
//
//				}
//
//			}
//
//		} else {
//			if(session()->has('commish')) {
//				Auth::loginUsingId(session()->get('commish'));
//			} else {
//				$league = $showSeason = LeagueProfile::find(2);
//				$activeSeason = $league->seasons()->active()->get()->last();
//			}
//		}
//
//		return $showSeason;
//	}
}
