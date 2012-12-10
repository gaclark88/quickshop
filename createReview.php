<?php include "session.php"; ?>
<!--createReview.php allows a customer to submit a review for a product. The review consists of the a rating from 1-5 and a written opinion. -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Front Page</title>

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
			    <?php include './models/Account.php';
				$db = new DatabaseLink();
				$a = Account::dbGet($_SESSION['accountId'], $db);
				if ($a == false) {
					echo("<a class=\"brand\" href=\"login.php\">Login/Create Account</a>");
				} else {
					echo("<a class=\"brand\" href=\"accountmgr.php\">Hello, " . $a->fields['first_name'] . "!</a>");
				}
			    ?>	
                            <a class="brand" href="mycart.php">My Cart</a>
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
                        <form action="reviewProcessing.php" method="post" name="Processing">
                        
                            <?php
                            if(isset($_GET['product_id']))
                            {
                                /* Posts the customer's account id for processing */
                                echo("<input type=\"hidden\" name=\"accountId\" value=\"" . $_SESSION['accountId'] . "\"><br>");
                             
                                /* Connect to database */
				$db = new DatabaseLink();
				$con = $db->connection;
                                $query = "";
                                $row = array();
                                
                                /* Query for the name of the product being reviewed */
                                $query = ("SELECT name FROM `products` WHERE id =" . $_GET['product_id']);
                                $result = mysql_query($query, $con) or die("Could not execute query '$query'");
                                $row = mysql_fetch_array($result);
                                
                                echo("<h3>Write your review</h3><br>");
                                
                                /* Print the name of the product being reviewed and post the product's id for processing */
                                echo("<b>Product:</b> " . $row[0] . "<br>");
                                echo("<input type=\"hidden\" name=\"productId\" value=\"" . $_GET['product_id'] . "\"><br>");
                                
                                /* Generates a dropdown box of ratings from 1 to 5 */
                                echo("<b>How would you rate this product: </b>");
                                echo("<select style=\"width:60px;\" name=rating>");
                                for($i = 1; $i <= 5; $i++)
                                {
                                    echo("<option value=\"" . $i . "\">" . $i ."</option>");
                                
                                }
                                echo("</select> out of 5 <br><br>");
                                
                                /* Generates a text box for the customer to type their opinion about the product */
                                echo("<b>What do you think of this product?</b><br>");
                                echo("<textarea style=\"width:750px; height: 200px;\" name=\"review\" maxlength=\"3000\"></textarea><br>");
                                
                                /* generates a submit button to submit the review for processing */
                                echo("<input type=\"submit\" value=\"Submit Review\">");
				
				$db->disconnect();
                            }      
                            ?>

                        </form>


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
