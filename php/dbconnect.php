<?php
	function connectToServer(){
		$servername = "localhost";
		$username = "cosmicadmin";
		//$username = "harrison_astrnot";
		$password = "DtQNSBuxFG5aerm4nw";
		//$password = "Zz4A7N9ND2KKm3Rbpq";
		$dbname="polyspace";
		//$dbname = "harrison_polyspace";

		// Create connection
		$conn = new mysqli($servername, $username, $password,$dbname);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		return $conn;
	};
?>