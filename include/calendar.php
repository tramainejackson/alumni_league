<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Calendar extends DatabaseObject {
	
	protected static $table_name = "calendar";

	public $month_id;
	public $month_days;
	public $month_name;
	public $day_name;
	
	function __construct() {
		// $this->month = self::find_by_sql("SELECT * FROM calendar_month;");
		// $this->day = self::find_by_sql("SELECT * FROM calendar_day;");
	}
	
	public static function get_day_names() {
		
	}
	
	public static function get_all_months() {
		$months = self::find_by_sql("SELECT * FROM calendar_month;");

		return $months;
	}
	
} ?>