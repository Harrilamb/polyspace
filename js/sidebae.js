$(document).ready(function(){
	var requirements = {
		"records":undefined,
		"dataUpdate":function(sysid){
			$.ajax({
				method:"POST",
				url: "../php/sqlHandlers.php",
				data: { action: 'find_reqs',
						sysid:sysid
				}
			})
			.done(function( msg ) {
				if(msg){
					requirements.records=JSON.parse(msg).records;
					requirements.DOMUpdate();
				}else{
					alert("Sorry something went wrong.");
					console.log(JSON.parse(msg));
				};
			});
		},
		"DOMUpdate":function(){
			for(var req in requirements.records){
				/*var block = document.createElement("div");
				var name = document.createElement("h4");
				var desc = document.createElement("p");
				var owner = document.createElement("a");
				owner.append("<p>"+requirements.records[req].linked+"</p>");*/
				console.log(requirements.records[req].linked);	
			};
		}
	};
	
	$("#usersname").load("../php/checkSession.php",function( response,status,xhr ){});
	$(".homehead h1").click(function(){window.location.href="../index.php";});
	
//Easy utility for quick html close buttons
	$(".close").click(function(){
		$(this).parent().fadeOut("fast",function(){});
	});
	
//Handle the logout process
	$("#logout").click(function(){
		$(document).load("../php/logout.php",function( response,status,xhr ){
			if(response==1){
				window.location.href="../index.php";
			}else{
				console.log(response);
			}
		});
	});
	
//Handle the login process
	$(".ascend").click(function(){
		
		  $.ajax({
			method: "POST",
			url: "php/checkUser.php",
			data: { name: $("#username").val(), code: $("#password").val()}
		  })
		  .done(function( msg ) {
			if(msg==1){
				window.location.href="pages/home.php";
			}else{
				alert("I'm sorry dave, I can't do that.");
			}
		  });
	});
	
//Handle the addition of a new team
	$(".addTeam").click(function(){
		if($("#teamNameSet").val().trim()!="" && $("#teamDescSet").val().trim()!=""){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'add_team',
						name: $("#teamNameSet").val(),
						description: $("#teamDescSet").val()
				}
			})
			.done(function( msg ) {
				if(msg==1){
					$("#addTeamSuccess").fadeIn("fast",function(){});
					$("#teamNameSet").val("");
					$("#teamDescSet").val("");
				}else{
					console.log(msg);
					alert("Something didn't go right, the team was unable to be created.");
				}
			});
		}else{
			$("#addTeamFailed").fadeIn("fast",function(){});
		}
	});
	
//Handle the addition of a new project
	$(".addProject").click(function(){
		if($("#projectTitleSet").val().trim()!="" && $("#projectDescSet").val().trim()!=""){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'add_project',
						title: $("#projectTitleSet").val(),
						description: $("#projectDescSet").val()
				}
			})
			.done(function( msg ) {
				if(msg==1){
					$("#addProjectSuccess").fadeIn("fast",function(){});
					$("#projectTitleSet").val("");
					$("#projectDescSet").val("");
				}else{
					console.log(msg);
					alert("Something didn't go right, the team was unable to be created.");
				}
			});
		}else{
			$("#addProjectFailed").fadeIn("fast",function(){});
		}
	});
	
//Handle the addition of a new system
	$(".addSystem").click(function(){
		if($("#systemParentSet").val()!="none" && $("#systemTitleSet").val().trim()!="" && $("#systemDescSet").val().trim()!=""){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'add_system',
						parent: $("#systemParentSet").val().trim(),
						title: $("#systemTitleSet").val().trim(),
						description: $("#systemDescSet").val().trim()
				}
			})
			.done(function( msg ) {
				if(msg==1){
					$("#addSystemSuccess").fadeIn("fast",function(){});
					$("#systemParentSet").val("0");
					$("#systemTitleSet").val("");
					$("#systemDescSet").val("");
				}else{
					console.log(msg);
					alert("Something didn't go right, the team was unable to be created.");
				}
			});
		}else{
			$("#addSystemFailed").fadeIn("fast",function(){});
		}
	});

//Handle the addition of a new requirement
	$(".addRequirement").click(function(){
		if($("#requirementNameSet").val().trim()!="" && $("#requirementDescSet").val().trim()!="" && $("#requirementPassFailSet").val().trim()!="" && $("#requirementSourceSet").val().trim()!="" && $("requirementTierSet").val()!="none"){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'add_requirement',
						name: $("#requirementNameSet").val().trim(),
						description: $("#requirementDescSet").val().trim(),
						passfail: $("#requirementPassFailSet").val().trim(),
						source: $("#requirementSourceSet").val().trim(),
						tier: $("#requirementTierSet").val(),
						dynamic: $("#requirementDynamicSet").is(":checked")?1:0
				}
			})
			.done(function( msg ) {
				if(msg==1){
					$("#addRequirementSuccess").fadeIn("fast",function(){});
					$("#requirementNameSet").val("");
					$("#requirementDescSet").val("");
					$("#requirementPassFailSet").val("");
					$("#requirementSourceSet").val("");
					$("#requirementTierSet").val("none");
					$("#requirementDynamicSet").prop("checked",true);
				}else{
					console.log(msg);
					alert("Something didn't go right, the team was unable to be created.");
				}
			});
		}else{
			$("#addRequirementFailed").fadeIn("fast",function(){});
		}
	});

//Handle the addition of a new variable
	$(".addVariable").click(function(){
		if($("#variableNameSet").val().trim()!="" && $("#variableDescSet").val().trim()!="" && $("#variableSymbolSet").val().trim()!="" && $("#variableUnitSet").val().trim()!=""){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'add_variable',
						name: $("#variableNameSet").val().trim(),
						description: $("#variableDescSet").val().trim(),
						symbol: $("#variableSymbolSet").val().trim(),
						units: $("#variableUnitSet").val().trim()
				}
			})
			.done(function( msg ) {
				if(msg==1){
					$("#addVariableSuccess").fadeIn("fast",function(){});
					$("#variableNameSet").val("");
					$("#variableDescSet").val("");
					$("#variableSymbolSet").val("");
					$("#variableUnitSet").val("");
				}else{
					console.log(msg);
					alert("Something didn't go right, the team was unable to be created.");
				}
			});
		}else{
			$("#addVariableFailed").fadeIn("fast",function(){});
		}
	});

//Handle the signup process
	$(".subutt").click(function(){
			var name = $("#name").val().split(" ");
			var fn = name[0];
			var ln = "";
			for(var i = 1; i<name.length; i++){
				ln=ln+name[i];
			}
		  $.ajax({
		  	method:"POST",
		  	url:"../php/signupHandler.php",
		  	data:{ name: $("#name").val(), email: $("#email").val(), password: $("#password").val(), firstname: fn, lastname: ln }
		  })
		  .done(function( msg ) {
		  	if(msg==1){
		  		window.location.href="home.php";
		  	}else{
		  		alert("Something went wrong trying to add you, please contact the site admin Harrison L with the deets.");
		  	}
		  });
	});

//Used to drop down and pull up list of teams to select distinct drives
	$(".driveBtn").click(function(){
		$(".driveList").toggleClass("dlHidden",function(){});
		if($(".driveList").hasClass("dlHidden")){
			$(".driveList").slideUp("fast",function(){});
		}else{
			$(".driveList").slideDown("fast",function(){});
		}
	});
	
//Switch between entity views, triggered by list
	$(".switchop").click(function(){
		$(".currop").removeClass("currop");
		switch($(this).text()){
			case 'Team':
				$(".teamop").addClass("currop");
			break;
			case 'Project':
				$(".projop").addClass("currop");
			break;
			case 'System':
				$(".sysop").addClass("currop");
			break;
			case 'Requirement':
				$(".reqop").addClass("currop");
			break;
			case 'Variable':
				$(".varop").addClass("currop");
			break;
			default:
				$(".op").addClass("currop");
		}
	});
	
//Switch to system definition tool
	$(".fa-rocket").click(function(){
		var sysid = $(this).parents().eq(1).attr("id");
		requirements.dataUpdate(sysid);
	});
	
//Handle deletion of an entity
	$(".fa-trash").click(function(){
		var userid = $(this).parents().eq(1).attr("id");
	});
});