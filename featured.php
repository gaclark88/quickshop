<?php

$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $db database");
$query = "";
$row = array();

$featuredId = array();
$idCount = 0;


$query = ("SELECT COUNT(product_id) FROM `images`");
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);


$query = ("SELECT product_id  FROM (SELECT * FROM `images` ORDER BY product_id  DESC LIMIT 2," . $row[0] . ") AS t ORDER BY rand() LIMIT 3");
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

for($i = 0; $i <= 2; $i++)
{
    $query = ("SELECT file_data FROM `images` WHERE product_id = " . $featuredId[$i]);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    if($row[0] != NULL){
		$img = $row[0];
    }
    
    if($i == 0)
    {
        echo ("<div class=\"active item\"><img src=\"data:image/jpeg;base64," . base64_encode( $img ) . "\" width=\"500\" height=\"100\" >&rsaquo;");
    }
    else
    {
        echo ("<div class=\"item\"><img src=\"data:image/jpeg;base64," . base64_encode( $img ) . "\" width=\"500\" height=\"100\" >&rsaquo;");
    }
    
    $query = ("SELECT name, price  FROM `products` WHERE id = " . $featuredId[$i]);
    $result = mysql_query($query, $con) or die("Could not execute query '$query'");
    $row = mysql_fetch_array($result);
    if($row[0] != NULL){
		$name = $row["name"];
        $price = $row["price"];
    }
    echo ("<div class=\"carousel-caption\"><p>" . $name .": $" . $price ."</p></div></div>");
 
}

?>