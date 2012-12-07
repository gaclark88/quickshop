<?php include "session.php"; ?>

<!--Index.php is the an auto generated page for a any particular product. The product id passed to the page determines which product's page is generated-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>View Product</title>

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
         
                        /* Takes in product id */
                        if(isset($_GET['product_id']))
                        {
                            $productId = $_GET['product_id'];
                            
                            /* Connect to database */
                            $con = mysql_connect("studentdb.gl.umbc.edu","clargr1","clargr1") or die("Could not connect to MySQL");
                            $rs = mysql_select_db("clargr1", $con) or die("Could not connect select $con database");
                            $query = "";
                            $row = array();
                        }
                        ?>
                        
                        <!--Start of section containing product image and details-->
                        <div class="row-fluid">
                            <!--Start of section containing product image-->
                            <div class="span5">
                                <?php
                                
                                /* Fetch and display product image */
                                $query = ("SELECT file_data FROM `images` WHERE product_id =" . $productId);
                                $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                                $row = mysql_fetch_array($result);
                                echo ("<img src=\"data:image/jpeg;base64," . base64_encode( $row[0] ) . "\" width=\"660\" height=\"660\" ><br>");
                                
                                ?>             
                            </div><!--End of section containing product image-->
                            
                            <!--Start of section containing product details-->
                            <div class="span6" style="padding-top:50px">
                                <?php
                                
                                /* Query for product details */
                                $query = ("SELECT id, name, price, inventory, description FROM `products` WHERE id =" . $productId);
                                $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                                $row = mysql_fetch_array($result);
                                
                                /* Display product name */
                                echo("<b><font size=\"5\"> $row[1] </font></b><br>");
                                /* Display price of product */
                                echo("<b><font size=\"4\" color=\"darkred\"> $ $row[2]  </font></b><br>");
                                /* Determine availability of product and display appropriate message. Display "Add to Cart" button as long as product is not Out of Stock  */
                                if($row[3] == -1)
                                {
                                    echo("<font size=\"4\"> Back-Order </font><br>");
                                    /* Add 1 instance of the product to the current user's cart */
                                    echo("<p style=\"margin-top:20px\"><button class=\"btn btn-large\" type=\"button\">Add to Cart</button></p>");
                                }
                                elseif($row[3] == 0)
                                {
                                    echo("<font size=\"4\"color=\"red\">Out of Stock </font><br>");
                                }
                                else{
                                    echo("<font size=\"4\" color=\"green\"> In Stock </font><br>");
                                    /* Add 1 instance of the product to the current user's cart */
                                    echo("<p style=\"margin-top:20px\"><a href=\"addToCart.php?id=" . $row[0] . "\"><button class=\"btn btn-large\" type=\"button\">Add to Cart</button></a></p>");
                                }
                                
                                ?>
                            </div><!--End of section containing product details-->

                        </div><!--End of section containing product image and details-->
                        
                        <!--Start of section containing product description-->
                        <div class="row-fluid">
                            <!--Breakline before product description-->
                            <hr><br>
                            <h4>Product Details</h4>
                            <?php
                            
                            /* Display product description */
                            echo("$row[4]<br>");
                            
                            ?>
                            <!--Breakline after product description-->
                            <hr>
                        </div><!--End of section containing product description-->
                        
                        <!--Start of reviews section-->
                        <div class="row-fluid">
                            <h4>Customer Reviews</h4>
                            <?php
                            
                            /* only give registered users the option to submit and delete reviews */
                            if($_SESSION['accountId'] != session_id())
                            {
                                echo("<a href=\"createReview.php?product_id=" . $productId . "\">(Write a review for this product)</a><br>");
                                
                                $query = ("SELECT * FROM `product_reviews` WHERE account_id =" . $_SESSION['accountId'] . " AND product_id=" . $productId);
                                $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                                $row = mysql_fetch_array($result);
                                if($row[0] != null){
                                    echo("<a href=\"reviewProcessing.php?delete=1&productId=" . $productId  . "\">(Delete your Review)</a><br><br>");
                                }
                            }
                            
                            /* Fetch all reviews for the product */
                            $query = ("SELECT * FROM `product_reviews` WHERE product_id=" . $productId);
                            $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                            $row = mysql_fetch_array($result);
                            
                            /* If none exist, print an appropriate message */
                            if($row[0] == null)
                            {
                                echo("<br><b>No reviews have been written for this product</b>");
                            
                            }
                            /* If reviews for the product do exist, determine the average rating for the product and list all of the reviews */
                            else
                            {
                                /* Query for the total number of ratings given to the product */
                                $count = array();
                                $queryCount = ("SELECT COUNT(*) FROM `product_reviews` WHERE product_id=" . $productId);
                                $resultCount = mysql_query($queryCount, $con) or die("Could not execute query '$queryCount'");
                                $count = mysql_fetch_array($resultCount);
                                $totalRatings = $count[0];
                                
                                /* Fetch all ratings */
                                $rating = array();
                                $queryRating = ("SELECT rating FROM `product_reviews` WHERE product_id=" . $productId);
                                $resultRating = mysql_query($queryRating, $con) or die("Could not execute query '$queryRating'");
                                $rating = mysql_fetch_array($resultRating);
                                $sumRatings = $rating[0];
                                
                                /* Sum up all the ratings */
                                while($rating = mysql_fetch_array($resultRating)){
                                    if($rating[0] != NULL){
                                        $sumRatings = $sumRatings + $rating[0];
                                        
                                    }
                                }
                                
                                /* Determine and print the average rating for the product */
                                $avgRating = ($sumRatings / $totalRatings);
                                echo("<h5>Average rating of this product: " . round($avgRating, 1) . " out of 5</h5><br>");
                                
                                /* Start listing the reviews */
                                /* Determine the first and last name of the reviewer */
                                $name = array();
                                $queryName = ("SELECT first_name, last_name FROM `accounts` WHERE id=" . $row[2]);
                                $resultName = mysql_query($queryName, $con) or die("Could not execute query '$queryName'");
                                $name = mysql_fetch_array($resultName);
                                
                                /* Display the review as well as the name of the reviewer and the rating */
                                echo("<i><b>Review by: " . $name[0] . " " . $name[1] . "</b></i><br>");
                                echo("<i><b>Rating:" . $row[3] . " out of 5</b></i><br>");
                                echo("$row[4]<br><br>");
                                
                                /* Repeat for every review  */
                                while($row = mysql_fetch_array($result)){
                                    if($row[0] != NULL){
                                        
                                        $queryName = ("SELECT first_name, last_name FROM `accounts` WHERE id=" . $row[2]);
                                        $resultName = mysql_query($queryName, $con) or die("Could not execute query '$queryName'");
                                        $name = mysql_fetch_array($resultName);
                                        
                                        echo("<i><b>Review by: " . $name[0] . " " . $name[1] . "</b></i><br>");
                                        echo("<i><b>Rating:" . $row[3] . " out of 5</b></i><br>");
                                        echo("$row[4]<br><br>");    
                                    }
                                }                            
                            }
                            ?>
                            
                            <!--Breakline after product description-->
                            <hr><br>
                        </div><!--End of reviews section-->
                    </div><!--End of Main Section-->
                </div><!--Span-->
            </div><!--End of row containing sidebar and main section-->

      <hr><!--Breakline before Footer-->
      <!--Footer-->
      <footer>
        <p><a href="contact.php">Contact Us</a></p>
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
