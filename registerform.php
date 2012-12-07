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
                            <a class="brand" href="accounts.html">Login/Create Account</a>
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
			if ( isset($_GET['passerr']) )
				echo("<p style=\"color:red\">Passwords must match</p>");
			else if ( isset($_GET['emailerr']) )
				echo("<p style=\"color:red\">Email already exists</p>");
			?>
			<form class="form-horizontal" action="register.php" method="post" name="register">
				<div class="control-group">
			      		<label class="control-label" for="fname">First Name</label>
						<div class="controls">
							<input type="text" name="fname" placeholder="First Name">
						</div>
			        </div>
				<div class="control-group">
			      		<label class="control-label" for="lname">Last Name</label>
						<div class="controls">
							<input type="text" name="lname" placeholder="Last Name">
						</div>
			        </div>
				<div class="control-group">
			      		<label class="control-label" for="inputEmail">Email</label>
						<div class="controls">
							<input type="text" name="inputEmail" placeholder="Email">
						</div>
			        </div>
				<div class="control-group">
			        	<label class="control-label" for="inputPassword">Password</label>
						<div class="controls">
						      <input type="password" name="inputPassword" placeholder="Password">
					        </div>
			        </div>
				<div class="control-group">
			        	<label class="control-label" for="confirmPassword">Confirm Password</label>
						<div class="controls">
						      <input type="password" name="confirmPassword" placeholder="Confirm Password">
					        </div>
			        </div>
			        <div class="control-group">
					<div class="controls">
					        <input type="submit" class="btn"/>
					</div>
			        </div>
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
