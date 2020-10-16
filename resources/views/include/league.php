<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class League_Profile extends DatabaseObject {
	
	protected static $table_name = "leagues_profile";
	protected static $db_fields=array('leagues_profile_id', 'username', 'ttr_league', 'ttr_league_site', 'ttr_email', 'leagues_commish',
		'leagues_address', 'leagues_name', 'leagues_comp', 'leagues_age', 'leagues_fee', 'ref_fee', 'leagues_email', 
		'leagues_phone', 'leagues_website', 'leagues_picture', 'online_stats', 'created_date', 'user_account_id');

	private $id;
	private $username;
	protected $leagues_profile_id;
	protected $user_account_id;
	public $ttr_league;
	public $ttr_league_site;
	public $ttr_email;
	public $leagues_commish;
	public $leagues_address;
	public $leagues_name;
	public $leagues_comp;
	public $leagues_age;
	public $leagues_fee;
	public $ref_fee;
	public $leagues_email;
	public $leagues_phone;
	public $leagues_website;
	public $leagues_picture;
	public $online_stats;
	public $created_date;
	
	function __construct() {
		
	}
	
	public static function get_leagues() {
		$leagues = self::find_by_sql("SELECT * FROM leagues_profile ORDER BY leagues_name;");
			
		return $leagues;
	}
	
	public static function get_leagues_by_age($age) {
		$leagues = self::find_by_sql("SELECT * FROM leagues_profile WHERE leagues_age LIKE '%".$age."%' ORDER BY leagues_name;");
		
		return $leagues;
	}
	
	public static function get_leagues_by_comp($comp) {
		$leagues = self::find_by_sql("SELECT * FROM leagues_profile WHERE leagues_comp LIKE '%".$comp."%' ORDER BY leagues_name;");
		
		return $leagues;
	}
	
	public function get_league_id() {
		return $this->leagues_profile_id;
	}
	
	public static function get_league_by_id($ID=0) {
		$league = self::find_by_sql("SELECT * FROM leagues_profile WHERE leagues_profile_id = '".$ID."' LIMIT 1;");
		return $league;
	}
	
	public static function get_online_stats_leagues() {
		$league = self::find_by_sql("SELECT * FROM leagues_profile WHERE ttr_league = 'Y';");
		return $league;
	}
	
	function find_league_by_username($username) {
		global $connect;
		
		$safe_username = mysqli_real_escape_string($connect, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM leagues_profile ";
		$query .= "WHERE username = '".$safe_username."' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connect, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return false;
		}
	}

	function find_leaguenames() {
		global $connect;
		
		$allNames = array();
		$query  = "SELECT leagues_name ";
		$query .= "FROM leagues_profile;";
		$admin_set = mysqli_query($connect, $query);
		confirm_query($admin_set);
		while($admin = mysqli_fetch_assoc($admin_set)) {
			array_push($allNames, str_ireplace("_", "", str_ireplace(" ", "", strtolower($admin["leagues_name"]))));
		} 
		
		return $allNames;
	}

	function checkNewLeagueName($value) {
		$leagueName2 = $value;
		$leagueNameDupe = find_leaguenames();
		$leagueName = cleanValues(str_ireplace("_", "", str_ireplace(" ", "", trim(strtolower($value)))));
		$errors = 0;
		
		if(!preg_match("/^[A-Za-z0-9' -]{1,50}$/", $leagueName)) {
			$_SESSION['errors'] .= "<li class='error_item'>League name cannot be empty</li>";
			$errors++;
		} elseif(in_array($leagueName, $leagueNameDupe)) {
			$_SESSION['errors'] .= "<li class='error_item'>League name \"".$leagueName2."\" already exist</li>";
			$errors++;
		}
		
		if($errors > 0) {
			return $errors;
		} else {
			return $leagueName2;
		}
	}
	
	function checkNewVideo($filesArray) {
		$addID = find_player_by_username($_SESSION["user"]);
		$target_dir = "../uploads/".$addID["player_id"]."_";
		$target_file = $target_dir . basename($filesArray["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// echo $target_dir;
		// echo $target_file; 
		// Check if image file is a actual image or fake image
		if($filesArray["name"] != "") {
			// Check if file already exists
			if (file_exists($target_file)) {
				$_SESSION["errors"] .= "<li class='errorItem'>Sorry, file already exists.</li>";
				$uploadOk = 0;
			}
			// Check file size
			//Measures in bytes
			if ($filesArray["size"] > 75000000) {
				$_SESSION["errors"] .= "<li class='errorItem'>Sorry, your file is too large. File should be no larger than 750MB</li>";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "avi" && $imageFileType != "mp4" && $imageFileType != "mov" ) {
				$_SESSION["errors"] .= "<li class='errorItem'>Sorry, only MP4, AVI, & MOV files are allowed.</li>";
				$uploadOk = 0;
			}
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$_SESSION["errors"] .= "<li class='errorItem'>Sorry, your file was not uploaded.</li>";
			return false;
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($filesArray["tmp_name"], $target_file)) {
				$_SESSION["message"] .= "<li class='okItem'>Video was uploded successfully</li>";
				return [true, $target_file];
			} else {
				return $filesArray["error"];
			}
		}	
	}
	
	private function createLeagueProfile($arrayValue) {
		global $connect;
		
		$timestamp = date("Y-m-d H:i:s");
		$leagueName = cleanValues($arrayValue[2]);
		$commish = cleanValues($arrayValue[3]);
		$leagueAddress = cleanValues($arrayValue[4]);
		$email = cleanValues($arrayValue[5]);
		$website = cleanValues($arrayValue[7]);
		
		$lastInsertedID = find_last_inserted_id();
		$query  = "INSERT INTO leagues_profile";
		$query .= "(owner_id, username, leagues_name, leagues_commish, leagues_address, leagues_email, leagues_phone, ";
		$query .= "leagues_website, leagues_picture, leagues_comp, leagues_age, leagues_fee, ref_fee, created_date) ";
		$query .= "VALUES ('".$lastInsertedID ."', '".$arrayValue[0]."', '".$leagueName."', '".$commish."','".$leagueAddress."', '".$email."', ";
		$query .= "'".$arrayValue[6]."', '".$website."', 'bball_court.jpg', '".$arrayValue[8]."', '".$arrayValue[9]."', '".$arrayValue[10]."', '".$arrayValue[11]."','".$timestamp."'); ";
		$admin_set = mysqli_query($connect, $query);
		
		if(confirm_query($admin_set)) {
			$_SESSION["message"] .= "League registration successful";
			$_SESSION["loggedInLeague"] = $arrayValue[3];
		} else {
			$_SESSION["errors"] .= "League registration failed";
		}
	}
	
}

?>