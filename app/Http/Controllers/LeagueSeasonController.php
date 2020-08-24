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

class LeagueSeasonController extends Controller
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
		$this->middleware('auth')->except('index');

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
//    	dd($this->showSeason);
    	$showSeason = $this->showSeason;
	    $activeSeasons = $this->league->seasons()->active();
    	$completedSeasons = $this->league->seasons()->completed()->get();
	    $ageGroups = explode(' ', $this->league->age);
	    $compGroups = explode(' ', $this->league->comp);
	    $showSeasonSchedule = $this->showSeason->games()->upcomingGames()->get();
	    $showSeasonStat = $this->showSeason->stats()->get();
	    $showSeasonTeams = $this->showSeason->league_teams;
	    $showSeasonUnpaidTeams = $this->showSeason->league_teams()->unpaid();
	    $showSeasonPlayers = $this->showSeason->league_players;

    	if($showSeason !== null || $completedSeasons !== null) {

		    if($this->showSeason->is_playoffs == 'Y') {

			    $allGames = $this->showSeason->games;
			    $allTeams = $this->showSeason->league_teams;
			    $playoffSettings = $this->showSeason->playoffs;
			    $nonPlayInGames = $this->showSeason->games()->playoffNonPlayinGames()->get();
			    $playInGames = $this->showSeason->games()->playoffPlayinGames()->get();

			    return view('playoffs.index', compact('ageGroups', 'compGroups', 'completedSeasons', 'activeSeasons', 'showSeason', 'nonPlayInGames', 'playInGames', 'playoffSettings', 'allGames', 'allTeams'));
		    } else {
			    return view('seasons.index', compact('showSeason', 'completedSeasons', 'ageGroups', 'compGroups', 'showSeasonSchedule', 'showSeasonStat', 'showSeasonTeams', 'showSeasonPlayers', 'activeSeasons', 'showSeasonUnpaidTeams'));
		    }
	    } else {
		    return view('seasons.no_season');
	    }
    }
	
	/**
     * Store a new season for the logged in league.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
    	$season = new LeagueSeason();
		$season->league_profile_id = $request->league_id;
		$season->season = $request->season;
		$season->name = $request->name;
		$season->year = $request->year;
		$season->age_group = $request->age_group;
		$season->comp_group = $request->comp_group;
		$season->league_fee = $request->league_fee;
		$season->ref_fee = $request->ref_fee;
		$season->location = $request->location;
		$season->active = 'Y';
		$season->paid = 'Y';
		
		if($season->save()) {
			if($season->playoffs()->create([])) {
				$newSeason = $season->id;

				return [$newSeason, "New Season Added Successfully"];
			}
		}
    }
	
	/**
     * Store a new season for the logged in league.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_playoffs(Request $request, LeagueSeason $league_season) {
		// Get the season to show
		$showSeason = $this->find_season(request());
		
		$createPlayoffs = $showSeason->create_playoff_settings();
		
		return redirect()->back()->with(['status' => $createPlayoffs]);
    }
	
	/**
     * Store a new season for the logged in league.
     *
     * @return \Illuminate\Http\Response
     */
    public function complete_season(LeagueSeason $league_season) {
		// Get the season to show
		$showSeason = $this->find_season(request());
		
		$showSeason->completed = 'Y';
		$showSeason->active = 'N';
		
		if($showSeason->save()) {
			return redirect()->action('HomeController@index')->with(['status' => 'Season Completed']);
		}
    }
	
	/**
     * Store a new season for the logged in league.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
		// Get the season to show
		$showSeason = $this->find_season(request());

		$showSeason->name = $request->name;
		$showSeason->comp_group = $request->comp_group;
		$showSeason->age_group = $request->age_group;
		$showSeason->league_fee = $request->leagues_fee;
		$showSeason->ref_fee = $request->ref_fee;
		$showSeason->location = $request->leagues_address;
		
		if($showSeason->save()) {
			return redirect()->back()->with(['status' => 'Season Updated Successfully']);
		}
    }
	
	/**
     * Show the application about us page for public.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        
    }

	/**
     * Show the application about us page for public.
     *
     * @return \Illuminate\Http\Response
     */
    public function show() {

    }
}
