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
			var $form = $('<form class="updateBookingForm"></form>');
			$form.append('<div class="bookingField col1"><span>' + clubBookings[i].userName + '</span></div>');
			$form.append('<div class="bookingField col2"><select class="updateBookingActivity" ></select></div>');
			$form.append('<div class="bookingField col3"><span>£</span><input class="short fee"  value=' + clubBookings[i].fee + ' type="number" step="any" min="0"/></div>');
			$form.append('<div class="bookingField col4"><input type="checkbox" class="paid"/></div>');
			$form.append('<div class="bookingField col5"><input type="hidden" class="bookingId" value="' + clubBookings[i].bookingId + '"/><input type="submit" class="updateBookingSubmit" value="Update"/>');									
			$form.append('<div class="bookingField col6"><input type="submit" class="removeBookingSubmit" value="Remove"/></div><div class="clear"></div>');									
			$(".clubBookings").append($form);
			
			//Load activities into select and set the activity select option
			$.each(EventAdmin.EventActivities, function(key, value) {
				$form.find(".updateBookingActivity").append($("<option></option>").attr("value", value.activityId).text(value.activityName + '(' +value.placesRemaining + ')'));
			});
			
			$form.find(".updateBookingActivity").val(clubBookings[i].activityID);
			
			//Set the paid flag
			$form.find(".paid").prop('checked', clubBookings[i].paid);
		}	
		
		$(".removeBookingSubmit").click(function(e) {
			if(confirm("Are you sure you would like to remove booking?")) {
				e.preventDefault();
				var bookingId = $(this).parent().parent().find(".bookingId").val();
				var $thisForm = $(this).parent().parent();
				
				$.ajax({
					type: "POST",
					url: "?event=1&action=ajax&removeBooking=true",
					dataType: "JSON",
					data: {
						bookingId : bookingId
					}
				}).done(function(response) {
					if(response) {
						if(response.result != "success")  {
							alert("An error occurred removing the booking: " + response.message ? response.message : "");
						} else {
							alert("Booking removed");
							$thisForm.remove();
						}
					} else { 
						alert("No response from server");
					}						
				});
			}			
		});
					
		//Add a click handler to all the update buttons to confirm changes
		$(".updateBookingSubmit").click(function(e) {
			e.preventDefault();			
			var bookingId =  $(this).parent().parent().find(".bookingId").val();
			var activityId =  $(this).parent().parent().find(".updateBookingActivity").val();
			var fee =  $(this).parent().parent().find(".fee").val();
			var paid =  $(this).parent().parent().find(".paid").prop('checked') ? 1 : 0;
			
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
						alert("An error occurred updating the booking: " + response.message ? response.message : "");
					} else {
						alert("Booking updated!");
					}
				} else { 
					alert("No response from server");
				}						
			});
				
		});
	} else {
		$(".clubBookings").append("<p>No Bookings found</p>");
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

