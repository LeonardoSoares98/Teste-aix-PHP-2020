<?php
class User {
	
	// database connection and table name
	private $conn;
	private $db_name = "teste";
	private $table_name = "users";
	
	// object properties
	public $id;
	public $username;
	public $password;
	public $confirm_password;
	
	// constructor with $db as database connection
	public function __construct($db) {
		$this->conn = $db;
	}
	// signup user
	function signup() {
		// Remove html chars
		$this->sanitizeLogin ();
		
		if ($this->isAlreadyExist ()) {
			return false;
		}
		
		// query to insert record
		$query = "INSERT INTO
                    " . $this->db_name . "." . $this->table_name . "
                SET
                    username='" . $this->username . "', password='" . $this->password . "'";
		
		// prepare query
		$stmt = $this->conn->prepare ( $query );
		
		// execute query
		if ($stmt->execute ()) {
			$this->id = $this->conn->lastInsertId ();
			return true;
		}
		return false;
	}
	// login user
	function login() {
		// Remove html chars
		$this->sanitizeLogin ();
		
		// select all query
		$query = "SELECT
                    `id`, `username`, `password`
                FROM
                    " . $this->db_name . "." . $this->table_name . " 
                WHERE
                    username='" . $this->username . "' AND password='" . $this->password . "'";
		// prepare query statement
		$stmt = $this->conn->prepare ( $query );
		// execute query
		$stmt->execute ();
		return $stmt;
	}
	function isAlreadyExist() {
		$query = "SELECT *
            FROM
                " . $this->db_name . "." . $this->table_name . " 
            WHERE
                username='" . $this->username . "'";
		// prepare query statement
		$stmt = $this->conn->prepare ( $query );
		// execute query
		$stmt->execute ();

		if ($stmt->rowCount () > 0) {
			return true;
		} else {
			return false;
		}
	}
	function sanitizeLogin() {
		// sanitize login strings
		$this->username = htmlspecialchars ( strip_tags ( $this->username ) );
		$this->password = htmlspecialchars ( strip_tags ( $this->password ) );
		$this->confirm_password = htmlspecialchars ( strip_tags ( $this->confirm_password ) );
	}
}