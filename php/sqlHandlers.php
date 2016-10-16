<?php
	session_start();
	include 'dbconnect.php';
	$conn=connectToServer();
	$me=$_SESSION["userid"];
	$org=$_SESSION["orgid"];
	
	if($_POST["action"]=="add_team"){
		$teamName = htmlspecialchars($_POST["name"]);
		$teamDesc = htmlspecialchars($_POST["description"]);
		echo addTeam($teamName,$teamDesc);
	}elseif($_GET["action"]=="find_current_team"){
		echo findTeams();
	}
	
	function addTeam($name,$desc){
		global $conn;
		global $me;
		global $org;
		
		$sql="INSERT INTO team (NAME,DESCRIPTION,ORG_ID,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('".$name."','".$desc."',".$org.",".$me.",NULL)";
		
		$result = $conn->query($sql);
		if($result){
			$team = $conn->insert_id;
			$sql2="INSERT INTO joint_user_team (USERID,TEAMID,OWNER,CREATED_BY_USER_ID,CREATED_DATE) VALUE (".$me.",".$team.",1,".$me.",NULL)";
			$result2=$conn->query($sql2);
			if($result2){
				return 1;
			}else{
				return $conn->error;
			}
		}else{
			return $conn->error;
		}
	}
	
	function findTeams(){
		global $conn;
		global $me;
		global $org;
		
		$sql="SELECT t.id ti, t.name tn, t.description td, jut.userid ju,u.username uu,t.project_id tp FROM joint_user_team jut LEFT JOIN team t ON (t.id=jut.teamid) LEFT JOIN user u ON (u.id=jut.userid) WHERE jut.teamid IN (SELECT t.id FROM user u LEFT JOIN joint_user_team jut ON (jut.userid=u.id) LEFT JOIN team t ON (t.id=jut.teamid) WHERE jut.current=1 AND jut.userid=".$me.") AND jut.owner=1 AND t.org_id=".$org;
		
		$result=$conn->query($sql);
		if($result){
			$outp = "";
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($outp != "") {$outp .= ",";}
				$outp .= '{"id":"'  . $rs["ti"] . '",';
				$outp .= '"name":"'   . $rs["tn"]        . '",';
				$outp .= '"description":"'   . $rs["td"]        . '",';
				$outp .= '"currProj":"'   . $rs["tp"]        . '",';
				$outp .= '"owner":"'   . $rs["uu"]        . '",';
				$outp .= '"ownerid":"'. $rs["ju"]     . '"}'; 
			}
			$outp ='{"records":['.$outp.']}';
			$conn->close();
			
			/*$arr = array();
			while($row = $result->fetch_assoc()) {
				array_push($arr,[id=>$row["ti"],name=>$row["tn"],description=>$row["td"],currProj=>$row["tp"],owner=>$row["uu"],ownerid=>$row["ju"]]);
			}*/
			echo $outp;
		}
	}
?>