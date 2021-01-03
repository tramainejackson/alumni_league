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

	public $showSeason;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);

	    $this->showSeason = LeagueProfile::find(2)->seasons()->showSeason();
    }

	public function get_season() {
		return $this->showSeason;
	}

    /**
     * Show the stats index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	    // Get the season to show
	    $showSeason = $this->showSeason;

		$allPlayers = $showSeason->stats()->allFormattedStats();
		$allTeams = $showSeason->stats()->allTeamStats();
		$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks()->get();
		$checkStats = $showSeason->stats()->allFormattedStats()->get()->isNotEmpty();
	    $allStarGame = $this->showSeason->games()->where('all_star_game', 'Y')->first();

		// Resize the default image
		Image::make(public_path('images/emptyface.jpg'))->resize(800, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');

		if($showSeason->is_playoffs == 'Y') {
			$playoffRounds = $showSeason->games()->playoffRounds()->orderBy('round', 'asc')->get();
			$nonPlayInGames = $showSeason->games()->playoffNonPlayinGames();
			$playInGames = $showSeason->games()->playoffPlayinGames();
			$playoffSettings = $showSeason->playoffs;

			return view('stats.index', compact('showSeason', 'allPlayers', 'allTeams', 'seasonScheduleWeeks', 'defaultImg', 'checkStats', 'playoffSettings', 'playoffRounds', 'allStarGame'));

		} else {

			return view('stats.index', compact('showSeason', 'allPlayers', 'allTeams', 'seasonScheduleWeeks', 'defaultImg', 'checkStats', 'allStarGame'));

		}
    }

    /**
     * Show the stats index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $leagueSchedule) {
	    // Get the season to show
	    $showSeason = $this->showSeason;
	    $regularSeasonWeek = isset($request->round) ? false : true;

	    if($regularSeasonWeek) {
		    $week_games = $showSeason->games()->getWeekGames($leagueSchedule)->get();
		    $game = $week_games->first();
		    $weekCheck = 'Other Games This Week';

		    if($week_games->isEmpty()) {
			    $game = $showSeason->games()->getSingleGame($leagueSchedule)->first();
			    $week_games = $showSeason->games()->getWeekGames($game->season_week)->get();
		    }
	    } else {
		    $week_games = $showSeason->games()->getRoundGames($leagueSchedule)->get();
		    $game = $week_games->first();
		    $weekCheck = 'Other Playoff Games This Round';

		    if($week_games->isEmpty()) {
			    $game = $showSeason->games()->getSingleGame($leagueSchedule)->first();
			    $week_games = $showSeason->games()->getRoundGames($game->round)->get();
		    }
	    }

	    if($game) {
			$gameID = $game->id;
		    $game_results = $game->result;
		    $away_team = $game->away_team_obj;
		    $home_team = $game->home_team_obj;

		    $allPlayers = $showSeason->stats()->allFormattedStats();
		    $allTeams = $showSeason->stats()->allTeamStats();
		    $seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks()->get();
		    $checkStats = $showSeason->stats()->allFormattedStats()->get()->isNotEmpty();

		    // Resize the default image
		    Image::make(public_path('images/emptyface.jpg'))->resize(800, null, function ($constraint) {
			    $constraint->aspectRatio();
		    }
		    )->save(storage_path('app/public/images/lg/default_img.jpg'));
		    $defaultImg = asset('/storage/images/lg/default_img.jpg');

		    if ($showSeason->is_playoffs == 'Y') {
			    $playoffRounds = $showSeason->games()->playoffRounds()->orderBy('round', 'asc')->get();
			    $playoffSettings = $showSeason->playoffs;

			    return view('stats.show', compact('showSeason', 'allPlayers', 'allTeams', 'seasonScheduleWeeks', 'defaultImg', 'checkStats', 'playoffSettings', 'playoffRounds', 'week_games', 'game_results', 'away_team', 'home_team', 'gameID', 'game', 'weekCheck'));

		    } else {

			    return view('stats.show', compact('showSeason', 'allPlayers', 'allTeams', 'seasonScheduleWeeks', 'defaultImg', 'checkStats', 'game_results', 'away_team', 'home_team', 'week_games', 'gameID', 'game', 'weekCheck'));

		    }
	    } else {
		    abort(404);
	    }
    }
	
	/**
     * Show the stats to be edited for the All-Star Game.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_asg(Request $request) {
		// Get the season to show
	    $showSeason = $this->showSeason;
		$seasonASG = $showSeason->games()->where('all_star_game', 'Y')->first();
		$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks()->get();

		if((Auth::user()->type == 'statistician' || Auth::user()->type == 'admin')) {
			return view('stats.edit', compact('seasonScheduleWeeks', 'showSeason', 'seasonASG'));
		}
    }

	/**
     * Show the stats to be edited for selected week.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_week(Request $request, $week) {
		// Get the season to show
	    $showSeason = $this->showSeason;
		$seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks()->get();
		$weekGames 	= $showSeason->games()->getWeekGames($week)->orderBy('game_date')->orderBy('game_time')->get();
	    $allStarGame = $this->showSeason->games()->where('all_star_game', 'Y')->first();

		if((Auth::user()->type == 'statistician' || Auth::user()->type == 'admin')) {
			return view('stats.edit', compact('seasonScheduleWeeks', 'showSeason', 'week', 'weekGames', 'allStarGame'));
		}
    }
	
	/**
     * Show the stats to be edited for selected week.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_round(Request $request, $round) {
		// Get the season to show
		$showSeason = $this->showSeason;
		$playoffRounds = $showSeason->games()->playoffRounds()->orderBy('round', 'asc')->get();
		$roundGames	= $showSeason->games()->getRoundGames($round)->get();
	    $allStarGame = $this->showSeason->games()->where('all_star_game', 'Y')->first();
	    $playoffSettings = $showSeason->playoffs;
	    $seasonScheduleWeeks = $showSeason->games()->getScheduleWeeks()->get();

	    if((Auth::user()->type == 'statistician' || Auth::user()->type == 'admin')) {
		    return view('playoffs.stat', compact('playoffRounds', 'showSeason', 'round', 'roundGames', 'allStarGame', 'playoffSettings', 'seasonScheduleWeeks'));
	    }
    }
	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $week) {
		// Get the season to show
	    $showSeason = $this->showSeason;

		// Update existing stats
		if(isset($request->edit_points)) {
			$player_points   = $request->edit_points;
			$player_assists  = $request->edit_assists;
			$player_rebounds = $request->edit_rebounds;
			$player_steals   = $request->edit_steals;
			$player_blocks   = $request->edit_blocks;
			$player_threes   = $request->edit_threes;
			$player_frees  = $request->edit_fts;
			$counter = 0;

			//Get the games that are getting stats added to them
			foreach($request->edit_game_id as $game) {
				$game = LeagueSchedule::find($game);
				$away_team = $game->away_team_obj;
				$home_team = $game->home_team_obj;
				
				// Add away player stats
				foreach($away_team->players as $away_player) {
					$away_stat = $away_player->stats->where('league_schedule_id', $game->id)->first();
					$away_stat->potw = str_ireplace('potw_', '', $request->potw) == $away_player->id ? 'Y' : 'N';
					$away_stat->points = $player_points[$counter];
					$away_stat->assist = $player_assists[$counter];
					$away_stat->rebounds = $player_rebounds[$counter];
					$away_stat->steals = $player_steals[$counter];
					$away_stat->blocks = $player_blocks[$counter];
					$away_stat->threes_made = $player_threes[$counter];
					$away_stat->ft_made = $player_frees[$counter];
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
					$home_stat->potw = str_ireplace('potw_', '', $request->potw) == $home_player->id ? 'Y' : 'N';
					$home_stat->points = $player_points[$counter];
					$home_stat->assist = $player_assists[$counter];
					$home_stat->rebounds = $player_rebounds[$counter];
					$home_stat->steals = $player_steals[$counter];
					$home_stat->blocks = $player_blocks[$counter];
					$home_stat->threes_made = $player_threes[$counter];
					$home_stat->ft_made = $player_frees[$counter];
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
			$player_threes   = $request->threes;
			$player_frees  = $request->fts;
			$counter = 0;

			//Get the games that are getting stats added to them
			foreach($request->game_id as $game) {
				$game = LeagueSchedule::find($game);
				$away_team = $game->away_team_obj;
				$home_team = $game->home_team_obj;
				
				// Add away player stats
				foreach($away_team->players as $away_player) {
					$away_stat = new LeagueStat();
					$away_stat->potw = str_ireplace('potw_', '', $request->potw) == $away_player->id ? 'Y' : 'N';
					$away_stat->points = $player_points[$counter];
					$away_stat->assist = $player_assists[$counter];
					$away_stat->rebounds = $player_rebounds[$counter];
					$away_stat->steals = $player_steals[$counter];
					$away_stat->blocks = $player_blocks[$counter];
					$away_stat->threes_made = $player_threes[$counter];
					$away_stat->ft_made = $player_frees[$counter];
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
					$home_stat->potw = str_ireplace('potw_', '', $request->potw) == $home_player->id ? 'Y' : 'N';
					$home_stat->points = $player_points[$counter];
					$home_stat->assist = $player_assists[$counter];
					$home_stat->rebounds = $player_rebounds[$counter];
					$home_stat->steals = $player_steals[$counter];
					$home_stat->blocks = $player_blocks[$counter];
					$home_stat->threes_made = $player_threes[$counter];
					$home_stat->ft_made = $player_frees[$counter];
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

}
