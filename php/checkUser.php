<?php
$a=htmlspecialchars($_POST["code"]);

include 'dbconnect.php';
$conn=connectToMAMP();

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT u.ID ui,u.org_id uoi,u.USERNAME uu,u.PASSWORD up, ut.name utn FROM user u LEFT JOIN user_type ut ON (ut.code=u.user_type_code) WHERE u.EMAIL='".htmlspecialchars($_POST["name"])."'";
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
	unset($_SESSION["privelege"]);
	$_SESSION["userid"]=$c;
	$_SESSION["username"]=$d;
	$_SESSION["orgid"]=$e;
	$_SESSION["privelege"]=$f;
	echo true;
}else{
	echo $c;
}
?>