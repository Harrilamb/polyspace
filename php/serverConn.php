<?php
	function connectToServer(){
		$servername = "slave.ifixit.com";
		$username = "hlambert_ronly";
		$password = "U2JEpipwrQdKP2";
		$dbname = "ifixit_cart";
	
		// Create connection
		$conn = new mysqli($servername, $username, $password,$dbname);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		
		return $conn;
	};
?>