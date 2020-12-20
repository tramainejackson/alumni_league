<?php

namespace App\Http\Controllers\Auth;

use App\LeagueProfile;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

	use AuthenticatesUsers;

	public $showSeason;
	
	/**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/league_seasons';
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');

	    $this->showSeason = LeagueProfile::find(2)->seasons()->showSeason();
    }

	public function get_season() {
		return $this->showSeason;
	}
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showLoginForm(Request $request) {
	    $showSeason = $this->showSeason;

        return view('auth.login', compact('showSeason'));
    }

	public function username() {
		return 'username';
	}

	/**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request) {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => 'Y'])) {
	        // Authentication passed...
        	$user = Auth::user();
	        $user->last_login = Carbon::now();

	        if($user->save()) {
		        return redirect()->intended('league_seasons');
	        }

        } else {
			return redirect()->back()->with(['errors' => 'The username/password combination you entered is incorrect.']);
		}
    }
}
