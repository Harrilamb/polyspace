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
		<p>Something awesome this way comes.</p>
		<a class="btn-link" href="home.php"><p><- Return</p></a>
	</div>
</body>
</html>