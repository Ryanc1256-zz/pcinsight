CKEDITOR.plugins.add('gallery', {	
	icons: 'gallery',
	init: function( editor ) {		
		editor.addCommand( 'AddGalery', {		
			exec: function( editor ) {
				editor.insertHtml("hello");
			}				
		});		
		editor.ui.addButton( 'gallery', {
			label: 'Add a Gallery',
			command: 'AddGalery',
			toolbar: 'insert'
		});
	}
});