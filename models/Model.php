<?php

include_once("DatabaseLink.php");

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

		echo $query;

		$dbLink->queryDB($query, $_SERVER["SCRIPT_NAME"]);
		
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

		echo $queryString;

		$result =  $dbLink->queryDB($queryString, $_SERVER["SCRIPT_NAME"]);
		if (!$result) { return $result; }

		$this->id = mysql_insert_id($dbLink->connection);
	}

	/*
	 * get model from db by a specific field
	 */
	function dbGetBy($field, $key, $table, $dbLink) {
		$query = "SELECT * FROM ". $table . " WHERE " .
			$field . "='" .
			$key . "';";

		//echo $query;

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
?>