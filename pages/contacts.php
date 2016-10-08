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
	<script data-main="../js/main" src="../js/require.js"></script>
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
		<div id="directory">
			<table>
			<thead>
			<tr class="row"><th><h2>Industry Contact Directory</h2></th></tr>
			</thead>
			<tbody>
			<tr class="row"><td><h3>Imaging Specialists</h2></td></tr>
			<tr class="row"><td>
				<div class="col-sm-6 col-md-6 col-lg-6">
					<h4>Bob Thomson</h3>
					<p>Worked at Lockheed Martin Space Systems- Sunnyvale for almost 30 years. Specialized in satellite imaging and recently designed the World View 4 for Digital Globe, a satellite with very high resolution imaging capabilities in visible and near IR.</p>
					<a class="btn-link" href="https://dg-cms-uploads-production.s3.amazonaws.com/uploads/document/file/196/DG_WorldView4_DS_11-15_Web.pdf" target="_blank"><p>World View 4 Details</p></a>
					<p><b>Liaison:</b><a class="btn-link" href="mailto:bkragt21@gmail.com"> Ben Kragt</a></p>
				</div>
			</td></tr>
			</tbody>
			</table>
		</div>
	</div>
</body>
</html>