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
		<div class="row">
			<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2">
				<h2>Resources</h2>
				<ul>
					<li class="btn-link"><a href="../docs/rfp.pdf" target="_blank"><p>Request For Proposal</p></a></li>
			  		<li class="btn-link"><a href="https://drive.google.com/drive/folders/0B9f10mN88s-xRWd2MjNtdmlVcW8?usp=sharing" target="_blank"><p>Google Drive</p></a></li>
			  		<li class="btn-link"><a href="../docs/SMAD.pdf" target="_blank"><p>SMAD PDF</p></a></li>
			  		<li class="btn-link"><a href="../docs/firstResponse.pdf" target="_blank"><p>1st Round Responses</p></a></li>
			  		<li class="btn-link"><a href="https://www.agi.com/products/stk/" target="_blank"><p>AGI STK Software</p></a></li>
			  	</ul>
			</div>
			<div class="col-xs-5 col-xs-offset-1 col-sm-6 col-sm-offset-1 col-md-6 col-md-offset-0 col-lg-6 col-lg-offset-0">
				<h2>Bulletin</h2>
				<div class="naEntry">
					<h3>A New Hope</h3>
					<p>Welcome fellow comrades and compatriots! This is our year of reckoning, to declare in one voice that we will go with furor into a universe unknown to mankind. Stick together and we will rocket into the cosmos, and pave the path to an intergalactic future with the stardust of our tears.</p></br>
					<img class="img-responsive center-block" src="../images/oddsinfavor.png"/>
				</div>
			</div>
			<div class="col-xs-3 col-xs-offset-0 col-sm-3 col-sm-offset-0 col-md-4 col-lg-4">
				<h2>Important Shit</h2>
				<ul>
					<li><a href="rules.php"><p>RULES</p></a></li>
					<li><a href="requirements.php"><p>Requirements</p></a></li>
					<li><a href="qanda.php"><p>Questions and Answers and Stuff</p></a></li>
					<li><a href="contacts.php"><p>Helpful People</p></a></li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>