<?php

namespace App\Http\Controllers;

use App\LeagueConference;
use App\LeagueDivision;
use App\PlayerProfile;
use App\LeagueProfile;
use App\LeagueSchedule;
use App\LeagueStanding;
use App\LeaguePlayer;
use App\LeagueTeam;
use App\LeagueStat;
use App\LeagueSeason;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class LeagueTeamController extends Controller
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
        $this->middleware('auth')->except(['index', 'show']);

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
    public function index(Request $request) {
	    // Get the season to show
	    $showSeason = $this::get_season();
		$activeSeasons = $this::get_active_seasons();
		$seasonTeams = $showSeason->league_teams;

		// Resize the default image
		Image::make(public_path('images/commissioner.jpg'))->resize(544, null, 	function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');

		return view('teams.index', compact('showSeason', 'activeSeasons', 'seasonTeams', 'defaultImg'));
    }
	
	/**
     * Show the application create team page.
     *
     * @return \Illuminate\Http\Response
    */
    public function create() {
		// Get the season to show
		$showSeason = $this->get_season();
		$activeSeasons = $this::get_active_seasons();
		$totalTeams = $showSeason->league_teams->count();
		
		// Resize the default image
		Image::make(public_path('images/commissioner.jpg'))->resize(600, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');
		
		return view('teams.create', compact('showSeason', 'activeSeasons', 'defaultImg', 'totalTeams'));
    }

	/**
	 * Show the application create team page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(LeagueTeam $league_team) {
		$showSeason = $this->showSeason;
		$activeSeasons = $this->get_active_seasons();

		// Get the season to show
		if($this->showSeason->league_teams->contains('id', $league_team->id)) {

			// Resize the default image
			Image::make(public_path('images/commissioner.jpg'))->resize(600, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
			)->save(storage_path('app/public/images/lg/default_img.jpg'));
			$defaultImg = asset('/storage/images/lg/default_img.jpg');

			return view('teams.show', compact('league_team', 'showSeason', 'defaultImg', 'activeSeasons'));

		} else {

			abort(404);

		}
	}
	
	/**
     * Show the application create team page.
     *
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
		$this->validate($request, [
			'team_name' => 'required',
		]);
		
		// Create a new team for the selected season
		$team = $this->showSeason->league_teams()->create([
			'team_name' => ucwords(strtolower($request->team_name)),
			'fee_paid' => $request->fee_paid,
		]);

		if($team) {
			$teamStandings = new LeagueStanding();
			$teamStandings->league_season_id = $team->league_season_id;
			$teamStandings->league_team_id = $team->id;
			$teamStandings->team_name = $team->team_name;
			
			if($teamStandings->save()) {
				return redirect()->action('LeagueTeamController@edit', ['team' => $team->id, 'season' => $this->showSeason->id, 'year' => $this->showSeason->year])->with('status', 'New Team Added Successfully');
			}
		} else {}
    }
	
	/**
     * Show the application create team page.
     *
     * @return \Illuminate\Http\Response
    */
    public function edit(LeagueTeam $league_team) {
	    $showSeason = $this->showSeason;
	    $activeSeasons = $this::get_active_seasons();
	    $conferences = $showSeason->conferences;
	    $divisions = $showSeason->divisions;

		// Get the season to show
		if($this->showSeason->league_teams->contains('id', $league_team->id)) {

			// Resize the default image
			Image::make(public_path('images/commissioner.jpg'))->resize(600, null, 	function ($constraint) {
					$constraint->aspectRatio();
				}
			)->save(storage_path('app/public/images/lg/default_img.jpg'));
			$defaultImg = asset('/storage/images/lg/default_img.jpg');

			return view('teams.edit', compact('league_team', 'showSeason', 'defaultImg', 'activeSeasons', 'conferences', 'divisions'));
			
		} else {
			
			abort(404);

		}
    }
	
	/**
     * Update the teams information.
     *
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, LeagueTeam $league_team) {
		$this->validate($request, [
			'team_name' => 'required',
			'team_photo' => 'nullable|image',
		]);

		$league_team->team_name = $request->team_name;
		$league_team->fee_paid = $request->fee_paid;
		$league_team->league_conference_id = isset($request->conference) ? $request->conference : null;
		$league_team->league_division_id = isset($request->division) ? $request->division : null;
		$team_players = $league_team->players;
		$team_standing = $league_team->standings;
		$team_home_games = $league_team->home_games;
		$team_away_games = $league_team->away_games;

		// Store picture if one was uploaded
		if($request->hasFile('team_photo')) {
			$newImage = $request->file('team_photo');
			
			// Check to see if images is too large
			if($newImage->getError() == 1) {
				$fileName = $request->file('team_photo')[0]->getClientOriginalName();
				$error .= "<li class='errorItem'>The file " . $fileName . " is too large and could not be uploaded</li>";
			} elseif($newImage->getError() == 0) {
				$image = Image::make($newImage->getRealPath())->orientate();
				$path = $newImage->store('public/images');
				
				if($image->save(storage_path('app/'. $path))) {
					// prevent possible upsizing
					// Create a larger version of the image
					// and save to large image folder
					$image->resize(1700, null, function ($constraint) {
						$constraint->aspectRatio();
					});
					
					
					if($image->save(storage_path('app/'. str_ireplace('images', 'images/lg', $path)))) {
						// Get the height of the current large image
						// $addImage->lg_height = $image->height();
						
						// Create a smaller version of the image
						// and save to large image folder
						$image->resize(544, null, function ($constraint) {
							$constraint->aspectRatio();
						});
						
						if($image->save(storage_path('app/'. str_ireplace('images', 'images/sm', $path)))) {
							// Get the height of the current small image
							// $addImage->sm_height = $image->height();
						}
					}
				}
				
				$league_team->team_picture = str_ireplace('public', 'storage', $path);
			} else {
				$error .= "<li class='errorItem'>The file " . $fileName . " may be corrupt and could not be uploaded</li>";
			}
		}
			
		if($league_team->save()) {
			// Add new players
			if(isset($request->new_player_name)) {
				foreach($request->new_player_name as $key => $newPlayerName) {
					$newPlayer = new LeaguePlayer();
					$newPlayer->team_name = $request->team_name;
					$newPlayer->player_name = $newPlayerName;
					$newPlayer->jersey_num = $request->new_jers_num[$key];
					$newPlayer->email = $request->new_player_email[$key];
					$newPlayer->phone = $request->new_player_phone[$key];
					$newPlayer->team_captain = 'N';
					$newPlayer->league_team_id = $league_team->id;
					$newPlayer->league_season_id = $this->get_season()->id;

					if($newPlayer->player_name != null && $newPlayer->player_name != '') {
						// Save the new team player
						if ($newPlayer->save()) {
							// If this team has any team stats, then
							// add each new player to that games stats
							if ($league_team->home_games->merge($league_team->away_games)->isNotEmpty()) {
								$games = $league_team->home_games->merge($league_team->away_games);

								foreach ($games as $game) {
									// Check and see if the game has stats added yet
									// Add player to that games stats if exist
									if ($game->player_stats->isNotEmpty()) {
										$newPlayerStat = new LeagueStat();
										$newPlayerStat->league_teams_id = $league_team->id;
										$newPlayerStat->league_season_id = $showSeason->id;
										$newPlayerStat->league_schedule_id = $game->id;
										$newPlayerStat->league_player_id = $newPlayer->id;
										$newPlayerStat->game_played = 0;

										if ($newPlayerStat->save()) {
										}
									}
								}
							}
						}
					}
				}
			}
			
			// Updates team players
			if($team_players) {
				foreach($team_players as $key => $player) {
					$player->team_captain = str_ireplace('captain_', '', $request->team_captain) == $player->id ? 'Y' : 'N';
					$player->team_name = $request->team_name;
					$player->player_name = $request->player_name[$key];
					$player->jersey_num = $request->jersey_num[$key];
					$player->email = $request->player_email[$key];
					$player->phone = $request->player_phone[$key];

					if(!Auth::user()->username == 'testdrive') {
						if ($player->team_captain == 'Y') {
							$player_account = User::where('email', $player->email)->first();

							if ($player_account !== null) {
								$player->player_profile_id = $player_account->id;
							} else {
								// Create a user account with type player
								$new_player = User::create([
									'username' => $player->email,
									'email' => $player->email,
									'password' => null,
									'type' => 'player',
								]);

								$player->player_profile_id = $new_player->id;
							}
						}
					}

					if($player->save()) {}
				}
			}
			
			// Update team standings
			if($team_standing) {
				$team_standing->team_name = $request->team_name;
				if($team_standing->save()) {}
			}
			
			// Update games on the calendar
			if($team_home_games) {
				foreach($team_home_games as $home_game) {
					$home_game->home_team = $request->team_name;
					
					if($home_game->save()) {}
				}
			}
			
			if($team_away_games) {
				foreach($team_away_games as $away_game) {
					$away_game->away_team = $request->team_name;
					
					if($away_game->save()) {}
				}
			}
			
			// Update player stats
			return redirect()->back()->with('status', 'Team Updated');
		}
    }
	
	/**
     * Remove a whole team.
     *
     * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request, LeagueTeam $league_team) {
		// Get the season to show
		$league = Auth::user()->leagues_profiles->first();
		$showSeason = '';
		
		if(isset(parse_url($request->session()->previousUrl())['query'])) {
			$previousURL = parse_url($request->session()->previousUrl())['query'];
			$queryStr = explode('&', $previousURL);
			$queryArr = array();
			
			foreach($queryStr as $arr) {
				$arr = explode('=', $arr);
				$arr = array($arr[0] => $arr[1]);
				$queryArr = array_merge($queryArr, $arr);
			}
			
			$showSeason = $league->seasons()->active()->find($queryArr['season']);
		} else {
			$showSeason = $league->seasons()->active()->first();
		}

		// Delete team
		if($league_team->delete()) {
			// Delete team players
			if($league_team->players) {
				// Delete each player
				foreach($league_team->players as $player) {
					if($player->stats) {
						foreach($player->stats as $playerStat) {
							$playerStat->delete();
						}
					}
					
					$player->delete();
				}
				
				// Delete team standings
				if($league_team->standings->delete()) {
					// Delete team games
					if($league_team->home_games->merge($league_team->away_games)) {
						// Delete each game
						foreach($league_team->home_games->merge($league_team->away_games) as $game) {
							if($game->result) {
								$game->result->delete();
							}

							$game->delete();
						}
						
						return redirect()->action('LeagueTeamController@index', ['season' => $showSeason->id, 'year' => $showSeason->year])->with('status', 'Team Deleted Successfully');
					}
					
					// Update the standings after updating all the games
					$showSeason->standings()->standingUpdate();
				}
			}
		} else {}
    }
}
