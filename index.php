<?php
	session_start();
	if(isset($_SESSION["userid"]) && !empty($_SESSION["userid"])){
		header("location:pages/home.php");
	}
?>
<!--Written By Harrison Lambert-->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>AERO 447</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script data-main="js/main" src="js/front.js"></script>
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="container-fluid" style="padding:0;">
	<div class="rocketContainer">
		<div class="container">
			<div class="content">
				<h1 class="text-center whiteHeader">Cal Poly Spacecraft Design</h1>
				<div class="formwrap">
					<form>
						<div class="form-group">
							<input class="form-control textinput" id="username" type="text" placeholder="Email"/>
							<input class="form-control textinput" id="password" type="password" placeholder="Password"/>
						</div>
					</form>
					<div class="subinput">
						<p class="uibutton buttons ascend">Ascend</p>
						<a id="joinBtn" class="buttons" href="pages/signup.php">Join Us</a>
					</div>
				</div>
			</div>
		</div>
		<div style="width:100%;height:auto;position:absolute;bottom:10px;margin:0 auto;"><p class="moreDetails" style="color:white;display:block;margin:0 auto;text-align:center;font-family:arial;cursor:pointer;">DETAILS</p><img class="moreDetails" src="images/icons/slide-arrow.png" style="display:block;margin:0 auto;cursor:pointer;" width="75" height="auto"/></div>
	</div>
	<div class="mission">
		<!--The class and mission-->
		<div class="container" height="auto" style="display:block;">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="overflow:hidden;height:400px;top:50%;"><img src="images/disaster_relief.jpg" title="Natural Disaster" alt="Natural Disaster"/></div>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
				<div>
					<h2><u>The Mission</u></h2>
					<p>The Humphrey and Prudence Trickelbank Foundation was established 
					to support disaster relief activities around the world. The Foundation 
					is considering a major investment to create a rapid reaction satellite 
					constellation to assist relief efforts around the world. For political 
					reasons, the system is not to be prepositioned in orbit and will only 
					be deployed in the event of a major natural disaster (within 24 hours) 
					The feasibility and expected cost of the constellation. Final responses 
					to this RFP should describe the preliminary design of the proposed system 
					icluding expected performance, development schedule, and ROM cost.
					</p>
					<p><a href="http://protests.loc/polyspace/docs/rfp.pdf" target="_blank"><i class="fa fa-file-pdf-o"></i>Full Request For Proposal</a></p>
					<h2><u>The Class of 2016-2017</u></h2>
					<p>The best year, the one filled with geniuses that can 
					take on this beast of a class. In spacecraft design the 
					professor, and his industry network, throw all their combined 
					years of experience into a challenge that will battle harden students 
					into peak performance to enter the aerospace world and excel with all 
					that we have learned!
					</p>
				</div>
			</div>
		</div>
		<!--Dynamic profile-->
		<div class="container publicProfile" style="display:none;" height="auto">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 leftProf">
				<u><h3 class="userRole">Imaging Lead & Data Wrangler</h3></u>
				<p class="userStory">
					I am leading a team of 6 to find a way to meet the ridiculous requirements 
					bestowed on the imaging subsystem of the spacecrafts. The constellation 
					must be able to scan 287,500 square kilometers each day in the visible, 
					near infrared, and thermal infrared spectrum at 5 meter resolution. 
					The current state of the art for thermal infrared is 30 meters which has 
					thus far given us our greatest challenge. I have gathered information 
					about similar imaging missions from textbooks, online, and through 
					industry contact. With this data we were able to size a potential optical 
					system for all spectrums, choose materials, and integrate design with 
					auxilliary subsystems: guidance navigation & control, onboard 
					computing, data downlink communications, and cryogenic cooling. I have 
					also initiated, and maintain, a suite of software tools to support our 
					entire class of 50. This suite includes Google Drive for file 
					management, Slack for communications, Trello for planning, and this 
					site which I have developed from scratch and posted all code on my 
					<a href="https://github.com/Harrilamb">Github<i class="fa fa-github"></i></a>
				</p>
				<p class="userLinkHolder"><i class="fa fa-linkedin-square"></i><a class="userLink" href="https://www.linkedin.com/in/harrison-lambert">https://www.linkedin.com/in/harrison-lambert</a></p>
				<p class="userEmailHolder"><i class="fa fa-envelope"></i><a class="userEmail" href="mailto:lambert.harrison@gmail.com">lambert.harrison@gmail.com</a></p>
				<p class="userPhoneHolder"><i class="fa fa-phone"></i><a class="userPhone" href="tel:5104214007">(510) 421-4007</a></p>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 rightProf">
				<h2 class="userName" style="text-align:center;background-color:black;color:white;padding:5px 5px;margin:0;word-wrap:break-word;">Harrison Lambert</h2>
				<div style="overflow:hidden;width:100%;"><img class="userPhoto" src="images/uploads/aero_dept_logo.jpg" title="User Photo" alt="User Photo" width="100%"/></div>
			</div>
		</div>
		<!--Where we are photo break-->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-image:url('images/space_fire.jpg');background-size:cover;background-position:0px -150px;background-attachment:fixed; width:100%;display:block;margin:10px 0;" height="auto"><h1 style="padding:10px 10px 10px 10px;color:white;text-align:center;">Where We Are</h1></div>
		<!--Systems Requirement Review-->
		<div class="container" style="display:block;clear:both;" height="auto">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><img src="images/design_present.jpg" width="100%"/></div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<h2>Systems Requirement Review</h2>
				<p>
				For the first 6 weeks of the quarter the class was divided into 14 groups of 
				4-5 people each to investigate the viability of the requirements outlined by 
				the Tricklebank Foundation. Each team needed to come up with a high level 
				design without "going into the weeds" in order to see how each of us would 
				approach some of the big trades required by the request for proposal. This 
				process was intended to be as true to life as possible by requiring teams to 
				send notices of intent, and submit questions and requirement pushbacks by 
				certain deadlines. At the end of this period of the class each team had to give 
				a 15 minute presentation to the Trickelbank Foundation and a member of each team 
				about the team's chosen design.
				</p>
			</div>	
		</div>
		<!--Photo Break-->
		<div class="container-fluid" style="background-image:url('images/rapideye.jpg');background-position:0 0;background-attachment:fixed;display:block;height:90px;margin:10px 0;"></div>
		<!--Preliminary Design Review-->
		<div class="container" height="auto" style="display:block;">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<h2>Preliminary Design Review</h2>
				<p>
				For the last 4 weeks of the quarter the class was divided into 2 groups of about 25 
				people each to create a more comprehensive design. The increase in "horsepower" 
				for each subsystem allowed us to do even more research, calculations, and 
				trades to design everything from the subsystem level while simultaneously 
				designing at the system level to make sure that all subsystems would integrate 
				into a functional satellite constellation. Between the two sections there was 
				significant variations in design decisions, but the structure and process was 
				similar with both teams breaking up the system into 5 parts: system architecture, 
				imaging payload, communications payload/support, orbits, and launch. The major 
				goal of this period of the class was to make rational trades while avoiding 
				personal biases, maintaining a "big picture" view, and most importantly organizing 
				documentation of all decisions and research so that if anything needs to change in 
				the future everybody (not just the people who originally made the decision) knows 
				how it will effect every part of the design. At the end of the quarter each team 
				gave a 45 minute presentation to the Trickelbank Foundation, professors, and grad 
				students who were encouraged to find problems in the design and interrupt during 
				the presentations to test our ability to adapt and address concerns without guessing, 
				or conflicting viewpoints between teammates.
				</p>
				<p><a href="http://protests.loc/polyspace/docs/Sect1_PDR.pdf" target="_blank"><i class="fa fa-file-powerpoint-o"></i>Section 1 Presentation</a></p>
				<p><a href="http://protests.loc/polyspace/docs/Sect2_PDR.pdf" target="_blank"><i class="fa fa-file-powerpoint-o"></i>Section 2 Presentation</a></p>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="vertical-align:center;"><img src="images/space_hurricane.jpg" width="100%"/></div>
		</div>
		<!--Keep up break-->
		<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-image:url('images/vis_ir.jpg');background-size:cover;background-position:0px -150px; width:100%;display:block;text-align:center;color:white;" height="auto"><h1>Follow Our Progress on Our <a href="https://drive.google.com/drive/folders/0B9f10mN88s-xbHFwS0tOYnBWNFk?usp=sharing" target="_blank">Google Drive</a></h1></div>
	</div>
</div>
</body>
</html>