<?php include 'admin_session.php'; ?>


<html>
<head>

<?php include 'header_template.php' ?>

<title>Change pass</title>

</head>

<body>

<?php include 'body_template.php'?>

			<?php
			//make sure the current password is correct
			if ( isset($_GET['error']) )
				echo("<p style=\"color:red\">Invalid password</p>");
			//make sure the paswords match
			else if ( isset($_GET['passerr']) )
				echo("<p style=\"color:red\">Passwords must match</p>");
			?>
			<h3>Change password</h3>
			<!-- change password form -->
			<form class="form-horizontal" action="admin_pass.php" method="post" name="register">
				<div class="control-group">
			      		<label class="control-label" for="oldpass">Current password</label>
						<div class="controls">
							<input type="password" name="oldpass" placeholder="Current password">
						</div>
			        </div>
				<div class="control-group">
			      		<label class="control-label" for="newpass">New password</label>
						<div class="controls">
							<input type="password" name="newpass" placeholder="New password">
						</div>
			        </div>
				<div class="control-group">
			      		<label class="control-label" for="confirmpass">Confirm password</label>
						<div class="controls">
							<input type="password" name="confirmpass" placeholder="Confirm password">
						</div>
			        </div>
			        <div class="control-group">
					<div class="controls">
					        <button type="submit" class="btn btn-primary">Submit</button>
					</div>
			        </div>
			</form>


  

<?php include 'end_template.php'?>
</body>
</html>
