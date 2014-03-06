$(document).ready(function(){	
	$("#leftNav").css('height', ($(document).height() - 40));
	var toggled = false;
	$(".menu.menu-expand.toggle.btn").click(function(){
		if (!toggled) {
			$("#leftNav .submenu.toggled").slideUp().removeClass('toggled');
			$("#leftNav").animate({
				width: '40px'
			}, {queue: false});
			$("#leftNav span").hide();		
			toggled = true;
		}
		else
		{
			$("#leftNav").animate({
				width: '213px'
			}, {
				complete: function(){
					$("#leftNav span").show();
				}
			});
	
			toggled = false;
		}
	});

	$("body").click(function(e){
		if (!($(e.target).hasClass('dropdown') || $(e.target).parent().hasClass('dropdown') || $(e.target).parent().parent().parent().hasClass('dropdown') || $(e.target).parent().parent().hasClass('dropdown') || $(e.target).hasClass('profilePic') || $(e.target).parent().hasClass('profilePic'))){
			$("nav .dropdown").hide();
		}	
		var check = $(e.target).hasClass('notificationbar') || $(e.target).parent().parent().hasClass('notificationbar') || $(e.target).attr('id') == 'notifications' || $(e.target).parent().attr('id') == 'notifications';				
		if (!check){						
			//e.preventDefault();
			$(".notificationbar").hide();
		}
	});

	$("#leftNav li").click(function(e){		
		if ($(this).children('ul').hasClass('submenu'))	{
			e.preventDefault();
			if (!$(this).children('ul').hasClass('toggled')){
				$("#leftNav ul.toggled").slideToggle().removeClass('toggled');
			}
			var submenu = $(this).children('ul');
			submenu.slideToggle({
				complete: function() {								
					if (submenu.css('display') != 'none'){									
						submenu.addClass("toggled");
					} else {
						submenu.removeClass('toggled');
					}
				}
			});		
		}
	});


	
	$("a[data-dismiss]").click(function(e){
		e.preventDefault();
		$(this).parent().remove();
	});

	$(".submenu li").click(function(e){
		e.preventDefault();
		e.stopPropagation();
		if ($(this).children('a').attr('href') || $(this).children('span').children('a').attr('href')){
			location.href = $(this).children('a').attr('href');
		}
	});		
		
	$("#ArticlePOST").on('submit', function(e){
		e.preventDefault();		
		var reader = new FileReader();
		var url = window.location.href;
		var tags = $(".tagsEnclosure span");
		var tag = [];
		var files = $("#file")[0].files[0];	
		var $this = this;
		var article = $($this).children().find("iframe").contents().find('body').html();
		var title = $($this).children('#tileForm').val();			
		if (files && title && article){
			reader.onload = function(file){
				var filetype = files.type;
				file =	file.currentTarget.result || file.srcElement.result;
				file = file.replace(filetype, '');
				file = file.replace('data:;base64,', '');			
				$.each(tags, function(i, val){				
					var tagText = $(this).text();
					tag.push(tagText);
				});
				tags = tag.join('#');
					
				var date = '';		
				file = encodeURIComponent(file);
				article = encodeURIComponent(article);			
				var data = "reviewSubmit=true&tags=" + tags + "&article=" + article + '&title=' + title + '&date=' + date + '&file=' + file + '&filetype=' + filetype;		
				var loading = $('<div class="loading"><div class="center"> Please wait, your article is getting submitted </div></div>').appendTo("body");
				$.ajax({
					type: 'post',
					url: url,
					data: data,			
					success: function(result){	
						console.log(result);
						loading.hide();
						$('<div class="loading"><div class="center"> Your article has been submited correctly, and is now waiting someone to review it. <br /><small>click anywhere to remove me</small></div></div>').appendTo("body").click(function(){$(this).remove();});
					},
					error: function(result){
						console.log(result);
						loading.hide();
					}
				});	
			}
			reader.readAsDataURL(files);
		} else {			
			$('<div class="user alert alert-dismissable alert-info">Please fill in everything....</div>').appendTo("#ArticlePOST");
		}
	});
	
	$("#EditArticlePOST").on('submit', function(e){	
		e.preventDefault();		
		var reader = new FileReader();
		var url = window.location.href;
		var tags = $(".tagsEnclosure span");
		var tag = [];
		var files = $("#file")[0].files[0];	
		var $this = this;
		var article = $($this).children().find("iframe").contents().find('body').html();
		var title = $($this).children('#tileForm').val();			
		if (title && article){
			reader.onload = function(file){
				var filetype = files.type;
				file =	file.currentTarget.result || file.srcElement.result;
				file = file.replace(filetype, '');
				file = file.replace('data:;base64,', '');			
				$.each(tags, function(i, val){				
					var tagText = $(this).text();
					tag.push(tagText);
				});
				tags = tag.join('#');					
				var date = '';		
				file = encodeURIComponent(file);
				article = encodeURIComponent(article);			
				var id = $("#hiddenID").val();
				var data = "EditArticlePOST=true&tags=" + tags + "&article=" + article + '&title=' + title + '&date=' + date + '&file=' + file + '&filetype=' + filetype + '&id=' + id;		
				var loading = $('<div class="loading"><div class="center"> Please wait, your article is getting submitted </div></div>').appendTo("body");
				$.ajax({
					type: 'post',
					url: url,
					data: data,			
					success: function(result){	
						console.log(result);
						loading.hide();
						$('<div class="loading"><div class="center"> Your article has been submited correctly, and is now waiting someone to review it. <br /><small>click anywhere to remove me</small></div></div>').appendTo("body").click(function(){$(this).remove();});
					},
					error: function(result){
						console.log(result);
						loading.hide();
					}
				});	
			}
			
			if (!files){
				article = encodeURIComponent(article);			
				var id = $("#hiddenID").val();
				var date = '';
				$.each(tags, function(i, val){				
					var tagText = $(this).text();
					tag.push(tagText);
				});
				tags = tag.join('#');
				var data = "EditArticlePOST=true&tags=" + tags + "&article=" + article + '&title=' + title + '&date=' + date + '&id=' + id;		
				var loading = $('<div class="loading"><div class="center"> Please wait, your article is getting submitted </div></div>').appendTo("body");
				$.ajax({
					type: 'post',
					url: url,
					data: data,			
					success: function(result){	
						console.log(result);
						loading.hide();
						$('<div class="loading"><div class="center"> Your article has been submited correctly, and is now waiting someone to review it. <br /><small>click anywhere to remove me</small></div></div>').appendTo("body").click(function(){$(this).remove();});
					},
					error: function(result){
						console.log(result);
						loading.hide();
					}
				});	
			} else {
				reader.readAsDataURL(files);
			}
		} else {			
			$('<div class="user alert alert-dismissable alert-info">Please fill in everything....</div>').appendTo("#ArticlePOST");
		}		
	});

	$(".profilePic").click(function(){
		$(this).next().toggle();
	});

	$("#notifications").click(function(e){
		if ($(e.target).hasClass('notificationbar')){
			e.preventDefault();
		} else {
			$(this).children(".notificationbar").toggle();
		}
	});			

});


