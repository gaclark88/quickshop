<?php
/* 
 * sidebar.php is a script that generates the category links for the sidebar. The number of links depends on the total number of product categories.
 * 
 */
 
/* Connect to database */
$con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
$rs = mysql_select_db("clargr1", $con) or die("Could not connect select $con database");
$query = "";
$row = array();

/* Fetch categories to list in the sidebar */
$query = ("SELECT name, id FROM `categories`");
$result = mysql_query($query, $con) or die("Could not execute query '$query'");
$row = mysql_fetch_array($result);

/* List categories and link them to the search script */
echo("<li><a href=\"search.php?category=" . $row[1] . "\">$row[0]</a></li>");
while($row = mysql_fetch_array($result)){
	if($row[0] != NULL){
		echo("<li><a href=\"search.php?category=" . $row[1] . "\">$row[0]</a></li>");
    }
}

?>