var ResizeID;
var d1 = [[0, 3], [4, 8], [8, 5], [9, 13]];
var d2 = [[0, 0], [2, 8], [8, 10], [9, 13]];

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
	$(window).resize(function(){
		clearTimeout(ResizeID);
		ResizeID = setTimeout(doneResizing, 500);							
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
		var url = window.location.href;
		var tags = $(".tagsEnclosure span");
		var tag = [];
		$.each(tags, function(i, val){
			var tagText = $(this).text();
			tag.push(tagText);
		});
		tags = tag.join('#');
		var article = $(this).children().find("iframe").contents().find('body').html();
		var title = $(this).children('#tileForm').val();	
		var date = '';
		article = encodeURIComponent(article);
		var data = "reviewSubmit=true&tags=" + tags + "&article=" + article + '&title=' + title + '&date=' + date;		
		$.ajax({
			type: 'post',
			url: url,
			data: data,
			success: function(result){
				console.log(result);
			}
		});		
	});
	
	$("#EditArticlePOST").on('submit', function(e){
		e.preventDefault();		
		var url = window.location.href;
		var tags = $(".tagsEnclosure span");
		var tag = [];
		$.each(tags, function(i, val){
			var tagText = $(this).text();
			tag.push(tagText);
		});
		tags = tag.join('#');
		var article = $(this).children().find("iframe").contents().find('body').html();
		var title = $(this).children('#tileForm').val();	
		var date = '';
		var id = window.location.href;
		id = id.split('id')[1].replace('=', '');
		article = encodeURIComponent(article);	
		var data = "EditArticlePOST=true&tags=" + tags + "&article=" + article + '&title=' + title + '&date=' + date + '&id=' + id;		
		$.ajax({
			type: 'post',
			url: url,
			data: data,
			success: function(result){
				var data = jQuery.parseJSON(result);
				if (data && data.result){
					location.reload(true);
				}
			}
		});		
	});


	/*var graph1 = $.plot("#users .chart .innerChart", [d1], { 
		legend: {
			show: false
		},
		grid: {
			clickable: true,
			hoverable: true,
			borderWidth: 0,
			tickColor: "#f4f7f9"
		},
		colors: ["#f34541", "#49bf67"]					
	});

	var graph = $.plot("#visits .chart .innerChart", [d2], { 
		legend: {
			show: false
		},
		grid: {
			clickable: true,
			hoverable: true,
			borderWidth: 0,
			tickColor: "#f4f7f9"
		},
		colors: ["#f34541", "#49bf67"]					
	});*/

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





function doneResizing(){
	var graph1 = $.plot("#users .chart .innerChart", [d1], { 
		legend: {
			show: false
		},
		grid: {
			clickable: true,
			hoverable: true,
			borderWidth: 0,
			tickColor: "#f4f7f9"
		},
		colors: ["#f34541", "#49bf67"]					
		});

	var graph = $.plot("#visits .chart .innerChart", [d2], { 
		legend: {
			show: false
		},
		grid: {
			clickable: true,
			hoverable: true,
			borderWidth: 0,
			tickColor: "#f4f7f9"
		},
		colors: ["#f34541", "#49bf67"]					
	});		
}