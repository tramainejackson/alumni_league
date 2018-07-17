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
use Intervention\Image\ImageManagerStatic as Image;

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
     * Show the stats index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		
		if($showSeason instanceof \App\LeagueProfile) {
			
			if($showSeason->seasons->isNotEmpty()) {
		
				$activeSeasons = $showSeason->seasons()->active()->get();
				$checkStats = $seasonScheduleWeeks = $$seasonTeams = $allPlayers = $allTeams = collect();
				
				// Resize the default image
				Image::make(public_path('images/emptyface.jpg'))->resize(800, null, 	function ($constraint) {
						$constraint->aspectRatio();
					}
				)->save(storage_path('app/public/images/lg/default_img.jpg'));
				$defaultImg = asset('/storage/images/lg/default_img.jpg');
				
				if($showSeason->is_playoffs == 'Y') {
					$playoffRounds = $showSeason->games()->playoffRounds()->orderBy('round', 'desc')->get();
					$nonPlayInGames = $showSeason->games()->playoffNonPlayinGames();
					$playInGames = $showSeason->games()->playoffPlayinGames();
					$playoffSettings = $showSeason->playoffs;

					return view('stats.index', compact('activeSeasons', 'showSeason', 'allPlayers', 'allTeams', 'seasonScheduleWeeks', 'defaultImg', 'checkStats', 'playoffSettings', 'playoffRounds'));
					
				} else {

					return view('stats.index', compact('activeSeasons', 'showSeason', 'allPlayers', 'allTeams', 'seasonScheduleWeeks', 'defaultImg', 'checkStats'));
					
				}
			
			} else {
				
				return view('no_season', compact('showSeason'));
				
			}

		} else {
			
			$activeSeasons = $showSeason->league_profile->seasons()->active()->get();
			$seasonTeams = $showSeason->league_teams;
				
			$allPlayers = $showSeason->stats()->allFormattedStats();
			$allTeams = $showSeason->stats()->allTeamStats();
			$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks()->get();
			$checkStats = $showSeason->stats()->allFormattedStats()->get()->isNotEmpty();

			// Resize the default image
			Image::make(public_path('images/emptyface.jpg'))->resize(800, null, 	function ($constraint) {
					$constraint->aspectRatio();
				}
			)->save(storage_path('app/public/images/lg/default_img.jpg'));
			$defaultImg = asset('/storage/images/lg/default_img.jpg');
			
			if($showSeason->is_playoffs == 'Y') {
				$playoffRounds = $showSeason->games()->playoffRounds()->orderBy('round', 'desc')->get();
				$nonPlayInGames = $showSeason->games()->playoffNonPlayinGames();
				$playInGames = $showSeason->games()->playoffPlayinGames();
				$playoffSettings = $showSeason->playoffs;

				return view('stats.index', compact('activeSeasons', 'showSeason', 'allPlayers', 'allTeams', 'seasonScheduleWeeks', 'defaultImg', 'checkStats', 'playoffSettings', 'playoffRounds'));
				
			} else {

				return view('stats.index', compact('activeSeasons', 'showSeason', 'allPlayers', 'allTeams', 'seasonScheduleWeeks', 'defaultImg', 'checkStats'));
				
			}
		
		}
    }
	
	/**
     * Show the stats to be edited for selected week.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_week(Request $request, $week)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks()->get();
		$weekGames 	= $showSeason->games()->getWeekGames($week)->orderBy('game_date')->orderBy('game_time')->get();
		$activeSeasons = $showSeason instanceof \App\LeagueProfile ? $showSeason->seasons()->active()->get() : $showSeason->league_profile->seasons()->active()->get();

		return view('stats.edit', compact('seasonScheduleWeeks', 'showSeason', 'week', 'weekGames', 'activeSeasons'));
    }
	
	/**
     * Show the stats to be edited for selected week.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_round(Request $request, $round)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$playoffRounds = $showSeason->games()->playoffRounds()->orderBy('round', 'desc')->get();
		$roundGames	= $showSeason->games()->getRoundGames($round)->get();
		$activeSeasons = $showSeason instanceof \App\LeagueProfile ? $showSeason->seasons()->active()->get() : $showSeason->league_profile->seasons()->active()->get();

		return view('playoffs.stat', compact('playoffRounds', 'showSeason', 'round', 'roundGames', 'activeSeasons'));
    }
	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $week)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());

		// Update existing stats
		if(isset($request->edit_points)) {
			$player_points   = $request->edit_points;
			$player_assists  = $request->edit_assists;
			$player_rebounds = $request->edit_rebounds;
			$player_steals   = $request->edit_steals;
			$player_blocks   = $request->edit_blocks;
			$counter = 0;

			//Get the games that are getting stats added to them
			foreach($request->edit_game_id as $game) {
				$game = LeagueSchedule::find($game);
				$away_team = $game->away_team_obj;
				$home_team = $game->home_team_obj;
				
				// Add away player stats
				foreach($away_team->players as $away_player) {
					$away_stat = $away_player->stats->where('league_schedule_id', $game->id)->first();
					$away_stat->points = $player_points[$counter];
					$away_stat->assist = $player_assists[$counter];
					$away_stat->rebounds = $player_rebounds[$counter];
					$away_stat->steals = $player_steals[$counter];
					$away_stat->blocks = $player_blocks[$counter];
					$away_stat->league_season_id = $showSeason->id;
					$away_stat->league_player_id = $away_player->id;
					$away_stat->league_teams_id = $away_team->id;
					$away_stat->league_schedule_id = $game->id;
					
					if($player_points[$counter] !== null || $player_assists[$counter] !== null || $player_rebounds[$counter] !== null || $player_steals[$counter] !== null || $player_blocks[$counter] !== null) {
						
						$away_stat->game_played = 1;
						
					} else {
						
						$away_stat->game_played = 0;
						
					}
					
					if($away_stat->save()) {
						$counter++;
					}
				}
				
				// Add home player stats
				foreach($home_team->players as $home_player) {
					$home_stat = $home_player->stats->where('league_schedule_id', $game->id)->first();
					$home_stat->points = $player_points[$counter];
					$home_stat->assist = $player_assists[$counter];
					$home_stat->rebounds = $player_rebounds[$counter];
					$home_stat->steals = $player_steals[$counter];
					$home_stat->blocks = $player_blocks[$counter];
					$home_stat->league_season_id = $showSeason->id;
					$home_stat->league_player_id = $home_player->id;
					$home_stat->league_teams_id = $home_team->id;
					$home_stat->league_schedule_id = $game->id;
					
					if($player_points[$counter] !== null || $player_assists[$counter] !== null || $player_rebounds[$counter] !== null || $player_steals[$counter] !== null || $player_blocks[$counter] !== null) {
					
						$home_stat->game_played = 1;
					
					} else {
						
						$home_stat->game_played = 0;
						
					}
					
					if($home_stat->save()) {
						$counter++;
					}
				}
			}
		} 
		
		// Add new stats
		if(isset($request->points)) {
			$player_points   = $request->points;
			$player_assists  = $request->assists;
			$player_rebounds = $request->rebounds;
			$player_steals   = $request->steals;
			$player_blocks   = $request->blocks;
			$counter = 0;

			//Get the games that are getting stats added to them
			foreach($request->game_id as $game) {
				$game = LeagueSchedule::find($game);
				$away_team = $game->away_team_obj;
				$home_team = $game->home_team_obj;
				
				// Add away player stats
				foreach($away_team->players as $away_player) {
					$away_stat = new LeagueStat();
					$away_stat->points = $player_points[$counter];
					$away_stat->assist = $player_assists[$counter];
					$away_stat->rebounds = $player_rebounds[$counter];
					$away_stat->steals = $player_steals[$counter];
					$away_stat->blocks = $player_blocks[$counter];
					$away_stat->league_season_id = $showSeason->id;
					$away_stat->league_player_id = $away_player->id;
					$away_stat->league_teams_id = $away_team->id;
					$away_stat->league_schedule_id = $game->id;
					
					if($player_points[$counter] !== null || $player_assists[$counter] !== null || $player_rebounds[$counter] !== null || $player_steals[$counter] !== null || $player_blocks[$counter] !== null) {

						$away_stat->game_played = 1;
						
					} else {
						
						$away_stat->game_played = 0;						
						
					}
					
					if($away_stat->save()) {
						$counter++;
					}
				}
				
				// Add home player stats
				foreach($home_team->players as $home_player) {
					$home_stat = new LeagueStat();
					$home_stat->points = $player_points[$counter];
					$home_stat->assist = $player_assists[$counter];
					$home_stat->rebounds = $player_rebounds[$counter];
					$home_stat->steals = $player_steals[$counter];
					$home_stat->blocks = $player_blocks[$counter];
					$home_stat->league_season_id = $showSeason->id;
					$home_stat->league_player_id = $home_player->id;
					$home_stat->league_teams_id = $home_team->id;
					$home_stat->league_schedule_id = $game->id;
					
					if($player_points[$counter] !== null || $player_assists[$counter] !== null || $player_rebounds[$counter] !== null || $player_steals[$counter] !== null || $player_blocks[$counter] !== null) {
						
						$home_stat->game_played = 1;
						
					} else {
						
						$home_stat->game_played = 0;						
						
					}
					
					if($home_stat->save()) {
						$counter++;
					}
				}
			}
		}

		return redirect()->back()->with('status', 'Stats saved successfully');
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
