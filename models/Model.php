<?php

include_once("DatabaseLink.php");

/*
 * A Class for manipulating models in the db
 */
class Model {
	var $fields = array();
	var $table;
	var $fieldnames = array();
	var $id = NULL;
	

	function Model($fieldnames, $fields, $tablename) {
		foreach ($fields as $field => $value) {
			if (in_array($field, $fieldnames)) {
				$this->fields[$field] = $value;
			}
		}
		
		$this->table = $tablename;
	}

	/*
	 * save model in database by insert or update
	 */
	function dbSave($dbLink) {
		if ($this->id) {
			return $this->dbUpdate($dbLink);
		} else {
			return $this->dbInsert($dbLink);
		}
	}

	function updateArray($a, $b) {
		$db = new DatabaseLink();
		$db = $db->connection;
		return $a . "='" . mysql_real_escape_string($b, $db) ."'";
	}
	
	function dbUpdate($dbLink) {
		$query = "UPDATE " . $this->table . " SET ";
		$query = $query . implode(
			", ",
			array_map(
				array($this, 'updateArray'), 
				array_keys($this->fields), 
				array_values($this->fields)
			)
		);

		$query = $query . " WHERE id='" . $this->id . "';";

		//echo $query;

		return $dbLink->queryDB($query, $_SERVER["SCRIPT_NAME"]);
		
	}

	function map_escape_string($array, $dbLink) {
		$a = array();
		foreach($array as $value) {
			array_push($a, mysql_real_escape_string($value, $dbLink->connection));
		}

		return $a;
	}


 
	function dbInsert($dbLink) {
		$queryString = "INSERT INTO " . $this->table .  " (`";
		$queryString = $queryString . 
			implode("`, `", array_keys($this->fields)) . "`) ";
		
		$queryString = $queryString . "VALUES ('";
		$queryString = $queryString .
			implode("', '", 
				$this->map_escape_string(
					array_values($this->fields), 
					$dbLink
				)
			) . "'); ";

		// echo $queryString;

		$result =  $dbLink->queryDB($queryString, $_SERVER["SCRIPT_NAME"]);
		if (!$result) { return $result; }
		
		//return true if successfully edited
		else{
			$this->id = mysql_insert_id($dbLink->connection);
			return $result;
		}
	}
	
	/* delete from db based on some value */
	/* USE WITH CAUTION */
	function dbDelete($table, $field, $value, $dbLink) {
		
		$queryString = "DELETE FROM " . $table . 
						" WHERE " . $field . " IN ('" . $value . "');";
		//echo $queryString;
		 
		$status =  $dbLink->queryDB($queryString, $_SERVER["SCRIPT_NAME"]);
		return $status;
	}

	/*
	 * get model from db by a specific field
	 */
	function dbGetBy($field, $key, $table, $dbLink) {
		$query = "SELECT * FROM ". $table . " WHERE " .
			$field . " IN('" .
			$key . "');";

		// echo $query;

		return $dbLink->queryDB($query, $_SERVER["SCRIPT_NAME"]);
		
	}
	
	/*
	* select all fields from a table
	*/
	function dbGetAll($table, $dbLink) {
		$query = "SELECT * FROM ". $table . " ORDER BY 1;";

		//echo $query;

		return $dbLink->queryDB($query, $_SERVER["SCRIPT_NAME"]);
		
	}
	
	/*
	* select all fields from a table in list
	*/
	function dbGetAllInList($table, $field, $keys, $dbLink) {
		$query = "SELECT * FROM ". $table . " WHERE ".
			$field . " IN (".
			"'".implode("', '", $keys)."')";
		
		// echo $query;

		return $dbLink->queryDB($query, $_SERVER["SCRIPT_NAME"]);
		
	}
	
	/*
	 * special case of dbGetBy for fetching a model by it id (primary key)
	 */
	function dbGet($id, $table, $dbLink) {
		$result = Model::dbGetBy("id", $id, $table, $dbLink);

		if (!$result) { return $result; }
		
		return mysql_fetch_assoc($result);
	}

	function toString() {
		foreach ($this->fields as $field => $value) {
			echo $field . " => " . $value . "<br />";
		}
	}
}
/*
$db = new DatabaseLink();
$m = Model::dbGetBy("category_id", 1, "products",$db);

while ($row = mysql_fetch_assoc($m)) {
	print_r($row);
	echo "<br /><br />";
}
*/
?>
