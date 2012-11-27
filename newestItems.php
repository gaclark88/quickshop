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

/* Query for the images and corresponding product id of the 2 newest items */
$query = ("SELECT file_data, product_id FROM `images` ORDER BY product_id DESC LIMIT 2");
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);
$newestImage[0] = $row[0];
$newestId[0] = $row[1];
$count++;

while($row = mysql_fetch_array($result)){
	if($row[0] != NULL){
		$newestImage[$count] = $row[0];
        $newestId[$count] = $row[1];
        $count++;
    }
}
?>

<!--Start of Newest Item Display-->
<div class="offset3 span4"><

    <?php
    /* Display newest product image */
    echo ("<img src=\"data:image/jpeg;base64," . base64_encode( $newestImage[0] ) . "\" width=\"160\" height=\"160\" ><br>");
    
    /* Query for item details */
    $query = ("SELECT id, name, price, inventory FROM `products` WHERE id =" . $newestId[0]);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    
    /* Display product name and link to product page */
    echo("<b><a href=\"productPage.php?product_id=" . $row[0] . "\"> $row[1] </a></b><br>");
    /* Display price of product */
    echo("<b><font color=\"darkred\"> $ $row[2]  </font></b><br>");
    /* Determine availability of product and display appropriate message */
    if($row[3] == -1)
    {
        echo("Back-Order");
    }
    elseif($row[3] == 0)
    {
        echo("<font color=\"red\">Out of Stock </font>");
    }
    else{
        echo("<font color=\"green\"> In Stock </font>");
    }

    ?>
</div><!--End of Newest Item Display-->

<!--Start of 2nd Newest Item Display-->
<div class="offset1 span4">
    <?php
    
    /* Display 2nd newest product image */
    echo ("<img src=\"data:image/jpeg;base64," . base64_encode( $newestImage[1] ) . "\" width=\"160\" height=\"160\" ><br>");
    
    /* Query for item details */
    $query = ("SELECT id, name, price, inventory FROM `products` WHERE id =" . $newestId[1]);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    
    /* Display product name and link to product page */
    echo("<b><a href=\"productPage.php?product_id=" . $row[0] . "\"> $row[1] </a></b><br>");
    /* Display price of product */
    echo("<b><font color=\"darkred\"> $ $row[2]  </font></b><br>");
    /* Determine availability of product and display appropriate message */
    if($row[3] == -1)
    {
        echo("Back-Order");
    }
    elseif($row[3] == 0)
    {
        echo("<font color=\"red\">Out of Stock </font>");
    }
    else{
        echo("<font color=\"green\"> In Stock </font>");
    }

    ?>
    
</div><!--Start of 2nd Newest Item Display-->