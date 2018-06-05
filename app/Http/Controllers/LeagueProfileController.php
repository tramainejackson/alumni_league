<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeagueProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class LeagueProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leagues = LeagueProfile::all();
		
		return view('leagues.index', compact('leagues'));
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
    public function show(LeagueProfile $league)
    {
		return view('leagues.show', compact('league'));
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
			'leagues_fee' => 'required|nullable|',
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
		$league->age = implode(' ', $request->age);
		$league->comp = implode(' ', $request->leagues_comp);
		
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
			return redirect()->back()->with(['status' => '<li class="">Leagues Information Updated Successfully</li>']);
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
}
