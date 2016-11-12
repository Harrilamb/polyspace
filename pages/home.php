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
		<div class="row">
			<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2">
				<div>
					<h2>Resources</h2>
					<ul>
						<li class="btn-link"><a href="../docs/rfp.pdf" target="_blank">Request For Proposal</a></li>
						<li class="btn-link driveBtn">Google Drive</li>
							<ul class="driveList dlHidden">
								<li>Team 1</li>
								<li class="btn-link"><a href="https://drive.google.com/drive/folders/0B9f10mN88s-xRWd2MjNtdmlVcW8?usp=sharing" target="_blank">Team 2</a></li>
								<li>Team 3</li>
								<li>Team 4</li>
								<li>Team 5</li>
								<li>Team 6</li>
								<li>Team 7</li>
							</ul>
						<li class="btn-link"><a href="../docs/SMAD.pdf" target="_blank">SMAD PDF</a></li>
						<li class="btn-link"><a href="../docs/firstResponse.pdf" target="_blank">1st Round Responses</a></li>
						<li class="btn-link"><a href="../docs/NASA_Syst.pdf" target="_blank">NASA Systems Handbook</a></li>
						<li class="btn-link"><a href="https://www.agi.com/products/stk/" target="_blank">AGI STK Software</a></li>
						<li class="btn-link"><a href="../docs/NOI_Response.pdf" target="_blank">NOI Response</a></li>
					</ul>
			  	</div>
			</div>
			<div class="col-xs-5 col-xs-offset-1 col-sm-6 col-sm-offset-1 col-md-8 col-md-offset-0 col-lg-8 col-lg-offset-0">
				<h2>Bulletin</h2>
				<div id="bulletin">
					<div class="naEntry">
						<h3>Time To Get SOSD <img src="../images/icons/cheers.png" width="45" height="45"/></h3>
						<p><i>Nov 11, 2016</i></p>
						<p>System of Systems Designer (a.k.a. <a href="spacecraft.php">SOSD 1.0</a>) is a tool developed to help us manage our designs as we iterate through different variations. This application gives everybody the capability to build an entire system from the smallest level up, and is built around the following key features.</p>
						<p><strong>Currently Available</strong></p>
							<ul>
								<li><strong>Teams and Projects</strong>: Seperate out system structures between teams and projects as the segmentation of our class changes.</li>
								<li><strong>System Constructor</strong>: Provides the capability to construct a hierarchical model of all systems within the overall system. Attaching requirements forms the rules by which any entry must pass during voting.</li>
								<li><strong>Design Entries</strong>: The user has variables to define the empirical values going into and out of a subsystem design, as well as the description to note key features.</li>
								<li><strong>Direct MatLab Data Upload</strong>: Connect directly to the database from MatLab, this means that whenever the #1 entry for a system changes, any code using its variables can automatically update.</li>
							</ul>
						<p><strong>In Development</strong></p>
							<ul>
								<li><strong>Voting</strong>: Allows everyone to review requirements before an entry passes inspection, then they can choose which design entry is best in their opinion.</li>
								<li><strong>Notifications</strong>: When an entry gets dethroned and a new one steps into the primary position, other systems with the same variables as the old and new entries will have its team notified of the possible effect on its validity.</p>
							</ul>
						<p>If you would like to help develop future tools for this project, I have made the source code available on Github.</p>
						<p><a href="https://github.com/Harrilamb/polyspace"><i class="fa fa-github"></i>   Github Repository</a></p>
						<p>Enjoy the new feature, I hope it helps our process, and if you find any bugs please let me know!</p>
						<img class="img-responsive center-block" src="../images/sat_system.jpg"/>
					</div>
					<div class="naEntry">
						<h3>A New Hope</h3>
						<p><i>Sep 30, 2016</i></p>
						<p>Welcome fellow comrades and compatriots! This is our year of reckoning, to declare in one voice that we will go with furor into a universe unknown to mankind. Stick together and we will rocket into the cosmos, and pave the path to an intergalactic future with the stardust of our tears.</p></br>
						<img class="img-responsive center-block" src="../images/oddsinfavor.png"/>
					</div>
				</div>
			</div>
			<div class="col-xs-3 col-xs-offset-0 col-sm-3 col-sm-offset-0 col-md-2 col-lg-2">
				<div>
					<h2>Tools</h2>
					<ul>
						<li class="btn-link"><a href="spacecraft.php">System Of Systems Designer</a></li>
					</ul>
				</div>
				<div>
					<h3>Important Shit</h3>
					<ul>
						<li><a href="rules.php">RULES</a></li>
						<li><a href="qanda.php">Questions and Answers and Stuff</a></li>
						<li><a href="contacts.php">Helpful People</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
</html>