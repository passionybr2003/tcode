<?php
require_once 'libs/config.php';
class DbConnect {
	public $con = '';
	public function __construct(){
		
		$DBServer = DB_HOST;
		$DBUser   = DB_USER;
		$DBPass   = DB_PWD;
		$DBName   = DB_NAME;

		$this->con = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
		// check connection
		if ($this->con->connect_error) {
		  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
		}
	}
	
	public function qry_insert($sql){
		if($this->con->query($sql) === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->con->error, E_USER_ERROR);
		} else {
		  $last_inserted_id = $this->con->insert_id;
		  $affected_rows = $this->con->affected_rows;
		  return $this->con;
		}
	}
	public function qry_select($sql){
		$sql_res = $this->con->query($sql);
		if($sql_res  === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->con->error, E_USER_ERROR);
		} else {
			return $res = $sql_res->fetch_array(MYSQLI_ASSOC);
		}
	}
	
	public function qry_update($sql){
		if($this->con->query($sql) === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->con->error, E_USER_ERROR);
		} else {
			return $affected_rows = $this->con->affected_rows;
		}
	}
	
	public function __destruct(){
		$this->con->close();
	}
	

}
