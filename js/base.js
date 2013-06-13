$(document).ready(function(){	
	$('#login').css({	
		top: (Math.max(0, (($(window).height() - 322) / 2) + $(window).scrollTop()) + "px"),
		left: (Math.max(0, (($(window).width() - 522) / 2) + $(window).scrollLeft()) + "px")
	});	
	var name = window.location.href.substr(window.location.href.lastIndexOf("/")+1);	
	
	if (name.indexOf('register.php') !== -1)
	{
		//register		
		$("#login form input:nth-child(6)").click(function(e){	
				$("#login form input").css('border', '1px solid rgba(0,0,0,0.55)');
				$("#loader").show();
				e.preventDefault();
				if (($("#login form input:nth-child(1)").val().length > 0)&&($("#login form input:nth-child(2)").val().length > 0)&&($("#login form input:nth-child(3)").val().length > 0)&&($("#login form input:nth-child(4)").val().length > 0))
				{
					var emailCheck = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					var username = $("#login form input:nth-child(1)").val();
					if ($("#login form input:nth-child(3)").val() === $("#login form input:nth-child(4)").val())
					{
						var email = $("#login form input:nth-child(2)").val();
						if (emailCheck.test(email)){						
							var password = $("#login form input:nth-child(3)").val()
							var data = 'username=' + username + '&email='+email + '&password=' + password;
							$.ajax({
								type: 'POST',
								data: data,
								url: 'scripts/RegisterBackend.php',
								success: function(data)
								{
									$("#loader").hide();
									if (data == "emailTaken")
									{
										$("#login form input:nth-child(2)").css('border', '2px solid red');
										$("#errorMessage").text("Email Address has been taken");
										$("#errorMessage").css('display', 'block');
									}
								}				
							});
						}
						else
						{
							$("#login form input:nth-child(2)").css('border', '2px solid red');
							$("#loader").hide();
						}
					}
					else
					{
						$("#login form input:nth-child(3)").css('border', '2px solid red');
						$("#login form input:nth-child(4)").css('border', '2px solid red');
						$("#loader").hide();
					}
					
				}
				else
				{
					//shake...					
					shake();
					$("#loader").hide();
				}
		});
	}
	else
	{
		//login.php
		$("#login form input:nth-child(3)").click(function(e){	
				e.preventDefault();
				if (($("#login form input:nth-child(1)").val().length > 0)&&($("#login form input:nth-child(2)").val().length > 0))
				{
					$("#loader").show();
					var email = $("#login form input:nth-child(1)").val();
					var emailCheck = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					if (emailCheck.test(email)){
						var password = $("#login form input:nth-child(2)").val();
						var data = 'email=' + email + '&password=' + password;
						$.ajax({
							type: 'POST',
							data: data,
							url: 'scripts/ajaxlogin.php',
							success: function(data)
							{
								$("#loader").hide();
								console.log(data);
								if (data == 'AuthenticationSucceeded')
								{
									location.href = 'index.php';
								}
							}				
						});
					}
					else
					{
						$("#loader").hide();
						$("#login form input:nth-child(1)").css('border', '2px solid red');
					}
				}
				else
				{
					//shake...				
					shake();
					$("#loader").hide();
				}
		});
	}
});

function shake()
{
	for (var i = 0; i < 1; i++)
	{
		$("#login").animate({
			left: "-=50"
		}, 75);
		
		$("#login").animate({
			left: "+=50"
		}, 75);
		
		$("#login").animate({
			left: "-=50"
		}, 75);
		
		$("#login").animate({
			left: "+=50"
		}, 75);
	}				
}


window.onresize = function()
{
	$('#login').css({	
		top: (Math.max(0, (($(window).height() - 322) / 2) + $(window).scrollTop()) + "px"),
		left: (Math.max(0, (($(window).width() - 522) / 2) + $(window).scrollLeft()) + "px")
	});	
}

//google functions
function loginFinishedCallback(authResult) {
	if (authResult) {
	  if (authResult['error'] == undefined){
		gapi.auth.setToken(authResult); // Store the returned token.				
		getEmail();                     // Trigger request to get the email address.
	  } else {
		console.log('An error occurred');
	  }
	} else {
	  console.log('Empty authResult');  // Something went wrong
	}
}

function getEmail(){
// Load the oauth2 libraries to enable the userinfo methods.
	gapi.client.load('oauth2', 'v2', function() {
	  var request = gapi.client.oauth2.userinfo.get();
	  request.execute(getEmailCallback);
	});
}

function getEmailCallback(obj){
	var el = document.getElementById('email');
	var email = '';
	console.log(obj);   // Uncomment to inspect the full object.				
}