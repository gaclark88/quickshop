<?php

include_once("Model.php");

class Category extends Model {
	var $fieldnames = array( "name",
			"parent_id"
			);

	function Category($fields) {
		parent::Model($this->fieldnames, $fields, "categories");
	}

	function dbGet($id, $dbLink) {
		$fields = parent::dbGet($id, "categories", $dbLink);

		if (!$fields) {return $fields;}
		
		$category = new Category($fields);
		$category->id = $fields["id"];
		return $category;
	}
	
	function dbGetByName($name, $dbLink) {
		$rows = parent::dbGetby("name", $name, "categories", $dbLink);
		
		$row = mysql_fetch_assoc($rows);
			$category = new Category($row);
			$category->id = $row["id"];
			
		return $category;
	}
	
	function dbGetAll($dbLink) {
		
		$rows = parent::dbGetAll("categories", $dbLink);		

		$categories = array();
	
		while ($row = mysql_fetch_assoc($rows)) {
		$category = new Category($row);
		$category->id = $row["id"];

		array_push($categories, $category);
		}
	
	return $categories;
}	
}
/*
$db = new DatabaseLink();

$c = Category::dbGetByName("Books", $db);
$c->toString();
*/
?>

