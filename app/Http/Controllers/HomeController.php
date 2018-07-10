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

		$completedSeasons = $showSeason instanceof \App\LeagueProfile ? $showSeason->seasons()->completed()->get() : $showSeason->league_profile->seasons()->completed()->get();
		$activeSeasons = $showSeason instanceof \App\LeagueProfile ? $showSeason->seasons()->active()->get() : $showSeason->league_profile->seasons()->active()->get();
		$ageGroups = $showSeason instanceof \App\LeagueProfile ? explode(' ', $showSeason->age) : explode(' ', $showSeason->league_profile->age);
		$compGroups = $showSeason instanceof \App\LeagueProfile ? explode(' ', $showSeason->comp) : explode(' ', $showSeason->league_profile->comp);
		$showSeasonSchedule = $showSeason instanceof \App\LeagueProfile ? collect() : $showSeason->games()->upcomingGames()->get();
		$showSeasonStat = $showSeason instanceof \App\LeagueProfile ? collect() : $showSeason->stats()->get();
		$showSeasonTeams = $showSeason instanceof \App\LeagueProfile ? collect() : $showSeason->league_teams;
		$showSeasonUnpaidTeams = $showSeason instanceof \App\LeagueProfile ? collect() : $showSeason->league_teams()->unpaid();
		$showSeasonPlayers = $showSeason instanceof \App\LeagueProfile ? collect() : $showSeason->league_players;
		$allComplete = 'Y';
		
		if($showSeason->is_playoffs == 'Y') {
			$allGames = $showSeason->games;
			$allTeams = $showSeason->league_teams;
			$playoffSettings = $showSeason->playoffs;
			$nonPlayInGames = $showSeason->games()->playoffNonPlayinGames()->get();
			$playInGames = $showSeason->games()->playoffPlayinGames()->get();

			return view('playoffs.index', compact('ageGroups', 'compGroups', 'completedSeasons', 'activeSeasons', 'showSeason', 'nonPlayInGames', 'playInGames', 'playoffSettings', 'allGames', 'allTeams'));
		} else {
			if($showSeason instanceof \App\LeagueProfile) {
				return view('index', compact('completedSeasons', 'activeSeasons', 'showSeason', 'showSeasonSchedule', 'showSeasonStat', 'showSeasonPlayers', 'showSeasonTeams', 'ageGroups', 'compGroups', 'showSeasonUnpaidTeams', 'allComplete'));			
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
		$allComplete = 'Y';

		if($showSeason instanceof \App\LeagueProfile) {
			return view('about', compact('showSeason', 'allComplete'));
		} else {
			return view('about', compact('showSeason', 'activeSeasons'));
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
		$activeSeasons = $showSeason instanceof \App\LeagueProfile ? $showSeason->seasons()->active()->get() : $showSeason->league_profile->seasons()->active()->get();
		$allComplete = 'Y';
		
		$standings = $showSeason instanceof \App\LeagueProfile ? null : $showSeason->standings()->seasonStandings()->get();

		if($showSeason instanceof \App\LeagueProfile) {
			return view('standings', compact('activeSeasons', 'standings', 'league', 'showSeason', 'allComplete'));
		} else {
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
		} else {
			if(session()->has('commish')) {
				Auth::loginUsingId(session()->get('commish'));
			}
		}
	}
}
