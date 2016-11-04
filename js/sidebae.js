$(document).ready(function(){
	var systemBuilder = {
		"system":undefined,
		"requirements":undefined,
		"dataUpdate":function(sysid){
			$.ajax({
				method:"POST",
				url: "../php/sqlHandlers.php",
				data: { action: 'find_reqs',
						sysid:systemBuilder.system
				}
			})
			.done(function( msg ) {
				if(msg){
					systemBuilder.requirements=JSON.parse(msg).records;
					systemBuilder.DOMUpdate();
				}else{
					console.log(JSON.parse(msg));
					alert("Sorry something went wrong.");
				};
			});
		},
		"DOMUpdate":function(){
			if($("#linkedList").children().length>0){
				$("#linkedList").empty();
			}
			if($("#unlinkedList").children().length>0){
				$("#unlinkedList").empty();
			}
			for(var req in systemBuilder.requirements){
				var thisReq = systemBuilder.requirements[req];
				var thing = $("<div id='req"+thisReq.id+"' class='sysReq'><h4>"+thisReq.name+"</h4><p>"+thisReq.description+"</p></div>");
				if(systemBuilder.requirements[req].linked==1){
					thing.appendTo("#linkedList");	
				}else{
					thing.appendTo("#unlinkedList");
				}
			};
			$(".sysReq").click(function(){
				$(this).toggleClass("sysReqSelect",function(){});
			});
		},
		"changeReqLinkage":function(req,connect){
			if(connect==1){
				var act = "link_requirements";
			}else{
				var act = "unlink_requirements";
			}
			$.ajax({
				method:"POST",
				url: "../php/sqlHandlers.php",
				data:{	action: act,
						sysid: systemBuilder.system,
						reqids: req
				}
			})
			.done(function( msg ) {
				if(msg==1){
					systemBuilder.dataUpdate();
				}else{
					console.log(msg);
					alert("Something didn't go right, the requirement was unable to be linked to the system.");
				}
			});
		},
	};
	
	var entryBuilder = {
		"entryid":undefined, //switch to undefined when var add is finished
		"currsys":undefined,
		"systems":undefined,
		"entries":undefined,
		"systemid":undefined,
		"inputVars":"(0)",
		"outputVars":"(0)",
		"unusedVars":undefined,
		"currThroughput":undefined,
		"jointVars":undefined,
//Load systems available to attach the entry to
		"loadSystems":function(){
			$.ajax({
				method:"POST",
				url: "../php/sqlHandlers.php?action=all_systems"
			})
			.done(function( msg ) {
				if(msg){
					entryBuilder.systems = JSON.parse(msg).records;
					entryBuilder.updateDropdown();
				}else{
					console.log(msg);
					alert("Something didn't go right, the requirement was unable to be linked to the system.");
				}
			});
		},
//Put loaded systems in dropdown used to select when making an entry
		"updateDropdown":function(){
			var ebs = entryBuilder.systems;
			var options = "<option value='none'>--Choose-One--</option>";
			for(var i in ebs){
				options += "<option value='"+ebs[i].id+"'>"+ebs[i].title+"</option>";
			}
			$("#entrySysSelect").append(options);	
			//This is lazy but i'm putting this here because it should be the same
			$("#systemParentSet").append(options);
		},
//Load variables available to attach to the entry
		"loadVariables":function(entry,target){
			entryBuilder.entryid=entry;
			$.ajax({
				method:"POST",
				url: "../php/sqlHandlers.php",
				data: {
					action:"find_entryVars",
					entryid:entry
				}
			})
			.done(function( msg ) {
				if(msg){	
					entryBuilder.jointVars = JSON.parse(msg).records;
					if(target!=0){
						entryBuilder.updateVarLists(target);
					}
				}else{
					console.log(msg);
					alert("Something didn't go right, the variable was unable to be linked to the system.");
				}
			});
		},
//Put loaded variables into lists of variables used to select and edit for entry creation
		"updateVarLists":function(target){
			var inList = [];
			var outList = [];
			$("#"+target+" .inputList").empty();
			$("#"+target+" .outputList").empty();
			for(var varx in entryBuilder.jointVars){
				var thisVar = entryBuilder.jointVars[varx];
				if(thisVar.joinName.toLowerCase()=="input"){
					var thing = $("<div id='invar"+thisVar.id+"' class='entryVar'><strong>"+thisVar.symbol+"</strong><input type='text' id='fuckme' class='entryVarVal' value='"+thisVar.joinValue+"' placeholder='"+thisVar.joinValue+"'/><i>"+thisVar.units+"</i></div>");
					inList[inList.length]=thisVar;
					thing.appendTo("#"+target+" .inputList");
				}else if(thisVar.joinName.toLowerCase()=="output"){
					var thing = $("<div id='outvar"+thisVar.id+"' class='entryVar'><strong>"+thisVar.symbol+"</strong><input type='text' class='entryVarVal' value='"+thisVar.joinValue+"' placeholder='"+thisVar.joinValue+"'/><i>"+thisVar.units+"</i></div>");
					outList[outList.length]=thisVar;
					thing.appendTo("#"+target+" .outputList");
				}
			};
			if(inList.length!=0){
				entryBuilder.inputVars=utilities.jsToSqlArray(inList);
			}else{
				entryBuilder.inputVars="(0)";
			}
			if(outList.length!=0){
				entryBuilder.outputVars=utilities.jsToSqlArray(outList);
			}else{
				entryBuilder.outputVars="(0)";
			}
			$(".entryVar input").on("focusout",function(){
				var value = $(this).val();
				var varid = utilities.getNum($(this).parent().attr("id"));
				var throughput="";
				if($(this).parent().attr("id").indexOf("invar") !== -1){
					throughput = "input";
				}else if($(this).parent().attr("id").indexOf("outvar") !==-1){
					throughput = "output";
				}
				entryBuilder.changeVarVals(value,varid,throughput);
			});
		},
//
		"notinVars":function(location,throughput,popup){
			entryBuilder.currThroughput = throughput;
			if(throughput=="input"){
				var dontpick = entryBuilder.inputVars;
			}else if(throughput=="output"){
				var dontpick = entryBuilder.outputVars;
			}
			$.ajax({
		  	method:"POST",
		  	url:"../php/sqlHandlers.php",
		  	data: { action: 'unlinked_variables',
					notin:dontpick
				}
			})
			.done(function( msg ) {
				if(msg){
					entryBuilder.unusedVars=msg;
					entryBuilder.buildUnusedVars(location,popup);
				}else{
					console.log(msg);
					alert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"buildUnusedVars":function(location,popup){
			if(location=="colorbox"){
				$.colorbox({html:entryBuilder.unusedVars});
				$(".unlinkedVariables").click(function(){
					$(this).toggleClass("entryVarSelect",function(){});
				});
				$("#addEntryVars").click(function(){
					var i = 0;
					var varsList = [];
					$("#popupVariables .entryVarSelect").each(function(){
						varsList[i]=parseInt(utilities.getNum($(this).attr("id")));
						i++;
					});
					if(varsList.length!="()"){
						entryBuilder.linkVariable(varsList,popup);
					}else{
						alert("You must select at least one requirement to transfer.");
					}
				});
			}
		},
		"linkVariable":function(vars,popup){
			$.ajax({
		  	method:"POST",
		  	url:"../php/sqlHandlers.php",
		  	data: { action: 'link_variables',
					entryid:entryBuilder.entryid,
					variables:vars,
					throughput:entryBuilder.currThroughput
				}
			})
			.done(function( msg ) {
				if(msg){
					if(popup==0){
						$.colorbox.close();
					}else{
						$.colorbox({inline:true,href:"#entryStep2",overlayClose:false});
					}
					entryBuilder.loadVariables(entryBuilder.entryid,"entryVarMainRow");
				}else{
					console.log(msg);
					alert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"entryProcess":function(system,step){
			if(step==1){
				$("#entrySysSelect").val(system);
				$.colorbox({inline:true,href:"#entryStep1",overlayClose:false,escKey:false});						
				$("#entryNext1").click(function(){
					var system = $("#entrySysSelect").val();
					var title = $("#entryNameSet").val().trim();
					var description = $("#entryDescSet").val().trim();
					if(system!="none" && title!="" && description!=""){
						entryBuilder.addEntry(system,title,description);
					}else{
						alert("All fields must be filled to proceed.");
					}
				});				
			}else if(step==2){
				$("#entryStep1").appendTo("#entryStep1Perm");
				$.colorbox({inline:true,href:"#entryStep2",overlayClose:false,escKey:false});
				$("#inputVarsAdd,#outputVarsAdd").addClass("popup");
				$("#entryNext2").click(function(){
					entryBuilder.loadVariables(entryBuilder.entryid,"entryVarMainRow");
				});
			}else if(step==3){
				$("#entryStep2").appendTo("#entryStep2Perm");
				$("#inputVarsAdd,#outputVarsAdd").removeClass("popup");
				$.colorbox({inline:true,href:"#entryStep3",overlayClose:false,escKey:false});
				$("#entryStage").click(function(){
				
				});
				$("#entryStash").click(function(){
				
				});
			}
			//$("#entryStep1").appendTo("#entryAddProcess");
		},
		"addEntry":function(system,name,desc){
			$.ajax({
		  	method:"POST",
		  	url:"../php/sqlHandlers.php",
		  	data: { action: 'add_entries',
					sysid: system,
					title: name,
					description:desc
				}
			})
			.done(function( msg ) {
				if(JSON.parse(msg).success==1){
					entryBuilder.entryid=JSON.parse(msg).entryid;
					entryBuilder.loadVariables(entryBuilder.entryid,"entryVarMainRow");
					entryBuilder.entryProcess(system,2);
				}else{
					console.log(msg);
					alert("Something didn't go right, the entry was unable to be created.");
				}
			});
		},
		"loadEntries":function(system){
			$.ajax({
		  	method:"POST",
		  	url:"../php/sqlHandlers.php",
		  	data: { action: 'find_entries',
					sysid: system
				}
			})
			.done(function( msg ) {
				if(msg){
					entryBuilder.entries=JSON.parse(msg).records;
					entryBuilder.updateEntryList();
				}else{
					console.log(msg);
					alert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"updateEntryList":function(){
			$("#otherEntryList").empty();
			$("#currEntryList").empty();
			
			for(var entry in entryBuilder.entries){
				var thisEntry = entryBuilder.entries[entry];
				if(thisEntry.current==1){
					var thing = $("<div id='entry"+thisEntry.id+"' class='entity currentEntity entryEntity'><h4>"+thisEntry.title+"</h4><p>"+thisEntry.description+"</p><a class='btn-link' href='profile.php?glimpse="+thisEntry.ownerid+"'>"+thisEntry.owner+"</a></div>");
					thing.appendTo("#currEntryList");
				}else{
					var thing = $("<div id='entry"+thisEntry.id+"' class='entity otherEntity entryEntity'><h4>"+thisEntry.title+"</h4><p>"+thisEntry.description+"</p><a class='btn-link' href='profile.php?glimpse="+thisEntry.ownerid+"'>"+thisEntry.owner+"</a></div>");
					thing.appendTo("#otherEntryList");
				}
			};
			$(".entryEntity").click(function(){
				var entryid = utilities.getNum($(this).attr("id"));
				entryBuilder.entryid = entryid;
				entryBuilder.loadVariables(entryid,"entryVarMainRow");
				$.colorbox({inline:true,href:"#entryStep2"});
			});
		},
		"changeVarVals":function(value,varid,throughput){
			var entryid = entryBuilder.entryid;
			$.ajax({
		  	method:"POST",
		  	url:"../php/sqlHandlers.php",
		  	data: { action: 'update_variables',
					val: value,
					vid: varid,
					eid: entryid,
					thruput:throughput
				}
			})
			.done(function( msg ) {
				if(msg){
				}else{
					console.log(msg);
					alert("Something didn't go right, the variable was unable to be created.");
				}
			});
		}
	}
//Object to store userful methods
	var utilities = { 
//Extract number from a string, used to get db ids from html element ids
		"getNum": function(string){
			var num = string.replace( /^\D+/g, '');
			return num;
		},
//Convert javascript array to a string array that can be used in sql IN statement
		"jsToSqlArray":function(arr){
			var ret = "(";
			for(var thruput in arr){
				if(ret!="("){ret+=",";}
				ret+=arr[thruput].id;
			}
			ret+=")";
			return ret;
		}
	};

//Initialize page
	entryBuilder.loadSystems();
	entryBuilder.loadEntries(0);

//Banner load and actions (link to home, load username)
	$(function(){$("#headerArea").load("../html/heading-banner.html",
		function(){
			$("#usersname").load("../php/checkSession.php",function( response,status,xhr ){});
			$(".homehead h1").click(function(){window.location.href="../index.php";
			});
		});
	});
	
	
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
					alert("Something didn't go right, the project was unable to be created.");
				}
			});
		}else{
			$("#addProjectFailed").fadeIn("fast",function(){});
		}
	});
	
//Handle the addition of a new system
	$(".addSystem").click(function(){
		if($("#systemParentSet").val()!="0" && $("#systemTitleSet").val().trim()!="" && $("#systemDescSet").val().trim()!=""){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'add_system',
						parent: $("#systemParentSet").val(),
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
					alert("Something didn't go right, the system was unable to be created.");
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
					alert("Something didn't go right, the requirement was unable to be created.");
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
					alert("Something didn't go right, the variable was unable to be created.");
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
			case 'Entry':
				$(".entryop").addClass("currop");
			break;
			default:
				$(".op").addClass("currop");
		}
	});
		
	$(".systemEntity").click(function(){
		$(".systemEntitySelect").removeClass("systemEntitySelect");
		$(this).addClass("systemEntitySelect");
		$(".currop").removeClass("currop");
		$(this).parents().eq(1).addClass("currop");
		var sysid = parseInt(utilities.getNum($(this).attr("id")));
		entryBuilder.loadEntries(sysid);
		$("#entryLists").addClass("currop");
	});

//Switch to system definition tool
	$(".fa-rocket").click(function(){
		var sysid = parseInt(utilities.getNum($(this).parents().eq(1).attr("id")));
		systemBuilder.system = sysid;
		systemBuilder.dataUpdate();
		$(".currop").removeClass("currop");
		$(".sysReqOp,.sysList").addClass("currop");
		$(".systemEntitySelect").removeClass("systemEntitySelect");
		$(this).parents().eq(1).addClass("systemEntitySelect");
	});
	
	$(".systemEntity").click(function(){
        $(this).children(".children").toggle();
    });
   $(".systemEntity .interact i").click(function(e) {
        e.stopPropagation();
   });
	
//Handle addition of an entry
	$(".fa-plus-square").click(function(){
		var sysid = $(this).parents().eq(1).attr("id");
		entryBuilder.entryProcess(sysid,1);
	});
	
//Handle deletion of an entity
	$(".fa-trash").click(function(){
		var userid = $(this).parents().eq(1).attr("id");
	});
		
//Handle the linkage of a requirement to a system
	$("#linkReqs").click(function(){
		var i = 0;
		var reqList = [];
		$("#unlinkedList .sysReqSelect").each(function(){
			reqList[i]=parseInt(utilities.getNum($(this).attr("id")));
			i++;
		});
		if(reqList.length>0){
			systemBuilder.changeReqLinkage(reqList,1);
		}else{
			alert("You must select at least one requirement to transfer.");
		}
	});
	
//Handle the unlinkage of a requirement from a system
	$("#unlinkReqs").click(function(){
		var i = 0;
		var reqList = [];
		$("#linkedList .sysReqSelect").each(function(){
			reqList[i]=parseInt(utilities.getNum($(this).attr("id")));
			i++;
		});
		if(reqList.length>0){
			systemBuilder.changeReqLinkage(reqList,0);
		}else{
			alert("You must select at least one requirement to transfer.");
		}
	});	
	$("#testy").click(function(){
		$.colorbox({html:"<h1>Welcome Harry</h1>",trapFocus:true,overlayClose:false});
	});
	
	$("#inputVarsAdd").click(function(){
		var popup=0;
		if($(this).hasClass("popup")){popup = 1}
		entryBuilder.notinVars("colorbox","input",popup);
	});
	
	$("#outputVarsAdd").click(function(){
		var popup=0;
		if($(this).hasClass("popup")){popup = 1}
		entryBuilder.notinVars("colorbox","output",popup);
	});
	
	$(document).bind('cbox_complete', function(){
	  $.colorbox.resize();
	});
});