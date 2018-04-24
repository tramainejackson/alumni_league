<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class League_Login extends DatabaseObject {
	
	protected static $table_name = "leagues_logins";
	protected static $db_fields=array('leagues_profile_id', 'leagues_logins_id', 'user_account_id',
		'username', 'password', 'full_name', 'ttr_email', 'email_address', 'last_login');

	protected $leagues_profile_id;
	protected $leagues_logins_id;
	protected $user_account_id;
	protected $username;
	protected $password;
	public $id;
	public $full_name;
	public $last_login;
	public $ttr_email;
	public $email_address;
	
	function __construct() {
		
	}
	
	public function set_league_id($leaguesID=0) {
		$this->leagues_profile_id = $leaguesID;
	}
	
	public function get_league_id() {
		return $this->leagues_profile_id;
	}
	
	public function get_login_id() {
		return $this->leagues_logins_id;
	}
	
	public function set_user_account_id($loginID=0) {
		$this->user_account_id = $loginID;
	}
	
	public function get_user_account_id() {
		return $this->user_account_id;
	}
	
	public function set_username($username="") {
		$this->username = $username;
	}
	
	public function get_username() {
		return $this->username;
	}

	public function set_password($password="") {
		$this->password = $password;
	}
	
	public function get_password() {
		return $this->password;
	}
	
	public function set_last_login() {
		$this->last_login = date("Y-m-d h:i:s");
	}
	
	public static function get_league_users($leagueID=0) {
		$weeks = self::find_by_sql("SELECT * FROM leagues_logins WHERE leagues_profile_id = '".$leagueID."';");
		return $weeks;
	}
	
	public static function get_user_by_username($leagueID=0, $username="") {
		$user = self::find_by_sql("SELECT * FROM leagues_logins WHERE leagues_profile_id = '".$leagueID."' AND username = '".$username."';");
		return $user;
	}
}

?>