<?php

include_once("Model.php");

class Image extends Model {
	var $fieldnames = array("filename",
				"mime_type",
				"size",
				"file_data",
				"product_id");

	function fromImage($image, $product_id=NULL) {
		$info = getImageSize($image['tmp_name']);
		
		if(!$info) {
			return FALSE;
		}
		
		$fields = array();

		$db = new DatabaseLink();
		$db = $db->connection;
		$fields["filename"] = $image['name'];
		$fields["mime_type"] = $info['mime'];
		$fields["size"] = $image['size'];
		$fields["file_data"] = file_get_contents($image['tmp_name']);
		$fields["product_id"] = $product_id;

		$newImage = new Image($fields);

		$newImage->table = "images";
		return $newImage;
	
	}
	
	function Image($fields) {
		parent::Model($this->fieldnames, $fields, "images");
	}	

	function dbGet($id, $dbLink) {
		$fields = parent::dbGet($id, "images", $dbLink);

		if (!$fields) {return $fields;}
		//foreach ($fields as $field => $value) {
		//	echo $field . " => " . $value . "<br />";
		//}
		
		$image = new Image($fields);
		$image->id = $fields["id"];
		return $image;
	}

	function dbGetBy($field, $key, $dbLink) {
		$rows = parent::dbGetBy($field, $key, "images", $dbLink);		

		$images = array();
		
		while ($row = mysql_fetch_assoc($rows)) {
			$image = new Image($row);
			$image->id = $row["id"];
			
			array_push($images, $image);
		}
		
		return $images;
	}
	
	
	/*
	 * fetch an image by its product_id
	 */
	function dbGetByProductId($product_id, $dbLink) {
		$rows = parent::dbGetBy("product_id", $product_id, "images", $dbLink);
		$row = mysql_fetch_assoc($rows);
		$image = new Image($row);
		$image->id = $row["id"];
		
		return $image;
	}		

}
/*
$list = array("desk.jpg", "lamp.jpg", "towels.jpg", "britten.jpg", "reich.jpg");
foreach ($list as $filename) {
$file = fopen($filename, "rb");
$image = fread($file, filesize($filename));
fclose($file);

$fields = array(
	"name" => $filename,
	"mime" => "image/jpeg",
	"size" => filesize($filename),
	"tmp_name" => $filename
);

$p_id = split("-", $filename);

$i = Image::fromImage($fields);

$db = new DatabaseLink();
$i->dbSave($db);
}
*/

/*
$db = new DatabaseLink();
$realImage = Image::dbGet(62, $db);

header("Content-Type: " . $realImage->fields["mime_type"]);
echo $realImage->fields['file_data'];
*/
?>
