<?php

include_once("Model.php");

class Admin extends Model {
	var $fieldnames = array("email",
							"password"
			);

	function Admin($fields) {
		parent::Model($this->fieldnames, $fields, "admins");
		
		$this->fields["password"] = $this->hashPassword($this->fields["password"]);
	}

	function hashPassword($pwd) {
		return crypt($pwd); 
	}

	function checkPwd($input) {
		return crypt($input, $this->fields["password"]) == $this->fields["password"];
		
	}
	
	function dbCheckPwd($email, $pwd, $db) {
		$account = Admin::dbGetByEmail($email, $db);

		if ($account === null) {
			return null;
		}

		return $account->checkPwd($pwd);
	}

	function dbGet($id, $dbLink) {
		$fields = parent::dbGet($id, "admins", $dbLink);

		if (!$fields) {return $fields;}
		
		$account = new Admin($fields);
		$account->id = $fields["id"];
		$account->fields["password"] = $fields["password"];
		return $account;
	}	
	
	function dbGetBy($field, $key, $dbLink) {

		
		if($field == null && $key == null){
			$rows = parent::dbGetAll("admins", $dbLink);
		}
		else{
			$rows = parent::dbGetBy($field, $key, "admins", $dbLink);		
		}
		
		if (count($rows) < 1) {
			return null;
		}
			
		$accounts = array();
		
		while ($row = mysql_fetch_assoc($rows)) {
			$account = new Admin($row);
			$account->id = $row["id"];
			$account->fields["password"] = $row["password"];
			
			array_push($accounts, $account);
		}
		
		return $accounts;
	}	

	function dbGetByEmail($email, $dbLink) {
		$rows = parent::dbGetBy("email", $email, "admins", $dbLink);

		if (count($rows) < 1) {
			return null;
		}

		$fields = mysql_fetch_assoc($rows);

		if (!$fields) {
			return null;
		}		

		$account = new Admin($fields);
		$account->id = $fields["id"];
		$account->fields["password"] = $fields["password"];
	
		return $account;
	}
			
			

}
?>
