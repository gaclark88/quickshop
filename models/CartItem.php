<?php

include_once("Model.php");

class CartItem extends Model {
	var $fieldnames = array( "product_id",
			"account_id",
			"amount"
			);

	function CartItem($fields) {
		parent::Model($this->fieldnames, $fields, "cart_items");
	}

	function dbGet($id, $dbLink) {
		$fields = parent::dbGet($id, "cart_items", $dbLink);

		if (!$fields) {return $fields;}
		
		$cartItem = new CartItem($fields);
		$cartItem->id = $fields["id"];
		return $cartItem;
	}
	
	function dbGetBy($field, $key, $dbLink) {
		$rows = parent::dbGetBy($field, $key, "cart_items", $dbLink);		

		$cartItems = array();
		
		while ($row = mysql_fetch_assoc($rows)) {
			$cartItem = new CartItem($row);
			$cartItem->id = $row["id"];
			
			array_push($cartItems, $cartItem);
		}
		
		return $cartItems;
	}		
	
	function toString() {
		echo $this->fields["product_id"] .  " => " . 
			$this->fields["account_id"] . " : " . 
			$this->fields["amount"] . "<br />";
	}
}

?>
