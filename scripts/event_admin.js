//Init namespace
EventAdmin = {}

EventAdmin.ClubBookings = [];
EventAdmin.EventActivites = [];

$(document).ready(function() {
	//Apply wysiwyg editors
	$('#newsBody').ckeditor();
	$('#eventSummary').ckeditor();
	$('#eventInfo').ckeditor();
	$('#bookingSummary').ckeditor();
	$('#bookingInformation').ckeditor();
	$('#activityPageBrief').ckeditor();	

	EventAdmin.getClubs();
	EventAdmin.getActivities();
	
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


EventAdmin.getActivities = function() {
		$.ajax({
			url: "?event=1&action=ajax&getActivities=true",
			dataType: "JSON"
		}).done(function(activities) {
			EventAdmin.EventActivities = activities;
		});
}

EventAdmin.getClubBookings = function(clubId) {
		$.ajax({
			url: "?event=1&action=ajax&getClubBookings=true&clubId=" + clubId,
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
			var $form = $('<form class="updateBookingForm" action=".?event=1&action=admin&type=updateBooking#tabs-5" method="POST"></form>');
			$form.append('<div class="bookingField col1"><span>' + clubBookings[i].userName + '</span></div>');
			$form.append('<div class="bookingField col2"><select class="updateBookingActivity" ></select></div>');
			$form.append('<div class="bookingField col3"><span>£</span><input class="short fee"  value=' + clubBookings[i].fee + ' type="number" step="any" min="0"/></div>');
			$form.append('<div class="bookingField col4"><input type="checkbox" class="paid"/></div>');
			$form.append('<div class="bookingField col5"><input type="hidden" class="bookingId" value="' + clubBookings[i].bookingId + '"/><input type="submit" class="updateBookingSubmit" value="Update"/></div><div class="clear"></div>');									
			
			$(".clubBookings").append($form);
			
			//Load activities into select and set the activity select option
			$.each(EventAdmin.EventActivities, function(key, value) {
				$form.find(".updateBookingActivity").append($("<option></option>").attr("value", value.activityId).text(value.activityName + '(' +value.placesRemaining + ')'));
			});
			
			$form.find(".updateBookingActivity").val(clubBookings[i].activityID);
			
			//Set the paid flag
			$form.find(".paid").prop('checked', clubBookings[i].paid);
		}	
		
		//Add a click handler to all the update buttons to confirm changes
		$(".updateBookingForm").submit(function(e) {
			e.preventDefault();
			//if(confirm("Please confirm booking update.")) 
			//{
				var bookingId = $(this).find(".bookingId").val();
				var activityId = $(this).find(".updateBookingActivity").val();
				var fee = $(this).find(".fee").val();
				var paid = $(this).find(".paid").prop('checked') ? 1 : 0;
				
				$.ajax({
					type: "POST",
					url: "?event=1&action=ajax&updateBooking=true",
					dataType: "JSON",
					data: {
						bookingId : bookingId,
						activityId : activityId,
						fee : fee,
						paid : paid
					}
				}).done(function(response) {
					if(response) {
						if(response.result != "success")  {
							alert("An error occurred updating the booking: " + response.message ? response.messages : "");
						} else {
							alert("Booking updated!");
						}
					} else { 
						alert("No response from server");
					}						
				});
			//}
		});
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

