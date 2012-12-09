<?php include "session.php"; ?>
<?php 

/*
*cancelOrder just sends the user back to the cart. Sessions are cleared at the cart.
*/

//Redirect to cart
header("location: mycart.php");

?>