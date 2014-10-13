//Init namespace
EventAdmin = {}

EventAdmin.ClubBookings = [];

$(document).ready(function() {
	//Apply wysiwyg editors
	$('#newsBody').wysiwyg();

	EventAdmin.getClubs();
	
	$("#sltClubs").change(function() {
		EventAdmin.refreshClubBookings();
	});
	
	EventAdmin.refreshClubBookings();
});

EventAdmin.getClubs = function() {
		$.ajax({
			url: "?action=ajax&getClubs=true",
			dataType: "JSON"
		}).done(function(clubs) {
			EventAdmin.setClubDropdown(clubs);
		});
}

EventAdmin.getClubBookings = function(clubId) {
		$.ajax({
			url: "?eventId=1&action=ajax&getClubBookings=true&clubId=" + clubId,
			dataType: "JSON"
		}).done(function(clubBookings) {
			EventAdmin.ClubBookings = clubBookings;
			EventAdmin.setClubBookingsTable(clubBookings);
		});
}

EventAdmin.setClubBookingsTable = function(clubBookings) {	
	//Clear table
	if(!$(".clubBookings").is(":empty"))
		$(".clubBookings").empty();

	if(clubBookings && clubBookings.length)  {
		for(var i=0; i<clubBookings.length; i++) {
			var $form = $(".clubBookings").append('<form action=".?event=1&action=admin&type=updateBooking#tabs-5" method="POST"></form>');
			$form.append('<div class="bookingField col1"><span>' + clubBookings[i].userName + '</span></div>');
			$form.append('<div class="bookingField col2"><select id="updateBookingActivity" name="updateBookingActivity"><option>Gin Distillery</option></select></div>');
			$form.append('<div class="bookingField col3"><span>£</span><input class="short" id="updateBookingFee" name="updateBookingFee" value=' + clubBookings[i].fee + ' type="number" step="any" min="0"/></div>');
			$form.append('<div class="bookingField col4"><input type="checkbox"/></div>');
			$form.append('<div class="bookingField col5"><input type="hidden" name="bookingId" value=' + clubBookings[i].bookingId + '/><input type="submit" value="Update"/></div><div class="clear"></div>');									
			
			//Set the activity select option
			
			//Set the paid flag
		}	
	}
}

EventAdmin.refreshClubBookings = function() {
		var clubId = $("#sltClubs").val();
		EventAdmin.getClubBookings(clubId);
}

EventAdmin.setClubDropdown = function(clubs) {	
	if(clubs && clubs.length) {
		for(var i=0; i< clubs.length; i++) {		
			$("#sltClubs").append($("<option></option>").attr("value", clubs[i].id).text(clubs[i].name));
		}
		
		//Now fire off get club bookings on the first item
		EventAdmin.refreshClubBookings()		
	}	
}
