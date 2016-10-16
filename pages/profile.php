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
	<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/sidebae.css">
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
	<div class="container profileBody">
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
				<h3>Profile</h3>
				<ul class="infoList">
					<li class="btn-link">Info</li>
					<li class="btn-link">Team</li>
					<li class="btn-link">Project</li>
				</ul>
				<p><b>System Admin:</b> Harry Lambert</p>
				<p>For Questions, Comments, and/or Suggestions:</p>
				<p><b>Phone:</b> 510-421-4007</p>
				<p><b>Email:</b> lambert.harrison@gmail.com</p>
			</div>
			<div ng-app="userInfoApp" ng-controller="setTeams" class="col-xs-4 col-sm-4 col-md-5 col-lg-5">
				<div class="admInfo" width="50%">
					<div>
						<h3>Current Team:</h3>
						<div ng-repeat="team in thisTeam">
							<div id="{{team.id}}">
								<h3>{{team.name}}</h3>
								<p>{{team.description}}</p>
								<strong><p>{{team.owner}}</p></strong>
							</div>
						</div>
						<h3>Other Teams:</h3>
						
					</div>
				</div>				
			</div>
			<div ng-app="userInfoApp" ng-controller="setTeams" class="col-xs-4 col-sm-4 col-md-5 col-lg-5">
				<div width="50%">
					<h3>Add Team</h3>
					<form>
						<div class="form-group">
							<label for="teamNameSet">Name</label>
							<input id="teamNameSet" type="text" class="form-control" placeholder="Name"/>
							<label for="teamDescSet">Description</label>
							<textarea id="teamDescSet" type="text" class="form-control" placeholder="Description"></textarea>
						</div>
					</form>
					<div id="addTeamSuccess" class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> New Team Added.
					</div>
					<div id="addTeamFailed" class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Missing Info</strong> Both Fields Required.
					</div>
					<button class="uibutton buttons addTeam">Add</button>
				</div>
			</div>
		</div>
	</div>
	<script src="../bower_components/angular/angular.js"></script>
	<script src="../js/app.js"></script>
	<script src="../js/services/currTeam.js"></script>
	<script src="../js/controllers/MainController.js"></script>
</body>
</html>