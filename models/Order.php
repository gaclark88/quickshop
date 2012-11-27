<?php

include_once("Model.php");
include_once("OrderProduct.php");

class Order extends Model {
	var $fieldnames = array( "account_id",
			"phone",
			"shipping_address",
			"shipping_city",
			"shipping_state",
			"shipping_zip",
			"billing_address",
			"billing_city",
			"billing_state",
			"billing_zip",
			"status",
			"credit_4",
			"subtotal",
			"shipping_price",
			"total_amount"
			);

	function Order($fields) {
		parent::Model($this->fieldnames, $fields, "orders");
		
	
		foreach ($this->fields as $field => $value) {
			echo $field . " => " . $value . "<br />";
		}
	}

	function dbGet($id, $dbLink) {
		$fields = parent::dbGet($id, "orders", $dbLink);

		if (!$fields) {return $fields;}
		
		$order = new Order($fields);
		$order->id = $fields["id"];
		return $order;
	}	
	
	function dbGetBy($field, $key, $dbLink) {
		$rows = parent::dbGetBy($field, $key, "orders", $dbLink);		

		$orders = array();
		
		while ($row = mysql_fetch_assoc($rows)) {
			$order = new Order($row);
			$order->id = $row["id"];
			
			array_push($orders, $order);
		}
		
		return $orders;
	}	

	/*
	 * add or update amount of item on an order
	 */
	function updateProduct($product_id, $amount, $dbLink) {
		$orderProduct = OrderProduct::dbGetByOrderIdProductId(
			$this->fields["order_id"],
			$product_id);
		
		$orderProduct->fields["amount"] = $amount;
		$orderProduct->dbSave($dbLink);
	}
}
?>

