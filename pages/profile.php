<?php
	session_start();
	if(!isset($_SESSION["userid"]) || empty($_SESSION["userid"])){
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
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/main.css">
</head>

<body>
	<div class="container-fluid"> <!-- If Needed Left and Right Padding in 'md' and 'lg' screen means use container class -->
		<div class="row homehead">
			<h1>Cal Poly Space Design</h1>
			<div class="systemTab">
				<ul id="userbar"><li><a  id="usersname" class="btn-link profile" href="profile.php"></a></li><li> | </li><li><a id="logout" class="btn-link logout">Logout</a></li></ul>
			</div>
		</div>
	</div>
	<div class="container profileBody" ng-app="userInfoApp" ng-controller="setTeams" >
		<div class="row">
			<!--Start left column-->
			<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
				<h3>Profile</h3>
				<strong><p>Build a Spaceship</p></strong>
				<ul class="infoList">
					<li class="btn-link switchop">Team</li>
					<li class="btn-link switchop">Project</li>
					<li class="btn-link switchop">System</li>
					<li class="btn-link switchop">Requirement</li>
					<li class="btn-link switchop">Variable</li>
				</ul>
				<p><b>SysAdmin:</b> Harry Lambert</p>
				<p>For Questions, Comments, and/or Suggestions:</p>
				<p><b>Phone:</b> 510-421-4007</p>
				<p><b>Email:</b> lambert.harrison@gmail.com</p>
			<!--End left column-->
			</div>
			<!--Start middle column-->
			<div id="userTeams" class="col-xs-4 col-sm-4 col-md-5 col-lg-5">
				<div class="admInfo" width="50%">
					<div>
						<div class="op teamop currop">
							<h3>Current Team:</h3>
							<div ng-repeat="team in thisTeam" class="entity currentEntity">
								<div id="{{team.id}}">
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
									<div id="{{team.id}}">
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
								<div id="{{proj.id}}">
									<h4>{{proj.title}}</h4>
									<p>{{proj.description}}</p>
									<a class="btn-link" href="profile.php?glimpse={{proj.owner}}">{{proj.owner}}</a>
								</div>
							</div>
						</div>
						<div class="op projop">
							<h3>Other Projects:</h3>
							<div ng-repeat="proj in otherProjs" class="entity otherEntity">
								<div id="{{proj.id}}">
									<h4>{{proj.title}}</h4>
									<p>{{proj.description}}</p>
									<a class="btn-link" href="profile.php?glimpse={{proj.owner}}">{{proj.owner}}</a>
								</div>
							</div>
						</div>
						<div class="op sysop">
							<h3>All Systems:</h3>
							<div ng-repeat="system in allSystems" class="entity currentEntity">
								<div id="{{system.id}}">
									<div class="interact">
										<i class="fa fa-rocket"></i>
										<i class="fa fa-trash"></i>
									</div>
									<h4>{{system.title}}</h4>
									<p>{{system.description}}</p>
									<a class="btn-link" href="profile.php?glimpse={{system.owner}}">{{system.owner}}</a>
								</div>
							</div>
						</div>
						<div class="op reqop">
							<h3>All Requirements:</h3>
							<div ng-repeat="requirement in allRequirements" class="entity currentEntity">
								<div id="{{requirement.id}}">
									<h4>{{requirement.name}}</h4>
									<p>{{requirement.description}}</p>
									<a class="btn-link" href="profile.php?glimpse={{requirement.owner}}">{{requirement.owner}}</a>
								</div>
							</div>
						</div>
						<div class="op varop">
							<h3>All Variables:</h3>
							<div ng-repeat="variable in allVariables" class="entity currentEntity">
								<div id="{{variable.id}}">
									<h4>{{variable.symbol}} - <span class="symbName">{{variable.name}}</span></h4>
									<p>{{variable.description}}</p>
									<a class="btn-link" href="profile.php?glimpse={{variable.owner}}">{{variable.owner}}</a>
								</div>
							</div>
						</div>
					
					</div>
				</div>	
			<!--End middle column-->
			</div>
			<!--Start right column-->
			<div class="col-xs-4 col-sm-4 col-md-5 col-lg-5">
				<div class="op teamop currop" width="50%">
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
				<div class="op projop" width="50%">
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
				<div class="op sysop" width="50%">
					<h3>Add System</h3>
					<form>
						<div class="form-group">
							<label for="systemParentSet">Parent System</label>
							<select id="systemParentSet" class="form-control" ng-options="team.id as team.name for team in otherTeams track by team.id">
								<option value="none" selected="selected">--Choose One--</option>
								<option value="0">Ronin</option>
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
				<div class="op reqop" width="50%">
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
				<div class="op varop" width="50%">
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
				<div>
					<h3>Requirements</h3>
					<table>
						<thead>
							<tr><th>Unlinked</th><th>Linked</th></tr>
							<tr>
								<td id="unlinkedList"></td>
								<td id="linkedList"></td>
							</tr>
						</thead>
					</table>
				</div>
			<!--End right column-->
			</div>
			<!--Start bottom span-->
			<div class="col-xs-8 col-sm-8 col-md-10 col-lg-10 col-xs-offset-4 col-sm-offset-4 col-md-offset-2 col-lg-offset-2" style="background:orange;">
			<!--End bottom span-->
			</div>
		</div>	
	</div>
	<script src="../bower_components/angular/angular.js"></script>
	<script src="../js/app.js"></script>
	<script src="../js/services/httpConns.js"></script>
	<script src="../js/controllers/MainController.js"></script>
</body>
</html>