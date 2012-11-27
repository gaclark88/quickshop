<?php
/* 
 * newestItems.php is a script that displays the 2 newest items added to the inventory on the front page. 
 *
 */ 

$newestImage = array();
$newestId = array();
$count = 0;

/* Connect to database */
$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $con database");
$query = "";
$row = array();

/* Query for the product id of the 2 newest items */
$query = ("SELECT id FROM `products` ORDER BY id DESC LIMIT 2");
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);
$newestId[0] = $row[0];
$count++;

while($row = mysql_fetch_array($result)){
	if($row[0] != NULL){
        $newestId[$count] = $row[0];
        $count++;
    }
}

/* fetch the images of the 2 newest items */
for($i = 0; $i < $count; $i++)
{
    $query = ("SELECT file_data FROM `images` WHERE product_id =" . $newestId[$i] );
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    $newestImage[$i] = $row[0];

    while($row = mysql_fetch_array($result)){
        if($row[0] != NULL){
            $newestImage[$i] = $row[0];
        }
    }

}

?>

<!--Start of Newest Item Display-->
<div class="offset3 span4">

    <?php
    /* Display newest product image */
    echo ("<img src=\"data:image/jpeg;base64," . base64_encode( $newestImage[0] ) . "\" width=\"260\" height=\"260\" ><br>");
    
    /* Query for item details */
    $query = ("SELECT id, name, price, inventory FROM `products` WHERE id =" . $newestId[0]);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    
    /* Display product name and link to product page */
    echo("<b><font size=\"3\"><a href=\"productPage.php?product_id=" . $row[0] . "\"> $row[1] </a></font></b><br>");
    /* Display price of product */
    echo("<b><font size=\"3\" color=\"darkred\"> $ $row[2]  </font></b><br>");
    /* Determine availability of product and display appropriate message */
    if($row[3] == -1)
    {
        echo("<font size=\"3\"> Back-Order </font>");
    }
    elseif($row[3] == 0)
    {
        echo("<font size=\"3\"color=\"red\">Out of Stock </font>");
    }
    else{
        echo("<font size=\"3\" color=\"green\"> In Stock </font>");
    }

    ?>
</div><!--End of Newest Item Display-->

<!--Start of 2nd Newest Item Display-->
<div class="offset1 span4">
    <?php
    
    /* Display 2nd newest product image */
    echo ("<img src=\"data:image/jpeg;base64," . base64_encode( $newestImage[1] ) . "\" width=\"260\" height=\"260\" ><br>");
    
    /* Query for item details */
    $query = ("SELECT id, name, price, inventory FROM `products` WHERE id =" . $newestId[1]);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    
    /* Display product name and link to product page */
    echo("<b><font size=\"3\"><a href=\"productPage.php?product_id=" . $row[0] . "\"> $row[1] </a></font></b><br>");
    /* Display price of product */
    echo("<b><font size=\"3\" color=\"darkred\"> $ $row[2]  </font></b><br>");
    /* Determine availability of product and display appropriate message */
    if($row[3] == -1)
    {
        echo("<font size=\"3\"> Back-Order </font>");
    }
    elseif($row[3] == 0)
    {
        echo("<font size=\"3\"color=\"red\">Out of Stock </font>");
    }
    else{
        echo("<font size=\"3\" color=\"green\"> In Stock </font>");
    }

    ?>
    
</div><!--Start of 2nd Newest Item Display-->