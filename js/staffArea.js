var clicked = false;
var UploadData = [];
$(document).ready(function()
{
	$.event.props.push('dataTransfer');
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
			texteditorHTML = encodeURIComponent(texteditorHTML);
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
	
	$("#cancelUpload").click(function()
	{
		$("#FileUploader").hide();
	});
	
	$("#SubmitProfile").click(function(e)
	{
		var email = $("#InfoEmail").val();
		var username = $("#InfoUserName").val();
		$.ajax({
			type: 'POST',
			url: '../scripts/ajax/UpdateProfile.php',
			data: "username=" + username + "&email=" + email,
			success: function(data)
			{
				console.log(data);
			}
		});
		e.preventDefault();
		return false;
	});
	
	$("#changeImg").click(function()
	{
		$("#FileUploader").show()
		$("#innerDropZone").bind('dragover', function()
		{
			$('#FileUploader').css('border', '2px solid blue');
		});
		
		$("#innerDropZone").bind('dragexit', function()
		{
			$('#FileUploader').css('border', '2px solid #f1f1f1');
		});
		
		$("#innerDropZone").bind('drop', fileDropHandler);
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
		var texteditorHTML = $("#ckedit iframe").contents().find("body").html();		
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
			texteditorHTML = encodeURIComponent(texteditorHTML);
			var data = "message=" + texteditorHTML + '&tags=' + tags + '&title=' + title; 
			console.log(texteditorHTML);
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
							'<img src="'+ val['pic'] +'" width="64" height="64" />',
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

function handleFiles(editors)
{
	if (editors)
	{
		$("#DropZoneProgress").show();
		$("#DropZoneCenter").hide();
		$.each(UploadData, function(index, file){		
			var sendData = JSON.stringify(UploadData[index]);
			sendData = "Data=" + sendData;
			$.ajax({
				xhr: function()
				{
					var xhr = new window.XMLHttpRequest();
					 xhr.upload.addEventListener("progress", function(evt){
						   if (evt.lengthComputable) {
							 var percentComplete = evt.loaded / evt.total;
							 //Do something with upload progress
							$("#progress span").css('width', ((percentComplete*100) + '%'));
							
						  }
					 }, false);
					return xhr;
				},			
				url: '../scripts/ajax/uploads/editorsUploader.php',
				data: sendData,
				type: 'POST',			
				success: function(data)
				{
					console.log(data);
					$("#infomationLink").val(data).trigger('change');
				}
			});
		});	
	}
	else
	{
		$("#DropZoneProgress").show();
		$("#DropZoneCenter").hide();
		$.each(UploadData, function(index, file){		
			var sendData = JSON.stringify(UploadData[index]);
			sendData = "Data=" + sendData;
			$.ajax({
				xhr: function()
				{
					var xhr = new window.XMLHttpRequest();
					 xhr.upload.addEventListener("progress", function(evt){
						   if (evt.lengthComputable) {
							 var percentComplete = evt.loaded / evt.total;
							 //Do something with upload progress
							$("#progress span").css('width', ((percentComplete*100) + '%'));
							
						  }
					 }, false);
					return xhr;
				},			
				url: '../scripts/ajax/uploads/ProfilePic.php',
				data: sendData,
				type: 'POST',			
				success: function(data)
				{
					console.log(data);
					$("#changeImg img").attr('src', UploadData[index]['value']);
				}
			});
		});
	}
}

function fileDropHandler(evt, editors)
{
	console.log(evt, editors);	
	UploadData = [];
	$('#FileUploader').css('border', '2px solid #f1f1f1');
	//dropped the file now lets see...
	evt.stopPropagation();
	evt.preventDefault();
	//console.log(evt);
	var files = evt.originalEvent.dataTransfer.files;
	var count = files.length;			 
	// Only call the handler if 1 or more files was dropped.
	if (count > 0){				
		$.each(files, function(index, file){					
				var fileReader = new FileReader();     
				// When the filereader loads initiate a function
				fileReader.onload = (function(file) {	
						return function(e) {
							console.log('upload!');
							// Push the data URI into an array
							UploadData.push({name : file.name, value : this.result});
							if (editors && editors == "editors"){							
								//we will send the file to upload script
								handleFiles('editors');
							}
							else
							{
								handleFiles();
							}
						};
				})(files[index]);
			fileReader.readAsDataURL(file);					 
		});
		
	}	
}