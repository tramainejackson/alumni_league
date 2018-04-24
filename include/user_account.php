<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

class User_Account extends DatabaseObject {
	
	protected static $table_name = "user_account";
	protected static $db_fields=array('owner_id', 'username', 'password', 'created_date', 'last_login', 'admin');
	
	public $id;
	protected $username;
	protected $password;
	protected $user_account_id;
	protected $last_login;
	protected $admin;
	
	public function set_last_login() {
		$this->last_login = date("Y-m-d h:i:s");
	}
	
	public function get_last_login() {
		return $this->last_login;
	}
	
	public function get_username() {
		return $this->username;
	}
	
	public function get_password() {
		return $this->password;
	}
	
	public function get_user_account_id() {
		return $this->user_account_id;
	}
	
	private function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = password_verify($password, $existing_hash);
	  if ($hash === true) {
	    return true;
	  } else {
	    return false;
	  }
	}
	
	public static function authenticate($username="", $password="") {
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);

		$sql  = "SELECT * FROM ".static::$table_name." ";
		$sql .= "WHERE username = '".$username."' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);

		if(!empty($result_array)) {
			$verify_password = self::password_check($password, $result_array->password);
			
			if($verify_password != false) {
				// $ = self::
				// $sql  = "UPDATE ".static::$table_name." ";
				// $sql .= "SET last_login = '".date("Y-m-d h:i:s")."' ";
				// $sql .= "WHERE username = '".$username."';";
				// $database->query($sql);
				return $result_array;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

}

?>