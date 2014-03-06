$(document).ready(function(){
	$('#tags').on('keyup', function(e){
		var key = e.which || e.keycode;	
		if (key == 186 || key == 188){
			tags();
		}
	});
	
	$('.tagsHolder').on('click focus', function(){
		$("#tags").focus();
	});
	$("#calender").on('focus', function(){
		$("#calender").calender();
	});
});

function tags(){
	var text = $('#tags').val().replace(/[;,<:]/, '');
	if (text && text.length > 1){
		$('<span class="tags">' + text + '</span>').appendTo('#tagsHolder .tagsEnclosure');
	}
	$('#tags').val(' ');
}