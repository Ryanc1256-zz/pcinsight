(function(jQuery){
	jQuery.fn.gallery = function(){
		//simple jQuery plugin for a image gallery...
		//built by Ryan Clough, 7/11/13
		this.each(function(){
			//lets arrange the images...
			//creates two containers...
			var container = $('<div class="imageContainer"></div>').appendTo(this);
			var imageContainer = $('<div class="imgContainer"></div>').appendTo(container);
			var text = $('<div class="currentText"><p></p></div>').appendTo(container);
			//get a jquery object with all the img tags in them...
			var images = $(this).children('img');
			//adds them to the container				
			images.each(function(){				
				$(this).appendTo(imageContainer).hide().click(function(){
					//when the image is clicked, send them to the corresponding place...
					location.href = $(this).attr('data-link');
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
			
			$(text).children('p').text($(imageContainer).children('.current').attr('data-text'));		
			
			
			//auto scrolls...
			
			var timer = setInterval(function(){
				//container.find('.next').click();
			}, 5000);
			
			
			imageContainer.children('img').first().show();
			
			//lets make the controls	
			var controls = $('<div class="controls"></div>').appendTo(container);
			$('<span class="previous arrow">&lt;</span>').appendTo(controls).on('click', function(){	
				clearInterval(timer);//this will stop the auto gallery
				var current = imageContainer.children('.current');
				var old = current.prev();//gets the next image
				if (!old.length > 0){//if their is no next image, then displays the first image
					old = imageContainer.children('img').last();
				}
				
				current.show().animate({ //animates the image :)
					left: current.width(),
					top: 0
				},	{queue: false, speed: 300, complete: function(){
					$(this).removeClass('current').hide(); //hides the old image, as we don't need to see it
				}});
				
				
				old.show().css({ //animates the image :)
					left: -$(old).width()
				}).animate({
					left: 0,
					top: 0
				}, {queue: false, speed: 300, complete: function(){
						$(this).addClass('current');
						$(text).children('p').text($(imageContainer).children('.current').attr('data-text'));		
				}});
				
			});			
			
		
			$('<span class="next arrow">&gt;</span>').appendTo(controls).on('click', function(){
				if ($(controls).css('display') != 'none'){ //this will check if the controls and hidden if so then dont stop the timer
					clearInterval(timer);//this will stop the auto gallery
				}				
				//gets the current image
				var current = imageContainer.children('.current');
				var next = current.next(); //gets the next image
				if (!next.length > 0){ //if their is no next image, then displays the first image
					next = imageContainer.children('img').first(); //gets the first image
				}
				
				current.animate({ //animates the image :)
					left: -current.width(),
					top: 0
				},	{queue: false, speed: 300, complete: function(){
					$(this).removeClass('current').hide();;
				}});
				
				
				next.show().css({ //animates the next image
					left: $(next).width()
				}).animate({
					left: 0,
					top: 0
				}, {queue: false, speed: 300, complete: function(){
						$(this).addClass('current');
						$(text).children('p').text($(imageContainer).children('.current').attr('data-text'));		
				}});
				
			});
		});	
	}
})(jQuery);

$(window).ready(function(){
	var emailReg =  /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	$(".mobilenav .menu").hide();
	$('body').removeClass('nojs'); //removes the class noJS (as noJS has some site styling to fix the absence of javascript)
	$("#gallery").gallery(); //creates the gallery
	
	$(".mobileNavBu").click(function(){
		$(this).toggleClass("active");
		$(".mobilenav .menu").toggle();	
	});	
	
	$(".login form").on('submit', function(e){
		if (!($("#email-login").val().length > 0 && $("#password-login").val().length > 0)){		
			$(".alert-danger").remove();
			$('<div class="user alert alert-danger">Please fill in everything....</div>').appendTo(".login form");
			return false;			
		} 
		else {
			if (!(emailReg.test($("#email-login").val()))){
				$(".alert-danger").remove();
				$('<div class="user alert alert-danger">Please insert a valid email address</div>').appendTo(".login form");
				return false;
			}
		}
	});
	
	$("#registerForm").on('submit', function(e){
		$('#registerForm').children('input').each(function(){			
			if ($(this).attr('name') == 'email'){				
				if (!(emailReg.test($(this).val()))){			
					$(".alert-danger").remove();
					$('<div class="user alert alert-danger">Please insert a valid email address</div>').appendTo("#registerForm");
					e.preventDefault();					
					return false;
				}
			} else {
				if (!($(this).val().length > 0)){
					$(".alert-danger").remove();
					$('<div class="user alert alert-danger">Please fill in everything....</div>').appendTo("#registerForm");
					e.preventDefault();
					return false;
				}
			}
		});
	});

	if ($(window).width() < 500){
		$(".imgContainer img").each(function(){
			var src = $(this).attr('src');
			$(this).attr('src', $(this).attr('data-mobile'));
			$(this).attr('data-mobile', src);
		});
	}

	$(window).resize(function(){
		if ($(window).width() < 500){
			$(".imgContainer img").each(function(){
				$(this).attr('src', $(this).attr('data-mobile'));
				$(this).attr('data-mobile', $(this).attr('src'));
			});
		} else {
			$(".imgContainer img").each(function(){
				var src = $(this).attr('src');
				$(this).attr('src', $(this).attr('data-mobile'));
				$(this).attr('data-mobile', src);
			});
		}
	});
	
});