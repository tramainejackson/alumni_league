<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');
require_once('session.php');

class DatabaseObject {
	
	// Common Database Methods
	public static function find_all($company_id=0) {
		return static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE company_id = '".$company_id."' ORDER BY ".static::$table_name."_id DESC;");
	}
	
	public static function find_by_id($id=0) {
		$result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE ".static::$table_name."_id='".$id."' LIMIT 1");
		return !empty($result_array) ? $result_array : false;
	}
	
	public static function find_by_sql($sql="") {
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		$object;
		
		if($result_set->num_rows == 1) {
			while($row = $database->fetch_array($result_set)) {
				$object = static::instantiate($row);
			}
			return $object;
		} else {
			while ($row = $database->fetch_array($result_set)) {
			  $object_array[] = static::instantiate($row);
			}
			
			return $object_array;
		}
	}
	
	public static function checkNewPicture($filesArray) {
		global $session;
		global $message;
		// $addID = find_player_by_username($_SESSION["user"]);
		// echo"<pre>";
		// print_r($filesArray);
		// echo"</pre>";
		$target_dir = "../uploads/";
		$target_file = $target_dir . basename($filesArray['name']);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if($filesArray['name'] != "") {
			$check = getimagesize($filesArray["tmp_name"]);
			if($check !== false) {
				// $message->success("<li>File is an image - " . $check["mime"] . ".</li>");
				$uploadOk = 1;
			} else {
				$session->error("<li>File is not an image.</li>");
				$uploadOk = 0;
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				$session->error("<li>Sorry, picture already exists. (".$filesArray['name'].")</li>");
				$uploadOk = 0;
			}
			// Check file size
			if ($filesArray["size"] > 2000000) {
				$session->error("<li>Sorry, your file is too large.</li>");
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$session->error("<li>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</li>");
				$uploadOk = 0;
			}
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			// $message->error("<li>Sorry, your picture was not uploaded.</li>");
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($filesArray["tmp_name"], $target_file)) {
				return $target_file;
			} else {
				return false;
			}
		}
	}
	
	public static function checkNewPassword($value1="", $value2="") {
		global $message;
		$password = [$value1, $value2];
		$errors = 0;
		
		if($password[0] == "" || $password[1] == "") {
			$message->error("<li class='errorItem'>Password / Confirm Password cannot be empty</li>");
			$errors++;
		} if($password[0] != $password[1]) {
			$message->error("<li class='errorItem'>Your passwords did not match. Please re-enter your passwords</li>");
			$errors++;
		} if(strlen($password[0]) < 7) {
			$message->error("<li class='errorItem'>Password must be atleast 7 characters long</li>");
			$errors++;
		} if(!preg_match("/[A-Za-z0-9]{7,50}/", $password[0]) && $password[0] != "") {
			$message->error("<li class='errorItem'>Password must contain only letter's and numbers</li>");
			$errors++;
		} if(!preg_match("/[A-Za-z]+/", $password[0]) && $password[0] != "") {
			$message->error("<li class='errorItem'>Password must contain at least one letter</li>");
			$errors++;
		} if(!preg_match("/[0-9]+/", $password[0]) && $password[0] != "") {
			$message->error("<li class='errorItem'>Password must contain at least one number</li>");
			$errors++;
		} if($errors > 0) {
			return $errors;
		} else {
			return $password[0];
		}
	}
	
	public static function count_all() {
		global $database;
		$sql = "SELECT COUNT(*) FROM ".static::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	private static function instantiate($record) {
		// Could check that $record exists and is an array
		$object = new static;
		
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
			$object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // get_object_vars returns an associative array with all attributes 
	  // (incl. private ones!) as the keys and their current values as the value
	  $object_vars = get_object_vars($this);
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $object_vars);
	}
	
	private function cleanValues($values) {
		global $database;
		$returnValue = null;
		
		if(is_array($values)) {
			$returnValue = array();
			$arrayValues = $values;
			
			for($i=0; $i < count($arrayValues); $i++) {
				$newValue = $database->escape_value(trim($arrayValues[$i]));
				array_push($returnValue, $newValue);
			}
		} else {
			$returnValue = "";
			$returnValue = $database->escape_value(trim($values));
		}
		
		return $returnValue;
	}
	
	protected function attributes() { 
		// return an array of attribute names and their values
		$attributes = array();
		foreach(static::$db_fields as $field) {
			if(property_exists($this, $field)) {
				if($this->$field == "" || $this->$field == null) {				
					//Skip adding db field is value is empty
				} else {
					$attributes[$field] = $this->$field;
				}
			}
		}
		return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		if($database->query($sql)) {
			$this->id = $database->insert_id();
			return true;
		} else {
			return false;
		}
	}
	public function update() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			if($value == "" || $value == null) {
				// Skip adding empty fields to update SQL query
			} else {
				if($value == 'NULL') {
					$attribute_pairs[] = "{$key}={$value}";
				} else {
					$attribute_pairs[] = "{$key}='{$value}'";
				}
			}
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE ". static::$table_name ."_id='". $database->escape_value($this->id) . "';";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
		$tableID = static::$table_name . "_id";
		$sql = "DELETE FROM ".static::$table_name;
		$sql .= " WHERE ".static::$table_name."_id=". $database->escape_value($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}
}
?>