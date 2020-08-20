<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Member;
use App\Message;
use App\Service;
use App\NewsArticle;
use App\User;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
	public function __construct() {
		$this->middleware(['auth']);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	    $admin = Auth::user();
	    $messages = Message::all();
	    $services = Service::all();
	    $clients = Client::all();
	    $members = Member::all();
	    $articles = NewsArticle::all();
	    $states = DB::select('select * from states');
	    $today = Carbon::now();

        return view('admin.index', compact('admin', 'clients', 'messages', 'services', 'members', 'states', 'articles', 'today'));
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
//	    dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin) {
//	    dd($admin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin) {

	    $this->validate($request, [
		    'address'   => 'nullable|max:100',
		    'city'      => 'nullable|max:100',
		    'email'     => 'nullable|email|max:50',
		    'zip'       => 'nullable|numeric|digits:5',
		    'state'     => 'nullable|size:2',
		    'phone'     => 'nullable|numeric|digits:10',
	    ]);

	    $admin = Admin::first();
	    $admin->address = $request->address;
        $admin->city = $request->city;
        $admin->email = $request->email;
        $admin->zip = $request->zip;
        $admin->state = $request->state;
        $admin->phone = $request->phone;

        if($admin->save()) {
	        return redirect()->back()->with('status', 'Settings Updated!');
        } else {
	        return redirect()->back()->with('status', 'Settings Not Updated, Please Try Again.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
