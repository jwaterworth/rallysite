//Init namespace
BookingInfo = {}


$(document).ready(function() {
	
	$(".remove_button").click(function(e) {
		return confirm("Are you sure you wish to remove this booking? If you would prefer to edit your booking activity or check your food choices, please email the rally staff.");
	});
});