<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
	
	/**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'ttr_user']);
    }
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        return view('auth.login');
    }
	
	
	/**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
			// Once authenticated, make sure this is a
			// league account with totherec
			$user = Auth::user();

			if($user->leagues_profiles->where('user_id', Auth::id())->isNotEmpty()) {
				$league = $user->leagues_profiles->where('user_id', Auth::id())->first();
				
				if($user->type == 'commish') {
					session()->put(['user' => 'commish', 'commish' => $user->id]);
				}
				
				return redirect()->action('HomeController@index');
			} else {
				// This needs to redirect the player to the regular totherec site
				// and log them into their player account
				Auth::logout();
				
				return redirect()->back()->with(['errors' => 'The username/password combination you entered is incorrect.']);
			}
			
        } else {
			return redirect()->back()->with(['errors' => 'The username/password combination you entered is incorrect.']);
		}
    }
}
