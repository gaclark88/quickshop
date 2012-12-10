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
			    <?php include '../models/Admin.php';
				$conn = new DatabaseLink();
				$a = Admin::dbGet($_SESSION['admin_id'], $conn);
				if ($a == false) {
					echo "<script>location.href='login.php'</script>";
					}
			    ?>	
					<a class="brand" href="logout.php">Log Out</a>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div><!--End of Navigation Bar-->

        <!--Start of the Center Section below the Navigation Bar-->
        <div class="container-center">
            <div class="row-fluid">
                <!--Logo Here-->
                <a class="brand" href="index.php"> <img src="../assets/img/logo.png"></a>
            </div>
        
            <!--Start of Sidebar-->
            <div class="row-fluid">
                <div class="span3">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                            <li class="nav-header">Navigation</li>
								<li><a href="browse_inventory.php">Manage Inventory</a></li>
									<li> <a href="manage_orders.php">Manage Orders</a> </li>
									<li> <a href="add_item.php">Add Item</a> </li>
									<li> <a href="add_category.php">Add / Change Category</a> </li>
									<li> <a href="view_client_info.php">View Client Information</a> </li>
                        </ul>
                    </div><!--End of Sidebar-->
                </div><!--Span-->
        
                <!--Start of Main Section-->
                <div class="span9">
                    <div class="container-main">

                        



