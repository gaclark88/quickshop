<?php include '../session.php'; ?>

<html>
<head>

<?php include 'header_template.php' ?>

<title>Client Info</title>

</head>

<body>

<?php include 'body_template.php'?>

<?php>

include '../models/Account.php';
	
$conn = new DatabaseLink();

//find all clients info 
$accounts = Account::dbGetBy("", "", $conn);

?>

<table class = "table table-hover table-bordered">
<thead>
<tr>
<th>Select Account</th>
<th>Account id #</th>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Phone #</th>
</tr>
</thead>
<form name = "view_client" action = "view_client.php" method = "POST">
<tbody>
<?php
 
foreach($accounts as $account){
	echo "<tr>";
	echo "<td><label class='radio offset5'><input type = 'radio' name = 'id' value = ".$account->id."></label></td>";
	echo "<td>".$account->id."</td>";
	echo "<td>".$account->fields["first_name"]."</td>";
	echo "<td>".$account->fields["last_name"]."</td>";
	echo "<td>".$account->fields["email"]."</td>";
	echo "<td>".$account->fields["phone"]."</td>";
	echo "</tr>";
}

?>
</tbody>
</table>
<br><button type = "submit"  class = "btn btn-primary">View Detailed Info</button>
</form>

<?php
$conn->disconnect();
?>

<?php include 'end_template.php'?>
	
	</body>
</html>