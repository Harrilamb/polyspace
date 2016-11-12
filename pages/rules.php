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
	<div class="container">
		<h2>Hello Team! <3</h2>
		<p>Welcome to the Cal Poly 2016-2017 Senior Space Design class’s website. My hope is to keep one source of truth so we can keep track of information, and this is one way I hope to make our process run more smoothly this year. This site will house useful documents, links, apps/tools, and a beautiful site to show our design at symposium. While you use this site please be respectful of the fact that it is a work in progress, and will improve as we move along. DON’T BREAK MY SHIT! If you have any questions, concerns, suggestions, or any various ramblings please either find me in class, text me, or email. My deets below:</p>
		<ul>
			<li><b>SysAdmin:</b> Harry Lambert</li>
			<li><b>Phone: </b>510-421-4007</li>
			<li><b>Email: </b>lambert.harrison@gmail.com</li>
		</ul>
		<h4>Apps & Tools</h4>
		<ol>
			<li><strong><u>SOSD 1.0</u></strong>:Don't use apostrophes in the forms for now. Other than that there are safeguards against everything I could think of that might go wrong. Let me know if I missed anything.</li>
		</ol>
		<p>As the system develops I may add more rules here, so please check sometimes and follow the rules so we don't all get f*cked by your ignorance.</p>
	</div>
</body>
</html>