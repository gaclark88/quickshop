<?php

class DatabaseLink {
	var $config;
	var $server;
	var $database;
	var $username;
	var $password;
	
	
	var $connection;
	
	function DatabaseLink() {
		$this->config = parse_ini_file(dirname(__FILE__) . '/../db_config.ini');
		$this->server = $this->config["server"] or die ("server not found in db_config.ini");
		$this->database = $this->config["database"] or die ("database not found in db_config.ini");
		$this->username = $this->config["username"] or die ("username not found in db_config.ini");
		$this->password = $this->config["password"] or die ("password not found in db_config.ini");
		$this->getLink();
	}

	function getLink() {
		$connection = @mysql_connect($this->server,
			$this->username, $this->password) or die("Could not connect");
		
		@mysql_select_db($this->database, $connection);
		
		$this->connection = $connection;
	}
	
	function queryDB($queryString, $filename) {
		return mysql_query($queryString, $this->connection);
	}
	
	function disconnect(){
		mysql_close($this->connection);
	}
}
?>
