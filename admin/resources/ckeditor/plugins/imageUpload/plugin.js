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
			toolbar: 'insert'
		});
		
    }	
});

jQuery.event.props.push('dataTransfer');

var uploader = {
	container: null,
	files: [],
	upload: function(files){		
		$.each(files, function(){
			var reader = new FileReader();
			reader.onload = (function(file) {
				uploader.files.push(file);				
				$('<div class="file"><img src="'+ file.currentTarget.result +'" width="64" height="64"></div>').appendTo(uploader.container.children('.inner'));
			});
			reader.readAsDataURL(this);
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