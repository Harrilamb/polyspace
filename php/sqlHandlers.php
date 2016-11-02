<?php
	session_start();
	include 'dbconnect.php';
	include 'utilities.php';
	$conn=connectToMAMP();
	mysql_set_charset("utf8");
	if($_GET["glimpse"]){
		$me=$_GET["glimpse"];
		$actualUser=FALSE;
	}else{
		$me=$_SESSION["userid"];
		$actualUser=TRUE;
	}
	$org=$_SESSION["orgid"];
	
	if($_POST["action"]=="add_team"){
		$teamName = htmlspecialchars($_POST["name"]);
		$teamDesc = htmlspecialchars($_POST["description"]);
		echo addTeam($teamName,$teamDesc);
	}elseif($_POST["action"]=="add_project"){	
		$projTitle = htmlspecialchars($_POST["title"]);
		$projDesc = htmlspecialchars($_POST["description"]);
		echo addProject($projTitle,$projDesc);
	}elseif($_POST["action"]=="add_system"){
		$systemParent = htmlspecialchars($_POST["parent"]);
		$systemTitle = htmlspecialchars($_POST["title"]);
		$systemDesc = htmlspecialchars($_POST["description"]);
		echo addSystem($systemParent,$systemTitle,$systemDesc);
	}elseif($_POST["action"]=="add_requirement"){
		$reqName = htmlspecialchars($_POST["name"]);
		$reqDesc = htmlspecialchars($_POST["description"]);
		$reqPF = htmlspecialchars($_POST["passfail"]);
		$reqSource = htmlspecialchars($_POST["source"]);
		$reqTier = htmlspecialchars($_POST["tier"]);
		$reqDyn = htmlspecialchars($_POST["dynamic"]);
		echo addRequirement($reqName,$reqDesc,$reqPF,$reqSource,$reqTier,$reqDyn);
	}elseif($_POST["action"]=="add_variable"){
		$variableName = htmlspecialchars($_POST["name"]);
		$variableDesc = htmlspecialchars($_POST["description"]);
		$variableSymbol = htmlspecialchars($_POST["symbol"]);
		$variableUnits = htmlspecialchars($_POST["units"]);
		echo addVariable($variableName,$variableDesc,$variableSymbol,$variableUnits);
	}elseif($_POST["action"]=="find_reqs"){
		$sysid = $_POST["sysid"];
		echo findReqs($sysid);
	}elseif($_POST["action"]=="link_requirements"){
		$sysid = $_POST["sysid"];
		$reqids = $_POST["reqids"];
		echo sysReqLinkage($sysid,$reqids,1);
	}elseif($_POST["action"]=="unlink_requirements"){
		$sysid = $_POST["sysid"];
		$reqids = $_POST["reqids"];
		echo sysReqLinkage($sysid,$reqids,0);
	}elseif($_POST["action"]=="unlinked_variables"){
		echo findVariables($_POST["notin"],true);
	}elseif($_GET["action"]=="current_team"){
		echo findTeams(1);
	}elseif($_GET["action"]=="other_teams"){
		echo findTeams(0);
	}elseif($_GET["action"]=="current_project"){
		echo findProjects(1);
	}elseif($_GET["action"]=="other_projects"){
		echo findProjects(0);
	}elseif($_GET["action"]=="all_systems"){
		echo findSystems();
	}elseif($_GET["action"]=="all_requirements"){
		echo findRequirements();
	}elseif($_GET["action"]=="all_variables"){
		echo findVariables();
	}else{
		echo "No Task Found";
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
	
	function addProject($title,$desc){
		global $conn;
		global $me;
		global $org;
		
		$sql="INSERT INTO project (TITLE,DESCRIPTION,OWNERID,ORG_ID,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('".$title."','".$desc."','".$me."',".$org.",".$me.",NULL)";
		
		$result = $conn->query($sql);
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
	
	function addSystem($parent,$title,$desc){
		global $conn;
		global $me;
		global $org;
		
		$ismaster=0;
		if($parent==0){
			$parent=NULL;
			$ismaster=1;
		}
		
		$sql="INSERT INTO system (TITLE,DESCRIPTION,PARENT_ID,PROJECT_ID,ISMASTER,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('".$title."','".$desc."','".$parent."',(SELECT t.project_id FROM joint_user_team jut LEFT JOIN team t ON (t.id=jut.teamid) WHERE jut.CURRENT=1 AND jut.USERID=".$me."),".$ismaster.",".$me.",NULL)";
		
		$result = $conn->query($sql);
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
	
	function addRequirement($name,$desc,$pf,$source,$toi,$dyn){
		global $conn;
		global $me;
		global $org;
		
		$sql="INSERT INTO requirement (NAME,DESCRIPTION,SOURCE,PF_FORMAT,TIER,DYNAMIC,PROJECT_ID,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('".$name."','".$desc."','".$source."','".$pf."',".$toi.",".$dyn.",(SELECT t.project_id FROM joint_user_team jut LEFT JOIN team t ON (t.id=jut.teamid) WHERE jut.CURRENT=1 AND jut.USERID=".$me."),".$me.",NULL)";
		
		$result = $conn->query($sql);
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
	
	function addVariable($name,$desc,$symb,$unit){
		global $conn;
		global $me;
		global $org;
		
		$sql="INSERT INTO vars (NAME,DESCRIPTION,SYMBOL,UNITS,PROJECT_ID,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('".$name."','".$desc."','".$symb."','".$unit."',(SELECT t.project_id FROM joint_user_team jut LEFT JOIN team t ON (t.id=jut.teamid) WHERE jut.CURRENT=1 AND jut.USERID=".$me."),".$me.",NULL)";
		
		$result = $conn->query($sql);
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
	
	function findTeams($current){
		global $conn;
		global $me;
		global $org;
		
		if($current){
			$sql="SELECT t.id ti, t.name tn, t.description td, jut.userid ju,u.username uu,t.project_id tp FROM joint_user_team jut LEFT JOIN team t ON (t.id=jut.teamid) LEFT JOIN user u ON (u.id=jut.userid) WHERE jut.teamid IN (SELECT t.id FROM user u LEFT JOIN joint_user_team jut ON (jut.userid=u.id) LEFT JOIN team t ON (t.id=jut.teamid) WHERE jut.current=1 AND jut.userid=".$me.") AND jut.owner=1 AND t.org_id=".$org." AND t.active=1";
		}else{
			$sql = "SELECT t.id ti, t.name tn, t.description td, jut.userid ju,u.username uu,t.project_id tp FROM joint_user_team jut LEFT JOIN team t ON (t.id=jut.teamid) LEFT JOIN user u ON (u.id=jut.userid) WHERE jut.teamid NOT IN (SELECT t.id FROM user u LEFT JOIN joint_user_team jut ON (jut.userid=u.id) LEFT JOIN team t ON (t.id=jut.teamid) WHERE jut.current=1 AND jut.userid=".$me.") AND jut.owner=1 AND t.org_id=".$org." AND t.active=1";
		}
		
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

			echo $outp;
		}
	}
	
	function findProjects($current){
		global $conn;
		global $me;
		global $org;
		
		if($current){
			$sql="SELECT p.id pi, p.title pt, p.description pd, ow.username uu FROM team t LEFT JOIN joint_user_team jut ON (jut.teamid=t.id) LEFT JOIN user u ON (u.id=jut.userid) LEFT JOIN project p ON (p.id=t.project_id) LEFT JOIN user ow ON (ow.id=p.ownerid) WHERE p.org_id=".$org." AND p.active=1 AND (jut.userid=".$me." AND jut.current=1)";
		}else{
			$sql = "SELECT p.id pi, p.title pt, p.description pd, ow.username uu FROM project p LEFT JOIN user ow ON (ow.id=p.ownerid) WHERE p.org_id=".$org." AND p.active=1 AND p.id NOT IN (SELECT t.project_id FROM team t LEFT JOIN joint_user_team jut ON (jut.teamid=t.id) LEFT JOIN user u ON (u.id=jut.userid) WHERE jut.userid=".$me." AND jut.current=1)";
		}
		
		$result=$conn->query($sql);
		if($result){
			$outp = "";
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($outp != "") {$outp .= ",";}
				$outp .= '{"id":"'  . $rs["pi"] . '",';
				$outp .= '"title":"'   . $rs["pt"]        . '",';
				$outp .= '"description":"'   . $rs["pd"]        . '",';
				$outp .= '"owner":"'   . $rs["uu"]        . '",';
				$outp .= '"ownerid":"'. $rs["po"]     . '"}'; 
			}
			$outp ='{"records":['.$outp.']}';
			$conn->close();

			echo $outp;
		}
	}
	
	function findSystems(){
		global $conn;
		global $me;
		global $org;
		
		$sql = "SELECT s.id si, s.title st, s.description sd, u.username uu FROM system s LEFT JOIN project p ON (p.id=s.project_id) LEFT JOIN user u ON (u.id=s.created_by_user_id) WHERE s.project_id IN (SELECT p.id pi FROM team t LEFT JOIN joint_user_team jut ON (jut.teamid=t.id) LEFT JOIN user u ON (u.id=jut.userid) LEFT JOIN project p ON (p.id=t.project_id) LEFT JOIN user ow ON (ow.id=p.ownerid) WHERE p.org_id=".$org." AND p.active=1 AND (jut.userid=".$me." AND jut.current=1))";
		
		$result = $conn->query($sql);
		if($result){
			$outp = "";
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($outp != "") {$outp .= ",";}
				$outp .= '{"id":"'  . $rs["si"] . '",';
				$outp .= '"title":"'   . $rs["st"]        . '",';
				$outp .= '"owner":"'   . $rs["uu"]        . '",';
				$outp .= '"description":"'. $rs["sd"]     . '"}'; 
			}
			$outp ='{"records":['.$outp.']}';
			$conn->close();

			echo $outp;
		}
	}
	
	function findRequirements(){
		global $conn;
		global $me;
		global $org;
		
		$sql = "SELECT r.id ri, r.name rn, r.description rd, u.username uu FROM requirement r LEFT JOIN project p ON (p.id=r.project_id) LEFT JOIN user u ON (u.id=r.created_by_user_id) WHERE r.active=1 AND p.org_id=".$org;
		
		$result = $conn->query($sql);
		if($result){
			$outp = "";
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($outp != "") {$outp .= ",";}
				$outp .= '{"id":"'  . $rs["ri"] . '",';
				$outp .= '"name":"'   . $rs["rn"]        . '",';
				$outp .= '"owner":"'   . $rs["uu"]        . '",';
				$outp .= '"description":"'. $rs["rd"]     . '"}'; 
			}
			$outp ='{"records":['.$outp.']}';
			$conn->close();

			echo $outp;
		}
	}
	
	function findVariables($notin="(0)",$htmlified=false){
		global $conn;
		global $me;
		global $org;
		
		$sql = "SELECT v.id vi, v.name vn, v.description vd, v.symbol vs, v.units vu, u.username uu FROM vars v LEFT JOIN project p ON (p.id=v.project_id) LEFT JOIN user u ON (u.id=v.created_by_user_id) WHERE v.active=1 AND p.org_id=".$org." AND v.id NOT IN ".$notin;
		
		$result = $conn->query($sql);
		if($result){
			$outHTML = "<h4>Unlinked Variables</h4><div id='popupVariables'>";
			$outp = "";
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($outp != "") {$outp .= ",";}
				$outp .= '{"id":"'  . $rs["vi"] . '",';
				$outp .= '"name":"'   .   $rs["vn"]     . '",';
				$vsymb = cleanString($rs["vs"]);
				$outp .= '"symbol":"'   .   htmlspecialchars($vsymb)     . '",';
				$outp .= '"owner":"'   .   $rs["uu"]     . '",';
				$outp .= '"description":"'. $rs["vd"]     . '"}'; 
				$outHTML .= "<div id='var".$rs["vi"]."' class='unlinkedVariables'><p><strong>".htmlspecialchars($vsymb)." </strong>".$rs["vn"].": ".$rs["vd"]."</p></div>";
			}
			$outp ='{"records":['.$outp.']}';
			$outHTML.="<button id='addEntryInput' class='uibutton buttons addVars'>Add</button></div>";
			$conn->close();
			if($htmlified){
				echo $outHTML;
			}else{
				echo $outp;
			}
		}
	}
	
	function findReqs($sysid){
		global $conn;
		global $me;
		global $org;
		$sql = "SELECT r.id ri, r.name rn, r.description rd, IF(r.id IN (SELECT jrs.requirementid FROM joint_requirement_system jrs WHERE jrs.active=1 AND jrs.systemid=".$sysid."),true,false) linked FROM requirement r WHERE r.active=1";
		
		$result = $conn->query($sql);
		if($result){
			$outp=array();
			$i=0;
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) { 
				$outp[$i] = array("id" => $rs["ri"],"name" => $rs["rn"],"description" => $rs["rd"],"linked" => $rs["linked"]);
				$i++;
			}
			$outFinal =array("records"=>$outp);
			$conn->close();

			echo json_encode($outFinal);
		}else{
			$outFinal =array();
			$conn->close();

			echo json_encode($outFinal);
		}
	}
	
	function sysReqLinkage($sysid,$reqids,$connect){
		global $conn;
		global $me;
		global $org;
		
		$reqsUn="(";
		foreach($reqids as $i){
			if($reqsUn != "(") {$reqsUn .= ",";}
			$reqsUn.=$i;
		}
		$reqsUn.=")";
		
		if($connect==1){
			$sqlcheck = "SELECT requirementid ri FROM joint_requirement_system WHERE systemid=".$sysid." AND requirementid IN ".$reqsUn;
			$resultcheck=$conn->query($sqlcheck);
			$outp = array();
			$i=0;
			while($rs = $resultcheck->fetch_array(MYSQLI_ASSOC)) { 
				$outp[$i]= $rs["ri"];
				$i++;
			}
			$requ="(";
			$reqi="(";
			foreach($reqids as $i){
				if($requ != "(") { $requ .= ",";}
				if($reqi != "(") { $reqi .= ",(";}
				if(in_array($i,$outp)){
					$requ.=$i;
				}else{
					$reqi.=$sysid.",".$i.",1,".$me.",NULL";
					$reqi.=")";
				}
			}
			$requ=rtrim($requ, ",").")";
			
			$sql1="";
			$sql2="";
			if(sizeof($outp)<sizeof($reqids)){
				$sql1 = "INSERT INTO JOINT_REQUIREMENT_SYSTEM (SYSTEMID,REQUIREMENTID,ACTIVE,CREATED_BY_USER_ID,CREATED_DATE) VALUES ".$reqi.";";
			}
			if(sizeof($outp)>0){	
				$sql2 = "UPDATE JOINT_REQUIREMENT_SYSTEM SET ACTIVE=1 WHERE SYSTEMID=".$sysid." AND REQUIREMENTID IN ".$requ;
			}
			$sql=$sql1." ".$sql2;
			$result= $conn->multi_query($sql);
		}else{
			$sql="UPDATE JOINT_REQUIREMENT_SYSTEM SET ACTIVE=0 WHERE SYSTEMID=".$sysid." AND REQUIREMENTID IN ".$reqsUn;
			$result = $conn->query($sql);
		}
		
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
?>