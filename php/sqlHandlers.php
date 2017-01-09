<?php
	session_start();
	include 'dbconnect.php';
	include 'utilities.php';
	include 'DBEntity.php';
	$conn=startConn();
	//mysql_set_charset("utf8");
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
		echo findReqs($_POST["sysid"]);
	}elseif($_POST["action"]=="link_requirements"){
		$sysid = $_POST["sysid"];
		$reqids = $_POST["reqids"];
		echo sysReqLinkage($sysid,$reqids,1);
	}elseif($_POST["action"]=="unlink_requirements"){
		$sysid = $_POST["sysid"];
		$reqids = $_POST["reqids"];
		echo sysReqLinkage($sysid,$reqids,0);
	}elseif($_POST["action"]=="unlinked_variables"){
		echo findVariables($_POST["notin"],true,0);
	}elseif($_POST["action"]=="link_variables"){
		echo entryVarLinkage($_POST["entryid"],$_POST["variables"],$_POST["throughput"],1);
	}elseif($_POST["action"]=="find_entryVars"){
		echo findVariables("(0)",false,$_POST["entryid"]);
	}elseif($_POST["action"]=="find_entries"){
		echo findEntries($_POST["sysid"]);
	}elseif($_POST["action"]=="add_entries"){
		echo addEntries($_POST["sysid"],$_POST["title"],$_POST["description"]);
	}elseif($_POST["action"]=="update_variables"){
		echo updateVariables($_POST["val"],$_POST["vid"],$_POST["eid"],$_POST["thruput"]);
	}elseif($_POST["action"]=="switch_teams"){
		echo updateTeams($_POST["teamid"]);
	}elseif($_POST["action"]=="switch_projects"){
		echo updateProjects($_POST["projid"]);
	}elseif($_POST["action"]=="remove_team"){
		echo removeRecord($_POST["teamid"],"team");
	}elseif($_POST["action"]=="remove_project"){
		echo removeRecord($_POST["projid"],"project");
	}elseif($_POST["action"]=="stage_entry"){
		echo stageEntry($_POST["entry"]);
	}elseif($_POST["action"]=="remove_system"){
		echo removeRecord($_POST["sysid"],"system");
	}elseif($_POST["action"]=="remove_requirement"){
		echo removeRecord($_POST["reqid"],"requirement");
	}elseif($_POST["action"]=="remove_variable"){
		echo removeRecord($_POST["varid"],"variable");
	}elseif($_POST["action"]=="remove_entry"){
		echo removeRecord($_POST["entryid"],"entry");
	}elseif($_POST["action"]=="find_systems"){
		echo findSystems(true);
	}elseif($_POST["action"]=="set_student"){
		echo setStudent($_POST["code"]);
	}elseif($_POST["action"]=="set_privileges"){
		echo getPrivilege();
	}elseif($_POST["action"]=="set_public_profile"){
		$name=$_POST["name"];
		$role=$_POST["role"];
		$desc=$_POST["desc"];
		$li=$_POST["li"];
		$email=$_POST["email"];
		$phone=$_POST["phone"];
		$pic=$_POST["pic"];
		echo setPublicProfile($name,$role,$desc,$li,$email,$phone,$pic);
	}elseif($_POST["action"]=="get_public_profile"){
		$user = $_POST["user"];
		echo getPublicProfile($user);
	}elseif($_GET["action"]=="current_team"){
		echo findTeams(1);
	}elseif($_GET["action"]=="other_teams"){
		echo findTeams(0);
	}elseif($_GET["action"]=="current_project"){
		echo findProjects(1);
	}elseif($_GET["action"]=="other_projects"){
		echo findProjects(0);
	}elseif($_GET["action"]=="all_systems"){
		echo findSystems(false);
	}elseif($_GET["action"]=="all_requirements"){
		echo findRequirements();
	}elseif($_GET["action"]=="all_variables"){
		echo findVariables("(0)",false,0);
	}elseif($_GET["action"]=="view_user"){
		echo userDetails($_GET["userid"]);
	}else{
		echo "No Task Found";
	}
	
	function addTeam($name,$desc){
		global $conn;
		global $me;
		global $org;
		
		$sql="INSERT INTO TEAM (NAME,DESCRIPTION,ORG_ID,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('".$name."','".$desc."',".$org.",".$me.",NULL)";
		
		$result = $conn->query($sql);
		if($result){
			$team = $conn->insert_id;
			$sql2="INSERT INTO JOINT_USER_TEAM (USERID,TEAMID,OWNER,CREATED_BY_USER_ID,CREATED_DATE) VALUE (".$me.",".$team.",1,".$me.",NULL)";
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
		
		$sql="INSERT INTO PROJECT (TITLE,DESCRIPTION,OWNERID,ORG_ID,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('".$title."','".$desc."','".$me."',".$org.",".$me.",NULL)";
		
		$result = $conn->query($sql);
		
		if($result){
			$sql2 = "INSERT INTO SYSTEM (TITLE,DESCRIPTION,PARENT_ID,PROJECT_ID,ISMASTER,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('SYSTEM','Default starting point for all projects, flow out your systems from this one.',0,".$conn->insert_id.",1,".$me.",NULL);";
			$result2 = $conn->query($sql2);
			if($result2){
				return 1;
			}else{
				return $conn->error;
			}
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
		
		$sql="INSERT INTO SYSTEM (TITLE,DESCRIPTION,PARENT_ID,TIER,PROJECT_ID,ISMASTER,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('".$title."','".$desc."','".$parent."',(SELECT s.TIER FROM SYSTEM s WHERE ID=".$parent.")+1,(SELECT t.PROJECT_ID FROM JOINT_USER_TEAM jut LEFT JOIN TEAM t ON (t.ID=jut.TEAMID) WHERE jut.CURRENT=1 AND jut.USERID=".$me."),".$ismaster.",".$me.",NULL)";
		
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
		
		$sql="INSERT INTO REQUIREMENT (NAME,DESCRIPTION,SOURCE,PF_FORMAT,TIER,DYNAMIC,PROJECT_ID,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('".$name."','".$desc."','".$source."','".$pf."',".$toi.",".$dyn.",(SELECT t.PROJECT_ID FROM JOINT_USER_TEAM jut LEFT JOIN TEAM t ON (t.ID=jut.TEAMID) WHERE jut.CURRENT=1 AND jut.USERID=".$me."),".$me.",NULL)";
		
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
		
		$sql="INSERT INTO VARS (NAME,DESCRIPTION,SYMBOL,UNITS,PROJECT_ID,CREATED_BY_USER_ID,CREATED_DATE) VALUES ('".$name."','".$desc."','".$symb."','".$unit."',(SELECT t.PROJECT_ID FROM JOINT_USER_TEAM jut LEFT JOIN TEAM t ON (t.ID=jut.TEAMID) WHERE jut.CURRENT=1 AND jut.USERID=".$me."),".$me.",NULL)";
		
		$result = $conn->query($sql);
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
	
	function addEntries($sysid,$title,$desc){
		global $conn;
		global $me;
		global $org;
		
		$sql="INSERT INTO ENTRY (`SYSTEMID`,`MASTERID`,`CLONECOUNT`,`ENTRY_STATUS_CODE`,`TITLE`,`DESCRIPTION`,`ISFIRST`,`CREATED_BY_USER_ID`,`CREATED_DATE`) VALUES (".$sysid.",0,0,1,'".$title."','".$desc."',1,".$me.",NULL)";
		
		$result = $conn->query($sql);
		if($result){
			return json_encode(array("success"=>1,"entryid"=>$conn->insert_id));
		}else{
			return $conn->error;
		}
	}
	
	function findTeams($current){
		global $conn;
		global $me;
		global $org;
		
		if($current){
			$sql="SELECT t.ID ti, t.NAME tn, t.DESCRIPTION td, jut.USERID ju,u.USERNAME uu,t.PROJECT_ID tp FROM JOINT_USER_TEAM jut LEFT JOIN TEAM t ON (t.ID=jut.TEAMID) LEFT JOIN USER u ON (u.ID=jut.USERID) WHERE jut.TEAMID IN (SELECT t.ID FROM USER u LEFT JOIN JOINT_USER_TEAM jut ON (jut.USERID=u.ID) LEFT JOIN TEAM t ON (t.ID=jut.TEAMID) WHERE jut.CURRENT=1 AND jut.USERID=".$me.") AND jut.OWNER=1 AND t.ORG_ID=".$org." AND t.ACTIVE=1";
		}else{
			$sql = "SELECT t.ID ti, t.NAME tn, t.DESCRIPTION td, jut.USERID ju,u.USERNAME uu,t.PROJECT_ID tp FROM JOINT_USER_TEAM jut LEFT JOIN TEAM t ON (t.ID=jut.TEAMID) LEFT JOIN USER u ON (u.ID=jut.USERID) WHERE jut.TEAMID NOT IN (SELECT t.ID FROM USER u LEFT JOIN JOINT_USER_TEAM jut ON (jut.USERID=u.ID) LEFT JOIN TEAM t ON (t.ID=jut.TEAMID) WHERE jut.CURRENT=1 AND jut.USERID=".$me.") AND jut.OWNER=1 AND t.ORG_ID=".$org." AND t.ACTIVE=1";
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

		$sql="SELECT p.ID pi, p.TITLE pt, p.DESCRIPTION pd, ow.USERNAME uu, t.ID ti, ow.ID ui FROM TEAM t LEFT JOIN JOINT_USER_TEAM jut ON (jut.TEAMID=t.ID) LEFT JOIN USER u ON (u.ID=jut.USERID) LEFT JOIN PROJECT p ON (p.ID=t.PROJECT_ID) LEFT JOIN USER ow ON (ow.ID=p.OWNERID) WHERE p.ORG_ID=".$org." AND p.ACTIVE=1 AND (jut.USERID=".$me." AND jut.CURRENT=1)";
		$result=$conn->query($sql);
		$outc=array();
		$i=0;
		while($rs=$result->fetch_array(MYSQLI_ASSOC)){
			$outc[$i]=$rs;
			$i++;
		}
		//return sizeOf($outc);
		if($current===0){
			if(sizeOf($outc)>0){
				$sql = "SELECT p.ID pi, p.TITLE pt, p.DESCRIPTION pd, ow.USERNAME uu, ow.ID ui FROM PROJECT p LEFT JOIN USER ow ON (ow.ID=p.OWNERID) WHERE p.ORG_ID=".$org." AND p.ACTIVE=1 AND p.ID NOT IN (SELECT t.PROJECT_ID FROM TEAM t LEFT JOIN JOINT_USER_TEAM jut ON (jut.TEAMID=t.ID) LEFT JOIN USER u ON (u.ID=jut.USERID) WHERE jut.USERID=".$me." AND jut.CURRENT=1)";
			}else{
				$sql = "SELECT p.ID pi, p.TITLE pt, p.DESCRIPTION pd, ow.USERNAME uu, ow.ID ui FROM PROJECT p LEFT JOIN USER ow ON (ow.ID=p.OWNERID) WHERE p.ORG_ID=".$org." AND p.ACTIVE=1";
			}
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
				$outp .= '"ownerid":"'. $rs["ui"]     . '"}'; 
			}
			$outp ='{"records":['.$outp.']}';
			$conn->close();

			echo $outp;
		}
	}
	
	function findSystems($html){
		global $conn;
		global $me;
		global $org;		

		if($html==true){
			$data = array();
			$index = array();
			$sql="SELECT s.ID si, s.PARENT_ID sp, s.TITLE st, s.DESCRIPTION sd, s.TIER stier, u.USERNAME uu, u.ID ui FROM SYSTEM s LEFT JOIN PROJECT p ON (p.ID=s.PROJECT_ID) LEFT JOIN USER u ON (u.ID=s.CREATED_BY_USER_ID) WHERE s.PROJECT_ID IN (SELECT p.ID pi FROM TEAM t LEFT JOIN JOINT_USER_TEAM jut ON (jut.TEAMID=t.ID) LEFT JOIN USER u ON (u.ID=jut.USERID) LEFT JOIN PROJECT p ON (p.ID=t.PROJECT_ID) LEFT JOIN USER ow ON (ow.ID=p.OWNERID) WHERE s.ACTIVE=1 AND p.ORG_ID=".$org." AND p.ACTIVE=1 AND (jut.USERID=".$me." AND jut.CURRENT=1)) GROUP BY s.TIER,s.ID,s.PARENT_ID ORDER BY s.TIER,s.PARENT_ID ASC";
			$result = $conn->query($sql);
			
			if($result){
				while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
					$id = $rs["si"];
					$parent_id = $rs["sp"] === NULL ? "NULL" : $rs["sp"];
					$data[$id] = $rs;
					if(empty($index[$parent_id])){
						$index[$parent_id] =  array(); 
					}
					
					array_push($index[$parent_id],$id);
				}
			
				
				// sort the 
			
			
				/*
				 * Recursive top-down tree traversal example:
				 * Indent and print child nodes
				 */
		
				function display_child_nodes($parent_id, $level,$index,$data)
				{
					$string="";
					$parent_id = $parent_id === NULL ? 0 : $parent_id;
					if (isset($index[$parent_id])) {
						foreach ($index[$parent_id] as $id) {			
							$d = $data[$id];
							$string.="<div class='entity currentEntity' style='margin-left:".$d['stier']."0px;'>
										<div id='sys".$d['si']."' class='systemEntity'>
										<div class='interact'>
											<i title='Attach Requirements' class='fa fa-rocket fa-lg'></i>
											<i title='Add An Entry' class='fa fa-plus-square fa-lg'></i>
											<i title='Change Team Info' class='fa fa-pencil-square-o fa-lg'></i>
											<i title='Delete This System' class='fa fa-trash fa-lg'></i>
										</div>
										<div>
											<h4>".$d['st']."</h4>
											<p>".$d['sd']."</p>
											<a class='btn-link' href='profile.php?glimpse=".$d['ui']."'>".$d['uu']."</a>
										</div>
									</div>
									</div>";

							$string.=display_child_nodes($id, $level + 1,$index,$data);
						}
						//$string.=display_child_nodes($id, $level+1, $inde, data); 
						echo $string;
					}			
			
				}
			}else{
				echo 0;
			}
			return display_child_nodes(11,0,$index,$data);
		}else{
		
			$sql = "SELECT s.ID si,s.PARENT_ID sp, s.TITLE st, s.TIER stier, s.DESCRIPTION sd, u.USERNAME uu, u.ID ui FROM SYSTEM s LEFT JOIN PROJECT p ON (p.ID=s.PROJECT_ID) LEFT JOIN USER u ON (u.ID=s.CREATED_BY_USER_ID) WHERE s.PROJECT_ID IN (SELECT p.ID pi FROM TEAM t LEFT JOIN JOINT_USER_TEAM jut ON (jut.TEAMID=t.ID) LEFT JOIN USER u ON (u.ID=jut.USERID) LEFT JOIN PROJECT p ON (p.ID=t.PROJECT_ID) LEFT JOIN USER ow ON (ow.ID=p.OWNERID) WHERE s.ACTIVE=1 AND p.ORG_ID=".$org." AND p.ACTIVE=1 AND (jut.USERID=".$me." AND jut.CURRENT=1)) GROUP BY s.PARENT_ID,s.ID ORDER BY s.PARENT_ID,s.TIER";
		
			$result = $conn->query($sql);
			/*if($result){
				$outp = "";
				while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
					if ($outp != "") {$outp .= ",";}
					$outp .= '{"id":"'  . $rs["si"] . '",';
					$outp .= '"parentid":"'   . $rs["sp"]        . '",';
					$outp .= '"title":"'   . $rs["st"]        . '",';
					$outp .= '"owner":"'   . $rs["uu"]        . '",';
					$outp .= '"ownerid":"'   . $rs["ui"]        . '",';
					$outp .= '"tier":"'   . $rs["stier"]        . '",';
					$outp .= '"description":"'. $rs["sd"]     . '"}'; 
				}*/
			if($result){
				$outp=array();
				$i=0;
				while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
					$outp[$i] = array("id"=>$rs["si"],
										"parentid"=>$rs["sp"],
										"title"=>$rs["st"],
										"tier"=>$rs["stier"],
										"description"=>$rs["sd"],
										"owner"=>$rs["uu"],
										"ownerid"=>$rs["ui"]
								);
					$i++;
				}
				$outFinal = array("records"=>$outp);
				$conn->close();
			
				//echo var_dump($outp);
				$outq ='{"records":['.$outp.']}';
				$conn->close();
				$json_response = json_encode($outp);  
				//echo var_dump($obj); 
			 	echo instantiate($json_response);
				//echo $outp;
			}
		}
	}
	
	function findRequirements(){
		global $conn;
		global $me;
		global $org;
		
		$sql = "SELECT r.ID ri, r.NAME rn, r.DESCRIPTION rd, u.USERNAME uu, u.ID ui FROM REQUIREMENT r LEFT JOIN PROJECT p ON (p.ID=r.PROJECT_ID) LEFT JOIN USER u ON (u.ID=r.CREATED_BY_USER_ID) WHERE r.ACTIVE=1 AND p.ORG_ID=".$org;
		
		$result = $conn->query($sql);
		if($result){
			$outp = "";
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($outp != "") {$outp .= ",";}
				$outp .= '{"id":"'  . $rs["ri"] . '",';
				$outp .= '"name":"'   . $rs["rn"]        . '",';
				$outp .= '"owner":"'   . $rs["uu"]        . '",';
				$outp .= '"ownerid":"'   . $rs["ui"]        . '",';
				$outp .= '"description":"'. $rs["rd"]     . '"}'; 
			}
			$outp ='{"records":['.$outp.']}';
			$conn->close();

			echo $outp;
		}
	}
	
	function findVariables($notin="(0)",$htmlified=false,$entry=0){
	//!CURRENTLY HAS BAD CODE: if $entry!=0 && htmlified==true then htmlified won't return anything!
		global $conn;
		global $me;
		global $org;
		
		$typ = 0;
		if($entry!=0){
			$typ=1;
			$sql = "SELECT v.ID vi, v.SYMBOL vs, v.UNITS vu, jve.VALUE jv, jvt.NAME jn FROM JOINT_VARS_ENTRY jve LEFT JOIN VARS v ON (v.ID=jve.VARSID) LEFT JOIN PROJECT p ON (p.ID=v.PROJECT_ID) LEFT JOIN USER u ON (u.ID=v.CREATED_BY_USER_ID) LEFT JOIN JV_THROUGHPUT jvt ON (jvt.CODE=jve.THROUGHPUT_CODE) WHERE jve.ACTIVE=1 AND jve.ENTRYID=".$entry." AND p.ORG_ID=".$org;
		}else{
			$sql = "SELECT v.ID vi, v.NAME vn, v.DESCRIPTION vd, v.SYMBOL vs, v.UNITS vu, u.USERNAME uu, u.ID ui FROM VARS v LEFT JOIN PROJECT p ON (p.ID=v.PROJECT_ID) LEFT JOIN USER u ON (u.ID=v.CREATED_BY_USER_ID) WHERE v.ACTIVE=1 AND p.ORG_ID=".$org." AND v.ID NOT IN ".$notin;
		}
		$result = $conn->query($sql);
		if($result){
			$outHTML = "<h4>Unlinked Variables</h4><div id='popupVariables'>";
			$outp = "";
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($outp != "") {$outp .= ",";}
				$outp .= '{"id":"'  . $rs["vi"] . '",';
				$vsymb = cleanString($rs["vs"]);
				$outp .= '"symbol":"'   .   htmlspecialchars($vsymb)     . '",';
				if($typ==1){
					$outp .= '"joinValue":"' . $rs["jv"] . '",';
					$outp .= '"joinName":"' . $rs["jn"] . '",';
				}else{
					$outp .= '"owner":"'   .   $rs["uu"]     . '",';
					$outp .= '"ownerid":"'   .   $rs["ui"]     . '",';
					$outp .= '"name":"'   .   $rs["vn"]     . '",';
					$outp .= '"units":"'   .   $rs["vn"]     . '",';
					$outp .= '"description":"' . $rs["vd"] . '",';
					$outHTML .= "<div id='evars".$rs["vi"]."' class='unlinkedVariables'><p><strong>".htmlspecialchars($vsymb)." </strong>".$rs["vn"].": ".$rs["vd"]."</p></div>";
				}
				$outp .= '"units":"'. $rs["vu"]     . '"}'; 
			}
			$outp ='{"records":['.$outp.']}';
			$outHTML.="<a id='cancelVarAdd' class='btn btn-link'>Cancel</a><button id='addEntryVars' class='uibutton buttons addVars'>Add</button></div>";
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
		$sql = "SELECT r.ID ri, r.NAME rn, r.DESCRIPTION rd, IF(r.ID IN (SELECT jrs.REQUIREMENTID FROM JOINT_REQUIREMENT_SYSTEM jrs WHERE jrs.ACTIVE=1 AND jrs.SYSTEMID=".$sysid."),true,false) linked FROM REQUIREMENT r WHERE r.ACTIVE=1";
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
		}else{
			$outFinal =array();
			$conn->close();
		}
		echo json_encode($outFinal);
	}
	
	function findEntries($sysid){
		global $conn;
		global $me;
		global $org;
		
		if($sysid===0){
			$sql="SELECT e.ID ei, e.TITLE et, e.DESCRIPTION ed, e.MASTERID em, e.CLONECOUNT ec, e.CURRENT ecurr,ow.USERNAME uu, ow.ID ui FROM ENTRY e LEFT JOIN SYSTEM s ON (s.ID=e.SYSTEMID) LEFT JOIN PROJECT p ON (p.ID=s.PROJECT_ID) LEFT JOIN USER ow ON (ow.ID=e.CREATED_BY_USER_ID) WHERE e.ACTIVE=1 AND p.ORG_ID=".$org;
		}else{
			$sql="SELECT e.ID ei, e.TITLE et, e.DESCRIPTION ed, e.MASTERID em, e.CLONECOUNT ec, e.CURRENT ecurr,u.USERNAME uu, u.ID ui FROM ENTRY e LEFT JOIN USER u ON (u.ID=e.CREATED_BY_USER_ID) WHERE e.ACTIVE=1 AND e.SYSTEMID=".$sysid;
		}
		
		$result = $conn->query($sql);
		if($result){
			$outp=array();
			$i=0;
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				$outp[$i] = array("id"=>$rs["ei"],"title"=>$rs["et"],"description"=>$rs["ed"],"master"=>$rs["em"],"clonecount"=>$rs["ec"],"current"=>$rs["ecurr"],"owner"=>$rs["uu"],"ownerid"=>$rs["ui"]);
				$i++;
			}
			$outFinal = array("records"=>$outp);
			$conn->close();
		}else{
			$outFinal=array();
			$conn->close();
		}
		echo json_encode($outFinal);
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
			$sqlcheck = "SELECT REQUIREMENTID ri FROM JOINT_REQUIREMENT_SYSTEM WHERE SYSTEMID=".$sysid." AND REQUIREMENTID IN ".$reqsUn;
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
				$sql2 = "UPDATE JOINT_REQUIREMENT_SYSTEM SET ACTIVE=1,UPDATED_BY_USER_ID=".$me." WHERE SYSTEMID=".$sysid." AND REQUIREMENTID IN ".$requ;
			}
			$sql=$sql1." ".$sql2;
			$result= $conn->multi_query($sql);
		}else{
			$sql="UPDATE JOINT_REQUIREMENT_SYSTEM SET ACTIVE=0,UPDATED_BY_USER_ID=".$me." WHERE SYSTEMID=".$sysid." AND REQUIREMENTID IN ".$reqsUn;
			$result = $conn->query($sql);
		}
		
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
	
	function entryVarLinkage($entry,$vars,$throughput,$connect){
		global $conn;
		global $me;
		global $org;
		
		$varsUn="(";
		foreach($vars as $i){
			if($varsUn != "("){$varsUn .= ",";}
			$varsUn.=$i;
		}
		$varsUn.=")";
		if($connect==1){
			$sqlcheck = "SELECT VARSID vi FROM JOINT_VARS_ENTRY WHERE ENTRYID=".$entry." AND THROUGHPUT_CODE = (SELECT CODE FROM JV_THROUGHPUT WHERE NAME='".$throughput."') AND VARSID IN ".$varsUn;
			$resultcheck=$conn->query($sqlcheck);
			$outp = array();
			
			$i=0;
			while($rs = $resultcheck->fetch_array(MYSQLI_ASSOC)) {
				$outp[$i]=$rs["vi"];
				$i++;
			}
			$varu="(";
			$vari="(";
			foreach($vars as $i){
				if($varu != "(") {$varu .= ",";}
				if($vari != "(") {$vari .= ",(";}
				if(in_array($i,$outp)){
					$varu.=$i;
				}else{
					$vari.=$entry.",".$i.",(SELECT CODE FROM JV_THROUGHPUT WHERE NAME='".$throughput."'),1,".$me.",NULL";
					$vari.=")";
				}
			}
			$varu=rtrim($varu,",").")";
			
			$sql1="";
			$sql2="";
			if(sizeof($outp)<sizeof($vars)){
				$sql1 = "INSERT INTO JOINT_VARS_ENTRY (ENTRYID,VARSID,THROUGHPUT_CODE,ACTIVE,CREATED_BY_USER_ID,CREATED_DATE) VALUES ".$vari.";";
			}
			if(sizeof($outp)>0){
				$sql2 = "UPDATE JOINT_VARS_ENTRY SET ACTIVE=1,UPDATED_BY_USER_ID=".$me." WHERE ENTRYID=".$entry." AND THROUGHPUT_CODE = (SELECT CODE FROM JV_THROUGHPUT WHERE NAME='".$throughput."') AND VARSID IN ".$varu;			
			}
			$sql = $sql1." ".$sql2;
			$result = $conn->multi_query($sql);
		}else{
			$sql="UPDATE JOINT_VARS_ENTRY SET ACTIVE=0,UPDATED_BY_USER_ID=".$me." WHERE ENTRYID=".$entry." AND THROUGHPUT_CODE = (SELECT CODE FROM JV_THROUGHPUT WHERE NAME='".$throughput."') AND VARSID IN ".$varsUn;
			$result = $conn->query($sql);
		}
		
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
	
	function updateVariables($val,$varid,$entryid,$throughput){
		global $conn;
		global $me;
		global $org;
		
		$sql = "UPDATE JOINT_VARS_ENTRY SET VALUE='".$val."',UPDATED_BY_USER_ID=".$me." WHERE VARSID=".$varid." AND ENTRYID=".$entryid." AND THROUGHPUT_CODE = (SELECT CODE FROM JV_THROUGHPUT WHERE NAME='".$throughput."')";
		$result= $conn->query($sql);
		
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
	
	function updateTeams($team){
		global $conn;
		global $me;
		global $org;
			
		$sqlcheck = "SELECT ID juti FROM JOINT_USER_TEAM WHERE TEAMID=".$team." AND USERID=".$me;
		$resultcheck=$conn->query($sqlcheck);
		
		$outp = array();
		$i=0;
		while($rs = $resultcheck->fetch_array(MYSQLI_ASSOC)) {
			$outp[$i]=$rs["juti"];
			$i++;
		}
		
		$sql1="";
		$sql2="";
		if(sizeof($outp)===0){
			$sql1 = "INSERT INTO JOINT_USER_TEAM (TEAMID,USERID,CURRENT,CREATED_BY_USER_ID,CREATED_DATE) VALUES (".$team.",".$me.",1,".$me.",NULL);";
		}elseif(sizeof($outp)>0){
			$sql2 = "UPDATE JOINT_USER_TEAM SET CURRENT=1,UPDATED_BY_USER_ID=".$me." WHERE TEAMID=".$team." AND USERID = ".$me.";";			
		}
		$sql = $sql1." ".$sql2." UPDATE JOINT_USER_TEAM SET CURRENT=0,UPDATED_BY_USER_ID=".$me." WHERE USERID=".$me." AND TEAMID!=".$team.";";
		$result = $conn->multi_query($sql);
		
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
		
	}
	
	function updateProjects($proj){
		global $conn;
		global $me;
		global $org;
			
		$sql="UPDATE TEAM SET PROJECT_ID=".$proj.",UPDATED_BY_USER_ID=".$me." WHERE ID=(SELECT TEAMID FROM JOINT_USER_TEAM WHERE USERID=".$me." AND CURRENT=1);";
		$result = $conn->query($sql);
		
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
		
	}
	
	function removeRecord($entityid,$entity){
		global $conn;
		global $me;
		global $org;
		
		if($entity=="team"){
			$sql="UPDATE TEAM SET ACTIVE=0,UPDATED_BY_USER_ID=".$me." WHERE ID=".$entityid."; UPDATE JOINT_USER_TEAM SET ACTIVE=0 WHERE TEAMID=".$entityid.";"; 
		}elseif($entity=="project"){
			$sql="UPDATE PROJECT SET ACTIVE=0,UPDATED_BY_USER_ID=".$me." WHERE ID=".$entityid.";";
		}elseif($entity=="system"){
			$sql="UPDATE SYSTEM SET ACTIVE=0,UPDATED_BY_USER_ID=".$me." WHERE ID=".$entityid.";";
		}elseif($entity=="requirement"){
			$sql="UPDATE REQUIREMENT SET ACTIVE=0,UPDATED_BY_USER_ID=".$me." WHERE ID=".$entityid.";";
		}elseif($entity=="variable"){
			$sql="UPDATE VARS SET ACTIVE=0,UPDATED_BY_USER_ID=".$me." WHERE ID=".$entityid.";";
		}elseif($entity=="entry"){
			$sql="UPDATE ENTRY SET ACTIVE=0,UPDATED_BY_USER_ID=".$me." WHERE ID=".$entityid.";";
		}else{
			return "Unable to delete entity.";
		}
		$result=$conn->multi_query($sql);
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
	
	function stageEntry($entryid){
		global $conn;
		global $me;
		global $org;
			
		$sqlcheck = "SELECT ID ei FROM ENTRY WHERE SYSTEMID=(SELECT SYSTEMID FROM ENTRY WHERE ID=".$entryid.") AND ENTRY_STATUS_CODE=3";
		$resultcheck=$conn->query($sqlcheck);
		
		$outp = array();
		$i=0;
		while($rs = $resultcheck->fetch_array(MYSQLI_ASSOC)) {
			$outp[$i]=$rs["ei"];
			$i++;
		}
		
		$sql1="";
		$sql2="";
		if(sizeof($outp)===0){
			$sql1 = "UPDATE ENTRY SET ENTRY_STATUS_CODE=3,UPDATED_BY_USER_ID=".$me." WHERE ACTIVE=1 AND ID=".$entryid;
		}elseif(sizeof($outp)>0){
			$sql2 = "UPDATE ENTRY SET ENTRY_STATUS_CODE=2,UPDATED_BY_USER_ID=".$me." WHERE ACTIVE=1 AND ID=".$entryid;			
		}
		$sql = $sql1." ".$sql2;
		$result = $conn->multi_query($sql);
		
		if($result){
			return 1;
		}else{
			return $conn->error;
		}
	}
	
	function setStudent($code){
		global $conn;
		global $me;
		global $org;
		$pswd=password_hash(htmlspecialchars("260307"),PASSWORD_DEFAULT);
		if(password_verify($code,$pswd)==1){
			$sql="UPDATE USER SET USER_TYPE_CODE=(SELECT CODE FROM USER_TYPE WHERE NAME='student') WHERE ID=".$me;
			$result = $conn->query($sql);
	
			if($result){
				return 1;
			}else{
				return $conn->error;
			}
		}else{
			return 0;
		}
	}
	
	function getPrivilege(){
		global $conn;
		global $me;
		global $org;
		$sql="SELECT ut.NAME un FROM USER u LEFT JOIN USER_TYPE ut ON (ut.CODE=u.USER_TYPE_CODE) WHERE u.ID=".$me;
		$result=$conn->query($sql);
		$outp="";
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$outp.=$rs["un"];
		}
		if($result){
			return $outp;
		}else{
			return $conn->error;
		}
	}
	
	function userDetails($id){
		global $conn;
		global $me;
		global $org;
		
		$sql = "SELECT u.USERNAME uu, u.EMAIL ue, u.PHONE up, (SELECT t.NAME FROM TEAM t LEFT JOIN JOINT_USER_TEAM jut ON (jut.TEAMID=t.ID) WHERE jut.CURRENT=1 AND jut.USERID=".$me.") tn FROM USER u WHERE u.ID=".$id;
		$result = $conn->query($sql);
		if($result){
			$outp="";
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				$outp .= "<div class='glimpsedUser'><h3>".$rs["uu"]."</h3><h4><strong>Team: </strong>".$rs["tn"]."</h4><p><strong>Email: </strong>".$rs["ue"]."</p><p><strong>Phone: </strong>".$rs["up"]."</p>";
			}
			$conn->close();
		}else{
			$outp="No Result";
			$conn->close();
		}
		return $outp;
	}
	
	function setPublicProfile($name,$role,$desc,$li,$email,$phone,$pic){
		global $conn;
		global $me;
		global $org;
		
		$sqlcheck = "SELECT pp.ID ppi, pp.EMAIL ppe FROM public_profile pp WHERE pp.USERID=".$me;
		$resultcheck = $conn->query($sqlcheck);
		
		$sqli="";
		if($resultcheck->num_rows==0){
			$sqli = "INSERT INTO PUBLIC_PROFILE (USERID,CREATED_BY_USER_ID,CREATED_DATE) VALUES (".$me.",".$me.",NULL);";
		}
		$sqlu = $sqli."UPDATE PUBLIC_PROFILE SET NAME='".$name."',ROLE='".$role."',DESCRIPTION='".$desc."',LINKEDIN='".$li."',EMAIL='".$email."',PHONE='".$phone."',PICTURE_PATH='".$pic."',UPDATED_BY_USER_ID=".$me." WHERE USERID=".$me;
		$resultu = $conn->multi_query($sqlu);

		if($resultu){
			if($resultcheck->num_rows!==0){
				$default = "http://www.exodes.co/images/uploads/aero_dept_logo.jpg";
				$size = 120;
				$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
			}
			return $grav_url;
			return 1;
		}else{
			return $conn->error;
		}
		return 0;
	}
	
	function getPublicProfile($user){
		global $conn;
		global $me;
		global $org;
		
		if($user==0){
			$user=$me;
		}
		$sql = "SELECT pp.USERID ppu, pp.NAME ppn, pp.ROLE ppr, pp.DESCRIPTION ppd, pp.LINKEDIN ppl, u.EMAIL ue, pp.EMAIL ppe, pp.PHONE ppp,pp.PICTURE_PATH pppp FROM PUBLIC_PROFILE pp LEFT JOIN USER u ON (u.ID=pp.USERID) WHERE pp.USERID=".$user;
		$result = $conn->query($sql);
		if($result->num_rows==0){
			$outp = array("uid"=>$user);
		}else{
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				sizeof($rs["ppe"])==0?$email=$email = $rs["ue"]:$email = $rs["ppe"];
				$default = "http://www.exodes.co/images/uploads/aero_dept_logo.jpg";
				$size = 120;
				$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
				$outp = array("uid"=>$rs["ppu"],"name"=>$rs["ppn"],"role"=>$rs["ppr"],"description"=>$rs["ppd"],"li"=>$rs["ppl"],"email"=>$rs["ppe"],"phone"=>$rs["ppp"],"pic"=>$grav_url);
			}
		}
		$conn->close();
		return json_encode($outp);
	}
?>