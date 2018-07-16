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
		
    }
	
	/**
     * Store a new season for the logged in league.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
    public function create_playoffs(Request $request, LeagueSeason $league_season)
    {
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
    public function complete_season(LeagueSeason $league_season)
    {
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
    public function update(Request $request)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());

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
    public function edit()
    {
        
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
				if($league->seasons()->active()->count() < 1 && $league->seasons()->completed()->count() > 0) {
					$showSeason = $league;
				} else {
					if($league->seasons()->active()->first()) {
						$showSeason = $league->seasons()->active()->first();
					} else {
						if($league->seasons()->first()) {
							$showSeason = $league->seasons()->first();
						} else {
							$showSeason = $league;
						}
					}
				}
			}
			
			return $showSeason;
		}
	}
}
