<?php
	session_start();
	if(isset($_SESSION["userid"]) && !empty($_SESSION["userid"])){
		header("location:pages/home.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>AERO 447</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script data-main="js/main" src="js/require.js"></script>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/sidebae.css">
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<div class="container col-lg-12">
		<div class="content">
			<h1 class="text-center">Cal Poly Spacecraft Design</h1>
			<div class="formwrap">
				<form>
					<div class="form-group">
						<input class="form-control textinput" id="username" type="text" placeholder="Username"/>
						<input class="form-control textinput" id="password" type="password" placeholder="Password"/>
					</div>
				</form>
				<div class="subinput">
					<p class="uibutton buttons ascend">Ascend</p>
					<a class="buttons" href="pages/signup.php">Join Us</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>