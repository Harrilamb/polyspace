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
	<div class="container" >
		<h2>¡¿DO YOU EVEN GO HERE?!</h2>
		<form>
			<div class="form-group">
				<label for="codename">What is the code for the space design room?</label>
				<input id="codename" type="password" placeholder="swagattack" class="form-control"/>
			</div>
		</form>
		<button id="proveit" class="uibutton buttons">Prove It</button>
		<div id="userTypeInfo">
			<p>If you are not a student but would still like access to some key features on this site please contact the system administrator.</p>
			<p><b>SysAdmin:</b> Harry Lambert</p>
			<p>For Questions, Comments, and/or Suggestions:</p>
			<p><b>Phone:</b> 510-421-4007</p>
			<p id="adminEmail"><b>Email:</b> lambert.harrison@gmail.com</p>
		</div>
	</div>
</body>
</html>