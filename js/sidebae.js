$(document).ready(function(){
//Object to handle the system management process
	var systemBuilder = {
		"system":undefined,
		"requirements":undefined,
		"findSystems":function(){
			$.ajax({
				method:"POST",
				url: "../php/sqlHandlers.php",
				data: { action: 'find_systems'
				}
			})
			.done(function( msg ) {
				$(".sysList").empty();
				$(".sysList").append("<h3>All Systems:</h3>");
				
				if(msg){

//Reload list of systems in view
					$(".sysList").append(msg);

//Call reload of system dropdowns
					entryBuilder.loadSystems();
				}else{
					console.log(msg);
					//sweetAlert("Sorry something went wrong.");
				};
				
//Handle addition of an entry
				$(".fa-plus-square").click(function(){
					var sysid = utilities.getNum($(this).parents().eq(1).attr("id"));
					entryBuilder.entryProcess(sysid,1);
				});
				
//Handle the clicking of a system to show entries attached to it
				$(".systemEntity").click(function(){
					$(".systemEntitySelect").removeClass("systemEntitySelect");
					$(this).addClass("systemEntitySelect");
					$(".currop").removeClass("currop");
					$(this).parents().eq(1).addClass("currop");
					$("#entryLists").addClass("currop");
					var sysid = parseInt(utilities.getNum($(this).attr("id")));
					entryBuilder.loadEntries(sysid);
					$("#entryLists").addClass("currop");
				});

				$(".systemEntity").click(function(){
					$(this).children(".children").toggle();
				});

			   $(".systemEntity .interact i").click(function(e) {
					e.stopPropagation();
			   });
//Handle deletion of an entity
				$(".fa-trash").click(function(){
					var adult = $(this).parents().eq(1).attr("id");
					var entityid = utilities.getNum(adult);
					if($(this).parents().eq(2).hasClass("currentEntity")===false){
						if(adult.indexOf("team")!=-1){
							utilities.confirmAction("Are you sure you want to delete this team?",function(){counselor.removeTeam(entityid);},"Yes, delete it!","No, cancel plox!","red");
						}else if(adult.indexOf("proj")!=-1){
							utilities.confirmAction("Are you sure you want to delete this project?",function(){counselor.removeProject(entityid);},"Yes, delete it!","No, cancel plox!","red");
						}else if(adult.indexOf("entry")!=-1){
							utilities.confirmAction("Are you sure you want to delete this entry?",function(){counselor.removeEntry(entityid);},"Yes, delete it!","No, cancel plox!","red");
						}else{
							sweetAlert("I don't know what icon you clicked o_0");
						}
					}else{
						if(adult.indexOf("sys")!=-1){
							utilities.confirmAction("Are you sure you want to delete this system?",function(){counselor.removeSystem(entityid);},"Yes, delete it!","No, cancel plox!","red");
						}else if(adult.indexOf("req")!=-1){
							utilities.confirmAction("Are you sure you want to delete this requirement?",function(){counselor.removeRequirement(entityid);},"Yes, delete it!","No, cancel plox!","red");
						}else if(adult.indexOf("var")!=-1){
							utilities.confirmAction("Are you sure you want to delete this variable?",function(){counselor.removeVariable(entityid);},"Yes, delete it!","No, cancel plox!","red");
						}else{
							sweetAlert("I don't know what icon you clicked o_0");
						}
					}
				});

				$(".fa-trophy").click(function(){
					var adult = $(this).parents().eq(1).attr("id");
					if($(this).parents().eq(2).hasClass("currentEntity")===false){
						var entityid = utilities.getNum(adult);
						if(adult.indexOf("team")!=-1){
							utilities.confirmAction("Are you sure you want to promote this team?",function(){counselor.switchTeams(entityid);},"Yes, promote it!","No, cancel plox!","green");
						}else if(adult.indexOf("proj")!=-1){
							utilities.confirmAction("Are you sure you want to promote this project?",function(){counselor.switchProjects(entityid);},"Yes, promote it!","No cancel plox!","green");
						}else{
							console.log("I don't know what icon you clicked o_0");
						}
					}
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
				
				security.lockdownView();
			});
		},
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
					("Sorry something went wrong.");
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
					sweetAlert("Something didn't go right, the requirement was unable to be linked to the system.");
				}
			});
		},
	};
	
//Object to handle the entry management process
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
		"lockProcess":false,
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
					sweetAlert("Something didn't go right, the requirement was unable to be linked to the system.");
				}
			});
		},
//Put loaded systems in dropdown used to select when making an entry
		"updateDropdown":function(){
			$(".systemSelect").empty();
			var ebs = entryBuilder.systems;
			var options = "<option value='none'>--Choose-One--</option>";
			for(var i in ebs){
				options += "<option value='"+ebs[i].id+"'>"+ebs[i].title+"</option>";
			}
			$(".systemSelect").append(options);	
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
					sweetAlert("Something didn't go right, the variable was unable to be linked to the system.");
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
					if(security.edit===true){
						var thing = $("<div id='invar"+thisVar.id+"' class='entryVar'><strong>"+thisVar.symbol+"</strong><input type='text' class='entryVarVal' value='"+thisVar.joinValue+"' placeholder='"+thisVar.joinValue+"'/><i>"+thisVar.units+"</i></div>");
					}else{
						var thing = $("<div id='invar"+thisVar.id+"' class='entryVar'><strong>"+thisVar.symbol+"</strong><p>"+thisVar.joinValue+"</p><i>"+thisVar.units+"</i></div>");
					}
					inList[inList.length]=thisVar;
					thing.appendTo("#"+target+" .inputList");
				}else if(thisVar.joinName.toLowerCase()=="output"){
					if(security.edit===true){
						var thing = $("<div id='outvar"+thisVar.id+"' class='entryVar'><strong>"+thisVar.symbol+"</strong><input type='text' class='entryVarVal' value='"+thisVar.joinValue+"' placeholder='"+thisVar.joinValue+"'/><i>"+thisVar.units+"</i></div>");
					}else{
						var thing = $("<div id='outvar"+thisVar.id+"' class='entryVar'><strong>"+thisVar.symbol+"</strong><p>"+thisVar.joinValue+"</p><i>"+thisVar.units+"</i></div>");
					}
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
					sweetAlert("Something didn't go right, the variable was unable to be created.");
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
						sweetAlert("You must select at least one requirement to transfer.");
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
					entryBuilder.loadVariables(entryBuilder.entryid,"entryVarMainRow");
					if(popup==0){
						$.colorbox.close();
					}else{
						$.colorbox({inline:true,href:"#entryStep2",overlayClose:false});
					}
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"entryProcess":function(system,step){
			if(step==1){
				entryBuilder.lockProcess=true;
				$("#entrySysSelect").val(system);
				$.colorbox({inline:true,href:"#entryStep1",overlayClose:false,escKey:false});						
				$("#entryNext1").click(function(){
					var system = $("#entrySysSelect").val();
					var title = $("#entryNameSet").val().trim();
					var description = $("#entryDescSet").val().trim();
					if(system!="none" && title!="" && description!=""){
						entryBuilder.addEntry(system,title,description);
					}else{
						sweetAlert("All fields must be filled to proceed.");
					}
				});				
			}else if(step==2){
				$("#entryStep1").appendTo("#entryStep1Perm");
				$("#entryVarTitle,#entryNext2").css("display","block");
				$.colorbox({inline:true,href:"#entryStep2",overlayClose:false,escKey:false});
				$("#inputVarsAdd,#outputVarsAdd").addClass("popup");
				$("#entryNext2").click(function(){
					//entryBuilder.loadVariables(entryBuilder.entryid,"entryVarMainRow");
					entryBuilder.entryProcess(system,3);
				});
			}else if(step==3){
				$("#entryStep2").appendTo("#entryStep2Perm");
				$("#inputVarsAdd,#outputVarsAdd").removeClass("popup");
				$.colorbox({inline:true,href:"#entryStep3",overlayClose:false,escKey:false});
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
					$("#entrySysSelect").val("none");
					$("#entryNameSet").val("");
					$("#entryDescSet").val("");
					entryBuilder.entryProcess(system,2);
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the entry was unable to be created.");
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
					sweetAlert("Something didn't go right, the variable was unable to be created.");
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
					var thing = $("<div id='entry"+thisEntry.id+"' class='entity otherEntity entryEntity'><div class='interact'><i title='Delete This Entry' class='fa fa-trash fa-lg'></i></div><h4>"+thisEntry.title+"</h4><p>"+thisEntry.description+"</p><a class='btn-link' href='profile.php?glimpse="+thisEntry.ownerid+"'>"+thisEntry.owner+"</a></div>");
					thing.appendTo("#otherEntryList");
				}
			};
			$(".entryEntity").click(function(){
				var entryid = utilities.getNum($(this).attr("id"));
				entryBuilder.entryid = entryid;
				entryBuilder.loadVariables(entryid,"entryVarMainRow");
				$("#inputVarsAdd,#outputVarsAdd").addClass("popup");
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
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"stageEntry":function(){
			$.ajax({
		  	method:"POST",
		  	url:"../php/sqlHandlers.php",
		  	data: { action: 'stage_entry',
					entry: entryBuilder.entryid
				}
			})
			.done(function( msg ) {
				if(msg){
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		}
	}
	
//Object to handle relationships
	var counselor = {
		"switchTeams":function(team){
			$.ajax({
		  	method:"POST",
		  	url:"../php/sqlHandlers.php",
		  	data: { action: 'switch_teams',
					teamid:team
				}
			})
			.done(function( msg ) {
				if(msg){
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"switchProjects":function(proj){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'switch_projects',
						projid:proj
					}
			})
			.done(function( msg ) {
				if(msg){
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
				
		},
		"removeTeam":function(team){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'remove_team',
						teamid:team
					}
			})
			.done(function( msg ) {
				if(msg){
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"removeProject":function(proj){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'remove_project',
						projid:proj
					}
			})
			.done(function( msg ) {
				if(msg){
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"removeSystem":function(sys){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'remove_system',
						sysid:sys
					}
			})
			.done(function( msg ) {
				if(msg){
					console.log(msg);
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"removeRequirement":function(req){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'remove_requirement',
						reqid:req
					}
			})
			.done(function( msg ) {
				if(msg){
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"removeVariable":function(vars){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'remove_variable',
						varid:vars
					}
			})
			.done(function( msg ) {
				if(msg){
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"removeEntry":function(entry){
			$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'remove_entry',
						entryid:entry
					}
			})
			.done(function( msg ) {
				if(msg){
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		}
	};
	
//Object to store userful methods
	var utilities = { 
		"host":window.location.hostname,
		"page":window.location.href.split("/")[window.location.href.split("/").length-1].substring(0,window.location.href.split("/")[window.location.href.split("/").length-1].indexOf(".php")),
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
		},
//
		"confirmAction":function(string,fn,yes,no,color){
			if(color=="red"){
				color="#DD6B55";
			}else if(color=="green"){
				color="#008000";
			}else{
				//blue
				color="3e779d";
			}
			swal({
			  title: "Are you sure?",
			  text: string,
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: color,
			  confirmButtonText: yes,
			  cancelButtonText: no,
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm){
			  if (isConfirm) {
			  	fn();
				swal("WooHOOO!", "'Execute that order, you will bitch' -Yoda", "success");
			  } else {
				swal("Cancelled", "Okay Okay I didn't do it....jeez", "error");
			  }
			});
		},
		
		"getURI":function(sParam){
			var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : sParameterName[1];
				}
			}
		}
	};
	
	var security = {
		"level":undefined,
		"read":false,
		"write":false,
		"remove":false,
		"edit":false,
		"setPrivileges": function(){
			$.ajax({
		  	method:"POST",
		  	url:"../php/sqlHandlers.php",
		  	data: { action: 'set_privileges',
					entry: entryBuilder.entryid
				}
			})
			.done(function( msg ) {
				if(msg){
					security.level=msg;
					security.setupLevels();
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the variable was unable to be created.");
				}
			});
		},
		"setupLevels":function(){
			var s = security;
			switch(security.level){
				case "guest":
					s.read=true;
					s.write=false;
					s.remove=false;
					s.edit=false;
				break;
				case "student":
					s.read=true;
					s.write=true;
					s.remove=false;
					s.edit=true;
				break;
				case "professor":
					s.read=true;
					s.write=true;
					s.remove=false;
					s.edit=false;
				break;
				case "teamlead":
					s.read=true;
					s.write=true;
					s.remove=true;
					s.edit=true;
				break;
				case "sysadmin":
					s.read=true;
					s.write=true;
					s.remove=true;
					s.edit=true;
				break;
				default:
					s.read=false;
					s.write=false;
					s.remove=false;
					s.edit=false;
			}
			s.lockdownView();
		},
		
		"lockdownView":function(){
			if(security.read==false){
				if(utilities.page!="home.php"){
					//window.location.href="../index.php";
				}
			}else{
				if(security.write==false){
					$(".writepriv").remove();
					$(".fa-plus-square").remove();
					$(".fa-rocket").remove();
					$("#inputVarsAdd,#outputVarsAdd").remove();
				}
			
				if(security.remove==false){
					$(".fa-trash").remove();
				}
			
				if(security.edit==false){
					$(".fa-pencil-square-o").remove();
				}
			}
		}
	};

//Initialize page
	security.setPrivileges();
	systemBuilder.findSystems();
	if(utilities.page=="profile" && utilities.getURI("glimpse")!=undefined){
		$(".personalDetails").load("../php/sqlHandlers.php?action=view_user&userid="+utilities.getURI("glimpse"));
	}

//Banner load and actions (link to home, load username)
	$(function(){$("#headerArea").load("../html/heading-banner.html",
		function(){
			$("#usersname").load("../php/checkSession.php",function( response,status,xhr ){});
			$(".homehead h1").click(function(){window.location.href="../index.php";});
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
		});
	});
	
	
//Easy utility for quick html close buttons
	$(".close").click(function(){
		$(this).parent().fadeOut("fast",function(){});
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
				console.log(msg);
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
					sweetAlert("Something didn't go right, the team was unable to be created.");
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
					sweetAlert("Something didn't go right, the project was unable to be created.");
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
					systemBuilder.findSystems();
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the system was unable to be created.");
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
					sweetAlert("Something didn't go right, the requirement was unable to be created.");
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
					sweetAlert("Something didn't go right, the variable was unable to be created.");
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
		  	}else if(msg==0){
		  		sweetAlert("The email you used is already taken.");
		  	}else{
		  		console.log(msg);
		  		sweetAlert("Something went wrong trying to add you, please contact the site admin Harrison L with the deets.");
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
		$(".systemEntitySelect").removeClass("systemEntitySelect");
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
			sweetAlert("You must select at least one requirement to transfer.");
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
			sweetAlert("You must select at least one requirement to transfer.");
		}
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
	
	$("#entryStage").click(function(){
		entryBuilder.stageEntry();
		$.colorbox.close();
		sweetAlert("Awww yeah dawg! This entry is ready for the stage!");
		entryBuilder.lockProcess=false;
	});
	
	$("#entryStash").click(function(){
		$.colorbox.close();
		sweetAlert("All finished, this entry is now created!");
		entryBuilder.lockProcess=false;
	});

	
	$(document).bind('cbox_complete', function(){
	  //$.colorbox.resize({width:"500px",height:"400px"});
	  	
		$("#cancelVarAdd").click(function(){
			$.colorbox({inline:true,href:"#entryStep2"});
		});
	});
	
	$("#proveit").click(function(){
		$.ajax({
				method:"POST",
				url:"../php/sqlHandlers.php",
				data: { action: 'set_student',
						code: $("#codename").val()
				}
			})
			.done(function( msg ) {
				if(msg==1){
					sweetAlert("Welcome to the club my friend!");
				}else if(msg==0){
					console.log(msg);
					sweetAlert("You can't sit with us.");
				}else{
					console.log(msg);
					sweetAlert("Something didn't go right, the system was unable to be created.");
				}
			});
	});
	
});