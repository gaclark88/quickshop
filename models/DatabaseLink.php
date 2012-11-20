<?php

class DatabaseLink {
	var $connection;
	
	function DatabaseLink() {
		$this->getLink();
	}

	function getLink() {
		$connection = @mysql_connect("studentdb.gl.umbc.edu",
			"clargr1", "clargr1") or die("Could not connect");
		
		@mysql_select_db("clargr1", $connection);
		
		$this->connection = $connection;
	}

	function queryDB($queryString, $filename) {
		return mysql_query($queryString, $this->connection);
	}
}
?>
