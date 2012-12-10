<?php include 'admin_session.php';
include '../models/Admin.php';
$conn = new DatabaseLink();
$a = Admin::dbGet($_SESSION['admin_id'], $conn);
if($a) {
	echo "<script>location.href='index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Login Page</title>

    <!--Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 15px;
        padding-bottom: 20px;
		background: #FFFFFF;
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
	<div class = 'row'>	
		<div class="span6 offset5">
			<?php 
			if( isset($_GET['error']) ) 
				echo "<div class='alert alert-error'><h5>You entered invalid password<h5></div>";
			else if ( isset($_GET['noemail']) )
				echo "<div class='alert alert-error'><h5>Email not found in database<h5></div>";
			?>

			<h3>You must be logged in to acccess Admin Panel</h3>
			<form class="form-horizontal" action="accounts.php" method="post" name="login">
				<div class="control-group">
			      		<label class="control-label" for="email">Email</label>
						<div class="controls">
							<input type="text" name="email" placeholder="Email">
						</div>
			        </div>
				<div class="control-group">
			        	<label class="control-label" for="pass">Password</label>
						<div class="controls">
						      <input type="password" name="pass" placeholder="Password">
					        </div>
			        </div>
			        <div class="control-group">
					<div class="controls">
					        <button type="submit" class="btn btn-primary offset1">Log in</button>
					</div>
			        </div>
			</form>
			                    </div><!--End of Main Section-->
                </div><!--Span-->
           
			
    <!-- Javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery-1.8.2.min.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

</body></html>			