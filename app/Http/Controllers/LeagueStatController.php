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
		$activeSeasons = $showSeason->league_profile->seasons()->active()->get();
		$seasonTeams = $showSeason->league_teams;
		
		$seasonStats = $showSeason->stats();		
		$allPlayers = $seasonStats->allFormattedStats();
		$allTeams = $seasonStats->allTeamStats();
		$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks()->get();

		return view('stats.index', compact('activeSeasons', 'showSeason', 'allPlayers', 'allTeams', 'seasonScheduleWeeks'));
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

		return view('stats.edit', compact('seasonScheduleWeeks', 'showSeason', 'week', 'weekGames'));
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
