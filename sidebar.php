<?php
/* 
 * sidebar.php generates the category links for the sidebar. The number of links depends on the total number of product categories.
 * 
 */ 

$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $con database");
$query = "";
$row = array();

$query = ("SELECT name FROM `categories`");
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);

echo("<li><a href=\"#\">$row[0]</a></li>");
while($row = mysql_fetch_array($result)){
	if($row[0] != NULL){
		echo("<li><a href=\"#\">$row[0]</a></li>");
    }
}

?>