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
			"category_id"
			);

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
	
	function dbGetImage($dbLink) {
		if ($this->id == NULL) {
			return NULL;
		}
		
		return Image::dbGet($this->fields["image_id"], $dbLink);
	}
	
	function toString() {
		echo $this->fields["name"] . "<br />";
	}
}


$db = new DatabaseLink();
$test = Product::dbGet(45, $db);
$a = Product::dbGetBy("category_id", 3, $db);

echo count($a) . "<br />";

foreach ($a as $p) {
	$p->toString();
}

//$test->toString();
//$im = $test->dbGetImage($db);

//$h = array("name" => "Test Name", "id" => "33");

//header("Content-Type: " . $im->fields["mime_type"]);
//echo $im->fields['file_data'];

?>
