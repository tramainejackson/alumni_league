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
		// Get the season to show
		$showSeason = $this->find_season(request());

		if($showSeason instanceof \App\LeagueProfile) {

			$completedSeasons = $showSeason->seasons()->completed()->get();
			$activeSeasons = $showSeason->seasons()->active()->get();
			$ageGroups = explode(' ', $showSeason->age);
			$compGroups = explode(' ', $showSeason->comp);
			$showSeasonUnpaidTeams = $showSeasonTeams = $showSeasonStat = $showSeasonPlayers = $showSeasonSchedule = collect();

			if($showSeason->is_playoffs == 'Y') {
				
				$allGames = $showSeason->games;
				$allTeams = $showSeason->league_teams;
				$playoffSettings = $showSeason->playoffs;
				$nonPlayInGames = $showSeason->games()->playoffNonPlayinGames()->get();
				$playInGames = $showSeason->games()->playoffPlayinGames()->get();

				return view('playoffs.index', compact('ageGroups', 'compGroups', 'completedSeasons', 'activeSeasons', 'showSeason', 'nonPlayInGames', 'playInGames', 'playoffSettings', 'allGames', 'allTeams'));
			
			} else {

					return view('index', compact('completedSeasons', 'activeSeasons', 'showSeason', 'showSeasonSchedule', 'showSeasonStat', 'showSeasonPlayers', 'showSeasonTeams', 'ageGroups', 'compGroups', 'showSeasonUnpaidTeams'));			

			}
			
		} else {

			$completedSeasons = $showSeason->league_profile->seasons()->completed()->get();
			$activeSeasons = $showSeason->league_profile->seasons()->active()->get();
			$ageGroups = explode(' ', $showSeason->league_profile->age);
			$compGroups = explode(' ', $showSeason->league_profile->comp);
			$showSeasonSchedule = $showSeason->games()->upcomingGames()->get();
			$showSeasonStat = $showSeason->stats()->get();
			$showSeasonTeams = $showSeason->league_teams;
			$showSeasonUnpaidTeams = $showSeason->league_teams()->unpaid();
			$showSeasonPlayers = $showSeason->league_players;

			if($showSeason->is_playoffs == 'Y') {
				
				$allGames = $showSeason->games;
				$allTeams = $showSeason->league_teams;
				$playoffSettings = $showSeason->playoffs;
				$nonPlayInGames = $showSeason->games()->playoffNonPlayinGames()->get();
				$playInGames = $showSeason->games()->playoffPlayinGames()->get();

				return view('playoffs.index', compact('ageGroups', 'compGroups', 'completedSeasons', 'activeSeasons', 'showSeason', 'nonPlayInGames', 'playInGames', 'playoffSettings', 'allGames', 'allTeams'));
			
			} else {

					return view('index', compact('completedSeasons', 'activeSeasons', 'showSeason', 'showSeasonSchedule', 'showSeasonStat', 'showSeasonPlayers', 'showSeasonTeams', 'ageGroups', 'compGroups', 'showSeasonUnpaidTeams'));			

			}
			
		}
    }
	
	/**
     * Show the application about us page for public.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
		// Get the season to show
		$showSeason = $this->find_season(request());

		if($showSeason->seasons->isNotEmpty()) {
			
			return view('about', compact('showSeason', 'activeSeasons'));

		} else {

			return view('no_season', compact('showSeason'));

		}
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
		
		if($showSeason instanceof \App\LeagueProfile) {
			
			if($showSeason->seasons->isNotEmpty()) {
			
				$activeSeasons = $showSeason->seasons()->active()->get();
				$standings = null;

				return view('standings', compact('activeSeasons', 'standings', 'league', 'showSeason'));
				
			} else {

				return view('no_season', compact('showSeason'));

			}
		
		} else {
			
			$activeSeasons = $showSeason->league_profile->seasons()->active()->get();
			$standings = $showSeason->standings()->seasonStandings()->get();

			return view('standings', compact('activeSeasons', 'standings', 'league', 'showSeason'));
			
		}
    }
	
	/**
     * Show the leagues info page.
     *
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$league = null;
		$activeSeasons = $showSeason instanceof \App\LeagueProfile ? $showSeason->seasons()->active()->get() : $showSeason->league_profile->seasons()->active()->get();
		
		if($showSeason instanceof \App\LeagueProfile) {
			$league = $showSeason;
			$allComplete = 'Y';

			return view('info', compact('league', 'showSeason', 'allComplete', 'activeSeasons'));			
		} else {
			$league = $showSeason->league_profile;

			return view('info', compact('league', 'showSeason', 'activeSeasons'));			
		}
    }
	
	/**
     * Show the leagues archived season.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive(LeagueSeason $season)
    {
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
    public function test_drive(Request $request)
    {
		Auth::loginUsingId(6);
        
		return redirect()->action('HomeController@index');
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
				
				if($league) {
					
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
					
				} else {
					
					
					
				}
				
			}
			
			return $showSeason;
		} else {
			if(session()->has('commish')) {
				Auth::loginUsingId(session()->get('commish'));
			}
		}
	}
}
