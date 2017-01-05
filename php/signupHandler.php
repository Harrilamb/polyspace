<?php
$a=password_hash(htmlspecialchars($_POST["password"]),PASSWORD_DEFAULT);

include 'dbconnect.php';
$conn=startConn();

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

$sqlcheck = "SELECT u.ID ui FROM USER u WHERE EMAIL = '".htmlspecialchars($_POST["email"])."';";
$resultcheck = $conn->query($sqlcheck);
$outp = array();
$i=0;
while($rs = $resultcheck->fetch_assoc()) {
	$outp[$i]=$rs["ui"];
	$i++;
}
if(sizeof($outp) === 0){

	$sql="INSERT INTO USER (USERNAME,PASSWORD,EMAIL,FIRST_NAME,LAST_NAME,ORG_ID,USER_TYPE_CODE,CREATED_DATE) VALUES ('".htmlspecialchars($_POST["name"])."','".$a."','".htmlspecialchars($_POST["email"])."','".htmlspecialchars($_POST["firstname"])."','".htmlspecialchars($_POST["lastname"])."',1,1,NULL)";
	$result = $conn->query($sql);
	
	if($result){
		$sqlnew = "SELECT ID FROM USER WHERE EMAIL = '".htmlspecialchars($_POST["email"])."';";
		$resultnew = $conn->query($sqlnew);
		while($row = $resultnew->fetch_assoc()) {
			$a=$row["ID"];
		}
		session_start();
		unset($_SESSION["userid"]);
		unset($_SESSION["usersname"]);
		$_SESSION["userid"]= $a;
		$_SESSION["username"]=htmlspecialchars($_POST["name"]);
		echo 1;
	}else{
		echo $conn->error;
	}
}else{
	echo 0;
}