<?php
      include_once "./models/DatabaseLink.php";
/* 
 * featured.php is a script that generates a revolving slideshow of 3 random products. The name and price of 
 * each product is also displayed. The image is a link to the corresponding product's product page.
 *
 */
 
/* Connect to database */
$db = new DatabaseLink();
$con = $db->connection;
$query = "";
$row = array();

$featuredId = array();
$idCount = 0;

/* Make an initial query for the the total number of products with images */
$query = ("SELECT COUNT(product_id) FROM `images`");
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);

/* Select 3 random products that are NOT the 2 newest items and store for the product id of each in an array */
$query = ("SELECT id  FROM (SELECT * FROM `products` WHERE inventory > 0 ORDER BY id  DESC LIMIT 2," . $row[0] . ") AS t ORDER BY rand() LIMIT 3");
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);
$featuredId[0] = $row[0];
$idCount++;

while($row = mysql_fetch_array($result)){
	if($row[0] != NULL){
		$featuredId[$idCount] = $row[0];
        $idCount++;
    }
}

/* Go through the array and display the products in the revolving slideshow */
for($i = 0; $i <= 2; $i++)
{
    /* Query for product image */
    $query = ("SELECT file_data FROM `images` WHERE product_id = " . $featuredId[$i]);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    if($row[0] != NULL){
		$img = $row[0];
    }
    
    /* Set the first product as the active item */
    if($i == 0)
    {
        echo ("<div class=\"active item\"><a href=\"productPage.php?product_id=" . $featuredId[$i] . "\"><img src=\"data:image/jpeg;base64," . base64_encode( $img ) . "\" width=\"500\" height=\"100\" ></a>&rsaquo;");
    }
    else
    {
        echo ("<div class=\"item\"><a href=\"productPage.php?product_id=" . $featuredId[$i] . "\"><img src=\"data:image/jpeg;base64," . base64_encode( $img ) . "\" width=\"500\" height=\"100\" ></a>&rsaquo;");
    }
    
    /* Query for the name and price of the product */
    $query = ("SELECT name, price  FROM `products` WHERE id = " . $featuredId[$i]);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    if($row[0] != NULL){
		$name = $row["name"];
        $price = $row["price"];
    }
    /* Display the name and price of the product in a caption */
    echo ("<div class=\"carousel-caption\"><p>" . $name .": $" . $price ."</p></div></div>");
}

$db->disconnect();

?>
