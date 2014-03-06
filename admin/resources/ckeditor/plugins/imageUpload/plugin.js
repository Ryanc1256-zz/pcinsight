CKEDITOR.plugins.add( 'imageUpload', {
    icons: 'images',
    init: function( editor ) {
		editor.addCommand( 'makeUploadScreen', {
			  exec: function( editor ) {
				window.uploader.makeUI(); 
			  }
		});
        editor.ui.addButton( 'imageUpload', {
			label: 'Upload',
			command: 'makeUploadScreen',
			toolbar: 'insert',
			icon: this.path + 'images/icon.png'
		});
		
    }	
});

jQuery.event.props.push('dataTransfer');

var uploader = {
	container: null,
	upload: function(files){		
		$.each(files, function(){
			var reader = new FileReader();
			reader.onload = (function(file) {						
				var element = $('<div class="file"><span class="progress"></span><img src="'+ file.currentTarget.result +'" width="64" height="64"><span class="result"></span></div>').appendTo(uploader.container.children('.inner'));				
				var data = {
					imageRes: ((file.currentTarget.result.split(/[:;]/)[2]).replace('base64,', '').replace(' ', '+')),
					type: (file.currentTarget.result.split(/[:;]/)[1]),
					actualImage: file.currentTarget.result
				}
				data = JSON.stringify(data);
				uploader.ajaxUpload(data, element);
			});
			reader.readAsDataURL(this);
		});		
	},
	ajaxUpload: function(data, element){
		$.ajax({
			url: location.href,
			data: 'ajaxUpload=true&data=' + data,
			type: 'post',
			dataType: 'json',
			success: function(e){	
				element.children('.result').addClass('success').show();
				if (e.reponse == 'success'){				
					CKEDITOR.instances.ckeditor.insertHtml('<img src="/' + e.relativePath + '" />');
				}
			},
			error: function(e){	
				element.children('.result').addClass('error').show();
				element.children('.progress').addClass('error');
			},
			xhr: function(){
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(evt){
					 if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						//Do something with upload progress
						element.children('.progress').animate({
							width: ((percentComplete * 100) + '%')
						});
					}
				});
				return xhr;
			}
		});
	},
	dragDrop: function(e){
		if(e.originalEvent.dataTransfer){
            if(e.originalEvent.dataTransfer.files.length) {
				e.preventDefault();
				e.stopPropagation();
				uploader.upload(e.originalEvent.dataTransfer.files);
			}
		}				
	},
	dragEnter: function(e){
		e.preventDefault();
		$(this).addClass('active');
	},
	dragExit: function(e){
		e.preventDefault();	
		$(this).removeClass('active');
	},
	prevent: function(e){
		e.preventDefault();	
		e.stopPropagation();
		$(this).addClass('active');
	},
	makeUI: function(){	
		uploader.container = $('<div class="dragDrop"><div class="inner"><a href="#" class="btn red closeButton"> Close </a></div></div>').appendTo('body').on({
			drop: uploader.dragDrop,
			dragenter: uploader.dragEnter,
			dragover:  uploader.prevent,
			dragleave: uploader.dragExit
		});
		uploader.container.children().find('.closeButton').click(function(){
			$('.dragDrop').remove();
		});;
	}
}
window.uploader = uploader;