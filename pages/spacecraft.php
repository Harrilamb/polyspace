<?php
	session_start();
	if(!isset($_SESSION["userid"]) || empty($_SESSION["userid"]) || !isset($_SESSION["privilege"])){
		header("location:../index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>AERO 447</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script data-main="../js/main.js" src="../js/require.js"></script>
	<link rel="stylesheet" href="../css/main.css">
</head>

<body>
	<div id="headerArea" class="container-fluid"> <!-- If Needed Left and Right Padding in 'md' and 'lg' screen means use container class --></div>
	<div class="container profileBody" ng-app="userInfoApp" ng-controller="setTeams" >
		<div class="row">
		<!--Start left column-->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 infoBlock">
				<strong><p>Build a Spaceship</p></strong>
				<ul class="infoList">
					<li class="switchop">Team</li>
					<li class="switchop">Project</li>
					<li class="switchop">System</li>
					<li class="switchop">Requirement</li>
					<li class="switchop">Variable</li>
				</ul>
			</div>
		</div>
		<div class="row">
			
		<!--Start middle column-->
			<div id="userTeams" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="admInfo" width="50%">
					<div>
						<div class="op teamop currop">
							<h3>Current Team:</h3>
							<div ng-repeat="team in thisTeam" class="entity currentEntity">
								<div id="team{{team.id}}">
									<div class="currentIcon">
										<i title="#1 Team" class="fa fa-trophy fa-lg"></i>
									</div>
									<h4>{{team.name}}</h4>
									<p>{{team.description}}</p>
									<a class="btn-link" href="profile.php?glimpse={{team.owner}}">{{team.owner}}</a>
								</div>
							</div>
						</div>
						<div class="op teamop currop">
							<h3>Other Teams:</h3>
							<div>
								<div ng-repeat="team in otherTeams" class="entity otherEntity">
									<div id="team{{team.id}}">
										<div class="interact">
											<i title="Make Primary Team" class="fa fa-trophy fa-lg"></i>
											<i title="Change Team Info" class="fa fa-pencil-square-o fa-lg"></i>
											<i title="Delete This Team" class="fa fa-trash fa-lg"></i>
										</div>
										<h4>{{team.name}}</h4>
										<p>{{team.description}}</p>
										<a class="btn-link" href="profile.php?glimpse={{team.owner}}">{{team.owner}}</a>
									</div>
								</div>
							</div>
						</div>
						<div class="op projop">
							<h3>Current Project:</h3>
							<div ng-repeat="proj in currProj" class="entity currentEntity">
								<div id="proj{{proj.id}}">
									<div class="currentIcon"><i title="#1 Project" class="fa fa-trophy fa-lg"></i></div>
									<h4>{{proj.title}}</h4>
									<p>{{proj.description}}</p>
									<a class="btn-link" href="profile.php?glimpse={{proj.owner}}">{{proj.owner}}</a>
								</div>
							</div>
						</div>
						<div class="op projop">
							<h3>Other Projects:</h3>
							<div ng-repeat="proj in otherProjs" class="entity otherEntity">
								<div id="proj{{proj.id}}">
									<div class="interact">
										<i title="Make Primary Project" class="fa fa-trophy fa-lg"></i>
										<i title="Change Team Info" class="fa fa-pencil-square-o fa-lg"></i>
										<i title="Delete This Project" class="fa fa-trash fa-lg"></i>
									</div>
									<h4>{{proj.title}}</h4>
									<p>{{proj.description}}</p>
									<a class="btn-link" href="profile.php?glimpse={{proj.owner}}">{{proj.owner}}</a>
								</div>
							</div>
						</div>
						
						<div class="op sysop sysList">
						</div>
						
						<div class="op reqop">
							<h3>All Requirements:</h3>
							<div ng-repeat="requirement in allRequirements" class="entity currentEntity">
								<div id="req{{requirement.id}}">
									<div class="interact">
										<i title="Change Team Info" class="fa fa-pencil-square-o fa-lg"></i>
										<i title="Delete This System" class="fa fa-trash fa-lg"></i>
									</div>
									<h4>{{requirement.name}}</h4>
									<p>{{requirement.description}}</p>
									<a class="btn-link" href="profile.php?glimpse={{requirement.owner}}">{{requirement.owner}}</a>
								</div>
							</div>
						</div>
						<div class="op varop">
							<h3>All Variables:</h3>
							<div ng-repeat="variable in allVariables" class="entity currentEntity">
								<div id="var{{variable.id}}">
									<div class="interact">
										<i title="Change Team Info" class="fa fa-pencil-square-o fa-lg"></i>
										<i title="Delete This System" class="fa fa-trash fa-lg"></i>
									</div>
									<h4>{{variable.symbol}} - <span class="symbName">{{variable.name}}</span></h4>
									<p>{{variable.description}}</p>
									<a class="btn-link" href="profile.php?glimpse={{variable.owner}}">{{variable.owner}}</a>
								</div>
							</div>
						</div>
					
					</div>
				</div>	
				<div class="op entryop">
					<form>
						<h3 id="createEntryTitle">Create An Entry</h3>
						<div id="entryStep1Perm">
							<div id="entryStep1" class="form-group writepriv">
								<h4>Step 1 of 3</h4>
								<label for="entrySysSelect">System</label>
								<select id="entrySysSelect" class="form-control systemSelect"></select>
								<label for="entryNameSet">Title</label>
								<input id="entryNameSet" type="text" class="form-control" placeholder="Name"/>
								<label for="entryDescSet">Description</label>
								<textarea id="entryDescSet" type="text" class="form-control" placeholder="Description"></textarea>
								<button id="entryNext1" class="uibutton buttons">Step 2 -></button>
							</div>
						</div>
						<div id="entryStep2Perm">
							<div id="entryStep2" class="form-group">
								<h4>Step 2 of 3</h4>
								<h5>Variables</h5>
								<table id="entryVarTable">
									<thead>
										<tr><th>Inputs</th><th>Outputs</th></tr>
									</thead>
									<tbody class="entryVarBody">
										<tr id="entryVarMainRow">
											<td class="inputList"></td>
											<td class="outputList"></td>
										</tr>
										<tr>
											<td><button id="inputVarsAdd" class="uibutton buttons inputAddBtn">Add</button></td>
											<td><button id="outputVarsAdd" class="uibutton buttons outputAddBtn">Add</button></td>
										</tr>
									</tbody>
								</table>
								<button id="entryNext2" class="uibutton buttons">Step 3 -></button>
							</div>
						</div>
						<div id="entryStep3Perm">
							<div id="entryStep3" class="form-group writepriv">
								<h4>Step 3 of 3</h4>
								<div>
									<h5>Stage Entry</h5>
									<p>Put it to the test!</p>
									<button id="entryStage" class="uibutton buttons">Stage</button>
								</div>
								<div>
									<h5>Stash Entry</h5>
									<p>Just making it now.</p>
									<button id="entryStash" class="uibutton buttons">Stash</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			<!--End middle column-->
			</div>
			<!--Start right column-->
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="op writepriv teamop currop" width="50%">
					<h3>Add Team</h3>
					<form>
						<div class="form-group">
							<label for="teamNameSet">Name</label>
							<input id="teamNameSet" type="text" class="form-control" placeholder="Name"/>
							<label for="teamDescSet">Description</label>
							<textarea id="teamDescSet" type="text" class="form-control" placeholder="Description"></textarea>
						</div>
					</form>
					<div id="addTeamSuccess" class="alert alert-success notifier">
						<a href="#" class="close" aria-label="close">&times;</a>
						<strong>Success!</strong> New Team Added.
					</div>
					<div id="addTeamFailed" class="alert alert-danger notifier">
						<a href="#" class="close" aria-label="close">&times;</a>
						<strong>Missing Info</strong> Both Fields Required.
					</div>
					<button class="uibutton buttons addTeam">Add</button>
				</div>
				<div class="op writepriv projop" width="50%">
					<h3>Add Project</h3>
					<form>
						<div class="form-group">
							<label for="projectTitleSet">Title</label>
							<input id="projectTitleSet" type="text" class="form-control" placeholder="Title"/>
							<label for="projectDescSet">Description</label>
							<textarea id="projectDescSet" type="text" class="form-control" placeholder="Description"></textarea>
						</div>
					</form>
					<div id="addProjectSuccess" class="alert alert-success notifier">
						<a href="#" class="close" aria-label="close">&times;</a>
						<strong>Success!</strong> New Project Added.
					</div>
					<div id="addProjectFailed" class="alert alert-danger notifier">
						<a href="#" class="close" aria-label="close">&times;</a>
						<strong>Missing Info</strong> Both Fields Required.
					</div>
					<button class="uibutton buttons addProject">Add</button>
				</div>
				<div class="op writepriv sysop" width="50%">
					<h3>Add System</h3>
					<form>
						<div class="form-group">
							<label for="systemParentSet">Parent System</label>
							<select id="systemParentSet" class="form-control systemSelect">
							</select>
							<label for="systemTitleSet">Title</label>
							<input id="systemTitleSet" type="text" class="form-control" placeholder="Title"/>
							<label for="systemDescSet">Description</label>
							<textarea id="systemDescSet" type="text" class="form-control" placeholder="Description"></textarea>
						</div>
					</form>
					<div id="addSystemSuccess" class="alert alert-success notifier">
						<a href="#" class="close" aria-label="close">&times;</a>
						<strong>Success!</strong> New System Added.
					</div>
					<div id="addSystemFailed" class="alert alert-danger notifier">
						<a href="#" class="close" aria-label="close">&times;</a>
						<strong>Missing Info</strong> All Fields Required.
					</div>
					<button class="uibutton buttons addSystem">Add</button>
				</div>
				<div class="op writepriv reqop" width="50%">
					<h3>Add Requirement</h3>
					<form>
						<div class="form-group">
							<label for="requirementNameSet">Name</label>
							<input id="requirementNameSet" type="text" class="form-control" placeholder="Name"/>
							<label for="requirementDescSet">Description</label>
							<textarea id="requirementDescSet" type="text" class="form-control" placeholder="Description"></textarea>
							<label for="requirementPassFailSet">Pass/Fail Format:</label>
							<input id="requirementPassFailSet" type="text" class="form-control" placeholder="i.e. altitude > 10km"/>
							<label for="requirementSourceSet">Source:</label>
							<input id="requirementSourceSet" type="text" class="form-control" placeholder="i.e. ROI, inferred, addendum #"/>
							<label for="requirementTierSet">Tier of Importance:</label>
							<select  id="requirementTierSet" class="form-control" ng-options="team.id as team.name for team in otherTeams track by team.id">
								<option value="none" selected="selected">Choose One</option>
								<option value="0">Necessary</option>
							</select>
							<label for="requirementDynamicSet">Dynamic
							<input id="requirementDynamicSet" type="checkbox" class="form-control" checked="checked"/>
							</label>
						</div>
					</form>
					<div id="addRequirementSuccess" class="alert alert-success notifier">
						<a href="#" class="close" aria-label="close">&times;</a>
						<strong>Success!</strong> New Requirement Added.
					</div>
					<div id="addRequirementFailed" class="alert alert-danger notifier">
						<a href="#" class="close" aria-label="close">&times;</a>
						<strong>Missing Info</strong> All Fields Required.
					</div>
					<button class="uibutton buttons addRequirement">Add</button>
				</div>
				<div class="op writepriv varop" width="50%">
					<h3>Add Variable</h3>
					<form>
						<div class="form-group">
							<label for="variableNameSet">Name</label>
							<input id="variableNameSet" type="text" class="form-control" placeholder="Name"/>
							<label for="variableDescSet">Description</label>
							<textarea id="variableDescSet" type="text" class="form-control" placeholder="Description"></textarea>
							<label for="variableSymbolSet">Symbol:</label>
							<input id="variableSymbolSet" type="text" class="form-control" placeholder="i.e. ∑, ∆, µ"/>
							<label for="variableUnitSet">Units:</label>
							<input id="variableUnitSet" type="text" class="form-control" placeholder="i.e. m/s, kg, N"/>
						</div>
					</form>
					<div id="addVariableSuccess" class="alert alert-success notifier">
						<a href="#" class="close" aria-label="close">&times;</a>
						<strong>Success!</strong> New Variable Added.
					</div>
					<div id="addVariableFailed" class="alert alert-danger notifier">
						<a href="#" class="close" aria-label="close">&times;</a>
						<strong>Missing Info</strong> All Fields Required.
					</div>
					<button class="uibutton buttons addVariable">Add</button>
				</div>
				<div class="op sysReqOp">
					<h3>Requirements</h3>
					<table id="reqLinkageTable">
						<thead>
							<tr><th>Unlinked</th><th>Linked</th></tr>
						</thead>
						<tbody>
							<tr>
								<td id="unlinkedList"></td>
								<td id="linkedList"></td>
							</tr>
							<tr>
								<td><button id="linkReqs" class="uibutton buttons linkBtn">Link</button></td>
								<td><button id="unlinkReqs" class="uibutton buttons unlinkBtn">Unlink</button></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="entryLists" class="op">
					<h3>Current Entries:</h3>
					<div id="currEntryList">
					</div>
					<h3>Other Entries:</h3>
					<div id="otherEntryList">
					</div>
				</div>
			<!--End right column-->
			</div>
			<!--<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			</div>--!>
		</div>	
	</div>
	<script src="../bower_components/angular/angular.js"></script>
	<script src="../js/app.js"></script>
	<script src="../js/services/httpConns.js"></script>
	<script src="../js/controllers/MainController.js"></script>
	
</body>
</html>