<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

class Video extends DatabaseObject {
	
	protected static $table_name = "videos";
	protected static $db_fields=array('upload_id', 'player_id', 'file', 'name', 'nickname',
		'upload_date');

	private $id;
	protected $upload_id;
	protected $player_id;
	protected $file;
	public $name;
	public $nickname;
	public $upload_date;
	public $total = 0;
	
	function __construct() {
		
	}
	
	public function get_player_id() {
		return $this->player_id;
	}
	
	public function get_upload_id() {
		return $this->upload_id;
	}
	
	public function get_filename() {
		return $this->file;
	}
	
	public static function find_player_videos_by_id($ID) {
		$playerVideo = self::find_by_sql("SELECT * FROM videos WHERE player_id ='".$ID."';");
		
		return $playerVideo;
	}
	
	public static function find_all_videos() {
		$videos = self::find_by_sql("SELECT * FROM videos ORDER BY upload_date DESC LIMIT 5;");
		return $videos;
	}
	
	public static function find_videos_range($ID) {
		global $connect;
		
		$begRange = $ID - 1;
		$endRange = 0;
		if(($begRange - 10) < 1) {
			$endRange = 0;
		} else {
			$endRange = $begRange - 10;
		}
		$query  = "SELECT * FROM ";
		$query .= "videos ";
		$query .= "WHERE upload_id BETWEEN ".$endRange." AND ".$begRange.";";
		$admin_set = self::find_by_sql($query);
		
		return $admin_set;
	}
	
	public static function find_video_by_id($ID) {
		global $connect;
		
		$query  = "SELECT * FROM ";
		$query .= "videos ";
		$query .= "WHERE upload_id='".$ID."';";
		$admin_set = mysqli_query($connect, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}
	
	public static function find_user_videos($username) {
		global $connect;
		
		$id = find_player_by_username($username);
		
		$query  = "SELECT * ";
		$query .= "FROM videos ";
		$query .= "WHERE player_id ='".$id["player_id"]."' ";
		$query .= "ORDER BY upload_date ";
		$query .= "LIMIT 20";
		
		$admin_set = mysqli_query($connect, $query);
		confirm_query($admin_set);
		if($admin_set) {
			return $admin_set;
		} else {
			return null;
		}
	}

}

?>