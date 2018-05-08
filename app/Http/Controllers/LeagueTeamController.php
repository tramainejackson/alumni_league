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

class LeagueTeamController extends Controller
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
    public function index(Request $request)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$activeSeasons = $showSeason->league_profile->seasons()->active()->get();
		$seasonTeams = $showSeason->league_teams;

		return view('teams.index', compact('showSeason', 'activeSeasons', 'seasonTeams'));
    }
	
	/**
     * Show the application create team page.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$activeSeasons = $showSeason->league_profile->seasons()->active()->get();

		return view('teams.create', compact('showSeason', 'activeSeasons'));
    }
	
	/**
     * Show the application create team page.
     *
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
		$this->validate($request, [
			'team_name' => 'required',
		]);
		
		// Get the season to show
		$showSeason = $this->find_season(request());
		$activeSeasons = $showSeason->league_profile->seasons()->active()->get();
		
		// Create a new team for the selected season
		$team = $showSeason->league_teams()->create([
			'team_name' => ucwords(strtolower($request->team_name)),
			'fee_paid' => $request->fee_paid,
			'leagues_profile_id' => $showSeason->league_profile->id,
		]);

		if($team) {
			return redirect()->action('LeagueTeamController@edit', ['team' => $team->id])->with('status', 'New Team Added Successfully');
		} else {}
    }
	
	/**
     * Show the application create team page.
     *
     * @return \Illuminate\Http\Response
    */
    public function edit(LeagueTeam $league_team)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());

		return view('teams.edit', compact('league_team', 'showSeason'));
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
			$showSeason = $league->seasons()->active()->first();
		}
		
		return $showSeason;
	}
}
