$(document).ready(function(){
	var utilities = { 
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
		  		alert("The email you used is already taken.");
		  	}else{
		  		console.log(msg);
		  		alert("Something went wrong trying to add you, please contact the site admin Harrison L with the deets.");
		  	}
		  });
	});
	
	$(window).scroll(function(){
		$(".content").css("opacity", 1 - $(window).scrollTop() / 250);
	  });
	  
	function getAllUrlParams(url) {

	  // get query string from url (optional) or window
	  var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

	  // we'll store the parameters here
	  var obj = {};

	  // if query string exists
	  if (queryString) {

		// stuff after # is not part of query string, so get rid of it
		queryString = queryString.split('#')[0];

		// split our query string into its component parts
		var arr = queryString.split('&');

		for (var i=0; i<arr.length; i++) {
		  // separate the keys and the values
		  var a = arr[i].split('=');

		  // in case params look like: list[]=thing1&list[]=thing2
		  var paramNum = undefined;
		  var paramName = a[0].replace(/\[\d*\]/, function(v) {
			paramNum = v.slice(1,-1);
			return '';
		  });

		  // set parameter value (use 'true' if empty)
		  var paramValue = typeof(a[1])==='undefined' ? true : a[1];

		  // (optional) keep case consistent
		  paramName = paramName.toLowerCase();
		  paramValue = paramValue.toLowerCase();

		  // if parameter name already exists
		  if (obj[paramName]) {
			// convert value to array (if still string)
			if (typeof obj[paramName] === 'string') {
			  obj[paramName] = [obj[paramName]];
			}
			// if no array index number specified...
			if (typeof paramNum === 'undefined') {
			  // put the value on the end of the array
			  obj[paramName].push(paramValue);
			}
			// if array index number specified...
			else {
			  // put the value at that index number
			  obj[paramName][paramNum] = paramValue;
			}
		  }
		  // if param name doesn't exist yet, set it
		  else {
			obj[paramName] = paramValue;
		  }
		}
	  }

	  return obj;
	}
	var user = getAllUrlParams().u;
	if(user!=undefined){
		$(".publicProfile").css("display","block");
	}
	
	function getPublicProfile(userid,callback){
			$.ajax({
				method:"POST",
				url:"php/sqlHandlers.php",
				data: { action: 'get_public_profile',
						user:userid
				},
				success: function(data){
					callback(data);
				}
			})
	};
	
	var uid = utilities.getURI("u");
	if(uid!=undefined){
		var p = getPublicProfile(uid,function(retdata){			
		console.log(p.hasOwnProperty("name"));
			var p = JSON.parse(retdata);
			p.name.length>0?$(".userName").text(p.name):null;
			p.role.length>0?$(".userRole").text(p.role):null;
			p.description.length>0?$(".userStory").text(p.description):null;
			p.li.length>0?$(".userLink").text(p.li).attr("href",p.li):$(".userLinkHolder").hide();
			p.email.length>0?$(".userEmail").text(p.email).attr("href","mailto:"+p.email):$(".userEmailHolder").hide();
			p.phone.length>0?$(".userPhone").text(p.phone).attr("href","tel:"+p.phone):$(".userPhoneHolder").hide();
			$(".userPhoto").attr("src",p.pic);
		});
	};
	
	$(".moreDetails").click( function() {
		$('html, body').animate({
			scrollTop: $(".mission").offset().top
		}, 1000);
	});

});