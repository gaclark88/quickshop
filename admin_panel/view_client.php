<?php include 'admin_session.php'; ?>

<html>
<head>

<?php include 'header_template.php' ?>

<title>Client Info</title>

</head>

<body>

<?php include 'body_template.php'?>

<?php>

include '../models/Account.php';

$account_id = $_POST['id'];

if(!$account_id){
	echo "<div class = 'row'><div class = 'span6 offset3'>";
		echo "<div class='alert alert-error'><h5>No client selected. Please select one client from a list.<h5></div>";
	echo "</div>";
}
else{
$conn = new DatabaseLink();

//find specific client info
$account = Account::dbGet($account_id, $conn);
unset($account->fields['password']);

?>

<table class = 'table table-bordered'>
<tbody>
<?php
 
foreach($account->fields as $key => $value){
	echo "<tr>";
	echo "<td><b>".strtoupper(str_replace("_", " ", $key)).":</b></td>";
	echo "<td>".strtoupper($value)."</td>";
	echo "</tr>";
}
}
?>
</tbody>
</table>

<?php
$conn->disconnect();
?>

<?php include 'end_template.php'?>

</body>
</html>