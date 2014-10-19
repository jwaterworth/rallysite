BookingScript = {};

$(document).ready(function() { 

	$(".activityButton").click(function(e) {
		e.preventDefault();
		$(this).css('background-color', 'rgba(0, 177, 45, 1)');
		$(this).siblings().css('background-color', 'rgba(143, 34, 113, 1)');
		
		var index = $(this).data("activityid");
		getActivityDetails(index);
		$('#activityInput').val(index);
	});
	
});



