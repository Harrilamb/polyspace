<?php
	function connectToMAMP(){
		$servername = "localhost";
		$username = "cosmicadmin";
		$password = "DtQNSBuxFG5aerm4nw";
		$dbname="polyspace";

		// Create connection
		$conn = new mysqli($servername, $username, $password,$dbname);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		return $conn;
	};
	
	function connectToServer(){
		$servername = "localhost";
		$username = "harrison_astrnot";
		$password = "Zz4A7N9ND2KKm3Rbpq";
		$dbname = "harrison_polyspace";
	
		// Create connection
		$conn = new mysqli($servername, $username, $password,$dbname);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		return $conn;
	};
	
	function startConn(){
		if($_SERVER["HTTP_HOST"]=="protests.loc"){
			return connectToMAMP();
		}else{
			return connectToServer();
		}
	}
	
?>