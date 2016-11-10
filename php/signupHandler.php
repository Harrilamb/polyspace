<?php
$a=password_hash(htmlspecialchars($_POST["password"]),PASSWORD_DEFAULT);

include 'dbconnect.php';
$conn=connectToMAMP();

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

$sqlcheck = "SELECT u.id FROM user u WHERE email = '".htmlspecialchars($_POST["email"])."';";
$resultcheck = $conn->query($sqlcheck);
if(mysql_num_rows($resultcheck) > 0){

	$sql="INSERT INTO user (USERNAME,PASSWORD,EMAIL,FIRST_NAME,LAST_NAME,ORG_ID,USER_TYPE_CODE,CREATED_DATE) VALUES ('".htmlspecialchars($_POST["name"])."','".$a."','".htmlspecialchars($_POST["email"])."','".htmlspecialchars($_POST["firstname"])."','".htmlspecialchars($_POST["lastname"])."',1,1,NULL)";
	$result = $conn->query($sql);
	if($result){
		$sqlcheck = "SELECT ID FROM user WHERE EMAIL = '".htmlspecialchars($_POST["email"])."';";
		$resultcheck = $conn->query($sqlcheck);
		while($row = $resultcheck->fetch_assoc()) {
			$a=$row["ID"];
		}
		session_start();
		unset($_SESSION["userid"]);
		unset($_SESSION["usersname"]);
		$_SESSION["userid"]= $a;
		$_SESSION["username"]=htmlspecialchars($_POST["name"]);
		return 1;
	}else{
		return $conn->error;
	}
}else{
	return 0;
}