<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeagueProfile;
use App\LeagueSeason;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class LeagueProfileController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth')->except(['index', 'show', 'show_season']); 
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
		// Get the season to show
		$showSeason = $this->find_season(request());

		$activeSeasons = $showSeason instanceof \App\LeagueProfile ? $showSeason->seasons->isNotEmpty() ? $showSeason->seasons()->active()->get() : null : $showSeason != null ? $showSeason->league_profile->seasons()->active()->get() : LeagueProfile::find(1) ;
        $leagues = LeagueProfile::all();
		
		// Resize the default image
		Image::make(public_path('images/commissioner.jpg'))->resize(350, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');
		
		return view('leagues.index', compact('activeSeasons', 'showSeason', 'leagues', 'defaultImg'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $league)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		
		$league_array = LeagueProfile::all()->toArray();
		$league_names = array_pluck($league_array, 'name', 'id');
		
		foreach($league_names as $id => $name) {
			$name = str_ireplace(" ", "", strtolower($name));
			
			if($league === $name) {
				$league = LeagueProfile::find($id);
			}
		}
		
		$activeSeasons = $league->seasons()->active()->get();
		
		// Resize the default image
		Image::make(public_path('images/commissioner.jpg'))->resize(350, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');
		
		return view('leagues.show', compact('activeSeasons', 'showSeason', 'league', 'defaultImg'));
    }
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_season(Request $request, $league, $season)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		
		$standings = null;
		$teams = null;
		$schedule = null;
		$playoffRounds = $nonPlayInGames = $playInGames = $playoffSettings = null;
		$league_array = LeagueProfile::all()->toArray();
		$league_names = array_pluck($league_array, 'name', 'id');
		
		foreach($league_names as $id => $name) {
			$name = str_ireplace(" ", "", strtolower($name));
			
			if($league === $name) {
				$league = LeagueProfile::find($id);
				$league_seasons = $league->seasons->toArray();
				$league_seasons_names = array_pluck($league_seasons, 'name', 'id');
				
				foreach($league_seasons_names as $id => $season_name) {
					$season_name = str_ireplace(" ", "", strtolower($season_name));
					
					if($season === $season_name) {
						$season = LeagueSeason::find($id);
						$standings = $season->standings;
						$teams = $season->league_teams;
						$schedule = $season->games()->getScheduleWeeks();
						$pictures = $season->pictures;
						$stats = $season->stats()->allFormattedStats()->get()->isNotEmpty();
						$allPlayers = $season->stats()->allFormattedStats();
						$allTeams = $season->stats()->allTeamStats();
						
						if($season->is_playoffs == 'Y') {
							$playoffRounds = $season->games()->playoffRounds()->orderBy('round', 'desc')->get();
							$nonPlayInGames = $season->games()->playoffNonPlayinGames();
							$playInGames = $season->games()->playoffPlayinGames();
							$playoffSettings = $season->playoffs;
						}
					}
				}
			}
		}
		
		$activeSeasons = $league->seasons()->active()->get();
		
		// Resize the default image
		Image::make(public_path('images/commissioner.jpg'))->resize(350, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');
		
		if($season->is_playoffs == 'Y') {
			return view('leagues.season', compact('activeSeasons', 'showSeason', 'league', 'season', 'standings', 'stats', 'teams', 'pictures', 'stats', 'schedule', 'allPlayers', 'allTeams', 'defaultImg', 'playInGames', 'nonPlayInGames', 'playoffRounds', 'playoffSettings'));
		} else {
			return view('leagues.season', compact('activeSeasons', 'showSeason', 'league', 'season', 'standings', 'stats', 'teams', 'schedule', 'stats', 'pictures', 'allPlayers', 'allTeams', 'defaultImg'));			
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeagueProfile $league_profile)
    {
		// Validate incoming data
		$this->validate($request, [
			'name' => 'required|max:50:unique:league_profile',
			'commish' => 'required|max:100',
			'leagues_fee' => 'numeric|nullable',
			'ref_fee' => 'numeric|nullable',
		]);
		
		$league = $league_profile;
		$league->name = $request->name;
		$league->commish = $request->commish;
		$league->address = $request->leagues_address;
		$league->phone = $request->leagues_phone;
		$league->leagues_email = $request->leagues_email;
		$league->leagues_website = $request->leagues_website;
		$league->leagues_fee = $request->leagues_fee;
		$league->ref_fee = $request->ref_fee;
		$league->age = isset($request->age) ? implode(' ', $request->age) : null;
		$league->comp = isset($request->leagues_comp) ? implode(' ', $request->leagues_comp) : null;
		
		// Store picture if one was uploaded
		if($request->hasFile('profile_photo')) {
			$newImage = $request->file('profile_photo');
			
			// Check to see if images is too large
			if($newImage->getError() == 1) {
				$fileName = $request->file('profile_photo')[0]->getClientOriginalName();
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
				
				$league->picture = str_ireplace('public', 'storage', $path);
			} else {
				$error .= "<li class='errorItem'>The file " . $fileName . " may be corrupt and could not be uploaded</li>";
			}
		}
		
		if($league->save()) {
			return redirect()->back()->with(['status' => 'Leagues Information Updated Successfully']);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
		} else {
			$showSeason = LeagueSeason::first();
		}

		return $showSeason;
	}
}
