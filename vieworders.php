<?php include "session.php"; ?>
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
			<?php include_once './models/Model.php';
				$db = new DatabaseLink();
				$rows = Model::dbGetBy("account_id", $_SESSION['accountId'], 'orders', $db);

				$account_orders = array();
				while ($row = mysql_fetch_assoc($rows)) 
					array_push($account_orders, $row['id']);

				$orders_rows = Model::dbGetAllInList("client_orders", "id", $account_orders, $db);
			?>
			<h3>Order History</h3>
			<p>Orders can be cancelled only if they haven't been processed yet</p>
			<table border = 1>
			<tr>
			<th width = 75>Order #</th>
			<th width = 100>Status</th>
			<th width = 100>Product Name</th>
			<th width = 75>Quantity</th>
			<th width = 50>Customer Name</th>
			<th width = 100>Shipping Address</th>
			<th width = 100>Shipping City</th>
			<th width = 100>Shipping State</th>
			<th width = 100>Shipping Zip</th>
			<th width = 50>Cancel</th>
			</tr>
			<form name="submit_cancel" action="cancel.php" method="POST">
			
			<?php

			while($row = mysql_fetch_assoc($orders_rows)){
					
					
				echo "<tr>";
				echo "<td align = 'center'><a href=\"invoice.php?order_id=$row[id]\">".$row[id]."</a></td>";
				echo "<td align = 'center'>".$row['status']."</td>";
				echo "<td align = 'center'>".$row['product_name']."</td>";
				echo "<td align = 'center'>".$row['quantity']."</td>";
				echo "<td align = 'center'>".$row['shipping_name']."</td>";
				echo "<td align = 'center'>".$row['shipping_address']."</td>";
				echo "<td align = 'center'>".$row['shipping_city']."</td>";
				echo "<td align = 'center'>".$row['shipping_state']."</td>";
				echo "<td align = 'center'>".$row['shipping_zip']."</td>";
				if ($row['status'] == "Submitted")
					echo "<td align = 'center'><input type=\"checkbox\" name=\"orders\" value=" . $row['id'] . " /></td>";
				else
					echo "<td />";
				echo "</tr>";
			}
			?>

			</table>
			<br><br>
			<input type=submit value="Submit" />
			</form>
			

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
