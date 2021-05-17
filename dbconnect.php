<?php 
	$DBcon = connectDB();
	//var_dump($DBcon );
	$con = configDB();
	//var_dump($con);
?>


<?php
	function getConnection($type_mysql){
		//$host = "lsbankingportal.com"; 
		$host = "localhost"; 
		$user = "dblsuser2021"; 
		$password = "^%D24L*!Ti5%"; 
		$database = "dbs57337";
		
		switch($type_mysql){
			case "mysql":
				return new mysqli($host, $user, $password, $database);
			case "MySQLi":
				return new MySQLi($host, $user, $password, $database);
			default:
				return null; 
		}
	}

	function configDB(){
		$con = getConnection("mysql");
// Check connection
		if ($con->connect_error) {
			die("Connection failed: " . $con->connect_error);
		}

		return $con;
	}

	 function connectDB(){
		$DBcon = getConnection("MySQLi");

		if ($DBcon->connect_errno) {
			die("ERROR : -> ".$DBcon->connect_error);
		}
		return $DBcon;
	 }

	 function get_fetch_array($query){
		$DBcon = connectDB();
		$query_from_db = $DBcon->query($query);
		$result = $query_from_db->fetch_array(MYSQLI_ASSOC);
		$DBcon->close();
		return $result;
	 }

	 function get_fetch_array_with_count($query){
		$DBcon = connectDB();
		$query_from_db = $DBcon->query($query);
		$result = $query_from_db->fetch_array(MYSQLI_ASSOC);
		$DBcon->close();
		return $result;		 
	 }


	 function real_escape_string($string){
		$DBcon = connectDB();
		return $DBcon->real_escape_string($string);
	 }


	 
?>