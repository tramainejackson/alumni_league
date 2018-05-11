<?php

namespace App\Http\Controllers;

use App\PlayerProfile;
use App\LeagueProfile;
use App\LeagueSchedule;
use App\LeagueStanding;
use App\LeaguePlayer;
use App\LeagueTeam;
use App\LeagueStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{	

    public function __construct()
    {
        
    }

    public function about_us()
    {	
		return view('templates.about-us');
    }

    public function blog_post()
    {	
		return view('templates.blog-post');
    }

    public function contact_us()
    {	
		return view('templates.contact-us');
    }
	
	public function ecommerce()
    {	
		return view('templates.ecommerce');
    }
	
	public function log_in()
    {	
		return view('templates.login-page');
    }
	
	public function pricing()
    {	
		return view('templates.pricing');
    }	
	
	public function profile_page()
    {	
		return view('templates.profile-page');
    }
	
	public function signup()
    {	
		return view('templates.signup-page');
    }
	
	public function landing()
    {	
		return view('templates.landing-page');
    }
}
