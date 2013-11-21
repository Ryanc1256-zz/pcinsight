(function(jQuery){
	jQuery.fn.gallery = function(){
		//simple jQuery plugin for a image gallery...
		//built by Ryan Clough, 7/11/13
		this.each(function(){
			//lets arrange the images...
			//creates two containers...
			var container = $('<div class="imageContainer"></div>').appendTo(this);
			var imageContainer = $('<div class="imgContainer"></div>').appendTo(container);
			//get a jquery object with all the img tags in them...
			var images = $(this).children('img');
			//adds them to the container				
			images.each(function(){				
				$(this).appendTo(imageContainer).click(function(){
					//when the image is clicked, send them to the corresponding place...
				});
			});
			//when the mouse enters it will show the controlls
			container.on('mouseenter', function(){
				$(this).find('.controls').show();
			});
			//when the mouse leaves it will fade out the icons (some cool transitions :) )
			container.on('mouseleave', function(){
				$(this).find('.controls').fadeOut(100);
			});
			
			
			//auto scrolls...
			
			var timer = setInterval(function(){
				container.find('.next').click();
			}, 5000);
			
			
			//lets make the controls	
			var controls = $('<div class="controls"></div>').appendTo(container);
			$('<span class="previous arrow">&lt;</span>').appendTo(controls).on('click', function(){	
				clearInterval(timer);//this will stop the auto gallery
				//this is the main part, this is for the next button, this will be the animating and it will look nice :)
				//gets the old image
				var old = $(imageContainer).children('.old')
				//gets the Current image
				var current = $(imageContainer).children('.current');
				//if their was no old image selected, the user must be at the start of the image list so we will select the last				
				if (!old.length){
					old = $(imageContainer).children('img').last();				
				}	
				//old css, aligns it to the right spot
				old.css({
					left: -old.width()
				});
				//animates the current element to left (offscreen) so the user cant see it anymore...
				current.animate({
					left: current.width()
				}, {
					queue: false, //stops jquery from doing the usual queuing for a smother animation
					complete: function(){
						//when the animation is finished we will remove the "current" class add a "old" class to it, and then hide it
						$(this).removeClass("current").addClass('old').hide();
					}
					
				});
				old.show(); //shows the old image (it will be offscreen so the user wont notice)
				//old image animate
				old.animate({
					left: 0
				}, {
					queue: false, //stops jquery from doing the usual queuing for a smother animation
					complete: function(){
							//when the animation is finished we will add the "current" class remove a "old" class to it
						$(this).addClass("current").removeClass('old');
					}
					
				});
			});
			$('<span class="next arrow">&gt;</span>').appendTo(controls).on('click', function(){
				if ($(controls).css('display') != 'none'){ //this will check if the controls and hidden if so then dont stop the timer
					clearInterval(timer);//this will stop the auto gallery
				}
				//this is the main part, this is for the next button, this will be the animating and it will look nice :)
				//gets the current image
				var current = $(imageContainer).children('.current');
				//gets the next image in the DOM
				var nextImage = $(imageContainer).children('.current').next();
				//if their was no nextImage selected, the user must be at the end of the image list so we will select the first
				if (!nextImage.length){
					nextImage = $(imageContainer).children('img').first();
				}
				//next image css, aligns it to the right spot
				nextImage.css({
					top: 0,
					left: nextImage.width()
				});
				//animates the elements to left (offscreen) so the user cant see it anymore...
				current.animate({
					left: -current.width()
				}, {
					queue: false,//stops jquery from doing the usual queuing for a smother animation
					complete: function(){
						//when the animation is finished we will remove the "current" class add a "old" class to it, and then hide it
						$(this).removeClass("current").addClass('old').hide();
					}
					
				});
				//shows the next image (it will be offscreen so the user wont notice)
				nextImage.show();
				//next image animate
				nextImage.animate({
					left: 0
				}, {
					queue: false, //stops jquery from doing the usual queuing for a smother animation
					complete: function(){
						//when the animation is finished we will add the "current" class remove a "old" class to it
						$(this).addClass("current").removeClass('old');
					}
					
				});
			});
		});	
	}
})(jQuery);

$(window).ready(function(){
	$('body').removeClass('nojs'); //removes the class noJS (as noJS has some site styling to fix the absence of javascript)
	$("#gallery").gallery(); //creates the gallery
});