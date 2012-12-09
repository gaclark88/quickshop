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
$db = new DatabaseLink();

echo "Testing Account constructor <br /><br />";
$fields = array ( "first_name" => "Joe",
		"last_name" => "Shmoe",
		"email" => "joe@shmoe.com",
		"password" => "greatpassword",
		"phone" => 1234567890,
		"shipping_address" => "1220 second street",
		"shipping_city" => "New Townlandville",
		"shipping_state" => "VA",
		"shipping_zip" => 22222,
		"billing_address" => "1224 first street",
		"billing_city" => "Pittsburgh",
		"billing_state" => "PA",
		"billing_zip" => 22587
		);
$first = new Account($fields);
print_r($first->fields);
echo "<br /><br />";


echo "Testing dbGetByEmail <br /><br />";
$b = Account::dbGetByEmail("peter@host.com", $db);
print_r($b->fields);
echo "<br />";

echo "Testing checkPwd when good pass<br /><br />";
$correct = $b->checkPwd(12345);
if ($correct === null ) {
	echo "Invalid Email";
} else if ($correct) {
	echo "pass confirm <br />";
} else {
	echo "invalid password <br />";
}
echo "<br />";

echo "Testing checkPwd when bad pass<br /><br />";
$correct = $b->checkPwd("jkadjf");
if ($correct === null ) {
	echo "Invalid Email";
} else if ($correct) {
	echo "pass confirm <br />";
} else {
	echo "invalid password <br />";
}
echo "<br />";

echo "Testing dbCheckPwd when good pass<br /><br />";
$correct = Account::dbCheckPwd("peter@host.com","12345", $db);
if ($correct === null ) {
	echo "Invalid Email";
} else if ($correct) {
	echo "pass confirm <br />";
} else {
	echo "invalid password <br />";
}
echo "<br />";

echo "Testing dbCheckPwd when bad pass<br /><br />";
$correct = Account::dbCheckPwd("peter@host.com","jdk", $db);
if ($correct === null ) {
	echo "Invalid Email";
} else if ($correct) {
	echo "pass confirm <br />";
} else {
	echo "invalid password <br />";
}
echo "<br />";

echo "Testing dbCheckPwd when bad email<br /><br />";
$correct = Account::dbCheckPwd("peter@hst.com","12345", $db);
if ($correct === null ) {
	echo "Invalid Email";
} else if ($correct) {
	echo "pass confirm <br />";
} else {
	echo "invalid password <br />";
}
echo "<br />";

echo "Testing dbGetBy<br /><br />";
$list = Account::dbGetBy("billing_city", "Elkridge", $db);
echo count($list) . " Accounts found<br />";
foreach ($list as $account) {
	print_r($account->fields);
	echo "<br />";
}

echo "Testing inserting a model<br /><br />";
$fields = array ( "first_name" => "Joe",
		"last_name" => "Shmoe",
		"email" => "joe@shmoe.com",
		"password" => "greatpassword",
		"phone" => 1234567890,
		"shipping_address" => "1220 second street",
		"shipping_city" => "New Townlandville",
		"shipping_state" => "VA",
		"shipping_zip" => 22222,
		"billing_address" => "1224 first street",
		"billing_city" => "Pittsburgh",
		"billing_state" => "PA",
		"billing_zip" => 22587
		);

$a = new Account($fields);
$a->dbSave($db);

$a = Account::dbGetByEmail("joe@shmoe.com", $db);
$a->toSTring();
echo "<br />";
*/
/*
$a->fields["phone"] = 9876543210;
$a->fields["password"] = Account::hashPassword("12345");
$a->dbSave($db);

$a = Account::dbGetByEmail("joe@shmoe.com", $db);
$a->toString();
$correct = $a->checkPwd("12345");
if ($correct === null ) {
	echo "Invalid Email";
} else if ($correct) {
	echo "pass confirm <br />";
} else {
	echo "invalid password <br />";
}
echo "<br />";
*/


//$db = new DatabaseLink();
//$a = Account::dbGetByEmail("peter@hst.com", $db);
//if ($a === null ) {
//	echo "Its null";
//}


/*
$db = new DatabaseLink();
$correctPwd = Account::dbCheckPwd("peter@host.com", "12345", $db);
*/

/*
$db = new DatabaseLink();
$a = Account::dbGet(12345, $db);

if ($a === null ) {
	echo "Its null";
} else if ($correctPwd) {
	echo "true <br />";
} else {
	echo "false <br />";
}
*/
?>
