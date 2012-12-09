<?php
	
	include '../models/Admin.php';
	
	$conn = new DatabaseLink();
	$fields['email'] = "admin@quickshop.com";
	$fields['password'] = "admin123";
	$admin = new Admin($fields);
	
	$status = $admin->dbSave($conn);
	
	if($status){
		echo "Account Created";
	}
	else{
		echo "Could not create account. Try again";
	}


?>