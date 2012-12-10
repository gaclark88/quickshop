<?php include 'admin_session.php'; ?>

<html>
	<head>
	
	<?php include 'header_template.php' ?>
	
	<title>Process Category</title>
	</head>
	<body>
	<?php include 'body_template.php'?>
<?php

include '../models/Category.php';

$conn = new DatabaseLink();
 

$categories = $_POST['category'];
$action = $_POST['action'];


//edit categories
if($action == 'edit'){
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
	
	echo "<div class = 'row'><div class = 'span8'>";
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

	while($row = mysql_fetch_assoc($rows)){
			echo "<tr>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['name']."</td>";
			$status = Model::dbDelete("categories", "id", $row['id'], $conn);
			if($status){
				echo "<td>Deleted</td>";
			}
			else{
				echo "<td>Could not delete category. Please try again</td>";
			}
			echo "</tr>";
	}
	echo "</tbody></table>";
}
?>

<?php
$conn->disconnect();
?>

<?php include 'end_template.php'?>
	</body>
</html>