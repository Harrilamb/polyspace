<?php
$a=htmlspecialchars($_POST["code"]);

include 'dbconnect.php';
$conn=startConn();

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT u.ID ui,u.ORG_ID uoi,u.USERNAME uu,u.PASSWORD up, ut.NAME utn FROM USER u LEFT JOIN USER_TYPE ut ON (ut.CODE=u.USER_TYPE_CODE) WHERE u.EMAIL='".htmlspecialchars($_POST["name"])."'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
	$b=$row["up"];
	$c=$row["ui"];
	$d=$row["uu"];
	$e=$row["uoi"];
	$f=$row["utn"];
}

if(password_verify($a,$b)==1){	
	session_start();
	unset($_SESSION["userid"]);
	unset($_SESSION["username"]);
	unset($_SESSION["orgid"]);
	unset($_SESSION["privilege"]);
	$_SESSION["userid"]=$c;
	$_SESSION["username"]=$d;
	$_SESSION["orgid"]=$e;
	$_SESSION["privilege"]=$f;
	echo true;
}else{
	echo $conn->error;
}
?>