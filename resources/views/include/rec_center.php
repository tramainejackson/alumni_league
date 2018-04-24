<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Rec_Center extends DatabaseObject {
	
	protected static $table_name = "rec_profile";
	protected static $db_fields=array('recs_id', 'recs_name', 'recs_nickname', 'recs_owner',
		'recs_address', 'recs_website', 'indoor', 'outdoor', 'fee', 'recs_phone');

	private $id;
	public $recs_id;
	public $recs_name;
	public $recs_nickname;
	public $recs_owner;
	public $recs_address;
	public $recs_website;
	public $indoor;
	public $outdoor;
	public $fee;
	public $recs_phone;
	
	function __construct() {
		
	}
	
	public static function get_rec_centers() {
		$recs = self::find_by_sql("SELECT * FROM rec_profile ORDER BY recs_name;");

		return $recs;
	}
	
}

?>