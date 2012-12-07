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

// remove password field
// foreach($accounts as $account){
	// echo "$account->fields['password']";
// }

?>

<table border = 1>
<tr>
<th width = 100>First Name</th>
<th width = 100>Last Name</th>
<th width = 200>Email</th>
<th width = 100>Phone #</th>
<th width = 200>Shipping Address</th>
<th width = 100>Shipping City</th>
<th width = 50>Shipping State</th>
<th width = 50>Ship. Zip Code</th>
<th width = 200>Billing Address</th>
<th width = 100>Billing City</th>
<th width = 50>Billing State</th>
<th width = 50>Bill. Zip Code</th>
</tr>

<?php
 
foreach($accounts as $account){
	echo "<tr>";
	echo "<td>".$account->fields["first_name"]."</td>";
	echo "<td>".$account->fields["last_name"]."</td>";
	echo "<td>".$account->fields["email"]."</td>";
	echo "<td>".$account->fields["phone"]."</td>";
	echo "<td>".$account->fields["shipping_address"]."</td>";
	echo "<td>".$account->fields["shipping_city"]."</td>";
	echo "<td>".$account->fields["shipping_state"]."</td>";
	echo "<td>".$account->fields["shipping_zip"]."</td>";
	echo "<td>".$account->fields["billing_address"]."</td>";
	echo "<td>".$account->fields["billing_city"]."</td>";
	echo "<td>".$account->fields["billing_state"]."</td>";
	echo "<td>".$account->fields["billing_zip"]."</td>";
	echo "</tr>";
}

?>

<?php
$conn->disconnect();
?>

</body>
</html>