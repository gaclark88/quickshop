<?php

include 'models/Category.php';

$conn = new DatabaseLink();
 

$categories = $_POST['category'];
$action = $_POST['action'];
?>

<?php

//edit categories
if($action == 'edit'){
	
	echo "<table border = 1>";
	echo "<tr>";
	echo "<th width = 90>Category #</th>";
	echo "<th width = 100>Category Name</th>";
	echo "</tr>";
	echo "<form name = 'commit_categories' action = 'commit_category.php' method = 'POST'>";
	echo "<input type = 'hidden' name = 'process' value = 'modify'>";
	
	$rows = Model::dbGetAllInList("categories", "id", $categories, $conn);

	while($row = mysql_fetch_assoc($rows)){
			echo "<tr>";
			echo "<td align = 'center'>".$row['id']."<input type = 'hidden' name = 'id[]' value = $row[id]></td>";
			echo "<td><input type = 'text' name = 'category[]' value = $row[name]></td>";
			echo "</tr>";
	}
	
	echo "</table><br><br>";
	echo "<input type = submit value = 'Save Changes and Update Categories'>";
}

//delete category
else{
	echo "<table border = 1>";
	echo "<tr>";
	echo "<th width = 90>Category #</th>";
	echo "<th width = 150>Category Name</th>";
	echo "<th width = 100>Status</th>";
	echo "</tr>";
	
	$rows = Model::dbGetAllInList("categories", "id", $categories, $conn);

	while($row = mysql_fetch_assoc($rows)){
			echo "<tr>";
			echo "<td align = 'center'>".$row['id']."</td>";
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
	echo "</table>";
	echo "<br><p>Categories have been successfully processed</p>";
	echo "<br><a href = 'admin_panel.php'>Go Back to Admin Panel</a>";
}
?>

<?php
$conn->disconnect();
?>