<?php include '../session.php'; ?>

<html>
<head>

<?php include 'header_template.php' ?>

<title>Add New Product</title>

</head>

<body>

<?php include 'body_template.php'?>

<div class = 'row'><div class = 'span8'>

<form class = 'form-horizontal' method = POST enctype="multipart/form-data" action = 'commit_item.php'  name 'add_product'>
	
	<div class="control-group">
    <label class="control-label" >Product Name</label>
    <div class="controls">
     <input type = 'text' size = '30' maxLength = '252' name = 'name'>
    </div>
  </div>
	
	<?php
	include '../models/Category.php';
	
	$conn = new DatabaseLink();
	//find all categories 
	$categories = Category::dbGetAll($conn);

	echo "<div class='control-group'>";
    echo "<label class='control-label' >Category</label>";
    echo "<div class='controls'>";
    echo "<select name ='category'> ";	
	foreach($categories as $category){

		echo "<option value = $category->id>".$category->fields['name']." </option>";
	}
	echo "</select>";
	echo "</div>";
	echo "</div>";
	
	$conn->disconnect();
	?>
	
		<div class="control-group">
    <label class="control-label" >Price Per Item</label>
    <div class="controls">
     <input type = 'text' size = '30' maxLength = '252' name = 'price'>
    </div>
  </div>
  
  		<div class="control-group">
    <label class="control-label" >Quantity</label>
    <div class="controls">
     <input type = 'text' size = '30' maxLength = '252' name = 'inventory'>
    </div>
  </div>
  
	  		<div class="control-group">
    <label class="control-label" >Enter Description Below</label>
    <div class="controls">
     <textarea cols = 40 rows = 5 name = 'description'  maxLength = 50000></textarea>
    </div>
  </div>
	
		  		<div class="control-group">
    <label class="control-label" >Select an image to upload</label>
    <div class="controls">
     <input type="file" name="img" id = "img">
    </div>
  </div>
	
	<button type = "submit"  class = "btn btn-primary offset3">Save changes and add new item</button>
</form>

</div></div>

<?php include 'end_template.php'?>
</body>
</html>