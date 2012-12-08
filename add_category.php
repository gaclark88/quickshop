<html>
<header>
<title>Add/Change Category</title>
</header>

<body>

<?php>

include 'models/Category.php';

$conn = new DatabaseLink();

$rows = Model::dbGetAll("categories", $conn);
?>

<table border = 1>
<tr>
<th width = 75>Select</th>
<th width = 100>Category Name</th>
<th width = 100>Category #</th>
<th width = 100>Num of products</th>

</tr>
<form name = "process_category" action = "process_category.php" method = "POST">
<?php

while($row = mysql_fetch_assoc($rows)){
		
		$items = Model::dbGetBy("category_id", $row['id'], "products", $conn);
		$num_items = mysql_num_rows($items);
		
		echo "<tr>";
		echo "<td align = 'center'><input type='checkbox' name='category[]' value = ".$row['id']."></td>";
		echo "<td>$row[name]</td>";
		echo "<td align = 'center'>".$row['id']."</td>";
		echo "<td align = 'center'>$num_items</td>";
		echo "</tr>";
		
}

echo "</table><br>";

$conn->disconnect();

?>

<table>
<tr><td>Select Actions</td>
<td>
<select name = "action">
  <option value="edit">Edit</option>
  <option value="delete">Delete</option>
</select>
</td>
<td><input type="submit" value="Go"></td></tr>
</form>
</table><br>

<form name="input" action="new_category.php" method="POST">
<input type = "hidden" name = "new_category" value = "true">
<input type="submit" value="Add New Category">
</form>



</body>
</html>