<?php include '../session.php'; ?>

<html>
	<head>
	
	<?php include 'header_template.php' ?>
	
	<title>Add New Category</title>
	</head>
	<body>

	<?php include 'body_template.php'?>

<?php

include '../models/Category.php';

$conn = new DatabaseLink();
 

$new_cat = $_POST['new_category'];

	echo "<div class = 'row'><div class = 'span6'>";	
echo "<table class = 'table table-bordered'>";
echo "<thead>";
echo "<tr>";
echo "<th>Category #</th>";
echo "<th>Category Name</th>";
echo "</tr>";
echo "</thead>";
echo "<form name = 'commit_categories' action = 'commit_category.php' method = 'POST'>";
echo "<input type = 'hidden' name = 'process' value = 'new_category'>";
echo "<tbody>";
echo "<tr>";
echo "<td align = 'center'>New</td>";
echo "<td><input type = 'text' name = 'new_category' value = $row[name]></td>";
echo "</tr>";
echo "</tbody>";

echo "</table><br>";
echo "<button type = 'submit'  class = 'btn btn-primary'>Create New Category</button>";
echo "</form></div></div>";

?>

<?php
$conn->disconnect();
?>

	<?php include 'end_template.php'?>
	</body>
</html>