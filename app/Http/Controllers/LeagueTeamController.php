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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
	    // Get the season to show
	    $showSeason = $this::get_season();
		$seasonTeams = $showSeason->league_teams;
	    $deletedTeams = $showSeason->league_teams()->onlyTrashed()->get();
	    $userTeamsIDs = array();

		// Resize the default image
		Image::make(public_path('images/commissioner.jpg'))->resize(544, null, 	function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');

		// Check for user and if they are a player on a team
	    if(Auth::check()) {
		    if(Auth::user()->type == 'player') {
		    	$playerProfiles = Auth::user()->league_player_profiles;

		    	if(Auth::user()->league_player_profiles->isNotEmpty()) {
		    		foreach ($playerProfiles as $teamPlayer) {
		    	        array_push($userTeamsIDs, $teamPlayer->league_team_id);
				    }
			    }
		    }
	    }

		return view('teams.index', compact('showSeason', 'seasonTeams', 'deletedTeams', 'defaultImg', 'userTeamsIDs'));
    }
	
	/**
     * Show the application create team page.
     *
     * @return \Illuminate\Http\Response
    */
    public function create() {
		// Get the season to show
		$showSeason = $this->get_season();
		$totalTeams = $showSeason->league_teams->count();
		
		// Resize the default image
		Image::make(public_path('images/commissioner.jpg'))->resize(600, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');
		
		return view('teams.create', compact('showSeason', 'defaultImg', 'totalTeams'));
    }

	/**
	 * Show the application create team page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(LeagueTeam $league_team) {
		$showSeason = $this->showSeason;

		// Get the season to show
		if($this->showSeason->league_teams->contains('id', $league_team->id)) {

			// Resize the default image
			Image::make(public_path('images/commissioner.jpg'))->resize(600, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
			)->save(storage_path('app/public/images/lg/default_img.jpg'));
			$defaultImg = asset('/storage/images/lg/default_img.jpg');

			return view('teams.show', compact('league_team', 'showSeason', 'defaultImg'));

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
	    $conferences = $showSeason->conferences;
	    $divisions = $showSeason->divisions;
	    $checkUserTeams = false;

		// Get the season to show
		if($this->showSeason->league_teams->contains('id', $league_team->id)) {

			// Resize the default image
			Image::make(public_path('images/commissioner.jpg'))->resize(600, null, 	function ($constraint) {
					$constraint->aspectRatio();
				}
			)->save(storage_path('app/public/images/lg/default_img.jpg'));
			$defaultImg = asset('/storage/images/lg/default_img.jpg');

			// Check for user and if they are a player on a team
			if(Auth::check()) {
				if(Auth::user()->type == 'player') {
					$playerProfiles = Auth::user()->league_player_profiles;

					if(Auth::user()->league_player_profiles->isNotEmpty()) {
						foreach ($playerProfiles as $teamPlayer) {
							if($teamPlayer->league_team_id == $league_team->id) {
								$checkUserTeams = true;
							}
						}
					}
				} elseif(Auth::user()->type == 'admin') {
					$checkUserTeams = true;
				}
			}

			if($checkUserTeams === true) {
				return view('teams.edit', compact('league_team', 'showSeason', 'defaultImg', 'conferences', 'divisions'));
			} else {
				return view('teams.show', compact('league_team', 'showSeason', 'defaultImg'));
			}

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

		if(Auth::user()->type == 'admin') {
			$league_team->fee_paid = $request->fee_paid;
			$league_team->is_all_star_team = $request->all_star_team;
			$league_team->league_conference_id = isset($request->conference) ? $request->conference : null;
			$league_team->league_division_id = isset($request->division) ? $request->division : null;
		}

	    $league_team->team_name = $request->team_name;
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
										$newPlayerStat->league_season_id = $this->showSeason->id;
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

					if(Auth::user()->type == 'admin') {
						if(isset($request->all_star)) {
							$player->all_star = in_array('all_star_' . $player->id, $request->all_star) ? 'Y' : 'N';
						}
					}

//					if(!Auth::user()->username == 'testdrive') {
//						if ($player->team_captain == 'Y') {
//							$player_account = User::where('email', $player->email)->first();
//
//							if ($player_account !== null) {
//								$player->player_profile_id = $player_account->id;
//							} else {
//								// Create a user account with type player
//								$new_player = User::create([
//									'username' => $player->email,
//									'email' => $player->email,
//									'password' => null,
//									'type' => 'player',
//								]);
//
//								$player->player_profile_id = $new_player->id;
//							}
//						}
//					}

					if($player->save()) {}
				}
			}
			
			// Update team standings
			if($league_team->is_all_star_team == 'Y') {
				if($team_standing) {
					if($team_standing->delete()) {}
				} else {}
			} else {
				if($team_standing) {
					$team_standing->team_name = $request->team_name;

					if($team_standing->save()) {}
				} else {
					LeagueStanding::onlyTrashed()->where('league_team_id', $league_team->id);
				}
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
		$showSeason = $this->showSeason;

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

						// Update the standings after updating all the games
						$showSeason->standings()->standingUpdate();

						return redirect()->action('LeagueTeamController@index', ['season' => $showSeason->id])->with('status', 'Team Deleted Successfully');
					}
				}
			}
		} else {}
    }

	/**
     * Restore a whole team.
     *
     * @return \Illuminate\Http\Response
    */
    public function restore(Request $request, $teamID=0) {
		// Get the season to show
		$showSeason = $this->showSeason;
		$league_team = LeagueTeam::onlyTrashed()->where('id', $teamID)->get()->first();

		// Restore team
		if($league_team->restore()) {
			// Restore team players
			if($league_team->players()->onlyTrashed()->where('league_team_id', $teamID)->get()->isNotEmpty()) {
				// Restore each player
				foreach($league_team->players()->onlyTrashed()->where('league_team_id', $teamID)->get() as $player) {
					if($player->stats()->onlyTrashed()->where('league_teams_id', $teamID)->get()->isNotEmpty()) {
						foreach($player->stats()->onlyTrashed()->where('league_teams_id', $teamID)->get() as $playerStat) {
							$playerStat->restore();
						}
					}

					$player->restore();
				}

				// Restore team standings
				if($league_team->standings()->onlyTrashed()->where('league_team_id', $teamID)->get()->first()->restore()) {
					// Restore team games
					if($league_team->home_games()->onlyTrashed()->where('home_team_id', $league_team->id)->get()->merge($league_team->away_games()->onlyTrashed()->where('away_team_id', $league_team->id)->get())->isNotEmpty()) {
						// Restore each game
						foreach($league_team->home_games()->onlyTrashed()->where('home_team_id', $league_team->id)->get()->merge($league_team->away_games()->onlyTrashed()->where('away_team_id', $league_team->id)->get()) as $game) {
							if($game->result()->onlyTrashed()->get()->isNotEmpty()) {
								$game->result()->onlyTrashed()->first()->restore();
							}

							$game->restore();
						}

						// Update the standings after updating all the games
						$showSeason->standings()->standingUpdate();

						return redirect()->action('LeagueTeamController@edit', ['league_team' => $league_team->id, 'season' => $showSeason->id])->with('status', 'Team Restored Successfully');
					}
				}
			}
		} else {}
    }
}
