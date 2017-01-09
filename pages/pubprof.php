<?php
	session_start();
	if(!isset($_SESSION["userid"]) || empty($_SESSION["userid"])){
		header("location:../index.php?returl=pubprof");
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
	<div class="container">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h1>Public Profile Setup</h1>
			<p>
			Enter your information in the fields below to populate your public profile
			that you can then give to employers to showcase your involvement in Senior Spacecraft
			Design.
			</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" style="background-color:#adccff;border:1px solid #75aaff;border-radius:2px;">
				<p style="margin:3px 0;">Your Personal URL:</p>
				<p id="personalURL" style="background-color:#f4f4f4;border:1px solid $d6d8db;padding:5px 5px">http://www.exodes.co?u=5</p>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<button class="uibutton publicSave">Save</button>
				<p class="successAlert" style="color:green;"></p>
				<p class="failedAlert" style="color:red;"></p>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form enctype="multipart/form-data">
				<div class="form-group">
					<label for="publicName">Full Name</label>
					<input type="text" id="publicName" class="form-control" placeholder="Bruce Wayne"/>
					<label for="publicRole">Role/Position</label>
					<input type="text" id="publicRole" class="form-control" placeholder="Scourge of the Underworld"/>
					<label for="publicDescription">Description</label>
					<textarea id="publicDescription" class="form-control" placeholder="It's not who you are underneath, it's what you do that defines you." resize="none"></textarea>
					<label for="publicLinkedin">LinkedIn URL</label>
					<input type="url" id="publicLinkedin" class="form-control" placeholder="https://www.linkedin.com/in/batman"/>
					<label for="publicEmail">Email</label>
					<input type="email" id="publicEmail" class="form-control" placeholder="dark.prince@gotham.com"/>
					<label for="publicPhone">Phone Number</label>
					<input type="tel" id="publicPhone" class="form-control" placeholder="3141592653"/>
					<label for="publicPicture"><b>Profile Picture</b>: Use <a href="http://en.gravatar.com/support/activating-your-account/">this link</a> to set up a Gravatar with the same email provided in the form. Current Image Shown Below</label></br>
					<img id="publicPicture" height="200"/>
				</div>
			</form>
			<div>
				<button class="uibutton publicSave">Save</button>
				<p class="successAlert" style="color:green;"></p>
				<p class="failedAlert" style="color:red;"></p>
			</div>
		</div>
	</div>
</body>
</html>