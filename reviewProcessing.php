<?php include "session.php"; ?>
<?php include_once "./models/DatabaseLink.php"; ?>

<?php
/* reviewProcessing.php enters a review into the database or updates the review if a customer has already submitted a review for the product. If reviewProcessing.php
*  recieves the delete flag from the product page, It will delete the review belonging to the current logged in user. 
*/

/* Connect to database */
$db = new DatabaseLink();
$con = $db->connection;
$query = "";
$row = array();

$accountId = $_POST['accountId'];
$productId = $_POST['productId'];
$rating = $_POST['rating'];
$review = $_POST['review'];

/* Deletes the review for the current logged in user if the delete flag is set */
if(isset($_GET['delete']))
{
    $productId = $_GET['productId'];
    $query = ("DELETE FROM `product_reviews` WHERE account_id =" . $_SESSION['accountId'] . " AND product_id=" . $productId);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    
    /* Automatically redirects the user to the product page */
    echo("<script>location.href=\"productPage.php?product_id=" . $productId . "\" </script>");
}

/* If called by createReview.php, Add the review to the database if it is new or update it if the current logged in user has already submitted a review */
else
{
    
    $query = ("SELECT * FROM `product_reviews` WHERE account_id =" . $accountId . " AND product_id=" . $productId);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    
    /* Check to see if a review for this product that was written by the current logged user already exists  */
    if($row[0] == null)
    {
        /* If none exist, add a new review to the database */
        $query = ("INSERT INTO `product_reviews` VALUES (NULL, \"" . $productId . "\", \"" . $accountId . "\", \"" . $rating . "\", \"" . $review . "\")");
        $result = mysql_query($query, $con) or die("Could not execute query '$query'");

    }
    /* If the current logged user has already submitted a review, update the existing review */
    else
    {
        $query = ("UPDATE `product_reviews` SET `rating`=\"" . $rating . "\", `review`=\"" . $review . "\" WHERE account_id =" . $accountId . " AND product_id=" . $productId);
        $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    }
    
    /* Automatically redirects the user to the product page */
    echo("<script>location.href=\"productPage.php?product_id=" . $productId . "\" </script>");
}


?>
