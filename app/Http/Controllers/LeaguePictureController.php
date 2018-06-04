<?php

namespace App\Http\Controllers;

use App\PlayerProfile;
use App\LeagueProfile;
use App\LeagueSchedule;
use App\LeagueStanding;
use App\LeaguePlayer;
use App\LeagueTeam;
use App\LeagueStat;
use App\LeaguePicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class LeaguePictureController extends Controller
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
		$activeSeasons = $showSeason instanceof \App\LeagueProfile ? $showSeason->seasons()->active()->get() : $showSeason->league_profile->seasons()->active()->get();
		$seasonPictures = $showSeason instanceof \App\LeagueProfile ? collect() : $showSeason->pictures;
		
		// Resize the default image
		Image::make(public_path('images/commissioner.jpg'))->resize(544, null, 	function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');

		if($showSeason instanceof \App\LeagueProfile) {
			$allComplete = 'Y';
			
			return view('pictures.index', compact('showSeason', 'activeSeasons', 'seasonPictures', 'defaultImg', 'allComplete'));
		} else {
			return view('pictures.index', compact('showSeason', 'activeSeasons', 'seasonPictures', 'defaultImg'));
		}
    }
	
	/**
     * Show the picture edit page.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaguePicture $league_picture)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());

		return view('pictures.edit', compact('showSeason', 'league_picture'));
    }
	
	/**
     * Update the pictures description.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaguePicture $league_picture)
    {
		$league_picture->description = $request->description;
		
		if($league_picture->save()) {
			return redirect()->action('LeaguePictureController@index', ['season' => $showSeason->id, 'year' => $showSeason->year])->with('status', 'Picture Description Updated Successfully');
		}
    }
	
	/**
     * Show the pictures create page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$activeSeasons = $showSeason->league_profile->seasons()->active()->get();
		$seasonPictures = $showSeason->pictures;

		return view('pictures.create', compact('showSeason', 'activeSeasons', 'seasonPictures'));
    }
	
	/**
     * Store new pictures.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		$counter = 0;

		if($request->hasFile('team_photo')) {
			foreach($request->file('team_photo') as $newImage) {
				// Check to see if upload is an image
				if($newImage->guessExtension() == 'jpeg' || $newImage->guessExtension() == 'png' || $newImage->guessExtension() == 'gif' || $newImage->guessExtension() == 'webp' || $newImage->guessExtension() == 'jpg') {
					$addImage = new LeaguePicture();
					
					// Check to see if images is too large
					if($newImage->getError() == 1) {
						$fileName = $request->file('team_photo')[0]->getClientOriginalName();
						$error .= "<li class='errorItem'>The file " . $fileName . " is too large and could not be uploaded</li>";
					} elseif($newImage->getError() == 0) {
						// Check to see if images is about 25MB
						// If it is then resize it
						if($newImage->getClientSize() < 25000000) {
							$image = Image::make($newImage->getRealPath())->orientate();
							$path = $newImage->store('public/images');
							
							if($image->save(storage_path('app/'. $path))) {
								// prevent possible upsizing
								// Create a larger version of the image
								// and save to large image folder
								$image->resize(1700, null, function ($constraint) {
									$constraint->aspectRatio();
									// $constraint->upsize();
								});
								
								
								if($image->save(storage_path('app/'. str_ireplace('images', 'images/lg', $path)))) {
									// Get the height of the current large image
									$addImage->lg_height = $image->height();
									
									// Create a smaller version of the image
									// and save to large image folder
									$image->resize(544, null, function ($constraint) {
										$constraint->aspectRatio();
									});
									
									if($image->save(storage_path('app/'. str_ireplace('images', 'images/sm', $path)))) {
										// Get the height of the current small image
										$addImage->sm_height = $image->height();
									}
								}
							}
							
							$addImage->picture_path = str_ireplace('public', 'storage', $path);
							$addImage->league_season_id = $showSeason->id;
							
							if($addImage->save()) {
								$counter++;
							}
						} else {
							// Resize the image before storing. Will need to hash the filename first
							$path = $newImage->store('public/images');
							$image = Image::make($newImage)->orientate()->resize(1500, null, function ($constraint) {
								$constraint->aspectRatio();
								$constraint->upsize();
							});
							
							$image->save(storage_path('app/'. $path));
							$addImage->property_id = $showSeason->id;
							
							if($addImage->save()) {
								$counter++;
							}
						}
					} else {
						$error .= "<li class='errorItem'>The file " . $fileName . " may be corrupt and could not be uploaded</li>";
					}
				} else {
					$error .= "<li class='errorItem'>The file " . $fileName . " may be corrupt and could not be uploaded</li>";
				}
			}
		}

		return redirect()->action('LeaguePictureController@index')->with('status', $counter . ' image(s) uploaded successfully');
    }
	
	/**
     * Delete picture.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaguePicture $league_picture)
    {
		// Get the season to show
		$showSeason = $this->find_season(request());
		
		if($league_picture->delete()) {
			return redirect()->action('LeaguePictureController@index', ['season' => $showSeason->id, 'year' => $showSeason->year])->with('status', 'Picture Deleted Successfully');
		}

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
