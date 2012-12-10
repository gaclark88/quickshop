<?php

class DatabaseLink {
	var $config;
	var $server;
	var $database;
	var $username;
	var $password;
	
	
	// the connection itself
	var $connection;
	
	/*
	 * create a new DatabaseLink and make a mysql connection
	 * the connection params are configure in /db_config.ini
	 */
	function DatabaseLink() {
		$this->config = parse_ini_file(dirname(__FILE__) . '/../db_config.ini');
		$this->server = $this->config["server"] or die ("server not found in db_config.ini");
		$this->database = $this->config["database"] or die ("database not found in db_config.ini");
		$this->username = $this->config["username"] or die ("username not found in db_config.ini");
		$this->password = $this->config["password"] or die ("password not found in db_config.ini");
		$this->getLink();
	}

	/*
	 * for internal user
	 * make a mysql connection
	 */
	function getLink() {
		$connection = @mysql_connect($this->server,
			$this->username, $this->password) or die("Could not connect");
		
		@mysql_select_db($this->database, $connection);
		
		$this->connection = $connection;
	}
	
	/*
	 * query the db
	 */
	function queryDB($queryString, $filename) {
		return mysql_query($queryString, $this->connection);
	}
	
	/*
	 * disconnect from the database
	 */
	function disconnect(){
		mysql_close($this->connection);
	}
}
?>
