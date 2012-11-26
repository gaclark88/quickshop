<?php
/* 
 * sidebar.php generates the category links for the sidebar. The number of links depends on the total number of product categories.
 * 
 */ 

$newestImage = array();
$newestId = array();
$count = 0;

$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $con database");
$query = "";
$row = array();

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


<div class="offset3 span4">
    <?php
    echo ("<img src=\"data:image/jpeg;base64," . base64_encode( $newestImage[0] ) . "\" width=\"160\" height=\"160\" ><br>");
    
    $query = ("SELECT id, name, price, inventory FROM `products` WHERE id =" . $newestId[0]);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
 
    echo("<b> $row[1] </b><br>");
    echo("<b><font color=\"darkred\"> $ $row[2]  </font></b><br>");
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
    echo ("<img src=\"data:image/jpeg;base64," . base64_encode( $newestImage[1] ) . "\" width=\"160\" height=\"160\" ><br>");
    
    $query = ("SELECT id, name, price, inventory FROM `products` WHERE id =" . $newestId[1]);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    
    echo("<b> $row[1] </b><br>");
    echo("<b><font color=\"darkred\"> $ $row[2]  </font></b><br>");
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