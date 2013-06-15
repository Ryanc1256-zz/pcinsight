var clicked = false;
$(document).ready(function()
{
	$("#Notif").click(function()
	{
		if (!clicked)
		{
			clicked = true;
			$("#Notifications").show();		
			$("#Notif").css('backgroundPosition', '-41px -53px');
		}
		else
		{
			clicked = false;
			$("#Notifications").hide();
			$("#Notif").css('backgroundPosition', '9px -53px');			
		}
	});
	$("#TopLeft a").click(function()
	{
		$(this).parent().find("ul").toggle();
	});
	
	$("#TopRight a").click(function()
	{
		$(this).parent().find("ul").toggle();
	});
	
	$("#reviewSubmit").click(function()
	{
		$("#loader").show();
		var texteditorHTML = $("#editor").html();
		if (texteditorHTML.length < 1 || $("#editorsTitle").text().length < 1)
		{
			//error
			$(".error").text("Your Article has no text in it?");
			$(".error").show();
			$("#loader").hide();
		}
		else
		{
			//so now some ajax stuff...
			var url = "../scripts/ajax/ResubmitsubmitContent.php";
			var id = location.search.replace('?', '').split('=')[1];			
			var title = $("#editorsTitle").text();
			var data = "message=" + texteditorHTML + '&id=' + id + "&title=" + title; 
			$.ajax({
				type: "POST",
				data: data,
				url: url,
				success: function(data)
				{
					console.log(data);
					$("#error").html("The article has been submited and you should be able to see it... <a href='../'>Here</a>");
					$("#error").css('display', 'block');
					$("#loader").hide();
				},
				error: function()
				{
					$("#loader").hide();
				}			
			});
		}
	});
	
	$("#changeImg").hover(function()
	{
		$("#hoveruserimg").css('display', 'inline');		
	},
	function()
	{
		$("#hoveruserimg").css('display', 'none');	
	});
	
	$("#submit").click(function()
	{
		$("#loader").show();
		var texteditorHTML = $("iframe").contents().find("body").text();		
		if (texteditorHTML.length < 1 && $("#title").val().length < 1)
		{
			//error
			$("#error").text("Your Article or title has no text in it!");
			$("#error").css('display', 'block');
			$("#loader").hide();
		}
		else
		{
			var tags = $("#tagsHolder").html().replace(/(<([^>]+)>)/ig,"%");
				tags = tags.split('%');
				tags = tags.filter(function(e){return e}); 
			
			var title = $("#title").val();
			//so now some ajax stuff...
			var url = "../scripts/ajax/submitContent.php";
			var data = "message=" + texteditorHTML + '&tags=' + tags + '&title=' + title; 
			console.log('submit');
			$.ajax({
				type: "POST",
				data: data,
				url: url,
				success: function(data)
				{
					$("#error").text("Your article has been submited to an editor");
					$("#error").css('display', 'block');
					$("#loader").hide();
				},
				error: function()
				{
					$("#loader").hide();
				}			
			});
		}
	});
	$("#TagInput").keyup(function(e)
	{
		var key = e.which;		
		if (key == 186 || key == 188)
		{
			//186 = ;
			var tag = $("#TagInput").val();
			tag = tag.substr(0, (tag.length - 1));
			$("#TagInput").val('');
			var oldtags = $("#tagsHolder").html();
			$("#tagsHolder").html(oldtags + '<span>' + tag + '</span>');
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
				$("#Notif").css("background-position", '-92px -53px');
			});
		}
	});
}