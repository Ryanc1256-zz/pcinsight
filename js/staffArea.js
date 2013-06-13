var clicked = false;
$(document).ready(function()
{
	$("#Notif").click(function()
	{
		if (!clicked)
		{
			clicked = true;
			$("#Notifications").show();
			$("#Notif").css('background', '#fff');
		}
		else
		{
			clicked = false;
			$("#Notifications").hide();
			$("#Notif").css('background', '#323232');
		}
	});
	$("#TopLeft a").click(function()
	{
		$(this).parent().find("ul").toggle();
	});
	
	$("#submit").click(function()
	{
		$("#loader").show();
		var texteditorHTML = $("iframe").contents().find("body").html();
		if (texteditorHTML.length < 1)
		{
			//error
			$(".error").text("Your Article has no text in it?");
			$(".error").show();
			$("#loader").hide();
		}
		else
		{
			//so now some ajax stuff...
			var url = "../scripts/ajax/submitContent.php";
			var data = "message=" + texteditorHTML; 
			$.ajax({
				type: "POST",
				data: data,
				url: url,
				success: function(data)
				{
					console.log(data);
					$("#loader").hide();
				},
				error: function()
				{
					$("#loader").hide();
				}			
			});
		}
	});
	setInterval(getNotifications, 10000);
	getNotifications(); //starts it off...
});


function getNotifications()
{	
	$.ajax({
		url: '../scripts/ajax/notificationsGET.php',
		type: 'GET',
		dataType: "json",
		success: function(data)
		{
			//this will be an json encoded value...			
			$("#notificationInsert").html(" ");
			$.each(data, function(i, val)
			{
				var addHTML = ['<li class="left">',
					'<a class="notification" href="review.php?reviewid='+val['id']+'">',
						'<span class="left">',
							'<img src="/pcinsight/images/ajax.gif" width="64" height="64" />',
						'</span>',
						'<p>'+val['message']+'</p>',			
					'</a>',
				'</li>'].join('\n');
				$("#notificationInsert").append(addHTML);
			});
		}
	});
}