<?php include 'admin_session.php'; ?>


<html>
<head>

<?php include 'header_template.php' ?>

<title>Add New Item</title>

</head>

<body>

<?php include 'body_template.php'?>

<?php

include '../models/Product.php';

$conn = new DatabaseLink();

$change_flag = $_POST['change_flag'];
$product_id = $_POST['product_id'];


$product_fields = array("name" => $_POST['name'],
			"description" 	=> $_POST['description'],
			"category_id" 	=> $_POST['category'],
			"price" 		=> $_POST['price'],
			"inventory"		=> $_POST['inventory']);

$img_fields = array("filename" => $_FILES['img']['name'],
					"mime_type" => $_FILES['img']['type'],
					"size" => $_FILES['img']['size'],
					"product_id" => $product->id,
					"file_data" => file_get_contents($_FILES["img"]["tmp_name"]));

$prod_err_fields = array();
					
foreach($product_fields as $key => $value){
	if(!$value || (($key == 'price' || $key == 'inventory') && !(is_numeric($value))) || (($key == 'description' || $key == 'name') && (is_numeric($value)))){
		$prod_err_fields[$key] = $value;
	}
}

if((count($prod_err_fields) > 0) || (!$img_fields['file_data'] && !$change_flag)){
	echo "<div class = 'row'><div class = 'span8 offset1'>";
	
	echo "<div class = 'row'><div class = 'span12 offset'>";
		echo "<div class='alert alert-error'><h5>Item could not be processed. Please see find the missing fields below.<h5></div>";
	echo "</div>";
	
	echo "<table class = 'table table-bordered'>";
	foreach($prod_err_fields as $key => $value){
		echo "<tr><td><strong>".strtoupper($key).":</strong></td>";
		if(!$value){
			echo "<td>MISSING</td></tr>";
		}
		else{
			echo "<td>INVALID FORMAT</td></tr>";
		}
	}
	if(!$img_fields['file_data'] && !change_flag){
		echo "<tr><td><strong>FILE:</strong></td><td>MISSING</td></tr>";
	}
	echo "</table>";
	echo "</div></div>";
}


else{

echo "<div class = 'row'><div class = 'span8'>";	
if($change_flag != 'true'){
	//echo "I better not be here";

	
	$product = new Product($product_fields);
	$prod_status = $product->dbInsert($conn);
						
	
	if($prod_status){
		
		$image = new Image($img_fields);
		$image->fields['product_id'] = $product->id;
		$image_status = $image->dbInsert($conn);
		
		if($image_status){
			
			$product->fields['image_id'] = $image->id;
			$product->dbUpdate($conn);
			
			echo "<div class='alert alert-success'><h5>Item has been successfully added!<h5></div>";
		}
		
	}
	
	else{
		echo "<div class='alert alert-error'><h5>Item could not be added. Please try again <h5></div>";
	}
}

else{
	
	$product = Product::dbGet($product_id, $conn);
	
	//query returns nothing if image is not there, and you try to edit item with new image
	$image = $product->dbGetImage($conn);

	//if image is not there, create it
	if(!$image->id && !$img_fields['filename']){

		$image = new Image($img_fields);
		$image->fields['product_id'] = $product->id;
		$image->dbInsert($conn);
		
		//update the new image id
		$product->fields['image_id'] = $image->id;
	}
	//else edit its fields
	else{
		
		if($img_fields['filename']){

			foreach($img_fields as $field => $value){
				$image->fields[$field] = $value;
			}
		}
	}
	
	foreach($product_fields as $field => $value){
		$product->fields[$field] = $value;
	}

	$product->dbUpdate($conn);
	$image->fields['product_id'] = $product->id;

	$image->dbUpdate($conn);

	echo "<div class='alert alert-success'><h5>Item has been successfully edited!<h5></div>";
}
}
	echo "</div></div>";
	$conn->disconnect();
?>

	<?php include 'end_template.php'?>
	</body>
</html>