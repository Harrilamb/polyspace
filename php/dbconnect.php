<?php
	function connectToMAMP(){
		$servername = "localhost";
		$username = "change-to-your-value";
		$password = "change-to-your-value";
		$dbname="change-to-your-value";

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
		$username = "change-to-your-value";
		$password = "change-to-your-value";
		$dbname = "change-to-your-value";
	
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