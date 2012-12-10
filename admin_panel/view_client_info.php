<?php include 'admin_session.php'; ?>

<html>
<head>
	<!--Include template file-->
<?php include 'header_template.php' ?>

<title>Client Info</title>

</head>

<body>
	<!--Include template file-->
<?php include 'body_template.php'?>

<?php>

//include files and establish db link
include '../models/Account.php';
	
$conn = new DatabaseLink();

//find all clients info 
$accounts = Account::dbGetBy("", "", $conn);

?>

	<!--Create table for all existing clients-->
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
<form name = "view_client" id = 'view_client' action = "view_client.php" method = "POST">
<tbody>
<?php
 
 //populate the table with client info
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
//close connection to db
$conn->disconnect();
?>
	<!--Include template file-->
<?php include 'end_template.php'?>
	
	</body>
</html>