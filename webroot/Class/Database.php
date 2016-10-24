<?php
/*
* Mysql database class - only one connection alowed
*/

class Database {
	private $_connection;
	private static $_instance; //The single instance
	private $_host = DB_API_HOST;
	private $_username = DB_API_USERNAME;
	private $_password = DB_API_PASSWORD;
	private $_database = DB_API_DATABASE;
	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	// Constructor
	private function __construct() {
		$dsn = "mysql:dbname={$this->_database};host={$this->_host}";

		try {
		    $this->_connection = new PDO($dsn, $this->_username, $this->_password);
		} catch (PDOException $e) {
		    echo 'Connection failed: ' . $e->getMessage();
		}

	}
	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }
	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}