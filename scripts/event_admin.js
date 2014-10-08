//Init namespace
EventAdmin = {}

EventAdmin.ClubBookings = [];

$(document).ready(function() {
	EventAdmin.getClubs();
	
	$("#sltClubs").change(function() {
		EventAdmin.refreshClubBookings();
	});
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
			EventAdmin.setClubBookingsDropdown(clubBookings);
		});
}

EventAdmin.setClubBookingsDropdown = function(clubBookings) {
	//Clear the options	
	$("#sltClubBookings")
		.find('option')
		.remove();
		
	if(clubBookings && clubBookings.length) {
		for(var i=0; i< clubBookings.length; i++) {		
			$("#sltClubBookings").append($("<option></option>").attr("value", "test").text("test"));
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
