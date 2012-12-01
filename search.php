<?php include "session.php"; ?>
<!--Search.php is the page that lists the search results for products based on category or keywords-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Search</title>

    <!--Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 15px;
        padding-bottom: 20px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    
    <!-- Icons -->
    <link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>


  <body>
    <!--Start of Center Section-->
    <div id="center-section">

        <!--Start of Navigation Bar-->
        <div class="navbar navbar-inverse ">
            <div class="navbar-inner">
                <div class="container-nav">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <!--Links to Account Login and Cart-->
                    <div class="nav-collapse collapse">
                        <p class="navbar-text pull-right">
                        <ul class="nav pull-right">
                            <a class="brand" href="accounts.php">Login/Create Account</a>
                            <a class="brand" href="#">My Cart</a>
                        </ul>
                        </p>
                    </div>
                    <!--Search Bar-->
                    <form class="form-search" action="search.php" method="post" name="Search">
                        <div style="text-align:left">
                            <input type="text" name="fsearch" maxlength="100" class="span6  input-large search-query">
                            <button type="submit" class="btn">Search</button>
                        </div>
                    </form><!--End of Search Bar-->
                </div>
            </div>
        </div><!--End of Navigation Bar-->

        <!--Start of the Center Section below the Navigation Bar-->
        <div class="container-center">
            <div class="row-fluid">
                <!--Logo Here-->
                <a class="brand" href="index.php"> <img src="assets/img/logo.png"></a>
            </div>
        
            <!--Start of Sidebar-->
            <div class="row-fluid">
                <div class="span3">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                            <li class="nav-header">Product Categories</li>
                            <?php include 'sidebar.php';?>
                        </ul>
                    </div><!--End of Sidebar-->
                </div><!--Span-->
        
                <!--Start of Main Section-->
                <div class="span9">
                    <div class="container-main">

                        <?php
                        $search = $_POST['fsearch'];
                        $hitId = array();
                        $hitCount = 0;
                        
                        /* Connect to database */
                        $con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
                        $rs = mysql_select_db("clargr1", $con) or die("Could not connect select $con database");
                        $query = "";
                        $row = array();
                        
                        /* if the search page was called by a category link, search by category */
                        if(isset($_GET['category']))
                        {
                            $categoryId = $_GET['category'];
                            
                            /* Determine the name of the category being listed */
                            $query = ("SELECT name FROM `categories` WHERE id = " . $categoryId);
                            $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                            $row = mysql_fetch_array($result);
                            $search = $row[0];
                            
                            /* Find all products that are of the searched category and store their product ids in an array */
                            $query = ("SELECT id  FROM `products` WHERE category_id = " . $categoryId);
                            $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                            $row = mysql_fetch_array($result);
                            if($row[0] != NULL){
                                $hitId[$hitCount] = $row[0];
                                $hitCount++;
                            }
                            while($row = mysql_fetch_array($result)){
                                if($row[0] != NULL){
                                    $hitId[$hitCount] = $row[0];
                                    $hitCount++;
                                }
                            }   
                        }
                        
                        /* if the search page was called via the search bar, search for products by user submitted keywords */
                        else
                        {
                            /* Find all products whose name or description matches the user submitted keywords and store their product ids in an array */
                            $query = ("SELECT id  FROM `products` WHERE MATCH(name, description) against('" . $search . "' IN BOOLEAN MODE)");
                            $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                            $row = mysql_fetch_array($result);
                            if($row[0] != NULL){
                                $hitId[$hitCount] = $row[0];
                                $hitCount++;
                            }
                            while($row = mysql_fetch_array($result)){
                                if($row[0] != NULL){
                                    $hitId[$hitCount] = $row[0];
                                    $hitCount++;
                                }
                            }
                        
                        }
                        
                        /* if no results display apporpriate message */
                        if($hitCount == 0)
                        {
                            echo("<u><h3>No matches found for: \"" . $search . "\"</h3></u><br>");
                        }
                        /* if result are found, report the number of results and list each product */
                        else
                        {
                            echo("<u><h3>" . $hitCount . " matches found for: \"" . $search . "\"</h3></u><br>");
                            
                            /* List each product */
                            for($i = 0; $i < $hitCount; $i++)
                            {
                                /* Fetch the image for the product */
                                $query = ("SELECT file_data FROM `images` WHERE product_id =" . $hitId[$i]);
                                $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                                $row = mysql_fetch_array($result);
                                
                                /* Display the image as a thumbnail */
                                echo ("<img src=\"data:image/jpeg;base64," . base64_encode( $row[0] ) . "\" width=\"260\" height=\"260\" ><br>");
                                
                                /* Query for item details */
                                $query = ("SELECT id, name, price, inventory FROM `products` WHERE id =" . $hitId[$i]);
                                $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                                $row = mysql_fetch_array($result);
                                
                                /* Display product name and link to product page */
                                echo("<b><font size=\"4\"><a href=\"productPage.php?product_id=" . $row[0] . "\"> $row[1] </a></font></b><br>");
                                /* Display price of product */
                                echo("<b><font size=\"4\" color=\"darkred\"> $ $row[2]  </font></b><br>");
                                /* Determine availability of product and display appropriate message */
                                if($row[3] == -1)
                                {
                                    echo("<font size=\"4\"> Back-Order </font>");
                                }
                                elseif($row[3] == 0)
                                {
                                    echo("<font size=\"4\"color=\"red\">Out of Stock </font>");
                                }
                                else{
                                    echo("<font size=\"4\" color=\"green\"> In Stock </font>");
                                }
                                /* Display a button that links to the product page */
                                echo("<p style=\"text-align:right\"><a href=\"productPage.php?product_id=" . $row[0] . "\"><button class=\"btn btn-large\" type=\"button\">View Product</button></a></p>");
                                /* Breakline between products */
                                echo("<hr>");
                            }
                        }
                        ?>
                       
                    </div><!--End of Main Section-->
                </div><!--Span-->
            </div><!--End of row containing sidebar and main section-->

      <hr><!--Breakline before Footer-->
      <!--Footer-->
      <footer>
        <p><a href="#">Contact Us</a></p>
      </footer>

        </div><!--End of the Center Section below the Navigation Bar-->
    </div><!--End of Center Section-->
    

    <!-- Javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery-1.8.2.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body></html>
