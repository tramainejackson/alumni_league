<?php

namespace App\Http\Controllers;

use App\Admin;
use App\LeaguePlayer;
use App\LeagueProfile;
use App\LeagueSeason;
use App\LeagueTeam;
use App\User;
use App\MessageReason;
use App\Service;
use App\NewsArticle;
use App\Mail\NewUser;
use App\Mail\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UserController extends Controller
{

	public $showSeason;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware(['auth']);

		$this->showSeason = LeagueProfile::find(2)->seasons()->showSeason();
	}

	public function get_season() {
		return $this->showSeason;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
    	$showSeason = $this->showSeason;
	    $allUsers = $showSeason->league_profile->users;
	    $users = $showSeason->league_profile->users()->showMembers();
	    
	    return view('users.index', compact('users', 'allUsers', 'showSeason'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
	    $this->validate($request, [
		    'name'      => 'required|max:50',
		    'username'  => 'required|max:50|unique:users,username',
		    'email'     => 'required|email|max:50|unique:users,email',
		    'phone'     => 'nullable',
		    'active'    => 'nullable',
	    ]);

	    $user = new User();
	    $user->league_profile_id = LeagueProfile::find(2)->id;
	    $user->name     = $request->name;
	    $user->username = $request->username;
	    $user->email    = $request->email;
	    $user->phone    = $request->phone;
	    $user->type     = $request->type;
	    $user->active   = $request->active;

	    if($user->save()) {
		    return back()->with('status', 'New User Added Successfully');
	    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  User $member
     * @return \Illuminate\Http\Response
     */
    public function show(User $member) {
    	return view('users.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  User $member
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
	    $showSeason = $this->showSeason;

	    //Check if user is a player
	    //and belongs to a teams
	    $getUserPlayer = LeaguePlayer::where('user_id', $user->id)->get()->last();
	    $teamCheck = $getUserPlayer != null ? true : false;

	    if($teamCheck) {
	    	$teamID = $getUserPlayer->league_team->id;
		    $seasonID = $getUserPlayer->league_team->season->id;
	    } else {
		    $teamID = null;
		    $seasonID = null;
	    }

	    return view('users.edit', compact('user', 'showSeason', 'teamCheck', 'getUserPlayer', 'teamID', 'seasonID'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  User $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {

	    $this->validate($request, [
		    'username'  => [
		    	    'required',
                    Rule::unique('users')->ignore($user->id),
		    ],
		    'name'      => 'required|max:100',
		    'type'      => 'required',
		    'email'     => [
		    	'required',
			    'email',
			    'max:50',
			    Rule::unique('users')->ignore($user->id),
		    ],
		    'active'    => 'required|',
	    ]);

	    $user->username = $request->username;
	    $user->name     = $request->name;
	    $user->type     = $request->type;
	    $user->email    = $request->email;
	    $user->active   = $request->active;

	    if($user->type == 'player') {
		    $this->validate($request, [
			    'season' => 'required|',
			    'season_team' => 'required',
		    ]);

		    $season_id = $request->season;
		    $team_id   = $request->season_team;
		    $teamCheck = LeaguePlayer::where([['email', '=', $user->email], ['league_season_id', '=', $request->season], ['user_id', '=', $user->id]])->get()->first();
		    $teamChangeCheck = $teamCheck !== null && $teamCheck->league_season_id == $season_id ? $teamCheck->league_team_id == $team_id ? false : true : false;

		    //Find season and make sure the selected team
		    //is in that season
		    $season = LeagueSeason::find($season_id);
		    $team = LeagueTeam::find($team_id);

		    if($season->id == $team->league_season_id) {
		    	$team_captain = $team->players()->captain();
		    	$team_players = $team->players;
		    	$matchCheck = null;

		    	if($team_captain->isEmpty()) {
				    foreach ($team_players as $team_player) {
					    $team_player->email == $user->email ? $matchCheck = $team_player : null;
				    }

				    if ($matchCheck) {
					    $matchCheck->user_id = $user->id;
					    $matchCheck->team_captain = 'Y';
				    } else {
					    //Check if player team was changed
				    	if($teamChangeCheck) {
						    $teamCheck->user_id = null;
						    $teamCheck->team_captain = 'N';

						    $teamCheck->save();
					    }

					    $newPlayer = new LeaguePlayer();
					    $newPlayer->user_id = $user->id;
					    $newPlayer->player_name = $user->name;
					    $newPlayer->email = $user->email;
					    $newPlayer->team_captain = 'Y';
					    $newPlayer->league_season_id = $season->id;
					    $newPlayer->league_team_id = $team->id;
					    $newPlayer->team_name = $team->team_name;

					    if($newPlayer->save()) {
						    // If this team has any team stats, then
						    // add each new player to that games stats
						    if ($team->home_games->merge($team->away_games)->isNotEmpty()) {
							    $games = $team->home_games->merge($team->away_games);

							    foreach ($games as $game) {
								    // Check and see if the game has stats added yet
								    // Add player to that games stats if exist
								    if ($game->player_stats->isNotEmpty()) {
									    $newPlayerStat = new LeagueStat();
									    $newPlayerStat->league_teams_id = $team->id;
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

				    if ($user->save()) {
					    return back()->with('status', 'User Info Updated Successfully');
				    }
			    } else {
		    		$captainPlayer = $team_captain->first();
		    		$userIDMatch = $captainPlayer->user_id == $user->id ? true : false;
		    		$userEmailMatch = $captainPlayer->email == $user->email ? true : false;

		    		if($userIDMatch && $userEmailMatch) {
				    } elseif(!$userIDMatch && $userEmailMatch) {
					    $captainPlayer->user_id = $user->id;

					    $captainPlayer->save();
				    } elseif($userIDMatch && !$userEmailMatch) {
					    $captainPlayer->email = $user->email;

					    $captainPlayer->save();
				    } else {
					    foreach ($team_players as $team_player) {
						    $team_player->email == $user->email ? $matchCheck = $team_player : null;
					    }

					    if ($matchCheck) {
						    $matchCheck->user_id = $user->id;
						    $matchCheck->team_captain = 'Y';

						    $matchCheck->save();
					    } else {
						    //Check if player team was changed
						    if($teamChangeCheck) {
							    $teamCheck->user_id = null;
							    $teamCheck->team_captain = 'N';

							    $teamCheck->save();
						    }

						    $newPlayer = new LeaguePlayer();
						    $newPlayer->user_id = $user->id;
						    $newPlayer->player_name = $user->name;
						    $newPlayer->email = $user->email;
						    $newPlayer->team_captain = 'Y';
						    $newPlayer->league_season_id = $season->id;
						    $newPlayer->league_team_id = $team->id;
						    $newPlayer->team_name = $team->team_name;

						    $newPlayer->save();
					    }
				    }

				    if ($user->save()) {
						if($user->password == null) {
							\Mail::to($user->email)->send(new NewUser($user));
						}

					    return back()->with('status', 'User Info Updated Successfully');
				    }
			    }
		    } else {
			    return back()->with('status', 'User Not Updated. The Team Selected Does\'t Belong to The Season Selected');
		    }
	    } else {
		    if($user->save()) {
			    return back()->with('status', 'User Info Updated Successfully');
		    }
	    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  User $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $member)
    {
        //
    }
}
