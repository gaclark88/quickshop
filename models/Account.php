<?php

include_once("Model.php");

class Account extends Model {
	var $fieldnames = array( "first_name",
			"last_name",
			"email",
			"password",
			"phone",
			"shipping_address",
			"shipping_city",
			"shipping_state",
			"shipping_zip",
			"billing_address",
			"billing_city",
			"billing_state",
			"billing_zip"
			);

	function Account($fields) {
		parent::Model($this->fieldnames, $fields, "accounts");
		
		$this->fields["password"] = $this->hashPassword($this->fields["password"]);
	}

	function hashPassword($pwd) {
		return crypt($pwd); 
	}

	function checkPwd($input) {
		return crypt($input, $this->fields["password"]) == $this->fields["password"];
		
	}
	
	function dbCheckPwd($email, $pwd, $db) {
		$account = Account::dbGetByEmail($email, $db);

		if ($account === null) {
			return null;
		}

		return $account->checkPwd($pwd);
	}

	function dbGet($id, $dbLink) {
		$fields = parent::dbGet($id, "accounts", $dbLink);

		if (!$fields) {return $fields;}
		
		$account = new Account($fields);
		$account->id = $fields["id"];
		$account->fields["password"] = $fields["password"];
		return $account;
	}	
	
	function dbGetBy($field, $key, $dbLink) {

		
		if($field == null && $key == null){
			$rows = parent::dbGetAll("accounts", $dbLink);
		}
		else{
			$rows = parent::dbGetBy($field, $key, "accounts", $dbLink);		
		}
		
		if (count($rows) < 1) {
			return null;
		}
			
		$accounts = array();
		
		while ($row = mysql_fetch_assoc($rows)) {
			$account = new Account($row);
			$account->id = $row["id"];
			$account->fields["password"] = $row["password"];
			
			array_push($accounts, $account);
		}
		
		return $accounts;
	}	

	function dbGetByEmail($email, $dbLink) {
		$rows = parent::dbGetBy("email", $email, "accounts", $dbLink);

		if (count($rows) < 1) {
			return null;
		}

		$fields = mysql_fetch_assoc($rows);

		if (!$fields) {
			return null;
		}		

		$account = new Account($fields);
		$account->id = $fields["id"];
		$account->fields["password"] = $fields["password"];
	
		return $account;
	}
			
			

}
/*
$fields = array ( "first_name" => "Greg",
		"last_name" => "Clark",
		"email" => "greg2@yahoo.com",
		"password" => "1098765",
		"phone" => 5554443333,
		"shipping_address" => "1224 first street",
		"shipping_city" => "Pittsburgh",
		"shipping_state" => "PA",
		"shipping_zip" => 22587,
		"billing_address" => "1224 first street",
		"billing_city" => "Pittsburgh",
		"billing_state" => "PA",
		"billing_zip" => 22587
		);

$a = new Account($fields);

$db = new DatabaseLink();
$a->dbSave($db);

//$db = new DatabaseLink();
//$a = Account::dbGetByEmail("peter@hst.com", $db);
//if ($a === null ) {
//	echo "Its null";
//}
//$correctPwd = $a->checkPwd("12345");
//$correctPwd = Account::dbCheckPwd("peter@host.co", "2345", $db);
/*
if ($correctPwd === null ) {
	echo "Its null";
} else if ($correctPwd) {
	echo "true <br />";
} else {
	echo "false <br />";
}
*/
?>
