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
	<div id="headerArea" class="container-fluid"> <!-- If Needed Left and Right Padding in 'md' and 'lg' screen means use container class --></div>
		<div class="container profileBody" ng-app="userInfoApp" ng-controller="setTeams" >
			<div class="row">
				<!--Start left column-->
				<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
					<h3>Profile</h3>
					<p><b>SysAdmin:</b> Harry Lambert</p>
					<p>For Questions, Comments, and/or Suggestions:</p>
					<p><b>Phone:</b> 510-421-4007</p>
					<p id="adminEmail"><b>Email:</b> lambert.harrison@gmail.com</p>
				<!--End left column-->
				</div>
				<div class="col-xs-8 col-sm-8 col-md-4 col-lg-4 personalDetails">
					<h3>Set Up All the Things</h3>
					<a href="spacecraft.php" class="btn-link"><h4>Build a Spacechip!</h4></a> 
					<a href="studentproof.php"><h4>Prove You're a Student</h4></a>
				</div>
			</div>	
		</div>
	</div>
	<script src="../bower_components/angular/angular.js"></script>
	<script src="../js/app.js"></script>
	<script src="../js/services/httpConns.js"></script>
	<script src="../js/controllers/MainController.js"></script>
</body>
</html>