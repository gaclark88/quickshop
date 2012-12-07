<?php

include 'models/Category.php';

$conn = new DatabaseLink();

$categories = $_POST['category'];
$ids = $_POST['id'];
$new_category = $_POST['new_category'];

if($new_category){
	$new_cat = new Category(array("name" => $new_category));
	$new_cat->dbSave($conn);
}

if($categories){
	
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