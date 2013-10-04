CKEDITOR.plugins.add( 'ImageUpload', {	
	icons: 'UploadImage',
	init: function( editor ) {		
		editor.addCommand( 'ShowUpload', {		
			exec: function( editor ) {
				var NEwFormHtml = document.createElement('div');
					NEwFormHtml.id = "FileUploader";
					NEwFormHtml.innerHTML = ['<h2> Upload a file </h2>',
							'<div id="innerDropZone">',
								'<div id="DropZoneCenter">',
									'<div id="DropZoneText">',
										'<span></span>',
										'<h2> Drag a photo here </h2>',
										'<p> or click to select photos from your computer </p>',
									'</div>',					
								'</div>',
								'<div id="DropZoneProgress" style="display: none">',
									'<div id="progress">',
										'<span></span>',
									'</div>',
								'</div>',
								'<input type="file" style="height: 82%; width: 100%; opacity: 0.0; z-index: 999; position: absolute;"/>',
								'<input type="hidden" id="infomationLink" value=""/>',
							'</div>',
							'<div id="actionBar">',
								'<button id="startUpload" class="blue">',
									'<span class="label">Start Upload</span>',
								'</button>',
								'<button id="cancelUpload">',
									'<span class="label">Cancel Upload</span>',
								'</button>',
							'</div>'].join('\n');						
						document.body.appendChild(NEwFormHtml);
						NEwFormHtml.style.display = "block";
						
						$("#cancelUpload").click(function()
						{
							$("#FileUploader").remove();
						});
						
						$("#innerDropZone").bind('dragover', function()
						{
							$('#FileUploader').css('border', '2px solid blue');
						});
						
						$("#innerDropZone").bind('dragexit', function()
						{
							$('#FileUploader').css('border', '2px solid #f1f1f1');
						});
						
						$("#innerDropZone").bind('drop', function(evt){
							fileDropHandler(evt, 'editors');
						});
						
						$("#infomationLink").change(function()
						{
							var link = $("#infomationLink").val();
							$("#FileUploader").remove();
							editor.insertHtml("<img src='"+link+"' />");
						});					
			}
		});		
		editor.ui.addButton( 'UploadImage', {
			label: 'Upload Image',
			command: 'ShowUpload',
			toolbar: 'insert'
		});
	}
});