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
		<h2>Hello Team! <3</h2>
		<p>Welcome to the Cal Poly 2016-2017 Senior Space Design class’s website. My hope is to keep one source of truth so we can keep track of information, and this is one way I hope to make our process run more smoothly this year. This site will house useful documents, links, apps/tools, and a beautiful site to show our design at symposium. While you use this site please be respectful of the fact that it is a work in progress, and will improve as we move along. DON’T BREAK MY SHIT! If you have any questions, concerns, suggestions, or any various ramblings please either find me in class, text me, or email. My deets below:</p>
		<ul>
			<li><b>SysAdmin:</b> Harry Lambert</li>
			<li><b>Phone:</b>510-421-4007</li>
			<li><b>Email:</b>lambert.harrison@gmail.com</li>
		</ul>
		<p>Since there are not yet any user tools to upload and manipulate data, if you see anything missing, or have something that should be shared with the class then send it to me and I will put it in the proper place. As the system develops I may add more rules here, so please check sometimes and follow the rules so we don't all get fucked by your ignorance.</p>
		<a class="btn-link" href="home.php"><p><- Return</p></a>
	</div>
</body>
</html>