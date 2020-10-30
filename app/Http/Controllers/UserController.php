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
use App\Mail\NewContact;
use App\Mail\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

class UserController extends Controller
{

	public $showSeason;

	public function __construct() {
		$this->middleware(['auth'])->except(['index']);

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
	    $allUsers = $this->league->users;
	    $users = $this->league->users()->showMembers();
	    
	    return view('users.index', compact('users', 'allUsers', 'showSeason'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
		    'title'     => 'nullable|max:50',
		    'email'     => 'nullable|email|max:50',
		    'phone'     => 'nullable',
		    'active'    => 'nullable',
		    'bio'       => 'nullable',
	    ]);

	    $user = new User();
	    $user->name   = $request->name;
	    $user->title  = $request->title;
	    $user->email  = $request->email;
	    $user->phone  = $request->phone;
	    $user->active = $request->active;
	    $user->bio    = $request->bio;

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
		    'username' => 'required',
		    'name'     => 'required|max:100',
		    'type'     => 'required',
		    'email'    => 'required|email|max:50',
		    'active'   => 'required|',
	    ]);

	    $user->username  = $request->username;
	    $user->name      = $request->name;
	    $user->type      = $request->type;
	    $user->email     = $request->email;
	    $user->active    = $request->active;

	    if($user->type == 'player') {
		    $season_id = $request->season;
		    $team_id   = $request->season_team;
		    $teamCheck = LeaguePlayer::where([['email', '=', $user->email], ['league_season_id', '=', $request->season], ['user_id', '=', $user->id]])->get()->first();
		    $teamChangeCheck = $teamCheck->league_season_id == $season_id ? $teamCheck->league_team_id == $team_id ? false : true : false;

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

					    $newPlayer->save();
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
