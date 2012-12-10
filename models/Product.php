<?php

include_once("Model.php");
include_once("Image.php");

class Product extends Model {
	var $fieldnames = array( "name",
			"description",
			"price",
			"inventory",
			"image_id",
			"thumbnail_id",
			"category_id",
			);
	var	$misc = NULL;

	function Product($fields) {
		parent::Model($this->fieldnames, $fields, "products");
	}

	function dbGet($id, $dbLink) {
		$fields = parent::dbGet($id, "products", $dbLink);

		if (!$fields) {return $fields;}
		
		$product = new Product($fields);
		$product->id = $fields["id"];
		return $product;
	}
	
	function dbGetBy($field, $key, $dbLink) {
		$rows = parent::dbGetBy($field, $key, "products", $dbLink);		

		$products = array();
		
		while ($row = mysql_fetch_assoc($rows)) {
			$product = new Product($row);
			$product->id = $row["id"];
			
			array_push($products, $product);
		}
		
		return $products;
	}

	function dbGetAll($table, $dbLink) {
		$rows = parent::dbGetAll($table, $dbLink);		

		$products = array();
		
		while ($row = mysql_fetch_assoc($rows)) {
			$product = new Product($row);
			$product->id = $row["id"];
			$product->misc = $row["category"];
			
			array_push($products, $product);
		}
		
		return $products;
	}	
	
	/*
	 * get the associated image for this product
	 */
	function dbGetImage($dbLink) {
		if ($this->id == NULL || $this->fields['image_id'] == NULL) {
			
			return NULL;
		}
		
		return Image::dbGetByProductId($this->id, $dbLink);
	}
	
	function toString() {
		echo $this->fields["name"] . "<br />";
	}
}



//$db = new DatabaseLink();
//$test = Product::dbGet(43, $db);
#print_r($test->fields);
//$a = Product::dbGetBy("category_id", 3, $db);

//echo count($a) . "<br />";

//foreach ($a as $p) {
//	$p->toString();
//}

//$test->toString();
//$im = $test->dbGetImage($db);

//$h = array("name" => "Test Name", "id" => "33");

//header("Content-Type: " . $im->fields["mime_type"]);
//echo $im->fields['file_data'];
?>
