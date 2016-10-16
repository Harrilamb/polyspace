$(document).ready(function(){
	//alert($("#usersname").text());
	$("#usersname").load("../php/checkSession.php",function( response,status,xhr ){
	});
	$(".homehead h1").click(function(){window.location.href="../index.php";});
	$("#logout").click(function(){
		$(document).load("../php/logout.php",function( response,status,xhr ){
			if(response==1){
				window.location.href="../index.php";
			}else{
				console.log(response);
			}
		});
	});
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
	$(".driveBtn").click(function(){
		$(".driveList").toggleClass("dlHidden",function(){});
		if($(".driveList").hasClass("dlHidden")){
			$(".driveList").slideUp("fast",function(){});
		}else{
			$(".driveList").slideDown("fast",function(){});
		}
	});
});
