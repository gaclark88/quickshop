<?php include 'admin_session.php'; ?>

<html>
<head>

<?php include 'header_template.php' ?>

<title>Add/Change Category</title>

</head>

<body>

<?php include 'body_template.php'?>

<?php>

//include files and establish db link

include '../models/Category.php';

$conn = new DatabaseLink();

$rows = Model::dbGetAll("categories", $conn);
?>
<div class = 'row'><div class = 'span8'>
<table class = 'table table-bordered table-hover'>
<thead>
<tr>
<th>Select</th>
<th>Category Name</th>
<th>Category #</th>
<th>Num of products</th>
</tr>
</thead>
<form name = "process_category" action = "process_category.php" method = "POST">
<tbody>
<?php

//fetch the data from db with category info
while($row = mysql_fetch_assoc($rows)){
		
		$items = Model::dbGetBy("category_id", $row['id'], "products", $conn);
		$num_items = mysql_num_rows($items);
		
		echo "<tr>";
		echo "<td><label class = 'checkbox offset1'><input type='checkbox' name='category[]' value = ".$row['id']."></label></td>";
		echo "<td>$row[name]</td>";
		echo "<td align = 'center'>".$row['id']."</td>";
		echo "<td align = 'center'>$num_items</td>";
		echo "</tr>";
		
}

$conn->disconnect();

?>

</tbody>
</table>
<br>
<!--Specify actions for editing categories-->
<table class = 'table'>
<thead>
<tr><td><h4>Select Actions</h4></td>
<td>
<select name = "action">
  <option value="edit">Edit</option>
  <option value="delete">Delete</option>
</select>
</td>
<td><button type = "submit"  class = "btn btn-primary">Go</button></td>
</tr>
</thead>
</form>
</table>
<!--Option to create new category-->
<form name="new_cat" action="new_category.php" method="POST">
<input type = "hidden" name = "new_category" value = "true">
<button type = "submit"  class = "btn btn-primary">Add New Category</button>
</form>
</div></div>

<?php include 'end_template.php'?>
</body>
</html>