//Init namespace
BookingInfo = {}


$(document).ready(function() {
	
	$(".remove_button").click(function(e) {
		return confirm("Are you sure you wish to remove this booking?");
	});
});