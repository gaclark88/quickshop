<?php

include '/models/Category.php';

$conn = new DatabaseLink();


$categories = $_POST['category'];
$new_category = $_POST['new_category'];

?>

<table border = 1>
<tr>
<th width = 90>Category #</th>
<th width = 100>Category</th>
</tr>
<form name = "commit_categories" action = "commit_category.php" method = "POST">

<?php
if($categories){
	$rows = Model::dbGetAllInList("categories", "id", $categories, $conn);

	while($row = mysql_fetch_assoc($rows)){

			echo "<tr>";
			echo "<td align = 'center'>".$row['id']."<input type = 'hidden' name = 'id[]' value = $row[id]></td>";
			
			echo "<td><input type = 'text' name = 'category[]' value = $row[name]></td>";
			echo "</tr>";

	}
}

if(count($new_category) != 0){
	echo "<tr><td align = 'center'>New</td>";
	echo "<td><input type = 'text' name = 'new_category'></td></tr>";
}
?>
</table>
<br><br>
<input type = submit value = 'Save Changes and Update Categories'>


<?php
$conn->disconnect();
?>