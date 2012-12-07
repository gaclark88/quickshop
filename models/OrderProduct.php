<?php

include_once("Model.php");

class OrderProduct extends Model {
	var $fieldnames = array( "product_id",
			"order_id",
			"amount"
			);

	function OrderProduct($fields) {
		parent::Model($this->fieldnames, $fields, "order_products");
	}

	function dbGet($id, $dbLink) {
		$fields = parent::dbGet($id, "order_products", $dbLink);

		if (!$fields) {return $fields;}
		
		$order_product = new OrderProduct($fields);
		$order_product->id = $fields["order_id"];
		return $order_product;
	}	
	
	function dbGetBy($field, $key, $dbLink) {
		$rows = parent::dbGetBy($field, $key, "order_products", $dbLink);		

		$order_products = array();
		
		while ($row = mysql_fetch_assoc($rows)) {
			$order_product = new OrderProduct($row);
			$order_product->id = $row["order_id"];
			
			array_push($order_products, $order_product);
		}
		
		return $order_products;
	}	
	
	function dbGetByOrderIdProductId($order_id, $product_id, $dbLink) {
		$query = "SELECT * FROM order_products WHERE product_id=" . 
			$product_id . " AND " . "order_id=" . 
			$order_id . ";";

		$rows = $dbLink->queryDB($query, $_SERVER["SCRIPT_NAME"]);
		
		$fields = array();
		
		if (!($fields = mysql_fetch_assoc($rows))) { 
			$fields = array("product_id" => $product_id, 
					"order_id" => $order_id,
					"amount" => 0
				       );
		}

		$op = new OrderProduct($fields);
		$op->id = $fields["order_id"];
		return $op;
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

		$query = $query . " WHERE order_id='" . $this->fields["order_id"] . 
				" AND " . "product_id='" .  $this->fields["product_id"] . 
				"';";

		echo $query;

		$dbLink->queryDB($query, $_SERVER["SCRIPT_NAME"]);
		
	}
}
?>
