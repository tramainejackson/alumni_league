<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\PlayerProfile;
use App\LeagueProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//	    abort(404);
//        $this->middleware('guest');
    }

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function index() {
		// Sub Domain
		$domain = 'leagues.' . parse_url(config('app.url'), PHP_URL_HOST);

		if(strpos(request()->header('host'), $domain) !== false) {
			return view('leagues_sub.auth.register');
		} else {
			return view('auth.register');
		}

		abort(404);
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {
//		 dd($data);
		$user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
		
		if(isset($data['player_profile'])) {
			$user->type = 'player';

			PlayerProfile::create([
				'user_id' => $user->id
			]);
		} else {
			$user->type = 'commish';

			LeagueProfile::create([
				'user_id' => $user->id
			]);
		}

		if($user->save()) {
			return $user;
		}
    }

	public function register() {
	    abort(404);
	}
}
