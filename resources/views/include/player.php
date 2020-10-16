<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Player_Profile extends DatabaseObject {
	
	protected static $table_name = "player_profile";
	protected static $db_fields=array('player_profile_id', 'username', 'user_account_id', 'player_playground', '$created_date',
		'ttr_player_info', 'ttr_player', 'firstname', 'lastname', 'nickname', 'highschool', 'college', 'height', 
		'weight', 'dob', 'picture', 'video', 'email', 'show_email', '$last_updated');
	protected $id;
	protected $user_account_id;
	protected $username;
	protected $player_profile_id;
	public $player_playground;
	public $ttr_player;
	public $ttr_player_info;
	public $firstname;
	public $lastname;
	public $nickname;
	public $highschool;
	public $college;
	public $height;
	public $weight;
	public $dob;
	public $picture;
	public $video;
	public $email;
	public $show_email;
	public $last_updated;
	public $created_date;
	
	function __construct() {
		
	}
	
	public function get_player_id() {
		return $this->player_profile_id;
	}
	
	public function set_id($ID=0) {
		$this->id = $ID;
	}
	
	public function full_name() {
		return $this->firstname . " " . $this->lastname;
	}
	
	public function get_player_age() {
		$dob = explode("-", $this->dob);
		$currentYear = date("Y");
		$currentDate = strtotime(date_format(date_create("now"), "Y-m-d"));
		$dobThisYear = strtotime(date_format(date_create($currentYear . "-" . $dob[1] . "-" . $dob[2]), "Y-m-d"));
		$dobYear = $dob[0];
		$age1 = $currentYear - $dobYear - 1;
		$age2 = $currentYear - $dobYear;
		
		return $currentDate < $dobThisYear ? $age1 : $age2;
	}
	
	public static function find_player_videos_by_id($ID) {
		$playerVideo = self::find_by_sql("SELECT * FROM videos WHERE player_id ='".$ID."';");
		
		return $playerVideo;
	}
	
	public static function find_player_by_username($username) {
		global $connect;
		
		$safe_username = mysqli_real_escape_string($connect, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM player_profile ";
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
	
	public static function find_player_by_id($ID) {
		$player = self::find_by_sql("SELECT * FROM player_profile WHERE player_profile_id = '".$ID."' LIMIT 1;");
		return $player;
	}

	public static function get_fire_recs() {
		$playerPlaygrounds = self::find_by_sql("SELECT player_playground FROM player_profile WHERE player_playground <> 'NULL';");

		if(!empty($playerPlaygrounds)) {
			$fireRecs = [];
			$returnArray = [];
			foreach($playerPlaygrounds as $playground) {
				$getPlaygrounds = explode("; ", $playground->player_playground);
				for($i=0; $i < count($getPlaygrounds); $i++) { 
					$playgrounds = explode(" ", $getPlaygrounds[$i]);
					array_push($fireRecs, $playgrounds[0]);
				}
			}
		
			//Sort the array by rec name and how many times it was selected
			$orderArray = array_count_values($fireRecs);
			
			//Sort the array again to put the recs selected the most at the beginning
			uasort($orderArray, "sortArray");
			
			//Get the top 3 keys of the array and return them as the fire recs
			$fireRecs = array_keys($orderArray);
			
			//Add top 3 recs to an array
			//Return the top 3 array
			isset($fireRecs[0]) ? array_push($returnArray, $fireRecs[0]) : "";
			isset($fireRecs[1]) ? array_push($returnArray, $fireRecs[1]) : "";
			isset($fireRecs[2]) ? array_push($returnArray, $fireRecs[2]) : "";
			
			return $returnArray;
		
		} else {
			return false;
		}
	}
	
	public static function find_player_profiles() {
		global $connect;
		
		$query  = "SELECT * ";
		$query .= "FROM player_profile ";
		$query .= "ORDER BY created_date ";
		$query .= "LIMIT 20";
		$admin_set = mysqli_query($connect, $query);
		confirm_query($admin_set);
		if($admin_set) {
			return $admin_set;
		} else {
			return null;
		}
		
		mysqli_close($connect);
	}
	
	public static function get_player_profiles_by_letter($letter) {
		$players = self::find_by_sql("SELECT * FROM player_profile WHERE lastname LIKE '".$letter."%' ORDER BY lastname;");
		
		return $players;
	}
	
	public static function get_players_by_search($arrayValues) {
		global $database;
		$values = explode(" ", $arrayValues);
		$totalValues = count($values);
		$parameters = "";
		for($i=0; $i < $totalValues; $i++) {
			$values[$i] = $database->escape_value($values[$i]);
			if(is_numeric($values[$i])) {
				$parameters .= "weight LIKE '%".$values[$i]."%',";
				$parameters .= "height LIKE '%".$values[$i]."%',";
				$parameters .= "nickname LIKE '%".$values[$i]."%',";
			} else {
				$parameters .= "firstname LIKE '%".$values[$i]."%',";
				$parameters .= "lastname LIKE '%".$values[$i]."%',";
				$parameters .= "nickname LIKE '%".$values[$i]."%',";
				$parameters .= "highschool LIKE '%".$values[$i]."%',";
				$parameters .= "college LIKE '%".$values[$i]."%',";
				$parameters .= "height LIKE '%".$values[$i]."%',";
			}
		}
		
		$sqlParameter = str_ireplace(",", " OR ", $parameters);
		$findLastORtoRemove = strrpos($sqlParameter, "OR");
		$sqlParameter = substr_replace($sqlParameter, "", $findLastORtoRemove, 2);
		// echo"<pre>";
		// print_r($totalValues);
		// echo"</pre>";
		
		$player = self::find_by_sql("SELECT * FROM player_profile WHERE ".$sqlParameter." ORDER BY lastname;");

		return $player;
	}
	
	public static function find_recent_added_players() {
		$players = self::find_by_sql("SELECT * FROM player_profile ORDER BY created_date DESC LIMIT 20;");

		return $players;
	}
	
	/*private function checkNewPicture($filesArray) {
		$addID = find_player_by_username($_SESSION["user"]);
		$target_dir = "../uploads/".$addID["player_id"]."_";
		$target_file = $target_dir . basename($filesArray["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if($filesArray["name"] != "") {
			$check = getimagesize($filesArray["tmp_name"]);
			if($check !== false) {
				$_SESSION["message"] .= "<li class='okItem'>File is an image - " . $check["mime"] . ".</li>";
				$uploadOk = 1;
			} else {
				$_SESSION["errors"] .= "<li class='errorItem'>File is not an image.</li>";
				$uploadOk = 0;
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				$_SESSION["errors"] .= "<li class='errorItem'>Sorry, picture already exists.</li>";
				$uploadOk = 0;
			}
			// Check file size
			if ($filesArray["size"] > 2000000) {
				$_SESSION["errors"] .= "<li class='errorItem'>Sorry, your file is too large.</li>";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$_SESSION["errors"] .= "<li class='errorItem'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</li>";
				$uploadOk = 0;
			}
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$_SESSION["errors"] .= "<li class='errorItem'>Sorry, your picture was not uploaded.</li>";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($filesArray["tmp_name"], $target_file)) {
				return [true, $target_file];
			} else {
				return false;
			}
		}
	}
	
	private function createPlayerProfile($arrayValue) {
		global $connect;
		
		$timestamp = date("Y-m-d H:i:s");
		$cleanHeight = cleanValues($arrayValue[8]);
		$cleanHighschool = cleanValues($arrayValue[6]);
		$cleanCollege = cleanValues($arrayValue[7]);
		
		$lastInsertedID = find_last_inserted_id();
		$query  = "INSERT INTO player_profile ";
		$query .= "(owner_id, firstname, lastname, nickname, highschool, ";
		$query .= "college, height, weight, email, picture, username, created_date) ";
		$query .= "VALUES ('".$lastInsertedID ."', '".$arrayValue[2]."', '".$arrayValue[3]."', '".$arrayValue[4]."','".$cleanHighschool."', '".$cleanCollege."', ";
		$query .= "'".$cleanHeight."', '".$arrayValue[9]."', '".$arrayValue[5]."', '../uploads/emptyface.jpg', '".$arrayValue[0]."','".$timestamp."');";
		echo $query;
		$admin_set = mysqli_query($connect, $query);
		
		if(confirm_query($admin_set)) {
			$_SESSION["message"] .= "Player registration successful";
			$_SESSION["loggedInPlayer"] = $arrayValue[2] . " " . $arrayValue[3];
			return true;
		} else {
			$_SESSION["errors"] .= "Player registration failed";
			return false;
		}
	}
	
	private function createPlayerPage() {
		$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
		$filename = $DOCUMENT_ROOT."/players/".$player_id."_".$firstname."_".$lastname.".php";
		$new = file_exists($filename) ? false : true;

		if($new) {
			$template = file_get_contents($DOCUMENT_ROOT."/player_template.php");
			$template = str_ireplace("*TripLocation*", $location, $template);
			$template = str_ireplace("*TripLocationID*", str_ireplace(" ", "_", strtolower($location)), $template);
			file_put_contents($filename, $template);
		} else {
				echo "Unable to create file, this account already exist";
		}
	}*/
}

?>