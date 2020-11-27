<?php

namespace App\Http\Controllers;

use App\Message;
use App\LeagueProfile;
use App\PlayerProfile;
use App\LeagueRule;
use App\LeagueSchedule;
use App\LeagueStanding;
use App\LeaguePlayer;
use App\LeagueTeam;
use App\LeagueStat;
use App\LeagueSeason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessagesController extends Controller
{

	public $showSeason;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth')->except('store');

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
	    $admin = Auth::user();
	    $messages = Message::all();
	    $today = Carbon::now();

	    return view('messages.index', compact('admin', 'messages', 'today', 'showSeason'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
	    $showSeason = $this->showSeason;
	    $admin = Auth::user();

	    return view('messages.create', compact('admin', 'showSeason'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
//    	dd($request);
	    $this->validate($request, [
		    'first_name' => 'required',
		    'last_name' => 'required',
		    'email' => 'required',
		    'message' => 'required',
	    ]);

		$message = new Message();

	    $message->name      = $request->first_name . ' ' . $request->last_name;
	    $message->email     = $request->email;
	    $message->phone     = $request->phone;
	    $message->message   = $request->message;

	    if($message->save()) {
	    	return redirect()->back()->with('status', 'Message sent successfully');
	    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message) {
	    if($message->delete()) {
		    return redirect()->action('MessagesController@index')->with('status', 'Message Deleted Successfully!');
	    }
    }
}
