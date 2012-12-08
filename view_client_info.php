<html>
<header>
<title>Client Info</title>
</header>

<body>



<?php>

include 'models/Account.php';
	
$conn = new DatabaseLink();

//find all clients info 
$accounts = Account::dbGetBy("", "", $conn);

?>

<table border = 1>
<tr>
<th width = 100>Select Account</th>
<th width = 100>Account id #</th>
<th width = 100>First Name</th>
<th width = 100>Last Name</th>
<th width = 200>Email</th>
<th width = 100>Phone #</th>

</tr>
<form name = "view_client" action = "view_client.php" method = "POST">

<?php
 
foreach($accounts as $account){
	echo "<tr>";
	echo "<td align = 'center'><input type = 'radio' name = 'id' value = ".$account->id."></td>";
	echo "<td align = 'center'>".$account->id."</td>";
	echo "<td>".$account->fields["first_name"]."</td>";
	echo "<td>".$account->fields["last_name"]."</td>";
	echo "<td>".$account->fields["email"]."</td>";
	echo "<td>".$account->fields["phone"]."</td>";
	echo "</tr>";
}

?>

</table>
<br><input type = 'submit' value = 'View Client Info'>
</form>

<?php
$conn->disconnect();
?>

</body>
</html>