<html>
<header>
<title>Client Info</title>
</header>

<body>


<?php>

include 'models/Account.php';

$account_id = $_POST['id'];
	
$conn = new DatabaseLink();

//find specific client info
$account = Account::dbGet($account_id, $conn);
unset($account->fields['password']);

?>

<table>

<?php
 
foreach($account->fields as $key => $value){
	echo "<tr>";
	echo "<td><b>".strtoupper(str_replace("_", " ", $key)).":</b></td>";
	echo "<td>".strtoupper($value)."</td>";
	echo "</tr>";
}

?>

</table>

<?php
$conn->disconnect();
?>

</body>
</html>