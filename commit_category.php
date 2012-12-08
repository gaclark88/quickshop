<?php

//DELETE THIS FILE BECAUSE NOT NEEDED ANYMORE

include 'models/Category.php';

$conn = new DatabaseLink();

$categories = $_POST['category'];
$purges = $_POST['delete'];
$ids = $_POST['id'];
$new_category = $_POST['new_category'];

if($new_category){
	$new_cat = new Category(array("name" => $new_category));
	$new_cat->dbSave($conn);
}

//check if need to edit existing categories
if($categories){
	
	echo "<table>";
	echo "<tr>";
	echo "<th>ID #</th>";
	echo "<th>Category</th>";
	echo "<th>Status</th>";
	
	
	//check if deleting any categories
	if($purges){
		
		//check if there are products associated with this category
		foreach($purges as $purge){
			
			$items = Model::dbGetBy("category_id", $purge, "products", $conn);
			
			if(mysql_num_rows($items) > 0){
				echo "<tr>";
				echo "<td>
			}
			
		}
	
	}
	
	$cat_id = array();
	
	foreach ($categories as $key1 => $value1) {
		$cat_id[$value1] = $ids[$key1];
	}

	foreach($cat_id as $category => $id){
		
		$category = new Category(array("name" => $category));
		$category->id = $id;
		$category->dbUpdate($conn);
	}
}

echo "<br><p>Categories have been successfully edited!</p>";
echo "<br><a href = 'admin_panel.php'>Go Back to Admin Panel</a>";

$conn->disconnect();
?>