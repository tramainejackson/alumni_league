<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecCenter;
use App\PlayerProfile;
use App\LeagueProfile;

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
    public function update(Request $request, LeagueProfile $league)
    {
		// Validate incoming data
		$this->validate($request, [
			'name' => 'required|max:50:unique:league_profile',
			'commish' => 'required|max:100',
			'leagues_fee' => 'required|nullable|',
			'ref_fee' => 'numeric|nullable',
		]);
		
		$league->name = $request->leagues_name;
		$league->commish = $request->leagues_commish;
		$league->address = $request->leagues_address;
		$league->phone = $request->leagues_phone;
		$league->leagues_email = $request->leagues_email;
		$league->leagues_website = $request->leagues_website;
		$league->leagues_fee = $request->leagues_fee;
		$league->ref_fee = $request->ref_fee;
		$league->age = implode(' ', $request->age);
		$league->comp = implode(' ', $request->leagues_comp);
		
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
