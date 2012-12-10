<?php include 'admin_session.php'; ?>

<html>
	<head>
			<!--Include template file-->
	<?php include 'header_template.php' ?>
	
	<title>Process Category</title>
	</head>
	<body>
			<!--Include template file-->
	<?php include 'body_template.php'?>
<?php

//include files and establish db link
include '../models/Category.php';

$conn = new DatabaseLink();
 
//receive post variables
$categories = $_POST['category'];
$action = $_POST['action'];

//error checking
if(!$categories){
	echo "<div class = 'row'><div class = 'span9 offset1'>";
		echo "<div class='alert alert-error'><h5>No categories were selected. To Edit/Delete please select at least one category from list.<h5></div>";
	echo "</div>";
}

else {

//edit categories
if($action == 'edit'){
	
	//create a form for new category name
	echo "<div class = 'row'><div class = 'span6'>";
	echo "<table class = 'table table-bordered'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Category #</th>";
	echo "<th width = 125>Category Name</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<form name = 'commit_categories' action = 'commit_category.php' method = 'POST'>";
	echo "<input type = 'hidden' name = 'process' value = 'modify'>";
	echo "<tbody>";
	$rows = Model::dbGetAllInList("categories", "id", $categories, $conn);
	
	//get the data about category from db
	while($row = mysql_fetch_assoc($rows)){
			echo "<tr>";
			echo "<td>".$row['id']."<input type = 'hidden' name = 'id[]' value = $row[id]></td>";
			echo "<td><input type = 'text' name = 'category[]' value ='".$row['name']."'></td>";
			echo "</tr>";
	}
	
	echo "</tbody></table><br>";
	echo "<button type = 'submit'  class = 'btn btn-primary'>Save change and update</button>";
	echo "</form></div></div>";
}

//delete category
else{
	//create a form for old category
	echo "<div class = 'row'><div class = 'span9'>";
	echo "<div class='alert alert-success'><h5>Categories have been processed. Please check their statuses below<h4></div>";
	echo "<table class = 'table table-bordered'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Category #</th>";
	echo "<th>Category Name</th>";
	echo "<th>Status</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	$rows = Model::dbGetAllInList("categories", "id", $categories, $conn);
	
	//error checking to see if category has any items associated
	while($row = mysql_fetch_assoc($rows)){
			echo "<tr>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['name']."</td>";
			$items = Model::dbGetBy("category_id", $row['id'], "products", $conn);
			
			if(mysql_fetch_assoc($items)){
				echo "<td>Cannot remove category with products associated with it</td>";
			}
			//if not items with category, then remove it and print message
			else{
				$status = Model::dbDelete("categories", "id", $row['id'], $conn);
				
				if($status){
					echo "<td>Deleted</td>";
				}
				else{
					echo "<td>Could not delete category. Please try again</td>";
				}
			}
			echo "</tr>";
	}
	echo "</tbody></table>";
}
}
?>

<?php
//close connection to database
$conn->disconnect();
?>
		<!--Include template file-->
<?php include 'end_template.php'?>
	</body>
</html>