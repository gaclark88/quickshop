<html>
<header>
<title>Add/Change Category</title>
</header>

<body>

<?php>

include '/models/Category.php';

$conn = new DatabaseLink();

$rows = Model::dbGetAll("categories", $conn);
?>

<table border = 1>
<tr>
<th width = 50>Edit</th>
<th width = 100>Category Name</th>
<th width = 100>Category #</th>

</tr>
<form name = "process_categories" action = "process_category.php" method = "POST">

<?php

while($row = mysql_fetch_assoc($rows)){
		
		echo "<tr>";
		echo "<td align = 'center'><input type='checkbox' name='category[]' value = ".$row['id']."></td>";
		echo "<td>$row[name]</td>";
		echo "<td>".$row['id']."</td>";
		echo "</tr>";
}

$conn->disconnect();

?>
<tr>
<td align = 'center'><input type = 'checkbox' checked name = 'new_category' value = '1'</td>
<td>Check to add new Category</td>
<td></td></tr>
</table>
<br><input type = 'submit' value = 'Edit Selected Categories'>
</form>

</body>
</html>