<?php
$a=htmlspecialchars($_POST["code"]);

include 'dbconnect.php';
$conn=connectToMAMP();

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
	unset($_SESSION["orgid"]);
	$_SESSION["userid"]=$c;
	$_SESSION["username"]=$d;
	$_SESSION["orgid"]=1;
	echo true;
}else{
	echo $c;
}