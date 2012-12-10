<?php include 'admin_session.php'; ?>


<html>
	<head>
	
	<?php include 'header_template.php' ?>
	
	<title>Commit Category</title>
	</head>
	<body>
	<?php include 'body_template.php'?>
<?php


include '../models/Category.php';

$conn = new DatabaseLink();

$categories = $_POST['category'];
$ids = $_POST['id'];
$action = $_POST['process'];
$new_cat_name = $_POST['new_category'];

//detect blank categories
if($categories){
	foreach($categories as $cat){
		if(!$cat){
			$err = true;
		}
	}
}
else{
	$err = true;;
}

if(!$new_cat_name && $err){
	echo "<div class = 'row'><div class = 'span8 offset2'>";
		echo "<div class='alert alert-error'><h5>Category name cannot be blank. Please check you input and try again<h5></div>";
	echo "</div>";
}

else{

echo "<div class = 'row'><div class = 'span8'>";

echo "<div class='alert alert-success'><h5>Categories have been processed. Please check their statuses below<h5></div>";

echo "<table class = 'table table-bordered'>";
echo "<thead>";	
echo "<tr>";
echo "<th>ID #</th>";
echo "<th>New Category Name</th>";
echo "<th>Status</th></tr>";
echo "</thead>";
if($action == 'new_category'){

	// $new_cat_name = $_POST['new_category'];
	$new_cat = new Category(array("name" => $new_cat_name));
	$status = $new_cat->dbSave($conn);
	echo "<tbody>";
	echo "<tr>";
	if($status == true ){
		
		echo "<td>".$new_cat->id."</td>";
		echo "<td>".$new_cat->fields['name']."</td>";
		echo "<td>Successfully added</td>";
	}
	else{
		echo "<td>N/A</td>";
		echo "<td><".$new_cat->fields['name']."</td>";
		echo "<td><Category not added. Please try again></td>";
	}
	echo "</tr>";
}

//check if need to edit existing categories
if($categories){
	
	$cat_id = array();
	
	foreach ($categories as $key1 => $value1) {
		$cat_id[$value1] = $ids[$key1];
	}
	echo "<tbody>";
	foreach($cat_id as $category => $id){
		
		$category = new Category(array("name" => $category));
		$category->id = $id;
		$status = $category->dbUpdate($conn);
		echo "<tr>";
		echo "<td>".$category->id."</td>";
		echo "<td>".$category->fields['name']."</td>";
		if($status){
			echo "<td>Successfully edited</td>";
		}
		else{
			echo "<td>Category not edited. Please try again</td>";
		}
		echo "</tr>";
	}
}
echo "</tbody></table></div></div>";

}
$conn->disconnect();
?>

	<?php include 'end_template.php'?>
	</body>
</html>