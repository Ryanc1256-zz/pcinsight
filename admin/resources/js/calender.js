$.fn.calender = function(){
	//calender jquery plugin built by Ryan Clough
	var Months = Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
	var Days = Array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
	var date = new Date();
	var year = date.getFullYear()
	var actualMonth = date.getMonth();

	return this.each(function(){
		var $this = $(this);
		var calender = createCalender(this);
		calender = $(calender).appendTo('body');	

		setTimeout(function(){
			$('body').on('click', function(e){
				var target = $(e.target);
				if (!(target.parent().hasClass('calenderElement') || target.parent().parent().hasClass('calenderElement')))
				{
					calender.remove();
				}
			});
		}, 300);
	});
	
	function createCalender(elem)
	{					
		var calender = $('<div class="calenderElement"></div>').css({
			position: 'absolute',
			top: ($(elem).offset().top - ( 98 )),
			left: ($(elem).offset().left + $(elem).width() + 13),
			width: '363px',
			height: '301px',
			backgroundColor: '#fff',
			padding: '5px',
			border: '1px solid rgb(204, 204, 204)',
			boxShadow: '1px 1px 2px 0 rgba(0,0,0,0.12)'
		});
		$('<span class="ArrowSide"></span>').appendTo(calender).css({
			left: '-10px',
			width: '0',
			heigth: '0',
			top: '95px',
			position: 'absolute',	
			borderTop: '10px solid transparent',
			borderBottom: '10px solid transparent', 	
			borderRight: '10px solid #CACACA'
		});
		
		var calenderTop = $('<div class="calenderTop"></div>').appendTo(calender);
		var days = $('<div class="calenderTop"></div>').appendTo(calender).css('margin-top', '10px');
		$.each(Days, function(i, value){
			$('<span>' + value + '</span>').appendTo(days).css({
					padding: '10px',
					backgroundColor: '#eee',
					cssFloat: 'left',
					maxWidth: '50px',
					textAlign: 'center',
					minWidth: '50px'
			});
		});
		
		var calenderContent = $('<div class="calenderContent"></div>').appendTo(calender);
	
		

		$('<button class="btn">Back</button>').appendTo(calenderTop).unbind().click(function(){
			//previous month
			actualMonth--;
			if (actualMonth <= 0){
				actualMonth = 11;
				year--;
			}
			monthText.text(Months[actualMonth])
			generateCalenderDates(calenderContent, elem)
		});;
		
		var monthText = $('<span class="monthCalender">Back</span>').appendTo(calenderTop).text(Months[actualMonth]).css('marginLeft', "90px");
		
		$('<button class="btn">Next</button>').appendTo(calenderTop).css("float", "right").unbind().click(function(){
			//next month
			actualMonth++;
			if (actualMonth >= 12){
				actualMonth = 0;
				year++;
			}
			monthText.text(Months[actualMonth])
			generateCalenderDates(calenderContent, elem);				
		});
		
		generateCalenderDates(calenderContent, elem);				
		return calender;
	}
	
	function generateCalenderDates(calender, elem)
	{
		$(calender).empty();
		var done = false;
		for (var i = 1; i <= 31; i++)
		{	
			var dayname = new Date(year, actualMonth, 1);
			dayname = dayname.getDay() - 1;	
			if (done == false && dayname !== 0)
			{
				for (var s = 0; s < dayname; s++)
				{											                		                		
					$('<span>&#160;</span>').appendTo(calender).css({
						padding: '10px',
						backgroundColor: '#eee',
						cssFloat: 'left',
						maxWidth: '50px',
						minWidth: '50px'
					});  
				}
			}	 
			done = true;
				
			if (checkDate(i, actualMonth, year))
			{
				$('<span>'+ i +'</span>').appendTo(calender).css({
					padding: '10px',
					backgroundColor: '#eee',
					cssFloat: 'left',
					maxWidth: '50px',
					minWidth: '50px',
					textAlign: 'center',
					cursor: 'pointer'
				}).hover(function(){
					$(this).css({
						backgroundColor: "#D4D0D0"
					});
				}, function()
				{
					$(this).css({
						backgroundColor: "#eee"
					});
				}).click(function(){
					actualMonth++;
					var currentDateString = ($(this).text() > 9 ?  $(this).text() : ('0' + $(this).text())) + '-' + (actualMonth > 9 ?  actualMonth : ('0' + actualMonth)) + '-' + year;
					$(elem).val(currentDateString);				
					$(calender).parent().remove();
				});
			}	
		}
	}
	
	function checkDate(day, month, year)
	{					
		console.log(month, year);
		var Newdate = new Date(year, month, day);
		if (Newdate.getMonth() == month && Newdate.getDate() == day){
			return true;
		} else {
			return false;
		}
	}
};