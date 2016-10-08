<?php
$a=htmlspecialchars($_POST["code"]);

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

$sql = "SELECT ID,USERNAME,PASSWORD FROM user WHERE EMAIL='".htmlspecialchars($_POST["name"])."'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
	$b=$row["PASSWORD"];
	$c=$row["ID"];
	$d=$row["USERNAME"];
}

if(password_verify($a,$b)==1){	
	session_start();
	unset($_SESSION["userid"]);
	unset($_SESSION["username"]);
	$_SESSION["userid"]=$c;
	$_SESSION["username"]=$d;
	echo true;
}else{
	echo $c;
}